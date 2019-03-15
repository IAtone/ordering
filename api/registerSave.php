<?php
  include 'conn.php';
  $valid = true;
  $message = '';

  if(isset($_POST['send']) && $_POST['send']==1){

    if(isset($_POST['email']) && $_POST['email']!=""){
        $email = $_POST['email'];
    }else{
         $valid = false;
          $message = 'email帐号不能为空';
    }
      
    if(isset($_POST['password']) && $_POST['password']!=""){
        $password = sha1($_POST['password']);
    }else{
        $valid = false;
        $message = '密码不能为空, 必须输入的';
    }

    if($valid){
         $result = mysqli_query($conn,"SELECT * FROM ordering_users WHERE userEmail = '$email'");
         if(mysqli_num_rows($result) == 0){

             $sql = "INSERT INTO ordering_users(userEmail,password)VALUES('$email','$password')";

             if(mysqli_query($conn,$sql)){
                $message = '注册成功';
             }else{
                $valid = false;
                $message = '注册失败'.$sql;
             }

         }else{
            $valid = false;
            $message = '邮箱已经存在!请重新选择!';
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