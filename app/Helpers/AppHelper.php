<?php // Code within app\Helpers\Helper.php

// namespace App\Helpers;

function formErrorMessage($errors)
{   
    $message = "";
    $i = 0;
    foreach ($errors->all() as $error){
        if($i>0){
            $message .="<br>";
        }
        $message .= $error;
        $i++;
    }
    $message = '<div class="alert alert-danger alert-dismissible bg-danger text-white alert-label-icon fade show" role="alert">
                    <i class="ri-error-warning-line label-icon"></i>'.$message.
                    '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    return $message;
}

function inputErrorMessage($input){
    $errorMessage =[
        'email' => 'Please enter a valid email address',
        'password' => 'Please enter password',
    ];
    return $errorMessage[$input];
}