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
            <?php 
                    $pro = new product();
                    $result=$pro->getList();
                    while ($set = $result ->fetch()):
                    ?>
            <form action="../controller/index.php" method="post">
            <input type="hidden" name="action" value="add_cart"/>
  <table>
  <tr>
  <th>Hình ảnh</th>
  <th>Tên sản phẩm</th>
  <th>Giá</th>
  <th>Mô tả </th>
  </tr>
  <tr><input type="hidden" name ="productkey" value ="<?php echo $set['productid']; ?>"/>
  <td><img src="../img/<?php echo $set['image'] ; ?>" width="150" height=""></td>
  <td><?php echo $set['name'] ; ?></td>
  <td><?php echo $set['price'] .'VNĐ'; ?> </td>
  <td><input style="background:#C30;color:whitesmoke;cursor:pointer;border:none;margin-left:-5em" type="submit" name="add_cart" value="Buy now">
      <select style="float:left; margin-left:6em " name="itemqty">
                                            <?php 
                                            for ($i=1; $i<=10;$i++):
                                            ?>
                                            <option value="<?php echo $i; ?>">
                                            <?php echo $i; ?>
                                            </option>
                                            <?php endfor; ?>
                                        </select></td>
  </tr>
  <?php endwhile; ?>
  </table>
	</div>
  
<?php include "content.php" ?>
<?php include "footer.php" ?>

</div>
</body>
</html> 