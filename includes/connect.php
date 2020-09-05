 <?php

 $Option = [
     PDO::ATTR_PERSISTENT => TRUE,
     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
 ];

 try {
     $conn = new PDO('mysql:host=localhost;dbname=blogCMS;charset=utf8;',"ahmad","password" , $Option);
 }catch (PDOException $e)
 {
     echo $e->getMessage();
 }