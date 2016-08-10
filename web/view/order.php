<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Hóa đơn thanh toán</title>
<link rel="stylesheet" type="text/css" href="../style/style.css">
</head>

<body>
    <div class="wrapper" style="margin-top:-1.3em">
<?php include "header.php" ?> 
<div style="margin-left:1em;margin-bottom:3em ">
             <?php 
            $result=$o->getOrder($_SESSION['oder_id']);
            $odi=$result[0];
            $dc=$result[1];
            $ctid=$result[3];
            $ctn=$result[4];
            $d=new DateTime($dc);
            echo '<h1 style="color:background">Hóa đơn:'.$odi.'</h1>';
            echo '<h5 style="color:background">Khách hàng:['.$ctid.']'.$ctn.'</h5>';
            echo '<h5 style="color:background">Ngày lập:'.$d->format('d/m/Y').'</h5>';
            ?>
            <table width="100%" border="1">
                <tr>
                    <td>Mã hàng</td>
                    <td>Tên</td>
                    <td>Số lượng</td>
                    <td>Đơn giá</td>
                    <td>Thành tiền<td>
                </tr>
                <?php 
                $result1=$o->getOderDetail($_SESSION['oder_id']);
                while($set = $result1->fetch()): ?>
                <tr>
                    <td><?php echo  $set["productid"]; ?></td> 
                    <td><?php echo  $set["name"]; ?></td> 
                    <td><?php echo  $set["quantity"]; ?></td> 
                    <td><?php echo  $set["price"]; ?></td> 
                    <td><?php echo  $set["total"]; ?></td> 
                </tr>
                <?php endwhile; ?>
                <tr>
                    <td colspan='4' style="text-align:right;font-weight:bold;color:black">Tổng hóa đơn:</td>
                    <td style="color:black; font-weight: bold;"><?php echo $result["total"]; ?></td>
                </tr>
            </table>
</div>
<?php include "footer.php" ?>
        </div>
</body>
</html>