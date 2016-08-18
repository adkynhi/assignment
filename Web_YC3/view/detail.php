<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Chi tiết sản phẩm</title>
<link rel="stylesheet" type="text/css" href="../style/style.css">
</head>

<body>
<div class="wrapper">
<?php include "header.php" ?> 
<?php 
$pro = new product();
$result=$pro->getProductById($_GET['id']);
$set = $result; ?>
<form action="../Controller/index.php" method="post">
<input type="hidden" name="action" value="add_cart"/>
<div class="detailbox">
<h2 style="color:background"><?php echo $set['name'] ; ?></h2>
	<div class="detail_img"><img src="../img/<?php echo $set['image'] ; ?>" width="339" height="339"></div>
        <input type="hidden" name ="productkey" value ="<?php echo $set['productid']; ?>"/>
    <div class="detail_content">
    <hr style="margin-top:0.8em; height:1px;">
    <p style="font-size:0.9em; color:background">Giá mua: <span style="font-size:2em"><?php echo $set['price'] .'VNĐ' ; ?></span> | <span style="color:#CC3300">Giảm ngay 15% khi đến cửa hàng</span></p>
    <hr style="margin-top:0.8em; height:1px;">
    <p style="font-size:0.8em; color:background">Bạn sẽ nhận được hàng trong 2-5 ngày làm việc(tùy địa chỉ).</p>
	<p style="color:background;font-size:0.9em"><strong>(+84)163 684 8453</strong></p>
    <hr style="margin-top:0.8em; height:1px;">
    <p style="color:background ;font-size:1em"><strong>Ghi chú:</strong><?php echo $set['detail'] ; ?></p>
    <hr style="margin-top:0.8em; height:1px;">
    <p style="color:background ;font-size:0.9em"><span style="color:#CC3300">+Lưu ý</span> : Khi nhân viên giao hàng của shop đã giao sản phẩm cho quý khách, nếu quý không không ưng ý sản phẩm, vui 	lòng thanh toán phí giao hàng <span style="color:#CC3300">(chỉ áp dụng đối với TPHCM)</span></p>
    <p style="float:left; margin-left: 5em"><a href="javascript:history.go(-1)"><img src="../img/cart.png" width="120" height="120"></a><p>
    
    </div>
</div>
</form>
<?php include "footer.php" ?>
</div>
</body>
</html> 