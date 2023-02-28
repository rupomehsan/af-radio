// Start:: image upload & drag
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".image-upload-wrap").hide();
            $(".file-upload-image").attr("src", e.target.result);
            $(".file-upload-content").show();
            $(".image-title").html(input.files[0].name);
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        removeUpload();
    }
}

function removeUpload() {
    $(".file-upload-input").replaceWith($(".file-upload-input").clone());
    $(".file-upload-input").val(null);
    $(".file-upload-content").hide();
    $(".image-upload-wrap").show();
}
$(".image-upload-wrap").bind("dragover", function () {
    $(".image-upload-wrap").addClass("image-dropping");
});
$(".image-upload-wrap").bind("dragleave", function () {
    $(".image-upload-wrap").removeClass("image-dropping");
});
// End:: image upload & drag

// Start:: Second image upload & drag
function readURLSec(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".image-upload-wrap-sec").hide();
            $(".file-upload-image-sec").attr("src", e.target.result);
            $(".file-upload-content-sec").show();
            $(".image-title-sec").html(input.files[0].name);
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        removeUpload();
    }
}

function removeUploadSec() {
    $(".file-upload-input-sec").replaceWith(
        $(".file-upload-input-sec").clone()
    );
    $(".file-upload-input-sec").val(null);
    $(".file-upload-content-sec").hide();
    $(".image-upload-wrap-sec").show();
}
$(".image-upload-wrap-sec").bind("dragover", function () {
    $(".image-upload-wrap-sec").addClass("image-dropping-sec");
});
$(".image-upload-wrap-sec").bind("dragleave", function () {
    $(".image-upload-wrap-sec").removeClass("image-dropping-sec");
});
// End:: Second image upload & drag

// Start::Edit image upload & drag
function readURLEdit(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".image-upload-wrap-edit").hide();
            $(".file-upload-image-edit").attr("src", e.target.result);
            $(".file-upload-content-edit").show();
            $(".image-title-edit").html(input.files[0].name);
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        removeUpload();
    }
}

function removeUploadEdit() {
    $(".file-upload-input-edit").replaceWith(
        $(".file-upload-input-edit").clone()
    );
    $(".file-upload-input-edit").val(null);
    $(".file-upload-content-edit").hide();
    $(".image-upload-wrap-edit").show();
}
$(".image-upload-wrap-edit").bind("dragover", function () {
    $(".image-upload-wrap-edit").addClass("image-dropping-edit");
});
$(".image-upload-wrap-edit").bind("dragleave", function () {
    $(".image-upload-wrap-edit").removeClass("image-dropping-edit");
});
// End::Edit image upload & drag

// Start:: Sec Edit image upload & drag
function readURLEditSec(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".image-upload-wrap-edit-sec").hide();
            $(".file-upload-image-edit-sec").attr("src", e.target.result);
            $(".file-upload-content-edit-sec").show();
            $(".image-title-edit-sec").html(input.files[0].name);
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        removeUpload();
    }
}

function removeUploadEditSec() {
    $(".file-upload-input-edit-sec").replaceWith(
        $(".file-upload-input-edit-sec").clone()
    );
    $(".file-upload-input-edit-sec").val(null);
    $(".file-upload-content-edit-sec").hide();
    $(".image-upload-wrap-edit-sec").show();
}
$(".image-upload-wrap-edit-sec").bind("dragover", function () {
    $(".image-upload-wrap-edit-sec").addClass("image-dropping-edit-sec");
});
$(".image-upload-wrap-edit-sec").bind("dragleave", function () {
    $(".image-upload-wrap-edit-sec").removeClass("image-dropping-edit-sec");
});
// End::Sec Edit image upload & drag

// Start:: video upload & drag
function readURLVideo(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".video-upload-wrap").hide();
            $(".file-upload-video").attr("src", e.target.result);
            $(".file-upload-content-video").show();
            $(".video-title").html(input.files[0].name);
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        removeUpload();
    }
}

function removeUploadVideo() {
    $(".file-upload-input-video").replaceWith(
        $(".file-upload-input-video").clone()
    );
    $(".file-upload-input-video").val(null);
    $(".file-upload-content-video").hide();
    $(".video-upload-wrap").show();
}
$(".video-upload-wrap").bind("dragover", function () {
    $(".video-upload-wrap").addClass("video-dropping");
});
$(".video-upload-wrap").bind("dragleave", function () {
    $(".video-upload-wrap").removeClass("video-dropping");
});
// End:: video upload & drag
function deleteItem(url) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "DELETE",
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (res) {
                    console.log(res);
                    Swal.fire(
                        "Deleted!",
                        "Your file has been deleted.",
                        "success"
                    );
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                },
                error: function (xhr, resp, text) {
                    console.log(xhr);
                    // on error, tell the failed
                },
            });
        }
    });
}

function startLoading(container){
    $(container).append(`
        <div id="loader">
            <div class="ph-item">
                <div class="ph-col-12">
                    <div class="ph-row">
                        <div class="ph-col-12 big"></div>
                        <br><br>
                    </div>
                    <div class="ph-picture"></div>
                </div>
            </div>
        </div>
    `)
}

function endLoading() {
    $('#loader').fadeOut()
    $('#loader').remove()
}
