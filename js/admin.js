jQuery(document).ready(function ($) {


    $('.color-field').wpColorPicker();

    var mediaUploader

    $('#fazzo-upload-button').on('click', function (e) {
        e.preventDefault()
        if (mediaUploader) {
            mediaUploader.open()
            return
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: js_localize_fazzo.select_picture,
            button: {
                text: js_localize_fazzo.select_picture,
            },
            multiple: false,
        })

        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON()

            $('#fazzo-image').val(attachment.url)
            $('#fazzo-image-preview').attr('src', attachment.url)
        })

        mediaUploader.open()

    })

    $('#fazzo-remove-picture').on('click', function (e) {

        e.preventDefault()

        $('#fazzo-image').val('')
        $('#fazzo-image-preview').attr('src', '')

        return
    })

});