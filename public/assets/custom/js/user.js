$(document).ready(function() {
    jQuery.validator.addMethod("validateEmail", function(value, element) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        // if(value ==""){
        //     return true;
        // }
        return regex.test(value);
    }, "Please Enter a valid email address");
    $("#userAddForm").validate({
        rules: {
            email: "validateEmail",
            mobile: {
                required: true,
                minlength: 11,
                maxlength: 11,
            },
            password: {
                required: true,
                minlength: 4
            },
            password_confirmation: {
                required: true,
                minlength: 4,
                equalTo : "#password"
            },
            role_id: "required"
        },
        messages: {
            email: "Please enter a valid email address",
            mobile: "Please enter a valid mobile number",
            password: {
                required: "Please enter password",
                minlength: "Password must be at least 4 character"
            },
            password_confirmation: {
                required: "Please enter confirm password",
                minlength: "Password must be at least 4 character",
                equalTo: "Password and confirm password do not match"
            },
            role_id: "Please select role"

        }
    });

    $("#userEditForm").validate({
        rules: {
            name: "required",
            username: {
                required: true,
                equalTo : "#emp_id"
            },
            role_id: "required",
            email: "validateEmail",
            emp_id: {
                required: true,
                minlength: 9,
                maxlength: 9
            },
        },
        messages: {
            name: "Please enter full name",
            username: "Username and Employee ID must be same",
            role_id: "Please select role",
            emp_id: "Please enter 9 digit employee ID",
        }
    });
});


function usernameVal(){
    $("#username").val($("#emp_id").val());
}