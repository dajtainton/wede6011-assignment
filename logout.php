<?php

    session_start();

    // Destroys session varibles so user 
    // cant go back without logging in again
    session_unset();
    session_destroy();

    // Redirects back to login page
    header("location:index.php");
    exit();

?>