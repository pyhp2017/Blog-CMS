<?php require_once 'pages/header.php'?>

<!--Body Div-->
<div class="body">

    <?php
    require_once 'pages/sidebar.php';
    ?>


    <div class="content">

        <?php addPost(); ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" required="required" class="textbox" name="post_title" placeholder="عنوان مطلب">

            <select name="post_category_id" class="textbox">
                <?php $selected = selectCategory(); ?>
                <?php
                foreach($selected as $value)
                {
                    echo "<option value='{$value->id}'>{$value->title}</option>";
                }
                ?>
            </select>

            <!--            Hello Hackers :))) -->
            <input type="text" name="post_author" required="required" class="textbox" value="<?php echo $_SESSION['loggedUser']['account_name'] ?>" hidden>

            <div class="selectPic">
                <input type="file" name="post_img" required="required">
            </div>

            <textarea name="post_body" required="required" class="textbox" style="height: 230px;padding: 15px;"
                      placeholder="توضیحات مطلب"></textarea>
            <input type="text" required="required" name="post_tags" class="textbox" placeholder="برچسب ها">
            <br>
            <input type="submit" class="btn btn-success" name="insertPost" value="درج مطلب">
            <input type="reset" class="btn btn-error"  value="انصراف">
        </form>
    </div>
    <div class="clear"></div>
</div>

<?php require_once 'pages/footer.php'?>