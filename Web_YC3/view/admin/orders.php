<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title><link rel="stylesheet" type="text/css" href="../style/style.css">
    </head>
    
    <body>
        <div class="button"><a href="?action=admincp"><strong>Quản lý sản phẩm</strong></a></div>
        <div class="button"><a href="?action=order"><strong>Quản lý đơn hàng</strong></a></div>
         <div class="button"><a href="?action=user"><strong>Quản lý tài khoản khách hàng</strong></a></div>

        <p style="clear: both"></p>
        <div class="button"><a href="../index.php?action=home">Về trang chủ</a></div>
        <div class="button"><a href="../index.php?action=logout">Đăng xuất</a></div>
        <br/><br/>

            <table width="1280" border="1" cellpadding="5">
                <tr>
                    <td>Mã đơn hàng</td>
                    <td>Ngày thành lập</td>
                    <td>Thành tiền</td>
                    <td>Mã khách hàng</td>
                </tr>
                <?php 
                $n = new Oder();
                $r=$n->Order();
                while($set = $r->fetch()):
                ?>
                <tr>
                    <td><?php echo  $set["orderid"]; ?></td> 
                    <td><?php echo  $set["datecreate"]; ?></td> 
                    <td><?php echo  $set["total"]; ?></td> 
                    <td><?php echo  $set["userid"]; ?></td> 
                </tr>
                <?php endwhile; ?>
            </table>
</div>
    </body>
</html>
