<?php
/* ======================================================
# Web357 Framework - Joomla! System Plugin v1.3.4
# -------------------------------------------------------
# For Joomla! 3.0
# Author: Yiannis Christodoulou (yiannis@web357.eu)
# Copyright (©) 2009-2016 Web357. All rights reserved.
# License: GNU/GPLv3, http://www.gnu.org/licenses/gpl-3.0.html
# Website: https://www.web357.eu/
# Support: support@web357.eu
# Last modified: 22 Feb 2016, 16:32:03
========================================================= */

defined('JPATH_BASE') or die;

require_once('elements_helper.php');

jimport('joomla.form.formfield');

class JFormFieldinfo extends JFormField {
	
	protected $type = 'info';

	// check if url exists
	protected function url_exists($url) {
		
		if ($this->_isCurl()):
	
			// cUrl method
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // $retcode >= 400 -> not found, $retcode = 200, found.
			curl_close($ch);
			
			if ($retcode == 200):
				return true;
			else:
				return false;
			endif;
			
		else:
			
			// default method
			$file_headers = @get_headers($url);
			if($file_headers[0] == 'HTTP/1.1 404 Not Found'):
				return false;
			else:
				return true;
			endif;
			
		endif;
	}

	protected function getInput()
	{
		return ' ';
	}

