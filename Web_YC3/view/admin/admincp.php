<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title><link rel="stylesheet" type="text/css" href="../style/style.css">
    </head>
    
    <body>
    <div class="wrapper">
        
        <div class="button"><a href="?action=admincp"><strong>Quản lý sản phẩm</strong></a></div>
        <div class="button"><a href="?action=order"><strong>Quản lý đơn hàng</strong></a></div>
         <div class="button"><a href="?action=user"><strong>Quản lý tài khoản khách hàng</strong></a></div>

        <p style="clear: both"></p>
        <div class="button"><a href="?action=insert">+ Thêm sản phẩm</a></div>
        <div class="button"><a href="../index.php?action=home">Về trang chủ</a></div>
        <div class="button"><a href="../index.php?action=logout">Đăng xuất</a></div>
        <br/><br/>
        <table width="1280" border="1" cellpadding="5">
            <tr>
                <td>ID</td>
                <td>Tên sản phẩm</td>
                <td>Hình ảnh</td>
                <td>Giá</td>
                <td>Chi tiết</td>
                <td>Sửa</td>
                <td>Xóa</td>
            </tr>
            <?php            
            $n = new manage();
            $r = $n->getList();
            while($set = $r->fetch()):
        ?>
                <tr>
                    <td><?php echo $set[0]; ?></td>
                    <td><?php echo $set[1]; ?></td>
                    <td> <img src="../img/<?php echo $set[2]; ?>" width="100" height="100"></td>
                    <td><?php echo $set[3]; ?></td>
                    <td><?php echo $set[4]; ?></td>
                    <td><div class="button"><a href="?action=update&id=<?php echo $set[0]; ?>">Update</a></div></td>
                    <td><div class="button"><a href="?action=delete&id=<?php echo $set[0]; ?>">Delete</a></div></td>
                </tr>
                
        <?php
            endwhile;
            echo "</table>";
        ?>
                
      </div>
    </body>
</html>
