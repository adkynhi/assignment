 <?php 
session_start();

include '../model/products.php';
include '../model/order.php';
include '../model/connect.php';
include '../model/cart.php';
include '../model/manage.php';
include '../model/customer.php';

        if(isset($_GET['action']))
            $action = $_GET['action'];
        elseif(isset($_POST['action']))
            $action = $_POST['action'];
        else $action = 'home';
        
switch ($action) {
    case "home":
        include "../view/home.php";
        break;
    case "cart":
        include "../view/cart_view.php";
        break;
    case "contact":
        include "../view/contact.php";
        break;  
    case "products":
        include "../view/products.php";
        break;
	case "products-list":
        include "../view/products-list.php";
        break;
    case "detail":
        include "../view/detail.php";
        break;
     case 'logout':
        session_destroy();
        header('location:index.php');
        break;
      case "add_cart":
        echo add_item($_POST['productkey'],$_POST['itemqty']);
        include "../view/cart_view.php";
        break;
    case "update_cart":
        $new_list = $_POST['newqty']; 
        foreach ($new_list as $key => $qty ) { 
            if ($_SESSION['cart'][$key] != $qty) {
                update_item($key, $qty);
            }
        }
        include '../view/cart_view.php';
        break;
    case "empty_cart":
        unset($_SESSION['cart']);
        include '../view/cart_view.php';
        break;
 
    	case "register":
        include "../view/register.php";
	case "register_process":
        include "../view/register_process.php";
        break;
        case 'order':
        if (!isset($_SESSION['cus_to_mer'])) {
            echo '<script> alert("Vui lòng đăng nhập để thanh toán!");</script>';
            include '../view/login.php';
        } else {
            $o = new Oder();
            $orderId = $o->CreateOder($_SESSION['cus_to_mer']);
            $_SESSION['oder_id'] = $orderId;
            $total = 0;
            foreach ($_SESSION['cart'] as $key => $item) {
                $o->insertOderDetail($orderId, $key, $item['cost'], $item['qty'], $item['total']);
                $total+=$item['total'];
            }
            $o->updateOderTotal($orderId, $total);
            include '../view/order.php';
        }
        break;
    case 'login':
        include '../view/login.php';
        break;
    
    case 'login_process':
    $username = $_POST['username'];
    $password = md5($_POST['password']);
        
        $user = new user();
        $query = $user->getUserByUserName($username);
        if($query)
        {
            $result = $user ->login($username,$password);
            if ($result)
                {
                $_SESSION['cus_to_mer']= $username;
                include '../view/home.php';
                }
            else
                {
                    $_SESSION['pass_fail']= $username;
                    include '../view/FBloginstyle.php';
                }
        }
        else { echo "<script>javascript: alert('Sai tài khoản hoặc mật khẩu')></script>";
               include '../view/login.php';
        }
        break;
        
        
    case "changeinfo_form":
        include "../view/userdetail.php";
        break;
    case "changeInfo";
        $tmpId = $_POST['userid'];
        $tmpUsername = $_POST['username'];
        $tmpPassword = md5($_POST['password']);
        $tmpFullname = $_POST['name'];
        $tmpEmail = $_POST['email'];
        $tmpTelephone = $_POST['telephone'];
        move_uploaded_file($_FILES['avatar']['tmp_name'],'../img/'.$_FILES['avatar']['name']);
        $avatar = $_FILES['avatar']['name'];
        $user = new user();
        $user->upadateUser($tmpId, $tmpUsername, $tmpPassword, $tmpFullname, $tmpEmail, $tmpTelephone, $avatar);
        header("Location:./index.php");
        echo "<script>javascript: alert('Cập nhật thành công')></script>"; }
?>