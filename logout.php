<?php
session_start();
session_destroy();
unset($_SESSION['loggedUser']);
header("location: login.php");