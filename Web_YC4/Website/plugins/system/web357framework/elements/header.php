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

class JFormFieldHeader extends JFormField {
	
	function getInput()
	{
		return "";
	}

	function getLabel()
	{
		if (method_exists($this, 'fetchTooltip')):
			$label = $this->fetchTooltip($this->element['label'], $this->description, $this->element, $this->options['control'], $this->element['name'] = '');
		else:
			$label = parent::getLabel();
		endif;
		
		// get joomla version
		JLoader::import( "joomla.version" );
		$version = new JVersion();
		if (version_compare( $version->RELEASE, "2.5", "<=")) :
			// v2.5
			$jversion = 'vj25x';
		elseif (version_compare( $version->RELEASE, "3.0", "<=")) :
			// v3.x
			$jversion = 'vj3x';
		else:
			// other
			$jversion = 'j00x';
		endif;
					
		return '<div class="w357frm_param_header '.$jversion.' '.JRequest::getVar('option').'">'.$label.'</div>';
	}

}