<?php
    class Oder {
    public function __construct() {
        
    }
    public function CreateOder($customerID){
        $db= new connection();
        $date = new DateTime("now");
        $dateCreate = $date->format("Y-m-d");
        $select = "INSERT INTO `order` values('NULL','$dateCreate','0','$customerID')";
        $db->exec($select);
        $int = $db->getInstance("SELECT `orderid` from `order` order by `orderid` DESC limit 1");
        return $int[0];
    }
    public function insertOderDetail($oderID,$proID,$price,$Quantily,$Total){
        $db = new connection();
        $strQuery = "INSERT INTO `order_detail` values ('$oderID','$proID','$price','$Quantily','$Total')";
        $result = $db->exec($strQuery);
    }
     public function updateOderTotal($oderID,$Total){
        $db = new connection();
        $strQuery = "UPDATE `order` SET `total` = $Total WHERE `orderid` = $oderID";
        $result = $db->exec($strQuery);
    }
    public function getOrder($orderID){
        $db= new connection();
        $select = "SELECT `orderid`,`datecreate`,`total`,c.`userid`, c.`name` from `order` as o inner join `user` as c on o.`userid` = c.`userid` WHERE `orderid`= $orderID";
        $result = $db->getInstance($select);
        return $result;
    }
    public function getOderDetail($orderID){
        $db= new connection();
        $select= "select m.`productid`, `name` , `quantity` , od.`price`, `total` from `order_detail` as od inner join `products` as m on od.`productid`=m.`productid` WHERE orderid = $orderID";
        $result = $db->getList($select);
        return $result;
    }
    
    public function Order(){
    $db = new connection();
    $select='select * from `order`';
    $result=$db->getList($select);
    return $result;
    }
    
    
    }

?>
