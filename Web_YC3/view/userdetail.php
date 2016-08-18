<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Thông tin tài khoản</title>
<link rel="stylesheet" type="text/css" href="../style/style.css">
</head>
<style>
    td,tr { text-align: left; font-size: 1em; width:30em  }
</style>
<body>
    <div class="wrapper">
         <?php include 'header_unslide.php'; ?>
          <div style="float:left;margin:1em 30em;color: background">
<?php  
            echo '<h2>Cập nhật thông tin thành viên</h2>'; ?>
        <div class="content">
            <form method="POST" action="index.php?action=changeInfo" enctype="multipart/form-data">
                <?php
                $users = new user();
                $user = $users->getUserByUserName($_SESSION['cus_to_mer']);
                ?>
                <table style="margin-bottom:5em">
                    <?php if(isset($users)):?>
                    <tr>
                        <td>
                            <label for="txtId">Mã tài khoản</label>
                        </td>
                        <td>
                            <input type="text" name="userid" id="txtId"
                                   <?php if(isset($users)) echo "value='".$user['userid']."'"?>
                                   />
                        </td>
                    </tr>
                    <?php endif; ?>
                    
                    <tr>
                        <td>
                            <label for="txtUser">Tên tài khoản</label>
                        </td>
                        <td>
                            <input type="text" name="username" id="txtUser"
                                   <?php if(isset($users)) echo "value='".$user['username']."'"?>
                                   />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="txtPass">Mật khẩu</label>
                        </td>
                        <td>
                            <input type="password" name="password" id="txtPass"
                                   <?php if(isset($users)) echo "value='".$user['password']."'"?>
                                   />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="txtFullname">Tên đầy đủ</label>
                        </td>
                        <td>
                            <input type="text" name="name" id="txtFullname"
                                   <?php if(isset($users)) echo "value='".$user['name']."'"?>
                                   />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="txtEmail">Email</label>
                        </td>
                        <td>
                            <input type="text" name="email" id="txtEmail"
                                   <?php if(isset($users)) echo "value='".$user['email']."'"?>
                                   />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="txtTelephone">Điện thoại</label>
                        </td>
                        <td>
                            <input type="text" name="telephone" id="txtTelephone"
                                   <?php if(isset($users)) echo "value='".$user['sdt']."'"?>
                                   />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="txtAvatar">Ảnh đại diện</label>
                        </td>
                        <td>
           <?php
             if(isset($users)) { echo "<img src='../img/".$user['avatar']."' width='175'".'"/>';
             echo '<br><input type="file" name="avatar">'; } ?>                                               
                                
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input class="cart_btn" type="submit" name="btnOK" value="OK"/>
                            <input class="cart_btn" type="reset" name="btnReset" value="Reset"/>
                        </td>
                    </tr>
                </table>
            </form>
            
            <h2>Danh sách thành viên</h2>
        <table>
            
            <th width="180px">Ảnh thành viên</th>
            <th width="180px">Tên thành viên</th>
           
        <?php
            $n = new user();
            $r = $n->getListExceptUser($_SESSION['cus_to_mer']);
            
            echo '<table style="margin-bottom:5em">';
            while($set = $r->fetch()):
        ?>
                <tr>
                    <td width="282px" ><img style="border-radius:40px" src="../img/<?php echo $set['avatar']; ?>" width="60"/></td>
                    <td width="282px" ><span><?php  echo $set['username']; ?></span></td>    
                </tr>
         
        <?php
            endwhile;
            echo "</table>";
        ?>  
            
        </div>
          </div>
        <?php include "footer.php" ?> 
    </div>
    </body>
</html>
