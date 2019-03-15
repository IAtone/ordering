<?php
   //     if (!isset($_COOKIE["username"])){
   //      echo json_encode(
   //      array('vaild' => false,'isLogin' =>'您未登陆'),JSON_UNESCAPED_UNICODE
   //      );
   //     exit();
   //  }
   include 'conn.php';
   
   if(isset($_GET['email']) AND $_GET['email']!=""){
      $email = htmlentities($_GET['email'],ENT_QUOTES,'UTF-8');
      $result = mysqli_query($conn,"SELECT userEmail,userName,userLevel,userAvatar,phoneNumber FROM ordering_users WHERE userEmail = '$email'");
   }else{
      $result = mysqli_query($conn,'SELECT userEmail,userName,userLevel,userAvatar,phoneNumber  FROM ordering_users');
   }
   if(!$result) {
      printf(mysqli_error($conn));
   }
   
   $users = mysqli_fetch_all($result,MYSQLI_ASSOC);

   echo json_encode($users);

