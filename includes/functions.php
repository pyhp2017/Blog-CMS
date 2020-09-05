<?php
function addCategory()
{
    global $conn;
    if (isset($_POST['insertCategory']))
    {
            $sql = "insert into Categories (title) values (:category_title)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":category_title",$_POST['title']);
            if($stmt->execute())
            {
                return $stmt;
            }
            else
            {
                return false;
            }
    }
}


function selectCategory()
{
    global $conn;
    $sql = "select * from Categories";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if($stmt->rowCount())
    {
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    else{
        return false;
    }
}

function deleteCategory($category_id)
{
    global $conn;
    if(isset($_GET['delete']))
    {
        $sql = "delete from Categories where id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1,$category_id);
        $stmt->execute();
        if($stmt->rowCount()){
            return $stmt;
        }
        else
        {
            return false;
        }
    }
}


function fetchCategoryById($category_id , $inPost)
{
    global $conn;
    if(isset($_GET['edit']) || $inPost)
    {
        $sql = "select * from Categories where id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1,$category_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

function updateCategory($category_id){
    global $conn;
    if(isset($_POST['title'])) {

        $sql = "update Categories set title=? where id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $_POST['title']);
        $stmt->bindValue(2, $category_id);
        $stmt->execute();
        if ($stmt->rowCount()) {
            return $stmt;
        } else {
            return false;
        }
    }

}

function categoryExist($category_name){
    global $conn;
    $sql = "select * from Categories where title=?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1,$category_name);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_OBJ);
    return $row;
}


function addPost()
{
    global $conn;
    if (isset($_POST['insertPost']))
    {
        $post_title = $_POST['post_title'];
        $post_category_id = $_POST['post_category_id'];
        $post_author = $_POST['post_author'];
        $post_body = $_POST['post_body'];
        $post_tags = $_POST['post_tags'];
        $post_date = date('y-m-d');

        $file = $_FILES['post_img']['name'];
        $extension = explode('.', $file);
        $fileExt = strtolower(end($extension));
        $post_img = md5(microtime() . $file);
        $post_img .= "." . $fileExt;
        $error = $_FILES['post_img']['error'];
        $tmp_name = $_FILES['post_img']['tmp_name'];

        switch ($error) {
            case UPLOAD_ERR_OK;
                $valid = true;
                if (!in_array($fileExt, array('png', 'jpg', 'gif', 'jpeg'))) {
                    $valid = false;
                    echo '<p class="alert alert-warning">پسوند فایل انتخابی باید png , jpg , gif , jpeg باشد</p>';
                }
                if ($error > 200000) {
                    $valid = false;
                    echo '<p class="alert alert-warning">عکس انتخاب شده بیش از حد بزرگ است</p>';
                }
                if ($valid) {
                    $valid = true;
                    echo '<p class="alert alert-success">عکس با موفقیت اپلودشد</p>';
                    move_uploaded_file($tmp_name, '../uploads/' . $post_img);
                    $sql = "INSERT INTO Posts (Category_id , title , author , created_at , image , body , tags) values (:category_id , :title , :author , :created_at , :image , :body , :tags)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":category_id" , $post_category_id);
                    $stmt->bindParam(":title" , $post_title);
                    $stmt->bindParam(":author" , $post_author);
                    $stmt->bindParam(":created_at" , $post_date);
                    $stmt->bindParam(":image" , $post_img);
                    $stmt->bindParam(":body" , $post_body);
                    $stmt->bindParam(":tags" , $post_tags);

                    $stmt->execute();
                    if($stmt->rowCount())
                    {
                        return $stmt;
                    }
                    else{
                        return false;
                    }


                }
                break;
            case UPLOAD_ERR_PARTIAL;
                echo '<p class="alert alert-warning">بخشی از عکس اپلود نشده است</p>';
                break;
            case UPLOAD_ERR_NO_TMP_DIR;
                echo '<p class="alert alert-warning">عکست کجاست؟</p>';
                break;
            default:
                echo '<p class="alert alert-error">خطا در درج</p>';
                break;
        }

    }
}


function selectAllPosts()
{
    global $conn , $count;

    if(!isset($_GET['page']))
    {
        $offset = $_GET['page'] = 1;
    }else{
        $offset = ($_GET['page']-1)*4;
    }

    $sql = "select * from Posts";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $count = ceil($stmt->rowCount()/4);

    $sql = "select * from Posts LIMIT ". $offset . ",4";
    $stmt = $conn->prepare($sql);
    $stmt->execute();


    if($stmt->rowCount())
    {
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    else{
        return false;
    }
}

function fetchPostById($id)
{
    global $conn;
    $sql = "select * from Posts where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1,$id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}


function convertDate($date)
{
    $date = explode('-' , $date);
    return gregorian_to_jalali($date[0],$date[1],$date[2],'/');
}


function deletePostById($id)
{
    global $conn;
    if(isset($_GET['delete']))
    {
        $sql = "delete from Posts where id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1,$id);
        $stmt->execute();
        if($stmt->rowCount()){
            return $stmt;
        }
        else
        {
            return false;
        }
    }
}

function updatePost($post_id)
{
    global $conn;
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category_id'];
    $post_author = $_POST['post_author'];
    $post_body = $_POST['post_body'];
    $post_tags = $_POST['post_tags'];
    $post_date = date('y-m-d');

    $file = $_FILES['post_img']['name'];
    $extension = explode('.', $file);
    $fileExt = strtolower(end($extension));
    $post_img = md5(microtime() . $file);
    $post_img .= "." . $fileExt;
    $error = $_FILES['post_img']['error'];
    $tmp_name = $_FILES['post_img']['tmp_name'];

    switch ($error)
    {
        case UPLOAD_ERR_OK;
            $valid = true;
            if (!in_array($fileExt, array('png', 'jpg', 'gif', 'jpeg'))) {
                $valid = false;
                echo '<p class="alert alert-warning">پسوند فایل انتخابی باید png , jpg , gif , jpeg باشد</p>';
            }
            if ($error > 200000) {
                $valid = false;
                echo '<p class="alert alert-warning">عکس انتخاب شده بیش از حد بزرگ است</p>';
            }
            if ($valid)
            {
                $valid = true;
                echo '<p class="alert alert-success">عکس با موفقیت اپلودشد</p>';
                move_uploaded_file($tmp_name, '../uploads/' . $post_img);
                $sql = "update Posts set Category_id=? , title=? , author=? , created_at=? , image=? , body=? , tags=? where id=?";
                $stmt = $conn->prepare($sql);

                $stmt->bindValue(1, $post_category_id);
                $stmt->bindValue(2, $post_title);
                $stmt->bindValue(3, $post_author);
                $stmt->bindValue(4, $post_date);
                $stmt->bindValue(5, $post_img);
                $stmt->bindValue(6, $post_body);
                $stmt->bindValue(7, $post_tags);
                $stmt->bindValue(8, $post_id);

                $stmt->execute();
                if($stmt->rowCount())
                {
                    return $stmt;
                }
                else{
                    return false;
                }


            }
            break;
        case UPLOAD_ERR_PARTIAL;
            echo '<p class="alert alert-warning">بخشی از عکس اپلود نشده است</p>';
            break;
        case UPLOAD_ERR_NO_TMP_DIR;
            echo '<p class="alert alert-warning">عکست کجاست؟</p>';
            break;
        default:
            echo '<p class="alert alert-error">خطا در درج</p>';
            break;
    }


}


function searchPost($value)
{
    global $conn;
    //search by title
    $sql = "select * from Posts where title like ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1,"%$value%");
    $stmt->execute();
    if($stmt->rowCount())
    {
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    else {
        return false;
    }
}


function limitBodyString($value)
{
    return mb_substr($value,0,70,'utf-8') . '... ';
}

function fetchAllPostsByCategoryId($category_id)
{
    global $conn;
    $sql = "select * from Posts where Category_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1,$category_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function sendComment($post_id , $author , $body , $email)
{

    global $conn;
    $status_default = 0;
    $reply_default = 0;
    if(isset($_POST['btnComment']))
    {
        $comment_created_at = date('y-m-d');
        $sql =  "INSERT INTO Comments (post_id , author , body, status  , email , created_at , reply ) VALUES (:post_id , :author , :body , :status  , :email , :created_at , :reply)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":post_id", $post_id );
        $stmt->bindParam(":author" , $author);
        $stmt->bindParam(":body" , $body);
        $stmt->bindParam(":status" , $status_default);
        $stmt->bindParam(":email" , $email);
        $stmt->bindParam(":created_at" , $comment_created_at);
        $stmt->bindParam(":reply" , $reply_default);

        $stmt->execute();
        if($stmt->rowCount())
        {
            return $stmt;
        }
        else{
            return false;
        }


    }
}


function selectAllComments(){
    global $conn;
    $sql = "SELECT * FROM Comments";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if($stmt->rowCount())
    {
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    else{
        return false;
    }
}

function confirm_comment($comment_id){
    error_reporting(E_ALL);
    ini_set('display_errors','1');

    global $conn;
    $sql = "UPDATE Comments set status=? where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1,1);
    $stmt->bindValue(2,$comment_id);
    $stmt->execute();
    if($stmt->rowCount()){
        return $stmt;
    }else{
        return false;
    }
}

function reject_comment($comment_id){

    global $conn;
    $sql = "UPDATE Comments set status=? where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1,0);
    $stmt->bindValue(2,$comment_id);
    $stmt->execute();
    if($stmt->rowCount()){
        return $stmt;
    }else{
        return false;
    }
}

function fetch_comment_by_id($comment_id){
    global $conn;
    $sql = "select * from Comments where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1,$comment_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}


function send_reply($selected_comment , $body , $admin_name)
{
    global $conn;
    $status_default = 1;
    $reply_default = $selected_comment;
    if(isset($_POST['btnComment']))
    {
        $comment_created_at = date('y-m-d');
        $post_id = fetch_comment_by_id($selected_comment)->post_id;
        $author = $admin_name;
        $email = "admin@cms.com";

        $sql =  "INSERT INTO Comments (post_id , author , body, status  , email , created_at , reply ) VALUES (:post_id , :author , :body , :status  , :email , :created_at , :reply)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":post_id", $post_id );
        $stmt->bindParam(":author" , $author);
        $stmt->bindParam(":body" , $body);
        $stmt->bindParam(":status" , $status_default);
        $stmt->bindParam(":email" , $email);
        $stmt->bindParam(":created_at" , $comment_created_at);
        $stmt->bindParam(":reply" , $reply_default);

        $stmt->execute();
        if($stmt->rowCount())
        {
            return $stmt;
        }
        else{
            return false;
        }


    }

}


function fetchAllCommentsByPostId($post_id){
    global $conn;
    $sql = "select * from Comments where post_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1,$post_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}


function delete_comment($id)
{
    global $conn;
        $sql = "delete from Comments where id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1,$id);
        $stmt->execute();
        if($stmt->rowCount())
        {
            $selectAll = selectAllComments();
            foreach ($selectAll as $value)
            {
                if($value->reply == $id)
                {
                    delete_comment($value->id);
                }
            }
            return $stmt;
        }
        else
        {
            return false;
        }
}


function edit_comment($comment_id , $comment_body)
{
    global $conn;
    $sql = "update Comments set body=? where id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $comment_body);
        $stmt->bindValue(2, $comment_id);
        $stmt->execute();
        if ($stmt->rowCount()) {
            return $stmt;
        } else {
            return false;
        }
}

//function login_Check($user , $pass)
function login_check($user,$pass)
{
    global $conn;
    $sql = "SELECT * FROM Admins WHERE username=? and password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1,$user);
    $stmt->bindValue(2,md5($pass));
    $stmt->execute();
    if($stmt->rowCount())
    {
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    else {
        return false;
    }
}