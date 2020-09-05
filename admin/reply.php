<?php require_once 'pages/header.php'?>

<!--Body Div-->
<div class="body">

    <?php require_once 'pages/sidebar.php'; ?>

    <div class="content">

        <?php $selected = fetch_comment_by_id($_GET['id']) ?>

        <div class="commentFooter">
            <div class="answerComment">
                <div class="info">
                    <span class="comment_author"><?php echo $selected->author ?></span>
                    <span class="comment_date"><?php echo convertDate($selected->created_at) ?></span>
                    <div class="clear"></div>
                </div>
                <div class="userComment">
                    <p class="commentQ">
                        <?php echo $selected->body ?>
                    </p>
                </div>
            </div>
        </div>

        <br>

        <?php

        if($_POST['btnComment'])
        {
            $result = send_reply($selected->id , $_POST['comment_body'] , $_SESSION['loggedUser']['account_name']);
            if ($result) {
                header('location:comments.php?success=ok');
            } else {
                header('location:comments.php?error=ok');
            }
        }

        ?>
        <form action="" method="post">
            <p class='alert alert-info'>پاسخ ادمین</p>
            <div class="commentBody">
                <textarea required class="textbox" name="comment_body" style="height: 150px; resize: none;padding: 12px" placeholder="دیدگاه..."></textarea>
                <br>
                <input type="submit" name="btnComment" class="btn btn-success" value="ارسال پاسخ">
                <input type="reset" class="btn btn-error" value="انصراف">
            </div>
        </form>

    </div>
    <div class="clear"></div>
</div>

<?php require_once 'pages/footer.php'?>
