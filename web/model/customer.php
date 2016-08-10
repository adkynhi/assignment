<?php

class user {
    var $userid = null;
    var $username = null;
    var $password = null;
    var $fullname = null;
    var $gender = null;
    var $email = null;
    var $telephone = null;
    var $dateofbirth = null;
    var $avatar = "../img/";

    function __construct(){
        
    }
    
    function getList(){
        $db = new connection();
        $select = "select * from user";
        $result = $db ->getList($select);
        return $result;
    }
    
    function getListExceptUser($username){
        $db = new connection();
        $select = "select * from user where username <> '$username'";
        $result = $db ->getList($select);
        return $result;
    }
    
    function getListPage($from,$to)
    {
        $db = new connection();
        $select = "select * from user limit $from,$to";
        $result = $db ->getList($select);
        return $result;
    }
    
    function getListPageExceptUser($username,$from,$to)
    {
        $db = new connection();
        $select = "select * from user where username <> '$username' limit $from,$to";
        $result = $db ->getList($select);
        return $result;
    }
    
      function login($username,$password)
    {
        $db = new connection();
        $select = "select * from user where username = '$username' and password = '$password'";
        $result = $db ->getInstance($select);
        if($result == null)
            return false;
        else
            return true;
    }
    
    function countUser()
    {
        $db = new connection();
        $select = "select count(*) from user";
        $result = $db ->getInstance($select);
        return $result[0];
    }
    
    function getUserById($id){
        $db = new connection();
        $select = "select * from user where userid = $id";
        $result = $db ->getInstance($select);
        return $result;
    }
    
    function getUserByUserName($username){
        $db = new connection();
        $select = "select * from user where username = '$username'";
        $result = $db ->getInstance($select);
        return $result;
    }
    
    function getUserIdByUserName($username){
        $db = new connection();
        $select = "select userid from user where username = '$username'";
        $result = $db ->getInstance($select);
        return $result[0];
    }
    
    function insertUser($tmpUsername,$tmpPassword,$tmpFullname,$tmpGender,$tmpEmail,$tmpDateofBirth,$tmpTelephone,$avatar){
        $db = new connection();
        $query = "insert into user values ('NULL','$tmpUsername','$tmpPassword','$tmpFullname','$tmpGender','$tmpEmail','$tmpDateofBirth','$tmpTelephone','$avatar')";
        $result = $db ->exec($query);
        return $result;
    }
    
    function upadateUser($tmpId,$tmpUsername,$tmpPassword,$tmpFullname,$tmpEmail,$tmpTelephone,$avatar){
        $db = new connection();
        $select = "update user set username = '$tmpUsername',password = '$tmpPassword',name = '$tmpFullname',email = '$tmpEmail',sdt = '$tmpTelephone',avatar='$avatar' where userid=$tmpId";
        $result = $db ->exec($select);
        return $result;
    }
    
    function deleteUser($tmpId){
        $db = new connection();
        $select = "delete from user where userid = '$tmpId'";
        $result = $db ->exec($select);
        return $result;
    }
    
    public function checkUser($user,$dateofbirth)
    {        
     $db = new connection();
     $select = "select * from User where Username = '$user' and dateofbirth = '$dateofbirth'";
     $result = $db->getInstance($select);
     //echo $select;
     if($result!=null)
         return true;
     else
         return false;
     }
     
     public function getPassword(){
         $pass_length = 8;
         $symbol = "!@#$%^&*(){}[];?><,./";
         $symbol_count = strlen($symbol);
         $index = mt_rand(0,$symbol_count);
         $this->password = substr($symbol,$index,1);
         $this->password = chr(mt_rand(48,57));
         $this->password = chr(mt_rand(65,90));
         while(strlen($this->password) < $pass_length)
         { 
             $this->password = chr(mt_rand(97,122));
         }   
         $this->password = str_shuffle($this->password);
         return $this->password;
     }
}
     
?>
