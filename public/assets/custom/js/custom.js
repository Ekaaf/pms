function readURL(input, previewId) {
    if (input.files && input.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            $(previewId).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}


function removeImage(imageId, inputId, removeBtn){
    $(imageId).attr('src', '../../images/no-img.jpg');
    $(inputId).val('');
    $(removeBtn).hide();
}


function changeImage(imageId, inputId, removeBtn){
    $(imageId).attr('src', '../../images/no-img.jpg');
    $(inputId).val('');
    $(removeBtn).hide();
}