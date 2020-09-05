<div class="sidebar">
    <div class="accordion">
        <ul>
            <li><a href="./">داشبورد</a></li>
            <li class="has-sub active"><a href="">مدیریت دسته بندی</a>
            <ul>
                <li><a href="categories.php">افزودن دسته جدید</a></li>
            </ul>
            </li>

            <li class="has-sub"><a href="">مدیریت مطالب</a>
                <ul>
                    <li><a href="ShowPosts.php">مشاهده مطالب</a></li>
                    <li><a href="AddPost.php">افزودن مطلب جدید</a></li>
                </ul>
            </li>


            <li class="has-sub"><a href="">مدیریت نظرات</a>
                <ul>
                    <li><a href="comments.php">مشاهده نظرات</a></li>
                </ul>
            </li>


            <li><a href="../logout.php" style="background-color: #b1325a ; color: #fff">خروج</a></li>

        </ul>
    </div>
    <div class="clear"></div>
</div>


<script src="../assets/js/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function (){
        $('.accordion ul li.active').addClass('open').children('ul').show();
        $('.accordion ul li.has-sub > a').click(function (){
            $(this).removeAttr('href');
            var accordion = $(this).parent('li');
            if(accordion.hasClass('open'))
            {
                accordion.removeClass('open');
                accordion.find('ul').slideUp(500);
            }
            else
            {
                accordion.addClass('open');
                accordion.find('ul').slideDown(500);
                accordion.siblings('li').children('ul').slideUp(500);
                accordion.siblings('li').removeClass('open');
            }
        });
    });
</script>