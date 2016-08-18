<?php

/*------------------------------------------------------------------------

# mod_ofblikebox - Optimized Facebook Like Box



# ------------------------------------------------------------------------



# author:    Optimized Sense



# copyright: Copyright (C) 2011 http://www.o-sense.com. All Rights Reserved.



# @license: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL



# Websites: http://www.o-sense.com



# Technical Support:  http://www.o-sense.com/contact-us/support-inquiries.html



-------------------------------------------------------------------------*/

// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

class oFBLikeBox{

	public static function getData(&$params ){		

		$oFBLinkTitle	= 'O-Sense';

		$oFBLink	= 'http://www.o-sense.com';

		$oFBLinkImg = 'http://www.o-sense.com/osensecopy.png';

		

		$oFlink	= $params->get('olink', 'http://www.facebook.com/pages/Optimized-Sense/230549220294427?ref=ts');

		$oFwidth	= $params->get('owidth', '300');

		$oFheight	= $params->get('oheight', '500');

		$oFborder	= $params->get('oborder', '000000');

		$oFcolor	= $params->get('ocolor');

		$oFfaces	= $params->get('ofaces');		

		$oFshowborder	= $params->get('oshowborder');		

		$oFstream	= $params->get('ostream');

		$oFforce	= $params->get('oforce');

		$oFheader	= $params->get('oheader');

		$oFsource	= $params->get('osource');

		$oFlang	    = $params->get('olang');

		$oFshowBacklink = $params->get('oshowbacklink');

		

		if($oFcolor == '1'){

			$oFcolor	= 'light';

		}else{

			$oFcolor	= 'dark';

		}

		

		if($oFfaces == '1'){

			$oFfaces	= 'true';

		}else{

			$oFfaces	= 'false';

		}

		if($oFshowborder == '1'){

			$oFshowborder	= 'true';

		}else{

			$oFshowborder	= 'false';

		}
			

		if($oFstream == '1'){

			$oFstream	= 'true';

		}else{

			$oFstream	= 'false';

		}

		

		if($oFforce == '1'){

			$oFforce	= 'true';

		}else{

			$oFforce	= 'false';

		}

		

		if($oFheader == '1'){

			$oFheader	= 'true';

		}else{

			$oFheader	= 'false';

		}

		

		if($oFshowBacklink == '1'){

			$oFshowBacklink	= '<div style="position: relative; height: 15px; width: 100%; font-size: 10px; color: #808080; font-weight: normal; font-family: \'lucida grande\',tahoma,verdana,arial,sans-serif; line-height: 1.28; text-align: right; direction: ltr;"><a href="'.$oFBLink.'" target="_blank" style="color: #808080;"> <img alt="OSense" height="auto" src="'.$oFBLinkImg.'" style="visibility: visible; zoom: 1; opacity: 1; vertical-align: text-top;" width="auto" />  '.$oFBLinkTitle.'</a></div>';

		}

		else {

			$oFshowBacklink	= '';

		}



		$data ='';

		

		if($oFsource == '1'){

			//HTML5			

			$data = '<div id="fb-root"></div><script language="javascript" type="text/javascript">(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) {return;}  js = d.createElement(s); js.id = id;  js.src = "//connect.facebook.net/'.$oFlang.'/all.js#xfbml=1";  fjs.parentNode.insertBefore(js, fjs);}(document, \'script\', \'facebook-jssdk\'));</script>';


			$data = $data.'<script language="javascript" type="text/javascript">//<![CDATA[ 

																						   document.write(\'<div class="fb-like-box" data-href="'.$oFlink.'" data-width="'.$oFwidth.'" data-height="'.$oFheight.'" data-colorscheme="'.$oFcolor.'" data-show-faces="'.$oFfaces.'" data-border-color="'.$oFborder.'" data-stream="'.$oFstream.'" data-force-wall="'.$oFforce.'" data-show-border="'.$oFshowborder.'" data-header="'.$oFheader.'"></div> \'); 

																						   //]]>

			</script>'.$oFshowBacklink;

		}else if($oFsource == '2'){

			//XFBML

			$data = '<div id="fb-root"></div><script language="javascript" type="text/javascript">(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) {return;}  js = d.createElement(s); js.id = id;  js.src = "//connect.facebook.net/'.$oFlang.'/all.js#xfbml=1";  fjs.parentNode.insertBefore(js, fjs);}(document, \'script\', \'facebook-jssdk\'));</script>';

			$data = $data.'<script language="javascript" type="text/javascript">//<![CDATA[ 

																						   document.write(\'<fb:like-box href="'.$oFlink.'" width="'.$oFwidth.'" height="'.$oFheight.'" colorscheme="'.$oFcolor.'" show_faces="'.$oFfaces.'" border_color="'.$oFborder.'" stream="'.$oFstream.'" force_wall="'.$oFforce.'" show_border="'.$oFshowborder.'" header="'.$oFheader.'"></fb:like-box> \'); 

																						   //]]>

			</script>'.$oFshowBacklink;

		}else { 

			//iFrame

			$oFsource	="http://www.facebook.com/plugins/likebox.php?locale=".$oFlang."&amp;href=".$oFlink."&amp;width=".$oFwidth .

					"&amp;colorscheme=".$oFcolor."&amp;show_faces=".$oFfaces .

					"&amp;border_color=%23".$oFborder."&amp;show_border=".$oFshowborder."&amp;stream=".$oFstream."&amp;force_wall=".$oFforce."&amp;header=".$oFheader."&amp;height=".$oFheight;



			$data = '<iframe src="'.$oFsource.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$oFwidth.'px; height:'.$oFheight.'px;"></iframe>'.$oFshowBacklink;

		}



		return $data;

	}

}