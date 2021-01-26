var bachelorEmail = "";
var bachelorAlbumName = "";
var bachelorId = 0;

function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}

function changeState(id) {
  bachelorId = id;
  var new_image = "bachelor_photo_" + id;
  var edit_info = "edit_bachelor_" + id;
  document.getElementsByName(new_image)[0].disabled = false;
  document.getElementsByName(edit_info)[0].disabled = true;
}

function showForm() {
  console.log(document.readyState);
  if (document.readyState == "complete") {
    var selected_options = $('select.bachelor_signup option.bachelor:selected');
    console.log(selected_options);
    var options = $('select.bachelor_signup option.bachelor:not(:selected)');
    console.log(options);

    document.getElementById('bachelor_signup_info').style.visibility = "visible";

    if (selected_options.length == 1) {
      console.log(selected_options[0].value);
      console.log(document.getElementById("form-" + selected_options[0].value));
      document.getElementById("form-" + selected_options[0].value).style.display = "block";
      document.getElementById("title-" + selected_options[0].value).style.display = "block";
      var formName = "form-" + selected_options[0].value;
      bachelorEmail = $("#" + formName + " input[name=email]").val();
      bachelorAlbumName = bachelorEmail.split("@")[0];

      for (var j = 0; j < options.length; j++) {
        console.log(document.getElementById("form-" + options[j].value));
        document.getElementById("form-" + options[j].value).style.display = "none";
        document.getElementById("title-" + options[j].value).style.display = "none";
      }
    } else if (selected_options.length > 1) {
      for (var j = 0; j < selected_options.length; j++) {
        console.log(document.getElementById("form-" + options[j].value));
        document.getElementById("form-" + options[j].value).style.display = "none";
        document.getElementById("title-" + options[j].value).style.display = "none";
      }
    }

  }
}

function moveToRight() {
  var options = $('select.bachelor_signup option:selected').sort().clone();
  $('select.bachelor_approved').append(options);
  $('select.bachelor_signup option:selected').remove();

  var newOptions = $('select.bachelor_approved option').sort()
  for (var i = 0; i < newOptions.length; i++) {
    newOptions[i].selected = "true";
  }
}

function moveToLeft() {
  var options = $('select.bachelor_approved option:selected').sort().clone();
  $('select.bachelor_signup').append(options);
  $('select.bachelor_approved option:selected').remove();

  var newOptions = $('select.bachelor_approved option').sort()
  for (var i = 0; i < newOptions.length; i++) {
    newOptions[i].selected = "true";
  }
}

function disableInput() {
  var class_input = document.getElementById("class_input");
  class_input.disabled = "true";
}

function uploadNewImage() {
  require(['js/config.js'], function () {
    addNewBachelorPhoto(bachelorAlbumName);
  });
}

function addNewBachelorPhoto(albumName) {
  require(['js/config.js'], function () {
    var files = document.getElementsByName("bachelor_photo_" + bachelorId)[0].files;
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
        document.getElementById("message").innerHTML = "Successfully uploaded photo! Please submit form to save changes."
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
            createCookie(bachelorEmail, photoUrl, "/add-bachelors.php");
            document.getElementById("edit_bachelor_" + bachelorId).disabled = false;
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
