var bachelorEmail = "";
var bachelorAlbumName = "";
function changeState() {
  bachelorEmail = document.getElementsByName("email")[0].value;
  console.log(bachelorEmail);
  var isValid = true;
  $('input').filter('[required]').each(function() {
    if ($(this).val() === '') {
      isValid = false;
      console.log("Disabled");
      return false;
    }
  });

  if (isValid == true) {
    document.getElementById("upload_image").disabled = false;
    console.log("Enabled");
  }
}

function uploadImage() {
  console.log("image uploading");
  bachelorAlbumName = bachelorEmail.split("@")[0];
  require(['js/config.js'], function () {
    createBachelorAlbum(bachelorAlbumName);
    addBachelorPhoto(bachelorAlbumName);
  });
}

function createBachelorAlbum(albumName) {
  require(['js/config.js'], function () {
    albumName = albumName.trim();
    if (!albumName) {
      console.log("Album names must contain at least one non-space character.");
      return false;
    }

    if (albumName.indexOf("/") !== -1) {
      console.log("Album names cannot contain slashes.");
      return false;
    }

    var albumKey = encodeURIComponent(albumName);
    s3.headObject({ Key: albumKey }, function(err, data) {
      if (!err) {
        console.log("Album already exists.");
        return true;
      }
      if (err.code !== "NotFound") {
        console.log("There was an error creating your album: " + err.message);
        return false;
      }
      s3.putObject({ Key: albumKey }, function(err, data) {
        if (err) {
          console.log("There was an error creating your album: " + err.message);
          return false;
        }
        console.log("Album created successfully.");
        return true;
      });
    });
  });

}

function addBachelorPhoto(albumName) {
  require(['js/config.js'], function () {
    var files = document.getElementsByName("uploadImg")[0].files;
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
        document.getElementById("message").innerHTML = "Successfully uploaded photo. Please submit form."
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
            createCookie("photo", photoUrl, "/bachelor-signup.php");
            document.getElementById("submit_button").disabled = false;
            console.log(document.cookie);
            return true;
        });
      });
      },
      function(err) {
        console.log("There was an error uploading your photo: ", err.message);
        document.getElementById("message").innerHTML = "There was an error uploading your photo.";
        return false;
      }
    );
  });

}

function createCookie(name, value, path) {
  require(['js/config.js'], function () {
    var date = new Date();
    date.setTime(date.getTime()+(60*1000));
    var expires = "; expires="+date.toGMTString();

    document.cookie = name+ "=" + value+expires+"; path="+path+";";
    console.log("Cookie set");
  });

}

function viewPhoto(albumName) {
  require(['js/config.js'], function () {
    var albumPhotosKey = encodeURIComponent(albumName) + "/";
    s3.listObjects({ Prefix: albumPhotosKey }, function(err, data) {
      if (err) {
        return console.log("There was an error viewing your album: " + err.message);
      }
      // 'this' references the AWS.Response instance that represents the response
      var href = this.request.httpRequest.endpoint.href;
      var bucketUrl = href + albumBucketName + "/";
      var photos = data.Contents.map(function(photo) {
        var photoKey = photo.Key;
        var photoUrl = bucketUrl + encodeURIComponent(photoKey);

      document.getElementById("app").innerHTML = getHtml(htmlTemplate);
    });
  });
  });
}
