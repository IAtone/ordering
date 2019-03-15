<?php
  include 'conn.php';
  $valid = true;
  $message = '';


  if(isset($_POST['send']) && $_POST['send']==1){
    if(isset($_POST['username']) AND $_POST['username']!=""){
        $username = htmlentities($_POST['username'],ENT_QUOTES,'UTF-8');
    }
    if(isset($_POST['email']) AND $_POST['email']!=""){
        $email = htmlentities($_POST['email'],ENT_QUOTES,'UTF-8');
    }

    if($valid){

             $sql = "UPDATE ordering_users SET userName='$username' WHERE userEmail= '$email'";

             if(mysqli_query($conn,$sql)){
                $message = '昵称修改成功';
             }else{
                $valid = false;
                $message = '昵称修改失败'.$sql;
             }

  
    }else{
        $valid = false;
        $message = $message;
    }


  }else{
    $valid=false;
    $message = '接口地址来源非法！';
  }



  echo json_encode(
    array('valid'=>$valid,'message'=>$message),JSON_UNESCAPED_UNICODE
);