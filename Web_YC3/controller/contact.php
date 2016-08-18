<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    <body>
            <table>
            <tr>
        <form action="mail.php" method="post">
            <td>Email:</p> <input type="email" name="username" /></td>
            <td>Tên người gửi</p> <input type="text" name="name" /></td>
            <td>Tiêu đề</p> <input type="text" name="title" /></td>
             <td>Nội dung</p> <textarea name="textarea" style="width:200px; height: 200px" /></textarea></td>
        <td><input type="submit" name="ok" value="Gửi Mail"></td>
        <td><input type="reset"></p></td>
        </form>
        
            </tr>
        </table>
    </body>
</html>