	protected function getLabel()
	{	
		// get extension's details
		$position = $this->element['position']; // version's position (top + bottom)
		$extension_type_single = $this->element['extension_type']; // component, module, plugin 
		$extension_type = $this->element['extension_type'].'s'; // components, modules, plugins 
		$extension_name = $this->element['extension_name']; // mod_name, com_name, plg_system_name
		$plugin_type = $this->element['plugin_type']; // system, authentication, content etc.
		$plugin_folder = (!empty($plugin_type) && $plugin_type != '') ? $plugin_type.'/' : '';
		$real_name = $this->element['real_name'];
		
		if (empty($extension_type) || empty($extension_name)):
			JFactory::getApplication()->enqueueMessage("Error in XML. Please, contact us at support@web357.eu!", "error");
			return false;
		endif;
		
		// BEGIN: get joomla version & insert some style
		JLoader::import( "joomla.version" );
		$version = new JVersion();
		$j25 = false;
		$j3x = false;
		if ($version->RELEASE <= '2.5'):
			// j25
			$w357_ext_uptodate_class = 'w357_ext_uptodate_j25';
			$j25 = true;
		else:
			// j3x
			$w357_ext_uptodate_class = 'w357_ext_uptodate_j3x';
			$j3x = true;
		endif;

		// END: get joomla version & insert some style
		$html  = '';
		$html .= '<div>';

		// get current extension's version & creationDate from database
		$db = JFactory::getDBO();
		$query = "SELECT manifest_cache "
		."FROM #__extensions "
		."WHERE element = '".$extension_name."' and type = '".$extension_type_single."' "
		;
		$db->setQuery($query);
		$db->query();
		$manifest = json_decode( $db->loadResult(), true );
		$current_version = (!empty($manifest['version'])) ? $manifest['version'] : '1.0.0';
		$current_creationDate = (!empty($manifest['creationDate'])) ? $manifest['creationDate'] : '10 Oct 1985';
		
		// get download path
		$download_path = 'https://www.web357.eu/downloads';
		
		// get the latest extensions's version & creationDate
		if ($extension_type == 'components'):
		 	// administrator/components/com_name.xml
			$base_path = 'http://demoj3x.web357.eu/administrator/'.$extension_type.'/'.$extension_name.'/'.str_replace('com_', '', $extension_name).'.xml';
			$changelog_path = 'http://demoj3x.web357.eu/administrator/'.$extension_type.'/'.$plugin_folder.''.$extension_name.'/changelog.html';
		else:
		 	// modules/mod_name/mod_name.xml
			$base_path = 'http://demoj3x.web357.eu/'.$extension_type.'/'.$plugin_folder.''.$extension_name.'/'.$extension_name.'.xml';
			$changelog_path = 'http://demoj3x.web357.eu/'.$extension_type.'/'.$plugin_folder.''.$extension_name.'/changelog.html'; // modules/mod_name/changelog.html
		endif;
		
		// get changelog content
		if ($this->url_exists($changelog_path)):
			if ($this->_isCurl()): // check if extension=php_curl.dll is enabled from php.ini
				$curl = curl_init($changelog_path);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$changelog_content = curl_exec($curl);
			elseif ($this->_allowUrlFopen()):
				$changelog_content = file_get_contents($changelog_path);
			else:
				$changelog_content = 'no data';
			endif;
		else:
			$changelog_content = 'no data';
		endif;
		
		$changelog_content = preg_match('/<pre>(.*?)<\/pre>/s', $changelog_content, $match);
		$changelog_content = isset($match[0]) ? $match[0] : 'No content!';

		// output
		if ($this->url_exists($base_path)):
			if ($this->_isCurl()): // check if extension=php_curl.dll is enabled from php.ini
				$curl = curl_init($base_path);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$data = curl_exec($curl);
				$ext_xml_live = simplexml_load_string($data);
				$latest_version = trim($ext_xml_live->version);
				$latest_creationDate = trim($ext_xml_live->creationDate);
			elseif ($this->_allowUrlFopen()):
				$data = file_get_contents($base_path);
				$ext_xml_live = simplexml_load_string($data);
				$latest_version = trim($ext_xml_live->version);
				$latest_creationDate = trim($ext_xml_live->creationDate);
			else:
				return '<div class="w357_ext_uptodate '.JRequest::getVar('option').'">'.JText::_('W357FRM_UP_TO_DATE').'</div>';
			endif;

			// BEGIN: MODAL POPUP (Powered by: https://codyhouse.co/gem/morphing-modal-window/)
			$juri_base = str_replace('/administrator', '', JURI::base());
			$morphing_modal_window_dir_path = $juri_base.'plugins/system/web357framework/elements/assets/morphing-modal-window';
			$html .= '
		
			<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700" rel="stylesheet" type="text/css">
			<link rel="stylesheet" href="'.$morphing_modal_window_dir_path.'/css/style.css"> <!-- Resource style -->
		
			<section class="cd-section" style="padding:0;">';
			// END: MODAL POPUP
			
			// ==
			if ($current_version == $latest_version) :
				$html .= '<div class="w357_ext_uptodate '.JRequest::getVar('option').' '.$w357_ext_uptodate_class.'">';
				$html .= '<div class="cd-modal-action">'.JText::_('W357FRM_YOUR_CURRENT_VERSION_IS').': <a title="'.JText::_('W357FRM_VIEW_THE_CHANGELOG').'" href="#0" class="btn_view_changelog" data-type="modal-trigger">'.$current_version.' ('.$current_creationDate.')</a><span class="cd-modal-bg"></span><br />'.JText::_('W357FRM_UP_TO_DATE').'</div>';
				$html .= '</div>';
			// !=
			elseif ($current_version != $latest_version) :
				$current_version = (!empty($current_version)) ? $current_version : '1.0.0' ;
				$html .= '<div class="w357_ext_notuptodate '.JRequest::getVar('option').'">'.JText::_('W357FRM_YOUR_CURRENT_VERSION_IS').': '.$current_version.' ('.$current_creationDate.').<br /><span>You have to UPDATE your extension to the latest version '.$latest_version.' ('.$latest_creationDate.')'.'!</span><br /><div class="cd-modal-action"><a title="'.JText::_('W357FRM_VIEW_THE_CHANGELOG').'" href="#0" class="btn_view_changelog" data-type="modal-trigger">view the Changelog</a><span class="cd-modal-bg"></span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="'.$download_path.'" target="_blank">'.JText::_('W357FRM_GO_TO_DOWNLOAD_AREA').'</a></div></div>';
			endif;
			
			// BEGIN: MODAL POPUP
			$html .= '
		
				<div class="cd-modal">
					<div class="cd-modal-content">
						<h2>'.JText::_($real_name).' - Changelog</h2>
						'.$changelog_content.'
					</div> <!-- cd-modal-content -->
				</div> <!-- cd-modal -->
		
				<a href="#0" class="cd-modal-close">Close</a>
			</section> <!-- .cd-section -->';
			
			$html .= ($j25) ? '<script src="'.$morphing_modal_window_dir_path.'/js/jquery-2.1.1.js"></script>' : '';
			
			$html .= '
			<script src="'.$morphing_modal_window_dir_path.'/js/velocity.min.js"></script>
			<script src="'.$morphing_modal_window_dir_path.'/js/main.js"></script> <!-- Resource jQuery -->';
			// END: MODAL POPUP
			
		else:
			$html .= '<div class="w357_ext_uptodate '.JRequest::getVar('option').'">'.JText::_('W357FRM_UP_TO_DATE').'</div>';
		endif;
		$html .= '</div>';
		return $html;		
	}
	
	protected function _isCurl(){
		return function_exists('curl_version');
	}
	
	protected function _allowUrlFopen(){
		return ini_get('allow_url_fopen');
	}

}