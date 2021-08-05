let __csrf = $("[name=csrf-token]").attr("content");

let allowed_preview_types = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];

$(document).on("change", "[name=files]", function (event) {
    let files_count = this.files.length,
        form_data   = new FormData();

    for (let i = 0; i < files_count; i++) {
        form_data.append('file', this.files[i]);
        form_data.append('_csrf', __csrf);

        let progressBar     = readURL(this.files[i]),
            progressBarWrap = progressBar.find(".custom-progress-bar");

        $.ajax({
            url: '/api/load-files',
            xhr: function () {
                let xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        let percentComplete = evt.loaded / evt.total;
                        percentComplete     = percentComplete * 100;

                        let progressBarInner = progressBarWrap.find(".inner");
                        progressBarInner.css({"width": percentComplete + "%"});
                    }
                }, false);

                return xhr;
            },
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {

                if (data.success) {
                    progressBarWrap.css({"background": "#70b860"}).html("Done!");

                    setTimeout(function () {
                        progressBarWrap.fadeOut(2000);
                    })
                } else {
                    progressBarWrap.css({"background": "#843534"}).html("Can't load file!")
                }
            },
            error: function (data) {
                progressBarWrap.css({"background": "#843534"}).html("Can't load file!")
            },

        });

        form_data.delete("file");
    }

    $("#fileLoaderForm")[0].reset();
}).on("click", ".file-upload-btn", function () {
    $('.file-upload-input').trigger('click');
}).on("click", ".remove-upload-file-preview", function () {
    $(this).closest(".file-upload-content").remove();
});

function readURL(file) {
    let reader   = new FileReader(),
        newPhoto = $(".file-upload-template .file-upload-content").clone().insertAfter(".image-upload-wrap");

    reader.onload = function (e) {
        newPhoto.find(".file-upload-image").attr('src', allowed_preview_types.includes(file.type) ? e.target.result : "/images/preview.png");
        newPhoto.find('.image-title-wrap').html(file.name);
    };

    reader.readAsDataURL(file);

    return newPhoto;
}

$(document)

