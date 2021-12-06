<?php 
    session_start();
    $_GET['c'] = strip_tags($_GET['c']);
    $_SESSION['filecount'] = (int)$_GET['c'];
    echo $_SESSION['filecount'];
?>