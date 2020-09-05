<?php require_once 'pages/header.php'?>

<!--Body Div-->
<div class="body">

    <?php
    require_once 'pages/sidebar.php';
    ?>


    <div class="content">

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
                <th>عنوان</th>
                <th>دسته بندی</th>
                <th>نویسنده</th>
                <th>تاریخ</th>
                <th>تصویر</th>
                <th>برچسب</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(isset($_GET['delete']))
            {
                $deleted = deletePostById($_GET['delete']);
                if($deleted)
                {
                    header("location:ShowPosts.php?success=ok");
                    die();
                }
                else
                {
                    header("location:ShowPosts.php?error=ok");
                    die();
                }
            }
            $selectAllPost = selectAllPosts();
            if($selectAllPost)
            {

            foreach ($selectAllPost as $index=>$value)
            {
            ?>
            <tr>
                <td><?= $index+1 ?></td>
                <td><?= $value->title ?></td>
                <td><?php echo fetchCategoryById($value->Category_id,true)->title ?></td>
                <td><?= $value->author ?></td>
                <td><?php echo convertDate($value->created_at) ?></td>
                <td><img width="60" height="50" src="../uploads/<?php echo $value->image ?>" alt="post image"></td>
                <td><?php echo $value->tags ?></td>
                <td>
                    <a class="delete" href="ShowPosts.php?delete=<?php echo $value->id  ?>" >حذف</a>
                    <a class="edit" href="editPost.php?edit=<?php echo $value->id ?>">ویرایش</a>
                </td>
            </tr>
            <?php }}else{
                ?>
                <td colspan="8" class="alert alert-info">مطلبی وجود ندارد!</td>
                <?php
            } ?>
            </tbody>
        </table>

        <div class="pages" style="text-align: center">
            <?php
            if (isset($count)) {
                for ($i=1; $i<= $count ; $i++)
                {
                    if($i==@$_GET['page'])
                    {
                        echo "<a href='ShowPosts.php?page={$i}' class='pageC active'>{$i}</a>";
                    }
                    else{
                        echo "<a href='ShowPosts.php?page={$i}' class='pageC'>{$i}</a>";
                    }
                }
            }
            ?>
            <div class="clear"></div>
        </div>

    </div>
    <div class="clear"></div>
</div>

<?php require_once 'pages/footer.php'?>
