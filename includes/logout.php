<?php
session_start();
foreach($_SESSION as $key=>$val){
    unset($_SESSION[$key]);
};
session_destroy();

header("location: ../index");
exit();