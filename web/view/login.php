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
         <div style="float:left;margin:1em 30em; color:background">
        <form action="?action=login_process" method="POST">
        <input type="hidden" name="action" value="register_process"/>
        <h2 style="color:#4D75D6;margin-bottom:1em">Đăng nhập</h2>
    Tài khoản:<br> <input  name="username" type="text" size="20" maxlength="50" required placeholder="Nhập tài khoản"><br><br>
    Mật khẩu:<br> <input  name="password" type="password" size="20" maxlength="50" required placeholder="Nhập mật khẩu"><br><br>
                <input class="cart_btn" type="submit" value="Login"/>
            </form>
        </div>
        <?php include "footer.php" ?>
            
        </div>
    </body>
</html>