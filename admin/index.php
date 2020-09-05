<?php
require_once 'pages/header.php';

?>

<!--Body Div-->
<div class="body">

    <?php require_once 'pages/sidebar.php'?>

    <div class="content">
        <p class="alert alert-info"><?php echo $_SESSION['loggedUser']['account_name'] ?>  به پنل مدیریت خوش اومدی </p>
    </div>
    <div class="clear"></div>
</div>

<?php require_once 'pages/footer.php'?>
