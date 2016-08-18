<?php
include '../model/products.php';
include '../model/order.php';
include '../model/connect.php';
include '../model/cart.php';
include '../model/manage.php';
include '../model/customer.php';


if(isset($_POST["action"]))
    $action = $_POST["action"];
else if (isset($_GET["action"]))
    $action = $_GET["action"];
else
    $action = "admincp";

switch($action){
    case "admincp":
    include "../view/admin/admincp.php";
    break;
    case "admin_login":
    include "../view/admin/login.php";
    case "admin_login_process":
    include "../view/admin/login_process.php";
    break;
    case "order":
    include "../view/admin/orders.php";
    break;
    case "user":
    include "../view/admin/user.php";
    break;
    
    case "update":
    include "../view/admin/manage_delete.php";
    break;
    case "insert":
    include "../view/admin/manage.php";
    break;
    case "delete":
        include "../view/admin/manage_delete.php";
        break;
    case "insertProcess":   
        $ProductName = $_POST["txtname"];

    if (isset($_FILES['img']))
        { if ($_FILES['img']['error'] > 0)
            { echo 'File Upload Bị Lỗi';}
            else {
                move_uploaded_file($_FILES['img']['tmp_name'], '../img/'.$_FILES['img']['name']);
                echo 'File Uploaded';
                $image = $_FILES['img']['name'];
            }}else{echo 'Bạn chưa chọn file upload';}
        
        $ProductPrice = $_POST["txtprice"];
        $ProductDetail = $_POST["txtdetail"];
        $n = new manage("",$ProductName,$image,$ProductPrice,$ProductDetail);
        $n->insert();
        header("Location:?action=admincp");
        
    case "updateProcess":
        $id = $_GET["txtId"];
        $image = $GET["img"];
        $ProductName = $_GET["txtname"];
        $ProductPrice = $_GET["txtprice"];
        $ProductDetail = $_GET["txtdetail"];      
        $n = new manage($id,$ProductName,$name,$ProductPrice,$ProductDetail);
        $n->update();
        header("Location:?action=admincp");
        break;
        
    case "deleteProcess":
        $id = $_GET["txtId"];                
        $n = new manage($id,NULL,NULL,NULL,NULL);
        $n->delete();
        header("Location:?action=admincp");  
        break;
}

?>
