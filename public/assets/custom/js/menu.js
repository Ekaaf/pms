var i = 1;
$(document).ready(function() {
    // $( "#box" ).sortable({
    //     // connectWith: "#box",
    //     items: ".test"

    // });
    $('.path, #menu_path').select2({
        // placeholder: "Select"
    });
    $('#is_submenu').change(function() {
        if(this.checked) {
            $("#parentMenuDiv").show();
        }
        else{
            $("#parentMenuDiv").hide();
            $("#path-error").remove();
        }
    });


    $("#menu_form").validate({
        rules: {
            title: "required",
            menu_path: {
                required:'#is_submenu:checked'
            },
            parent_id:{
                required:'#is_submenu:checked'
            }
        },
        // Specify validation error messages
        messages: {
            title: "Please enter menu title",
            menu_path: "Please select path",
            parent_id: "Please select parent menu"
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "menu_path" ) {
                error.insertAfter("#pathDiv");
            }
            else{
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            var method_names = $("input[name='method_name[]']").map(function(){return $(this).val();}).get();
            var paths = []; 
            var menu_path = $("#menu_path").val();
            $('select[name="path[]"] option:selected').each(function() {
                paths.push($(this).val());
            });
            console.log()
            var check = 1; var message = "";
            if($('#is_submenu').is(':checked')){
                if((method_names[0] == "" || paths[0] == "") && check ==1){
                    message = "Menu must have a method name and an associated method";
                    check = 0;
                }
                if(($.inArray( "",method_names)!= -1 || $.inArray( "",paths) != -1) && check == 1){
                    message = "Every method must have an associated method";
                    check = 0;
                }

                if($.inArray( menu_path,paths)== -1 && check == 1){
                    message = "Menu method must exist in associated method";
                    check = 0;
                }
            }
            if(check == 0){
                Swal.fire(
                    message,
                    '',
                    'error'
                );
                return false;
            }
            form.submit();
        }
    });
});

function addMore(){
    var width = $("#methodTable tbody tr:first-child").find("span").width();
    $('.path').select2('destroy');
    var cloneTr = $("#methodTable tbody tr:first-child").clone();
    cloneTr.find("select").val("");
    cloneTr.insertAfter("#methodTable tbody tr:last").find("input[type='text']").val("");
    cloneTr.find("input[type='checkbox']").val(i).removeAttr('checked');;
    cloneTr.find("button").show();
    cloneTr.find("button").click(function(){
        $(this).parent().parent().parent().parent().remove();
    });
    i++;
    $('.path').select2({width: width});
}


function deleteMenu(element, type){
    var txt;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    Swal.fire({
            title: 'Are you sure want to delete ?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: 'menus/delete-menu',
                    data: {
                      id : element.value
                    },
                    dataType: 'json',
                })
                .done(function (data) {
                    if(data){
                        Swal.fire(
                          'Successfully Deleted',
                          '',
                          'success'
                        );
                        if(type == 'parent'){
                            window.location.reload();
                        }
                        else{
                            $(element).parent().parent().remove();
                        }
                    }
                    else{
                        Swal.fire(
                          'Sorry! Menu could not be deleted',
                          '',
                          'error'
                        );
                    }
                });
            }
    })
}