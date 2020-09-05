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
            <li><a href="login.php">ورود ادمین</a></li>
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
    <div class="container">

        <?php
        $selectedPosts = selectAllPosts();
        if($selectedPosts)
        {

        foreach ($selectedPosts as $value){
        ?>

        <div class="post">
            <div class="postHeader">
                <h1 class="postTitle"><a href="post.php?id=<?php echo $value->id ?>"><?php echo $value->title ?></a></h1>
                <span><?php echo convertDate($value->created_at) ?></span>
                <div class="clear"></div>
            </div>
            <div class="postBody">
                <div class="postPic">
                    <img src="uploads/<?php echo $value->image ?>" alt="image">
                </div>
                <div class="postDescription">
                    <?php echo limitBodyString($value->body) ?>
                </div>
                <div class="clear"></div>
            </div>

            <div class="postFooter">
            <span><?php echo $value->author ?></span>
                <a href="post.php?id=<?php echo $value->id ?>" class="ReadMore">ادامه مطلب</a>
                <div class="clear"></div>
            </div>

            <div class="clear"></div>
    </div>

        <?php } } else{
            echo "<p class='alert alert-info'>مطلبی یافت نشد</p>";
        } ?>

        <div class="clear"></div>
        <div class="pages" style="text-align: center">
            <?php
            if (isset($count)) {
                for ($i=1; $i<= $count ; $i++)
                {
                    if($i==@$_GET['page'])
                    {
                        echo "<a href='index.php?page={$i}' class='pageC active'>{$i}</a>";
                    }
                    else{
                        echo "<a href='index.php?page={$i}' class='pageC'>{$i}</a>";
                    }
                }
            }
            ?>
            <div class="clear"></div>
        </div>
</div>

<!--Footer Div-->
<div class="footer">
    <p>Coded by Ahmad Foroughi</p>
</div>

</body>

</html>