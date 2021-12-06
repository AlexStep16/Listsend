<?php
    session_start();
    header('Location:'.$_SESSION['login'].'.php');
?>