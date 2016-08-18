<?php
class manage {
    var $productid = null;
    var $name = null;
    var $image = null;
    var $price = null;
    var $detail = null;
    
    public function __construct() {
        if(func_num_args()==5){
            $this->productid = func_get_arg(0);
            $this->name = func_get_arg(1);
            $this->image = func_get_arg(2);
            $this->price = func_get_arg(3);
            $this->detail = func_get_arg(4);
        }
    }
    
    public function getList(){
        $db = new connection();
        $strQuery = "select * from products";
        $r = $db->getList($strQuery);
        return $r;        
    }
    
    public function getNewsById($tmpId){
        $db=new connection();
        $strQuery = "select * from products where productid = $tmpId";
        $r = $db->getInstance($strQuery);
        return $r;
    }
    
    public function insert(){
        $db=new connection();
        $strQuery = "insert into products values (NULL,'$this->name','$this->image','$this->price','$this->detail')";
        $db->exec($strQuery);
    }
    
    public function update(){
        $db=new connection();
        $strQuery = "update products set name = '$this->name', image='$this->image',price='$this->price',detail='$this->detail' where productid=$this->productid";
        $db->exec($strQuery);
    }
    
    public function delete(){
        $db=new connection();
        $strQuery = "delete from products where ProductID = $this->productid";
        $db->exec($strQuery);
    }
}

?>
