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

defined('JPATH_PLATFORM') or die;

class JFormFieldListf extends JFormField
{
	protected $type = 'Listf';

	protected function getInput()
	{
		// Give style
		JLoader::import( "joomla.version" );
		$version = new JVersion();
		if (!version_compare( $version->RELEASE, "2.5", "<=")) :
			// j3x
			$style = 'padding-top: 5px;';
		else:
			// j25x
			$style = 'float: left; width: auto; margin: 5px 5px 5px 0;';
		endif;
		
		// get extension's details
		$link_to_pro = '<a href="https://www.web357.eu/pricing?utm_source=CLIENT&utm_medium=CLIENT-ProLink-web357&utm_content=CLIENT-ProLink&utm_campaign=listfelement" target="_blank">PRO</a>';
		return '<p style="'.$style.'"><em>'.sprintf(JText::_('W357FRM_ONLY_IN_PRO'), $link_to_pro).'</em></p>';
	}
}