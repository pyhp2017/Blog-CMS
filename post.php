<?php require_once 'includes/init.php'; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>CMS</title>
</head>

<body>

<!--Header Div-->
<div class="header">
    <div class="container">
        <ul class="menu">
            <?php
            $selected = selectCategory();
            foreach ($selected as $key=>$value)
            {
                echo "<li><a href='category.php?id={$value->id}'>{$value->title}</a></li>";
            }
            ?>
            <li><a href="admin">ورود ادمین</a></li>
            <li class="logo"><a href="."><img src="assets/images/cmsicon.png"></a></li>
        </ul>
        <div class="clear"></div>
    </div>

    <div class="HeaderPic">
        <img src="assets/images/desk.jpeg">
        <div class="clear"></div>

        <form action="search.php" method="post">
            <div class="search">
                <input type="text" placeholder="جستجو" name="search" class="inputSearch">
                <button class="searchBtn" name="searchBtn">جستجو</button>
                <div class="clear"></div>
            </div>
        </form>

    </div>

    <div class="clear"></div>
</div>

<!--Body Div-->
<div class="body">
    <div class="container" style="display: flex; flex-direction: column">

        <?php
        if(isset($_GET['id']))
        {
            $selectedPost = fetchPostById($_GET['id']);
            if($selectedPost)
            {
                ?>

                <div class="post" style="width: 70%; align-self: center">
                    <div class="postHeader">
                        <h1 class="postTitle"><a href="post.php?id=<?php echo $selectedPost->id ?>"><?php echo $selectedPost->title ?></a></h1>
                        <span><?php echo convertDate($selectedPost->created_at) ?></span>
                        <div class="clear"></div>
                    </div>
                    <div class="postBody">
                        <div style="height: auto" class="postPic">
                            <img src="uploads/<?php echo $selectedPost->image ?>" alt="image">
                        </div>
                        <div class="postDescription">
                            <?php echo $selectedPost->body ?>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="postFooter">
                        <span><?php echo $selectedPost->author ?></span>

                        <div style="float: left">
                        <?php
                        $tags = explode(',',$selectedPost->tags);
                        foreach ($tags as $tag)
                        {
                            echo "<span class='tags'>{$tag}</span>";
                        }
                        ?>
                        </div>

                        <div class="clear"></div>
                    </div>

                    <div class="clear"></div>
                </div>


        <?php
            }
            else{
                echo "<p class='alert alert-error'>مطلبی یافت نشد</p>";
            }
        }
        else{
            echo "<p class='alert alert-error'>مطلبی یافت نشد</p>";
        }

        ?>

        <?php sendComment($_GET['id'],$_POST['comment_author'] , $_POST['comment_body'] ,$_POST['comment_email']) ?>
        <div class="sendComment">
            <div class="commentHeader">
                <h1>ارسال دیدگاه</h1>
            </div>

            <div class="clear"></div>


            <div class="commentBody">
                <form action="" method="post">
                    <input required type="text" name="comment_author" class="textbox" placeholder="نویسنده">
                    <input required type="email" name="comment_email" class="textbox" placeholder="ایمیل">
                    <textarea required class="textbox" name="comment_body" style="height: 150px; resize: none;padding: 12px" placeholder="دیدگاه..."></textarea>
                    <br>
                    <input type="submit" name="btnComment" class="btn btn-success" value="ارسال دیدگاه">
                    <input type="reset" class="btn btn-error" value="انصراف">
                </form>
            </div>

            <div class="commentFooter">

                <?php

                if(isset($selectedPost))
                {
                $dump = fetchAllCommentsByPostId($selectedPost->id);
                foreach ($dump as $value){
                ?>

                <div class="answerComment">

                    <?php if($value->reply == 0 && $value->status) { ?>
                    <div class="info">
                        <span class="comment_author"><?php echo $value->author ?></span>
                        <span class="comment_date">تاریخ : <?php echo convertDate($value->created_at) ?></span>
                        <div class="clear"></div>
                    </div>
                    <div class="userComment">
                        <p class="commentQ">
                            <?php echo $value->body ?>
                        </p>
                    </div>

                        <?php foreach ($dump as $adminValue){ ?>

                            <?php if($adminValue->reply == $value->id && $adminValue->status){ ?>

                                                    <div class="adminComment">
                                                        <div class="info">
                                                            <span class="comment_author" style="color: #21a1ff"><?php echo $adminValue->author ?></span>
                                                            <span class="comment_date">تاریخ: <?php echo convertDate($adminValue->created_at) ?></span>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <p class="admin_reply">
                                                            <?php echo $adminValue->body ?>
                                                        </p>
                                                    </div>

                            <?php }} ?>
                        <?php } ?>


                </div>
                <?php }} ?>
            </div>

        </div>


        <div class="clear"></div>
    </div>

    <!--Footer Div-->
    <div class="footer">
        <p>Coded by Ahmad Foroughi</p>
    </div>

</body>

</html>