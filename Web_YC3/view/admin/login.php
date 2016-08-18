<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>AdminCP</title>
<link rel="stylesheet" type="text/css" href="../style/style.css">
</head>

<body>
    <div class="wrapper">
        <div class="admin">
            <h1 style="color: #fff">Fantastic Footwear Shop</h1>
            <div style="margin-top:-1em;color:#fff">Admin control panel</div>
            <hr class="hr">
        <div class="admin_main">
        <form action='' method='POST'>
            
        <input type="hidden" name="action" value="admin_login_process"/>
        
        <h2 style="color:background">Login</h2>
        <table style="text-align:left;" cellpadding='0' cellspacing='0' border='1'>
                <tr>
                    <td style="color:background">
                        Account
                    </td>
                    <td>
                        <input type='text' name='txtUsername' required/>
                    </td>
                </tr>
                <tr>
                    <td style="color:background">
                        Password
                    </td>
                    <td>
                        <input type='password' name='txtPassword' required/>
                    </td>
                </tr>
            </table>
        <p></p> 
        <input class="cart_btn" type='submit' name="login" value='Login' />
        </form>
        </div>
        </div>
        </div>
    </body>
</html>