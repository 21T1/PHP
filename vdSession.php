<?php
    session_start();
/*  //  WARNING:  Skipping numeric key in Unknown on line 0
    $_SESSION[] = "An";
    $_SESSION[1] = "Anh";
*/    
    $_SESSION["key"] = "An";
    var_dump($_SESSION);
    
    die();
?>
