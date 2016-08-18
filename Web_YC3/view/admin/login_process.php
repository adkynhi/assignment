<!DOCTYPE html>
<html>
    <head>
<meta charset="utf-8">
        <title></title><link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    <body>
        <div class="wrapper">
        
<?php
session_start();

if (isset($_POST['login'])) 
{
	$username = $_POST['txtUsername'];
	$password = md5($_POST['txtPassword']);
    // Kết nối CSDL
    $conn = mysqli_connect('localhost', 'root', '', 'assignment') or die ('Lỗi kết nối');
    		mysqli_set_charset($conn, "utf8");
	
    //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
    if ( !$username || !$password ) {
        echo '<div style="width: 40em; padding:1em; background-color: #C30; font-weight:bold; font-size:1.2em; color:white; margin:auto">';
        echo "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu. <a style='color:white' href='javascript: history.go(-1)'>Trở lại</a>";
        echo '</div>';
        exit;
    }
     
    //Kiểm tra tên đăng nhập có tồn tại không
    $query = "SELECT username,password FROM admin WHERE username='$username'" ;
	$result = mysqli_query($conn,$query);
    if (mysqli_num_rows($result) === 0) {
         echo '<div style="width: 40em; padding:1em; background-color:background; font-weight:bold; font-size:1.2em; color:white; margin:auto">';
        echo "Tên đăng nhập này không tồn tại. Vui lòng kiểm tra lại. <a style='color:white' href='javascript: history.go(-1)'>Trở lại</a>";
        echo '</div>';
        exit;
    }
     
    //Lấy mật khẩu trong database ra
    $row = mysqli_fetch_array($result);
     
    //So sánh 2 mật khẩu có trùng khớp hay không
    if ($password != $row['password']) {
         echo '<div style="width: 40em; padding:1em; background-color:background; font-weight:bold; font-size:1.2em; color:white; margin:auto">';
        echo "Mật khẩu không đúng. Vui lòng nhập lại. <a style='color:white' href='javascript: history.go(-1)'>Trở lại</a>";
        echo '</div>';
        exit;
    }
     
    //Lưu tên đăng nhập
    $_SESSION['username'] = $username;
     echo '<div style="width: 40em; padding:1em; background-color:background; font-weight:bold; font-size:1.2em; color:white; margin:auto">';
    echo "Xin chào " . $username . ". Bạn đã đăng nhập thành công. <a style='color:white' href='?action=admincp'>Vào trang AdminCP</a>";
    echo '</div>';
    die();
}
?>
</div>
  </body>
</html>