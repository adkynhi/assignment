<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<body>
	<div class="top"> <!-- top -->
    	<div class="banner"> <!-- banner -->
                <div class="logo">
                <?php if (isset($_SESSION['cus_to_mer']))
                    { 
                echo ' <a href="#">'; echo ' Xin chào ' . $_SESSION['cus_to_mer']. ' ||';echo '</a>';
                echo ' <a href="?action=changeinfo_form">Profile || </a>';
                echo ' <a href="?action=logout">Logout</a>';
                    }
                
                else{?>   
                    <a href="?action=login">Đăng nhập</a> || <a href="?action=register">Đăng ký</a><?php } ?></div>
   
           
            <div style="float:right; margin-right:1em;font-size:0.8em;color:whitesmoke">HOTLINE: (+84)163 684 8453</div> <!-- hotline -->
            <div style="float:left;margin-top:2.5em"><form class="form"><a href="http://google.com.vn"><img style="position:absolute;top:46px;left:152px" src="../img/gicon.png" width="21px"/></a><input type="text" name="txtsearch" placeholder="Google Search"></form></div>
      </div> <!-- end banner -->
      <div style="float:right" class="logo"><a href="#"><img src="../img/logo.png" width="82"></a></div>
      <div class="menu"> <!-- menu -->
      	<ul>
        	<li><a href="index.php?action=home">Trang chủ</a></li>
            <li><a href="#">Giới thiệu</a></li>
            <li><a href="index.php?action=products">Sản phẩm</a></li>
            <li><a href="index.php?action=cart">Giỏ hàng</a></li>
            <li><a href="index.php?action=contact">Liên hệ</a></li>  
        </ul>
        
      </div> <!-- end menu -->
      <div><iframe src="slider.html" style="width:1366px;height:425px;max-width:100%;overflow:hidden;border:none;padding:0;margin:0 auto;display:block;" marginheight="0" marginwidth="0"></iframe></div>
    </div> <!-- end top -->

</body>
</html>