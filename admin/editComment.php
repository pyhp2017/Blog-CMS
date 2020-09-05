<?php require_once 'pages/header.php'?>

<!--Body Div-->
<div class="body">

    <?php require_once 'pages/sidebar.php'?>

    <?php

        if (isset($_GET['edit']))
        {
            $givenComment = fetch_comment_by_id($_GET['edit']);

            if(isset($_POST['btnComment']))
            {
                $edit =edit_comment($_GET['edit'],$_POST['comment_body']);
                if($edit){
                    header('location:comments.php?success=ok');
                } else {
                    header('location:comments.php?error=ok');
                }

            }

        }

    ?>

    <div class="content">

        <div class="commentBody">
            <form action="" method="post">
                <input required disabled type="text" value="<?php if(isset($givenComment)) echo $givenComment->author ?>" name="comment_author" class="textbox" placeholder="نویسنده">
                <input required disabled type="email" value="<?php if(isset($givenComment)) echo $givenComment->email ?>" name="comment_email" class="textbox" placeholder="ایمیل">
                <textarea required class="textbox" name="comment_body" style="height: 150px; resize: none;padding: 12px" placeholder="دیدگاه..."><?php if (isset($givenComment)) echo $givenComment->body ?></textarea>
                <br>
                <input type="submit" name="btnComment" class="btn btn-success" value="ویرایش دیدگاه">
                <input type="reset" class="btn btn-error" value="انصراف">
            </form>
        </div>
        <?php
        if(isset($_GET['success'])){
            echo "<p class='alert alert-success'>ویرایش با موفقیت انجام شد</p>";
        }
        else if(isset($_GET['error']))
        {
            echo "<p class='alert alert-error'>ویرایش انجام نشد!</p>";
        }
        ?>


    </div>
    <div class="clear"></div>
</div>

<?php require_once 'pages/footer.php'?>
