var bachelorEmail = document.getElementsByName("email")[0].value;
var bachelorAlbumName = bachelorEmail.split("@")[0];

function updateButtons() {
  if (document.getElementsByName("yes")[0].checked == true) {
    document.getElementsByName("no")[0].checked = false;
    document.getElementsByName("upload_image")[0].disabled = false;
    if (document.getElementsByName("uploadNewImg")[0].files.length == 0) {
      document.getElementsByName("submit_changes")[0].disabled = false;
    } else {
      document.getElementsByName("submit_changes")[0].disabled = true;
    }
  } else {
    document.getElementsByName("submit_changes")[0].disabled = false;
  }
}

function uploadImage() {
  console.log("image uploading");
  if (document.getElementsByName("uploadNewImg")[0].files.length > 0) {
    addBachelorPhoto(bachelorAlbumName);
    document.getElementsByName("submit_changes")[0].disabled = false;
  }
}

function addBachelorPhoto(albumName) {
  require(['js/config.js'], function (){
    console.log(files);
    if (!files.length) {
      console.log("Please choose a file to upload first.");
      return false;
    }
    var file = files[0];
    var fileName = file.name;
    var albumPhotosKey = encodeURIComponent(albumName) + "/";

    var photoKey = albumPhotosKey + fileName;

    // Use S3 ManagedUpload class as it supports multipart uploads
    var upload = new AWS.S3.ManagedUpload({
      params: {
        Bucket: albumBucketName,
        Key: photoKey,
        Body: file,
        ACL: "public-read"
      }
    });

    var promise = upload.promise();

    promise.then(
      function(data) {
        console.log("Successfully uploaded photo.");
        document.getElementById("message").innerHTML = "Successfully uploaded a new photo! Please submit changes for review."
        s3.listObjects({ Prefix: albumPhotosKey }, function(err, data) {
          if (err) {
            console.log("There was an error viewing your album: " + err.message);
            return false;
          }
          // 'this' references the AWS.Response instance that represents the response
          var href = this.request.httpRequest.endpoint.href;
          var bucketUrl = href + albumBucketName + "/";

          var photos = data.Contents.map(function(photo) {
            var photoKey = photo.Key;
            var photoUrl = bucketUrl + encodeURIComponent(photoKey);
            console.log(photoUrl);
            createCookie("newPhoto", photoUrl, "/edit-bachelor.php");
            location.reload();
            return true;
        });
      });
      },
      function(err) {
        console.log("There was an error uploading your photo: ", err.message);
        return false;
      }
    );
  });
}

function createCookie(name, value, path) {
  var date = new Date();
  date.setTime(date.getTime()+(60*1000));
  var expires = "; expires="+date.toGMTString();

  document.cookie = name+ "=" + value+expires+"; path=" +path+";";
  console.log("Cookie set");
}
