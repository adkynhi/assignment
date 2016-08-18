<?php

defined('_JEXEC') or die;

$doc = JFactory::getDocument();

$doc->addStyleSheet($this->baseurl . '/media/jui/css/bootstrap.min.css');
$doc->addStyleSheet($this->baseurl . '/media/jui/css/bootstrap-responsive.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/style.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/bootstrap.min.css');
$doc->addScript('/templates/' . $this->template . '/js/main.js', 'text/javascript');

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="templates/basicjoomla3.0template/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="templates/basicjoomla3.0template/css/style.css">

</head>

<body>

 <body>
<div class="wrapper">
    <!-- main container -->
    <div class='container'>

        <!-- header -->
		<div class='row'>
        <div class='col-sm-9 nopadding'><jdoc:include type="modules" name="logo" style="none" /><img style="margin-top:30px" src="<?php echo "templates/$this->template"?>/images/1.png" width="51%"></div>
		<div class='col-sm-3'>
        	<div class="contact"><jdoc:include type="modules" name="position-13" style="none" /><img src="<?php echo "templates/$this->template"?>/images/2.png" width="60%" height="60%"></div>
		</div>
		</div>
        
        <div class='row'>
        <div class='col-sm-8 h70 nopadding'><jdoc:include type="modules" name="nav" style="xhtml" /></div>
		<div class='col-sm-4 h70 nopadding'></div>
		</div>
    
    	<div class='row'>
        <div style="padding:50px 135px;" class='col-sm-12 h450'>
        <div style="border:5px #330136 solid;margin-left:-25px; text-align:center; border-radius:5px">
        <jdoc:include type="modules" name="position-12" style="none" />
        <img src="<?php echo "templates/$this->template"?>/images/3.jpg" width="890" height="335">
        </div>
        </div>
		</div>
        
        
        <div class="content">
        
                <div class='row'>
        <div class='col-sm-3 nopadding'><img src="<?php echo "templates/$this->template"?>/images/qr.png" width="150">
        <jdoc:include type="modules" name="position-1" style="xhtml" />
        <div style="margin-top:20px"><img src="<?php echo "templates/$this->template"?>/images/123.jpg" width="150"></div></div>
		
        
             <div class='col-sm-6 nopadding'>
			 <jdoc:include type="message" />
             <jdoc:include type="modules" name="position-2" style="none" />
             <strong><jdoc:include type="component" /></strong>
             <jdoc:include type="modules" name="position-3" style="none" />
				</div>

                <div class='col-sm-3 nopadding'>
                <div style="margin-left:126px">
				<img src="<?php echo "templates/$this->template"?>/images/124455.png" width="167" height="1277">
                </div></div>
</div>
        
        </div>
        
        
           <div class="footer">
    
    <div class="footer-box"><jdoc:include type="modules" name="position-10" style="none" />
    <p class="footer-title">Xuất xứ</p><br>
    <hr class="footer-hr">
    Tại các vùng biển nổi tiếng Phan Thiết - Ninh Chữ. Sản phẩm được khai thác vùng biển gần chiều ra khơi sáng quay về hoặc thu mua ngoài khơi nên hải sản cực kỳ tươi chưa qua bất kì công đoạn bảo quản nào
    </div>
 
 <div class="footer-box"><jdoc:include type="modules" name="position-9" style="none" />
 <p class="footer-title">Động lực</p><br>
    <hr class="footer-hr">
    Với nỗ lực đưa đến mỗi bếp ăn của từng gia đình những sản phẩm nguyên chất không bảo quản chúng tôi tin rằng. Chất lượng sản phẩm chính là niềm tin của khách nàng
    </div>
    
    <div class="footer-box"><jdoc:include type="modules" name="position-8" style="none" />
    <p class="footer-title">Cam kết</p><br>
    <hr class="footer-hr">
    Cam kết hải sản tươi sống mỗi ngày dịch vụ tốt nhất đi kèm với giá cả hợp lý
    </div>
    
    <div class="footer-box"><jdoc:include type="modules" name="position-13" style="none" />
    <p class="footer-title">Liên hệ</p><br>
    <hr class="footer-hr">
    391A Nam Kì Khởi Nghĩa P8 Q3 TP.Hồ Chí Minh<br>
    Email: Contact@abc.vn<br>
    Phone:(08) 123456<br>
    Fax:08) 123456
   </div>
   
   <div class="footer-icon"><img src="<?php echo "templates/$this->template"?>/images/icon.png" width="247" height="85"></div>
    
    </div>

        
        
        </div>    
    </div>
</body>

</html>
