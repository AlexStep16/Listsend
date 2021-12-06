<?php
    session_start();
    $_SESSION['filecount'] = $_SESSION['filecount'] - 1;
    $_SESSION['imgdel'] = 1;
    unlink('noteimage/'.$_POST['img']);
    print($_SESSION['filecount']);
?>