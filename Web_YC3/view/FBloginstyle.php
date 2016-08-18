<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Đăng nhập</title>
<link rel="stylesheet" type="text/css" href="../style/style.css">
</head>

<body>
    <div class="wrapper">
        <?php include 'header_unslide.php'; ?>
<?php 
            $users = new user();
            $user = $users->getUserByUserName($_SESSION['pass_fail']);
            $username = $_SESSION['pass_fail']; ?>
          <div style="float:left;margin:1em 30em">
    <form action="" method="POST">
        <input type="hidden" name="action" value="login"/>
        
        <table style="border: 1px background solid;">
            <tr>
    <td>Bạn là:<b><?php echo $username ?></b></td>
    <td><?php echo "<img src='../img/".$user['avatar']."' width='100'".'"/>' ?></td>
    <tr><td>Nhưng đã sai mật khẩu. Vui lòng nhập lại</td></tr>
            </tr>
            <tr>
                <td>Tài khoản</td>
                <td><input type="text" value="<?php echo $username ?>" name ="username"></td>
            </tr>
            
            <tr>
                <td>Mật khẩu</td>
                    <td><input type="password" name="password" id="txtPass"/></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input class="cart_btn" type="submit" name="btnOK" value="OK" onclick="return checkUsername()"/>
                    <input class="cart_btn" type="reset" name="btnReset" value="Reset"/>
                </td>
            </tr>
        </table>
  
    </center>
    </table>
          </div>
   <?php include "footer.php" ?>
    </div>
    </body>
</html>