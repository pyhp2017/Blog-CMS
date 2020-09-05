<?php
require_once 'includes/init.php';

if(isset($_SESSION['loggedUser']))
{
    header("location: admin/");
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>ورود به مدیریت</title>
</head>
<body>

    <div class="container" style= " width: 40% ;background: #fff; padding: 50px; margin: 120px auto; box-shadow: 0 0 3px #ccc;">



        <?php

             error_reporting(E_ALL);
             ini_set('display_errors','1');

            if(isset($_POST['btn_login']))
            {
                $login = login_check($_POST['username'],$_POST['password']);
                if($login)
                {
                    $_SESSION['loggedUser'] = [
                        "username" => $login->username,
                        "account_name"=> $login->account_name
                    ];
                    header("location: admin/");
                }
                else {
                    header("location: login.php?error=ok");
                }
            }

        ?>

        <?php
        if(isset($_GET['error']))
        {
            echo "<p class='alert alert-error'>پسورد نادرست است!</p>";
        }
        ?>
        <form action="" method="post" style="text-align: center">
            <input type="text" class="textbox" name="username" placeholder="نام کاربری">
            <input type="password" class="textbox" name="password" placeholder="رمزعبور">
            <br>
            <input type="submit" class="btn btn-success" name="btn_login" value="ورود به پنل مدیریت">
        </form>
    </div>


</body>
</html>