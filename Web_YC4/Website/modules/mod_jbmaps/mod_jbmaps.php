<?php
/**
 * @package		JB Maps
 * @subpackage	JB Maps
 * @author		Joomla Bamboo - design@joomlabamboo.com
 * @copyright 	Copyright (c) 2013 Joomla Bamboo. All rights reserved.
 * @license		GNU General Public License version 2 or later
 * @version		1.2.5
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$document = JFactory::getDocument();

// clientids must be an integer
$height = (int)str_replace('px', '', $params->get( 'height', '500' ));
$width = (int)str_replace('px', '', $params->get( 'width', '500' ));
$lat = (float)$params->get( 'lat', '0' );
$long = (float)$params->get( 'long', '0' );
$zoom = $params->get( 'zoom', '5' );
$lat1 = (float)$params->get( 'lat1', '1' );
$lat2 = (float)$params->get( 'lat2', '2' );
$lat3 = (float)$params->get( 'lat3', '3' );
$long1 = (float)$params->get( 'long1', '1' );
$long2 = (float)$params->get( 'long2', '2' );
$long3 = (float)$params->get( 'long3', '3' );
$title1 = $params->get( 'title1', '' );
$title2 = $params->get( 'title2', '' );
$title3 = $params->get( 'title3', '' );
$html1 = $params->get( 'html1', '' );
$html2 = $params->get( 'html2', '' );
$html3 = $params->get( 'html3', '' );
$pub1 = (int)$params->get( 'pub1', '0' );
$pub2 = (int)$params->get( 'pub2', '0' );
$pub3 = (int)$params->get( 'pub3', '0' );
$mapType = $params->get( 'mapType', 'ROADMAP' );
$mapCSS = "#map { height:".$height."px; width:".$width."px;max-width:100% }#map img {max-width:none}";

$document->addStyleDeclaration($mapCSS);

$lats = array($lat1,$lat2,$lat3);
$longs = array($long1,$long2,$long3);
$pubs = array($pub1,$pub2,$pub3);

$htmls = array(preg_replace("/\r?\n/", "\\n", addslashes($html1)),preg_replace("/\r?\n/", "\\n", addslashes($html2)),preg_replace("/\r?\n/", "\\n", addslashes($html3)));
$titles = array(preg_replace("/\r?\n/", "\\n", addslashes($title1)),preg_replace("/\r?\n/", "\\n", addslashes($title2)),preg_replace("/\r?\n/", "\\n", addslashes($title3)));
?>
<div id="map"></div>

<script type="text/javascript">
	var map

	function attachSecretMessage(marker, message) {
		var infowindow = new google.maps.InfoWindow({content: message});
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
		});
	}

	window.jbmapsLoadMap = function()
	{
		var center = new google.maps.LatLng('<?php echo $lat ?>', '<?php echo $long ?>');
		var settings = {
			mapTypeId: google.maps.MapTypeId.<?php echo $mapType ?>,
			zoom: <?php echo $zoom ?>,
			center: center
		};
		map = new google.maps.Map(document.getElementById('map'), settings);
		<?php for ($i = 0; $i < 3; $i++) {
			if($pubs[$i]){?>
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng('<?php echo $lats[$i] ?>', '<?php echo $longs[$i] ?>'),
					title: '<?php echo $titles[$i] ?>',
					map: map
				});
				marker.setTitle('<?php echo $titles[$i] ?>'.toString());
				attachSecretMessage(marker, '<?php echo $titles[$i] ?>'+' - '+'<?php echo $htmls[$i] ?>');
			<?php }
		}?>
	}
</script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=jbmapsLoadMap"></script>
