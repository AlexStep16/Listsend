<?php
    session_start();
    $_SESSION['filecount'] = $_SESSION['filecount'] - 1;
    $_SESSION['imgdel'] = 1;
    print($_SESSION['filecount']);
?>