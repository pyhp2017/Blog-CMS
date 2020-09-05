<?php require_once 'pages/header.php'?>

<!--Body Div-->
<div class="body">

    <?php require_once 'pages/sidebar.php'?>

    <?php
//     error_reporting(E_ALL);
//     ini_set('display_errors','1');
        $fetchData = fetchCategoryById($_GET['edit'] , false);
        if($_GET['edit']){
            if(isset($_POST['id']))
            {
                $updated = updateCategory($_POST['id']);
                if($updated)
                {
                header("location:editCategory.php?success=ok&edit={$_POST['id']}");
                die();
                }
                else{
                header("location:editCategory.php?error=ok");
                die();
                }
            }
        }
    ?>

    <div class="content">
        <form action="" method="post">
            <input type="hidden" value="<?php if(isset($fetchData)) echo $fetchData->id; ?>" class="textbox" name="id" placeholder="آی دی دسته بندی">
            <input type="text" value="<?php if(isset($fetchData)) echo $fetchData->title; ?>" class="textbox" name="title" placeholder="عنوان دسته بندی">
            <br>
            <input type="submit" class="btn btn-success" name="editCategory" value="ویرایش کن">
            <input type="reset" class="btn btn-error" value="انصراف">
        </form>
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
