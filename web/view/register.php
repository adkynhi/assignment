<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Register</title><link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    <body>
        <div class="wrapper">
       
        <?php include 'header_unslide.php'; ?>
          <div style="float:left;margin:1em 30em; color: background">
            <h2 style="color: #4D75D6;margin-bottom:1em">Đăng ký tài khoản</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="register_process"/>
    Tài khoản:<br> <input name="username" type="text" size="20" maxlength="50" required placeholder="Nhập tài khoản"><br><br>
    Mật khẩu:<br> <input name="password" type="password" size="20" maxlength="50" required placeholder="Nhập mật khẩu"><br><br>
    Email:<br>
    <input name="email" type="email" size="20" maxlength="50" required placeholder="Nhập Email"><br><br>
    Họ tên:<br> <input  name="fullname" type="text" size="20" maxlength="50" placeholder="Nhập tên họ"><br><br>
    Số điện thoại:<br> <input name="telephoneno" type="number" size="20" maxlength="50" placeholder="Nhập số điện thoại"><br><br>
    Ảnh đại diện:<br> <input name="avatar" type="file"><br><br>

    <input class="cart_btn" type="submit" name="signup" value="Đăng ký">
    <input class="cart_btn" type="reset" value="Nhập lại">
    
    </form>
         </div>
        <?php include "footer.php" ?>
         
        </div>
    </body>
</html>
