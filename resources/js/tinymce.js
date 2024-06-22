import tinymce from 'tinymce/tinymce';

// Any plugins you want to use has to be imported
import 'tinymce/themes/silver';
import 'tinymce/plugins/paste';
import 'tinymce/plugins/link';
import 'tinymce/plugins/image';

// Initialize TinyMCE
document.addEventListener("DOMContentLoaded", function () {
    tinymce.init({
        selector: 'textarea[name="artikel"]',
        height: 400,
        plugins: ['paste', 'link', 'image'],
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image',
        paste_as_text: true,
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        images_upload_url: '/upload/image', // adjust URL endpoint as needed
        images_upload_handler: function (blobInfo, success, failure) {
            // Your custom image upload handler logic
        }
    });
});
