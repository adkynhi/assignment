<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Danh sách sản phẩm</title>
<link rel="stylesheet" type="text/css" href="../style/style.css">
</head>

<body>
<div class="wrapper">
<?php include "header.php" ?>    
	<div class="dataview">
    	<ul>
    		<li><a href="index.php?action=products">Data Grid View</a></li>
            <li><a href="index.php?action=products-list">Data List View</a></li>
    	</ul>
    </div>
    
	<div class="content-left">
 <?php $pro = new product();
                    $result=$pro->getList();
                    while ($set = $result ->fetch()): ?>
            <form action="../controller/index.php" method="post">
            <input type="hidden" name="action" value="add_cart"/>
			<div class="product">
            <input type="hidden" name ="productkey" value ="<?php echo $set['productid']; ?>"/>
            <img src="../img/<?php echo $set['image'] ; ?>" width="339" height="339">
            <div class="product-detail">
            <p class="p1"><?php echo $set['name'] ; ?></p>
            <p class="p2"><?php echo $set['price'] .'VNĐ' ; ?></p>
            <div class="product-info"><a type="hidden" href="?action=detail&id=<?php echo $set['productid']; ?>">Chi tiết</a></div>
                <div class="product-buy"><input style="background:background;color:whitesmoke;cursor:pointer;border:none" type="submit" name="add_cart" value="Buy now">
                <select style="float: right; margin-top:3px " name="itemqty">
                                            <?php for ($i=1; $i<=10;$i++): ?>
                                            <option value="<?php echo $i; ?>">
                                            <?php echo $i; ?>
                                            </option>
                                            <?php endfor; ?>
                                        </select>
                </div></div></div>
            </form>
                 <?php endwhile;?>    
</div>
  
<?php include "content.php" ?>
<?php include "footer.php" ?>
</div>
</body>
</html> 