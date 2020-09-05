<?php
include_once '../includes/init.php';
if(!isset($_SESSION['loggedUser']))
{
    header("location: ../login.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>CMS</title>
</head>

<body>

<!--Header Div-->
<div class="header">
    <div class="container">
        <ul class="menu">
            <li><a target="_blank" href="../">مشاهده صفحه اصلی</a></li>
            <li class="logo"><a href="#"><img src="../assets/images/cmsicon.png"></a></li>
        </ul>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>