<?php
/*
# ------------------------------------------------------------------------
# Vina Jssor Content Slider for Joomla 3
# ------------------------------------------------------------------------
# Copyright(C) 2014 www.VinaGecko.com. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: VinaGecko.com
# Websites: http://vinagecko.com
# Forum:    http://vinagecko.com/forum/
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once dirname(__FILE__) . '/helper.php';

// load json code
$slider = json_decode($params->get('slides', ''));

// check if don't have any slide
if(!$slider) {
	echo "You don't have any slide!";
	return;
}

// load data
$slides = modVinaJssorContentSliderHelper::getSildes($slider);

// load params
$timthumb = JURI::base() . 'modules/mod_vina_jssor_content_slider/libs/timthumb.php?a=c&q=99&z=0';
$bgImage  = $params->get('bg_image');
if($bgImage != '') {
	if(strpos($bgImage, 'http://') === FALSE) {
		$bgImage = JURI::base() . $bgImage;
	}
}

// display layout
require JModuleHelper::getLayoutPath('mod_vina_jssor_content_slider', $params->get('layout', 'default'));

// display copyright text - You can't remove it!
modVinaJssorContentSliderHelper::getCopyrightText($module);