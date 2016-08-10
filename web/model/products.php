<?php
class product {
    var $ProducID=null;
    var $ProductName=null;
    var $ProductImage=null;
    var $ProductPrice=null;
    
    public function __construct() {}
    
function getList(){
    $db = new connection();
    $select='select * from products';
    $result=$db->getList($select);
    return $result;
}

function getListPage($from,$to){
    $db=new connection();
    $select="Select * from products limit $from,$to";
    $result=$db->getList($select);
    return $result;
}

function getProductById($key){
    $db = new connection();
    $select="select * from products where productid=$key";        
    $result = $db->getInstance($select);
    return $result;
}
}

 ?>


