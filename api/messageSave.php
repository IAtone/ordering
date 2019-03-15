<?php
  include 'conn.php';
  $valid = true;
  $message = '';
  
            if(isset($_POST['email']) && $_POST['email']!=""){
                $email = stripslashes($_POST['email']);
                // htmlentities stripslashes
            }else{
                $valid = false;
                $message = '邮箱为唯一标识，邮箱不能为空';
            } 
            
            if(isset($_POST['comId']) && $_POST['comId']!=""){
                $comId = $_POST['comId'];
            }else{
                $valid = false;
                $message = '商家唯一ID丢失，请退出重新进入';
            }

            if(isset($_POST['username']) && $_POST['username']!="") {
                $username = $_POST['username'];
            } else {
                $valid = false;
                $message = '昵称为空，请在我的界面添加昵称';
            }
                
            if(isset($_POST['content']) && $_POST['content']!=""){
                $content = $_POST['content'];
                // htmlentities stripslashes
            }else{
                $valid = false;
                $message = '评价内容不能为空';
            }  
            
            if(isset($_POST['userAvatar']) && $_POST["userAvatar"]!=""){
                $userAvatar = $_POST['userAvatar'];
                if(preg_match('/^(data:\s*image\/(\w+);base64,)/',$userAvatar,$res)){
                    //获取一个图片类型
                    $type = $res[2];
                   //  图片保存路径
                   $new_Avatar = '../upload/'.date('Ymd',time()).'/';
                   // 判断文件是否存在
                   if(!file_exists($new_Avatar)){
                       mkdir($new_Avatar,0755,true);
                   }
                   // 设置图片名称
                   $new_Avatar = $new_Avatar.time().'.'.$type;
                   // 写入
                   if(file_put_contents($new_Avatar,base64_decode(str_replace($res[1],'',$userAvatar)))){
                       $message = '头像移入成功';
                   }else{
                       $valid = false;
                       $message = '头像移入失败';
                   }
                }
           }else{
               $valid = false;
               $message = '头像不能为空，请在我的页面添加头像';
           }

            $createDate = DATETIME;

            if($valid){
                $sql = "INSERT INTO ordering_com(userEmail,comId,comContent,createTime,userName,userAvatar)VALUES('$email','$comId','$content','$createDate','$username','$new_Avatar')";

                if(mysqli_query($conn,$sql)){
                   $message = '评价成功';
                }else{
                   $valid = false;
                   $message = '评价失败';
                }
            }

  
  echo json_encode(
    array('valid'=>$valid,'message'=>$message),JSON_UNESCAPED_UNICODE
);