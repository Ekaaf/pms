$(document).ready(function() {
});

// var ckClassicEditor = document.querySelectorAll(".ckeditor-classic")
//     ckClassicEditor.forEach(function () {
//         ClassicEditor
//     .create( document.querySelector( '.ckeditor-classic' ) )
//     .then( function(editor) {
//         editor.ui.view.editable.element.style.height = '200px';
//     } )
//     .catch( function(error) {
//         console.error( error );
//     } );
// });


 ClassicEditor
.create( document.querySelector( '#description, #package' ) )
.then( function(editor) {
    editor.ui.view.editable.element.style.height = '200px';
} )
.catch( function(error) {
    console.error( error );
} );