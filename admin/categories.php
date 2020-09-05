<?php require_once 'pages/header.php'?>

<!--Body Div-->
<div class="body">

    <?php
    require_once 'pages/sidebar.php';
    ?>

    <?php
        $added = categoryExist($_POST['title']);
        if($added)
        {
            header("location:categories.php?error=ok");
            die();
        }
        else
        {
            $added = addCategory();
        }
    ?>

    <div class="content">
        <form action="" method="post">
            <input type="text" class="textbox" name="title" placeholder="عنوان دسته بندی">
            <input type="submit" class="btn btn-success" name="insertCategory" value="اضافه کن">
            <input type="reset" class="btn btn-error" value="انصراف">
        </form>
        <?php
            if(isset($_GET['success'])){
                echo "<p class='alert alert-success'>عملیات با موفقیت انجام شد</p>";
            }
            else if(isset($_GET['error']))
            {
                echo "<p class='alert alert-error'>عملیات انجام نشد!</p>";
            }
        ?>

        <table>
            <thead>
            <tr>
                <th>ردیف</th>
                <th>نام دسته</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>

            <?php
            if(isset($_GET['delete']))
            {
                $deleted = deleteCategory($_GET['delete']);
                if($deleted)
                {
                    header("location:categories.php?success=ok");
                    die();
                }
                else
                {
                    header("location:categories.php?error=ok");
                    die();
                }
            }
            $selected = selectCategory();
            if($selected){
            foreach ($selected as $key => $value) {
            ?>

                <tr>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo $value->title; ?></td>
                    <td>
                        <a class="delete" href="categories.php?delete=<?php echo $value->id; ?>" >حذف</a>
                        <a class="edit" href="editCategory.php?edit=<?= $value->id; ?>">ویرایش</a>
                    </td>
                </tr>


            <?php }}
            else{
               ?>
                <td colspan="3" class="alert alert-info">دسته ای وجود ندارد!</td>
            <?php } ?>

            </tbody>
        </table>


    </div>
    <div class="clear"></div>
</div>

<?php require_once 'pages/footer.php'?>
