<?php require_once 'pages/header.php'?>

<!--Body Div-->
<div class="body">

    <?php
    require_once 'pages/sidebar.php';
    ?>

    <div class="content">
        <?php

        if(isset($_GET['delete']))
        {
            $remove =  delete_comment($_GET['delete']);
            if ($remove) {
                header('location:comments.php?success=ok');
            } else {
                header('location:comments.php?error=ok');
            }
        }


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
                <th>مطلب</th>
                <th>نویسنده</th>
                <th>ایمیل</th>
                <th>دیدگاه</th>
                <th>تاریخ</th>
                <th>وضعیت</th>
                <th width="10%">پاسخ دادن</th>
                <th width="10%">عملیات</th>
            </tr>
            </thead>

            <tbody>

            <?php


            if (isset($_GET['confirm'])) {
                $result = confirm_comment($_GET['confirm']);
//                var_dump($result);
                if ($result) {
                    header('location:comments.php?success=ok');
                } else {
                    header('location:comments.php?error=ok');
                }
            } else if (isset($_GET['reject'])) {
                $result = reject_comment($_GET['reject']);
//                var_dump($result);
                if ($result) {
                    header('location:comments.php?success=ok');
                } else {
                    header('location:comments.php?error=ok');
                }
            }


            $comments = selectAllComments();
            foreach ($comments as $index=>$value){
            ?>

                <tr>
                    <td><?php echo $index+1 ?></td>
                    <td><?php echo fetchPostById($value->post_id)->title ?></td>
                    <td><?php echo $value->author ?></td>
                    <td><?php echo $value->email ?></td>
                    <td><?php echo $value->body ?></td>
                    <td><?php echo convertDate($value->created_at) ?></td>


                    <td>
                        <?php

                        if($value->status)
                        {?>
                            <a class="status_del" href="comments.php?reject=<?php echo $value->id ?>">رد نظر</a>
                        <?php

                        }
                        else
                            {?>

                                <a class="status" href="comments.php?confirm=<?php echo $value->id ?>">تایید نظر</a>
                                <?php

                        }

                        ?>
                    </td>
                    <td>
                        <?php if($value->reply == 0){ ?>
                        <a class="answer" href="reply.php?id=<?php echo $value->id ?>">پاسخ دادن</a>
                        <?php }else{ ?>
                            <a class="answer_admin">پاسخ ادمین</a>
                        <?php } ?>
                    </td>
                    <td>
                        <a class="delete" href="comments.php?delete=<?php echo $value->id ?>" >حذف</a>
                        <a class="edit" href="editComment.php?edit=<?php echo $value->id ?>">ویرایش</a>
                    </td>
                </tr>



                <?php
            } ?>


            </tbody>
        </table>


    </div>
    <div class="clear"></div>
</div>

<?php require_once 'pages/footer.php'?>
