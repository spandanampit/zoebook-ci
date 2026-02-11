Project.modules.savephoto = (function () {
  var objReturn = {};

  function init() {
    Common.initValidator();

    var videotype = $("#coverphoto_type").val();
    if (videotype == "Video") {
      var video = $("<video />", {
        id: "imagePreviewCover",
        src: $("#coversrc").val(),
        type: "video/mp4",
        controls: true,
      });
      video.appendTo($("#displaycover"));
    } else {
      var img_1 = $('<img id="imagePreviewCover">'); //Equivalent: $(document.createElement('img'))
      $(img_1).attr("src", $("#coversrc").val());
      $(img_1).attr("class", "profile-user-img");
      $("#displaycover").html($(img_1));
    }

    $("#loadingcover").hide();

    $("#editPost").on("shown.bs.modal", function () {
      $("#post_text").focus();
    });

    $("#cover_photo").change(function () {
      if (typeof FileReader != "undefined") {
        var dvPreview = $("#imagePreviewCover");
        dvPreview.html("");

        $($(this)[0].files).each(function () {
          var file = $(this);
          var videotype = file[0]["type"];

          if (videotype == "video/mp4") {
            $(dvPreview).remove();
            var fileUrl = window.URL.createObjectURL(file[0]);
            var video = $("<video />", {
              id: "imagePreviewCover",
              src: fileUrl,
              type: "video/mp4",
              controls: true,
            });
            $(video).appendTo($("#displaycover"));

            $(video)[0].load();
          } else {
            var reader = new FileReader();
            reader.onload = function (e) {
              dvPreview.attr("src", e.target.result);
            };
            reader.readAsDataURL(file[0]);

            $(".avatar-preview").addClass("draggable");

            $(".avatar-preview").css("cursor", "move");
            $(".avatar-preview").css({ top: 0 });

            var y1 = $(".avatar-preview").height();
            var y2 = $(".profile-user-img").height();

            $(".draggable").draggable({
              axis: "y",
              start: function () {
                $(".dragimagetext").show();
              },
              stop: function (event, ui) {
                $("#topcover").val(ui.position.top);
                $(".dragimagetext").hide();
              },
            });
          }

          $("#changephoto,#changephoto_block").hide();
          $("#savephoto,#savephoto_block").show();
        });
      } else {
        console.log("This browser does not support HTML5 FileReader.");
      }
    });

    $("#savephoto").click(function () {
      Project.showUILoader($(".profile-cover-block"), {
        style: "black",
        message: "Updating Profile Cover..",
      });
      $("#frmcover").submit();
    });
  }

  objReturn.init = init;
  return objReturn;
})();

Project.modules.saveprofilepic = (function () {
  var objReturn = {};

  function init() {
    Common.initValidator();

    // Create the img element and set its initial src and class
    var img_1 = $('<img id="imagePreviewProfile">');
    $(img_1).attr("src", $("#profilepicsrc").val());
    $(img_1).attr("class", "profile-user-img");

    // Insert the img element into the DOM
    $("#profilepic_inner").html(img_1);

    // Handle file input change event
    $("#profile_image").change(function () {
      if (typeof FileReader !== "undefined") {
        var dvPreview = $("#imagePreviewProfile"); // Select the image element for preview

        // Clear previous image preview (if needed)
        dvPreview.attr("src", "");

        // Loop through the selected files (in case multiple files)
        $($(this)[0].files).each(function () {
          var file = $(this);

          var reader = new FileReader();
          reader.onload = function (e) {
            console.log("File content as Data URL:", e.target.result);
            dvPreview.attr("src", e.target.result);
            var newImageUrl = e.target.result; // From FileReader
            $("#imagePreviewProfile").attr("src", newImageUrl);
            $("#profilepicsrc").val(newImageUrl);
          };

          reader.readAsDataURL(file[0]);

          $("#changeprofilepic, #changeprofilepic_block").hide();
          // $("#saveprofilepic, #saveprofilepic_block").show();
        });
      } else {
        console.log("This browser does not support HTML5 FileReader.");
      }
    });

    $("#saveprofilepic").click(function () {
      Project.showUILoader($(".circle-profile"), {
        style: "black",
        message: '<img src="public/images/fancybox_loading.gif">',
      });
      console.log("Form submission triggered.");
      $("#frmprofilepic").submit();
    });
  }

  objReturn.init = init;
  return objReturn;
})();

Project.modules.saveeditprofile = (function () {
  var objReturn = {};

  function init() {
    Common.initValidator();

    jQuery.validator.addMethod(
      "strictphone",
      function (value, element) {
        return this.optional(element) || /^[\d ()+-]+$/.test(value);
      },
      "Please enter valid Phone Number"
    );

    $("#saveeditprofile").click(function () {
      setEditProfileValidate();
    });

    $("#canceleditprofile").click(function () {
      $("#frmeditprofile").data("validator").resetForm();
    });
  }

  function setEditProfileValidate() {
    $("#frmeditprofile").validate({
      rules: {
        vEditName: {
          required: true,
          //  lettersonly:true
        },
        vEditPhone: {
          required: false,
          strictphone: true,
          maxlength: 10,
        },
      },
      messages: {
        vEditName: {
          required: "Please enter your Name",
          // lettersonly: 'Please enter valid Name'
        },
        vEditPhone: {
          required: "Please enter Phone Number",
          strictphone: "Please enter valid digits in Phone Number",
          maxlength: "Phone Number should not exceed 10 digits",
        },
      },
      errorPlacement: function (error, element) {
        if (element.attr("name")) {
          $("#" + element.attr("id") + "Err").html(error);
        }
      },
      submitHandler: function (form) {
        //$("#submitforgot").html("Processing..").css("opacity","0.4");
        Project.showUILoader($("#editProfile"), {
          style: "black",
          message: "Updating Please Wait..",
        });
        form.submit();
      },
      ignore: ".ignore",
    });
  }

  objReturn.init = init;
  return objReturn;
})();

Project.modules.savechangepassword = (function () {
  var objReturn = {};

  function init() {
    Common.initValidator();

    $("#savechangepassword").click(function () {
      setChangePasswordValidate();
    });

    $("#cancelchangepassword").click(function () {
      $("#frmchangepassword").data("validator").resetForm();
    });
  }

  function setChangePasswordValidate() {
    $("#frmchangepassword").validate({
      rules: {
        vOldPassword: {
          required: true,
          minlength: 6,
        },
        vNewPassword: {
          required: true,
          minlength: 6,
        },
        vRePassword: {
          required: false,
          equalTo: "#vNewPassword",
        },
      },
      messages: {
        vOldPassword: {
          required: "Please enter old password",
          minlength: "Password should contain atleast 6 characters",
        },
        vNewPassword: {
          required: "Please enter new password",
          minlength: "Password should contain atleast 6 characters",
        },
        vRePassword: {
          required: "Please re-type new password",
          equalTo: "Password does not match",
        },
      },
      errorPlacement: function (error, element) {
        if (element.attr("name")) {
          $("#" + element.attr("id") + "Err").html(error);
        }
      },
      submitHandler: function (form) {
        //$("#submitforgot").html("Processing..").css("opacity","0.4");
        Project.showUILoader($("#changePassword"), {
          style: "black",
          message: "Changing Please wait ..",
        });
        form.submit();
      },
      ignore: ".ignore",
    });
  }

  objReturn.init = init;
  return objReturn;
})();

$(function () {
  $("#loaddraggable").draggable();
  //console.log($('#loadedtopcover').val())
  $(".avatar-preview").css({ top: parseInt($("#loadedtopcover").val()) });
  $("#loaddraggable").css("overflow", "unset");
});
