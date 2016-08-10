<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title><link rel="stylesheet" type="text/css" href="../style/style.css">
    </head>
    
    <body>
    <div class="wrapper">
        <h2 style="color:background">Cập nhật sản phẩm</h2>
        <p></p>
        <?php
                if($_GET["action"]=="update" || $_GET["action"]=="delete"){
                $n = new manage();
                $set = $n->getNewsById($_GET["id"]);
                $id = $_GET["id"];
                }
        ?>
        <form action="?action=insertProcess" method="post" enctype="multipart/form-data">
            <table style="text-align:left">
                <?php if(isset($id)): ?>
                <tr>
                    <td>ID</td>
                    <td><input type="text" name="txtId" value="<?php echo $set[0]; ?>" <?php if(isset($id)){echo "readonly='readonly'";} ?>/></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td>Tên sản phẩm</td>
                    <td><input type="text" name="txtname" value="<?php if(isset($id)){echo $set[1];} ?>" style="width:450px"/></td>
                </tr>
                <tr>
                    <td>Giá</td>
                    <td><input name="txtprice" ><?php if(isset($id)){echo $set[3];} ?></td>
                </tr>
                <tr>
                    <td>Chi tiết</td>
                    <td><textarea style="width:450px" rows="30" type="text" name="txtdetail" value="<?php if(isset($id)){echo $set[4];} ?>"/></textarea></td>
                </tr>
                <tr>
                    <td>Hình ảnh</td>
                    <td><input class="cart_btn" type="file" name="img" id="file" value="<?php if(isset($id)){echo $set[2];} ?>"/></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input class="cart_btn" type="submit" value="Cập nhật"/>
                        <input class="cart_btn" type="reset" value="Nhập lại"/>
                    </td>
                </tr>
            </table>
        </form>
        </div>
    </body>
</html>
