<?php
    // success alert
    if(isset($success_msgs)){
        foreach($success_msgs as $success_msg){
            echo '<script>swal("'.$success_msg.'", "", "success");</script>';
        } 
    }

    // error alert
    if(isset($error_msgs)){
        foreach($error_msgs as $error_msg){
            echo '<script>swal("'.$error_msg.'", "", "error");</script>';
        } 
    }

    // warning alert
    if(isset($warning_msgs)){
        foreach($warning_msgs as $warning_msg){
            echo '<script>swal("'.$warning_msg.'", "", "warning");</script>';
        } 
    }
?>

