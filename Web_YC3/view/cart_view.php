<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<body>
<div class="wrapper">
<?php include "header.php" ?>
<div class="content" style="float:left;width:40em;margin-left:10em">
    <h1 style="color:background" class="cart">Giỏ hàng của bạn</h1>
        <?php if(!isset($_SESSION['cart']) || count($_SESSION['cart'])== 0 ): ?>
        <p style="color:background;"><strong>Chưa có hàng trong giỏ hàng !!</strong></p>
        <?php else: ?>
        <form action="../controller/index.php" method="post">
            <input type="hidden" name="action" value="update_cart"/>
            <table border="1">
                <tr>
                    <td>Tên sản phẩm</td>
                     <td>Giá</td> 
                     <td>Số lượng</td>
                      <td>Tổng cộng</td>
                </tr>
                <?php 
                        foreach ($_SESSION['cart'] as $key =>$item):
                            $cost = number_format($item['cost'],2);
                        $total = number_format($item['total'],2); ?>
                <tr>
                    <td>
                        <?php echo $item['name'];?>
                    </td>
                    <td>
                        <?php echo $cost ?>
                    </td>
                    <td>
                        <input type="text" name="newqty[<?php echo $key; ?>]" value ="<?php echo $item['qty']; ?>"/>
                    </td>
                    <td>
                        <?php echo $total; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" style="text-align: right;">
                        <b style="color:background">Tổng trị giá đơn hàng</b>
                    </td>
                    <td>
                        <?php echo get_subtotal(); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right;">
                        <input class="cart_btn" type="submit" value="Cập nhật"/>
                        <a class="cart_btn" style:="text-decoration:none" href="?action=order">Thanh toán</a>
                    </td>
                </tr>
            </table>
            </form>
        <?php endif; ?>
        <p><a class="cart_btn" href="?action=products">Thêm sản phẩm</a>
        <a class="cart_btn" href="?action=empty_cart">Xóa giỏ hàng</a></p>
        </div>
        <?php include "content.php" ?>
		<?php include "footer.php" ?>
        </div>
    </body>
</html>
