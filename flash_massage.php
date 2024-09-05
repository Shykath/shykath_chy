<?php 
if(!empty($_SESSION["success_massage"])){
    
    echo '<div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
            .$_SESSION["success_massage"].
        '</div>' ;
         unset($_SESSION["success_massage"]);
    }

if(!empty($_SESSION["error_massage"])){
   echo '<div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
            .$_SESSION["error_massage"].
        '</div>' ;
    unset($_SESSION["error_massage"]);
}

    