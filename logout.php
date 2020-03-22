<?php
/*
        authors:
        Piotr Bienkowski
        Bartosz Kostarczyk
        Mateusz Mazurczak
    */
    session_start();
    unset($_SESSION['gsidkID']);
    unset($_SESSION['gsidkLOG']);
    unset($_SESSION['gsidkstatus']);
    header("Location: login.php?n=1");

?>
