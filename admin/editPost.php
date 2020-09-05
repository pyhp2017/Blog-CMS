<?php require_once 'pages/header.php'?>

    <!--Body Div-->
    <div class="body">
        <?php require_once 'pages/sidebar.php'; ?>

        <?php

        if(isset($_GET['edit']))
            {
                $fetched = fetchPostById($_GET['edit']);
                if(isset($_POST['editPost']))
                {
                    $updated = updatePost($_GET['edit']);
                    if($updated)
                    {
                        header("location:editPost.php?success=ok&edit={$_GET['edit']}");
                        die();
                    }
                    else{
                        header("location:editPost.php?error=ok");
                        die();
                    }
                }
            }

        ?>

        <div class="content">
            <?php
            error_reporting(E_ALL);
            ini_set('display_errors','1');

            if(isset($_GET['success'])){
                echo "<p class='alert alert-success'>ویرایش با موفقیت انجام شد</p>";
            }
            else if(isset($_GET['error']))
            {
                echo "<p class='alert alert-error'>ویرایش انجام نشد!</p>";
            }
            ?>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="text" required="required" class="textbox" name="post_title" value="<?php if(isset($fetched)) echo $fetched->title ?>">

                <select name="post_category_id" class="textbox">
                    <?php if(isset($fetched)){ ?>
                    <?php $selected = selectCategory(); ?>
                    <?php
                    foreach($selected as $value)
                    {
                        if($value->id == $fetched->Category_id)
                        {
                            echo "<option value='{$value->id}' selected>{$value->title}</option>";
                        }
                        else
                        {
                            echo "<option value='{$value->id}'>{$value->title}</option>";
                        }
                    }
                    }?>
                </select>

                <!--            Hello Hackers :))) -->
                <input type="text" name="post_author" required="required" class="textbox" value="<?php if(isset($fetched)) echo $fetched->author ?>" hidden>

                <p><span>پیش نمایش:</span></p>
                <div class="thumbnail">
                    <?php if(isset($fetched)){ ?>
                        <img src="../uploads/<?php echo $fetched->image ?>" alt="Fetched" width="70" height="70">
                    <?php } ?>
                </div>


                <div class="selectPic">
                    <input type="file" name="post_img" required="required">
                </div>


                <textarea name="post_body" required="required" class="textbox" style="height: 230px;padding: 15px;"
                          placeholder="توضیحات مطلب"><?php if(isset($fetched)) echo $fetched->body ?></textarea>
                <input type="text" required="required" name="post_tags" class="textbox" placeholder="برچسب ها" value="<?php if(isset($fetched)) echo $fetched->tags ?>">
                <br>
                <input type="submit" class="btn btn-success" name="editPost" value="ویرایش مطلب">
                <input type="reset" class="btn btn-error" value="انصراف">
            </form>
        </div>
        <div class="clear"></div>
    </div>

<?php require_once 'pages/footer.php'?>