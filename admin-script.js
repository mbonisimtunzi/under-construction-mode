jQuery(document).ready(function($) {
    $('.upload-button').click(function(e) {
        e.preventDefault();
        var button = $(this);
        var custom_uploader = wp.media({
            title: 'Select Background Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('input[name="ucm_background_image"]').val(attachment.url);
        }).open();
    });
});
