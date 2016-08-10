<?php
//nên để ở 1 thư mục riêng tách biệt với code cho sáng sủa, dể quản lý
require 'class.phpmailer.php';
require 'class.smtp.php';
if (isset($_POST['ok']) ){
    $account = $_POST['username'];
    $pssword = $_POST['password'];
    $name = $_POST['name'];
    $subject = $_POST['title'];
    $content = $_POST['textarea'];
}

$mail = new PHPMailer;
$mail->isSMTP(); // đặt phương thức gửi thư là smtp
$mail->Host = 'smtp.gmail.com'; //địa chỉ tên miền server smtp
$mail->SMTPAuth = true; // Bật tính năng xác thức SMTP
$mail->Username = $account; // SMTP username
$mail->Password = $pssword; // SMTP password
$mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587; // cổng kết nối tới máy chủ smtp, 587 hoặc 465
$mail->From = $account; //địa chỉ email người gửi
$mail->FromName = $name;
$mail->addAddress('tuannaps03172@fpt.edu.vn'); //địa chỉ người nhận
$mail->addReplyTo('tuannaps03172@fpt.edu.vn'); 
$mail->isHTML(true); // đặt là true - định dạng email gửi đi làm html
$mail->Subject = $subject ;
$mail->Body = $content;
if(!$mail->send()) {
echo '<script>javascript: alert("Không thể gửi thư")></script>'; 
echo '<script>javascript: alert("Mail lỗi:")></script>' . $mail->ErrorInfo;} 
else {
echo '<script>javascript: alert("Thư đã được gửi đi")></script>';
}
?>