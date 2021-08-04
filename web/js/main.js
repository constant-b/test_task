let __csrf = $("[name=csrf-token]").attr("content");

$("[name=files]").on("change", function (event) {
    let files_count = this.files.length,
        form_data   = new FormData();

    for (let i = 0; i <= files_count; i++) {
        form_data.append('file' + i, this.files[i]);
    }

    form_data.append('_csrf', __csrf);

    $.ajax({
        url: '/api/load-files',
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function (data) {

        }
    });
})