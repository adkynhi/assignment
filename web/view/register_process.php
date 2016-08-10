<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
    <?php

if (isset($_POST['signup']))
{

    $username   = mysql_escape_string($_POST['username']);
    $password   = md5($_POST['password']);
    $fullname   = mysql_escape_string($_POST['fullname']);
    $email      = mysql_escape_string($_POST['email']);
    $telephone  = mysql_escape_string($_POST['telephoneno']);
    $avatar     = $_POST['email'];
    $avatar = $_FILES['avatar']['name'];
    move_uploaded_file($_FILES['avatar']['tmp_name'],'../img/'.$_FILES['avatar']['name']);

    $conn = mysqli_connect('localhost', 'root', '', 'assignment') or die ('Lỗi kết nối');
    mysqli_set_charset($conn, "utf8");

    $sql = "SELECT * FROM user WHERE username = '$username' OR email = '$email'";

    $result = mysqli_query($conn, $sql);
     
    // Kết quả trả về lớn hơn 1 thì nghĩa là username hoặc email đã tồn tại trong CSDL
    if (mysqli_num_rows($result) > 0)
    {
        echo '<script language="javascript">alert("Tài khoản đã bị trùng"); window.location="index.php?action=register";</script>';
        die ();
    }
    else {
        $sql = " INSERT INTO user (userid,name,username,password,email,sdt,avatar) VALUES ('','$fullname','$username','$password','$email','$telephone','$avatar')";
          
        if (mysqli_query($conn, $sql)){
            echo '<script language="javascript">alert("Đăng ký thành công"); window.location="index.php?action=home";</script>';
        }
        else {
            echo '<script language="javascript">alert("Có lỗi trong quá trình xử lý"); window.location="index.php?action=register";</script>';
        }
    }
}