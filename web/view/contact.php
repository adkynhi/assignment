<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Liên hệ</title>
<link rel="stylesheet" type="text/css" href="../style/style.css">
</head>

<body>
    
    <div class="wrapper">
        <?php include 'header_unslide.php'; ?>
        
        <div style="float:left;margin:1em 30em;color: background">
        <h2>Gửi email liên hệ</h2>
        <form action="mail.php" method="post">
            Email:<br> <input type="email" name="username" placeholder="Nhập Email"/><br><br>
            Tên người gửi<br> <input type="text" name="name" placeholder="Họ Tên"/><br><br>
            Tiêu đề<br> <input type="text" name="title" placeholder="Nhập tiêu đề"/><br><br>
            Nội dung<br> <textarea name="textarea" style="width:200px; height: 200px" placeholder="Nội dung" /></textarea><br><br>
        <br><input class="cart_btn" type="submit" name="ok" value="Gửi Mail"> <input class="cart_btn" type="reset"><br>
        </form>
        </div>
    <?php include "footer.php" ?>
                  
        </div>
    </body>
</html>
