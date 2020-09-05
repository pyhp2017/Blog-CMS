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
            $posts = fetchAllPostsByCategoryId($_GET['id']);
            if($posts)
            {
                foreach ($posts as $value){
                ?>

                <div class="post" style="width: 70%; align-self: center">
                    <div class="postHeader">
                        <h1 class="postTitle"><a href="post.php?id=<?php echo $value->id ?>"><?php echo $value->title ?></a></h1>
                        <span><?php echo convertDate($value->created_at) ?></span>
                        <div class="clear"></div>
                    </div>
                    <div class="postBody">
                        <div style="height: auto" class="postPic">
                            <img src="uploads/<?php echo $value->image ?>" alt="image">
                        </div>
                        <div class="postDescription">
                            <?php echo $value->body ?>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="postFooter">
                        <span><?php echo $value->author ?></span>
                        <div class="clear"></div>
                    </div>

                    <div class="clear"></div>
                </div>


                <?php
                }
            }
            else{
                echo "<p class='alert alert-error'>مطلبی یافت نشد</p>";
            }
        }
        else{
            echo "<p class='alert alert-error'>چنین دسته ای وجود ندارد</p>";
        }

        ?>





        <div class="clear"></div>
    </div>

    <!--Footer Div-->
    <div class="footer">
        <p>Coded by Ahmad Foroughi</p>
    </div>

</body>

</html>