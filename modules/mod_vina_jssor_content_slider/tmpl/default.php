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

$doc = JFactory::getDocument();
$doc->addScript('modules/mod_vina_jssor_content_slider/assets/jssor.core.js', 'text/javascript');
$doc->addScript('modules/mod_vina_jssor_content_slider/assets/jssor.utils.js', 'text/javascript');
$doc->addScript('modules/mod_vina_jssor_content_slider/assets/jssor.slider.js', 'text/javascript');
$doc->addStyleSheet('modules/mod_vina_jssor_content_slider/assets/jssor.css');
?>
<style>
#vina-content-slider<?php echo $module->id; ?> {
	<?php echo ($bgImage != '') ? 'background: url('.$bgImage.') top center no-repeat;' : ''; ?>
	<?php echo ($params->get('isBgColor', 1)) ? 'background-color: ' . $params->get('bg_color', '003399') : ''; ?>
}
#vina-content-slider<?php echo $module->id; ?> .vcs-slide-text,
#vina-content-slider<?php echo $module->id; ?> .vcs-slide-text span {
	<?php echo ($params->get('isTextColor', 1)) ? 'color: ' . $params->get('text_color', 'FFFFFF') : ''; ?>
}
#vina-content-slider<?php echo $module->id; ?> .vcs-slide-image {
	top: <?php echo $params->get('imageTop', 23); ?>px;
	left: <?php echo $params->get('imageLeft', 480); ?>px;
	width: <?php echo $params->get('imageWidth', 500); ?>px;
	height: <?php echo $params->get('imageHeight', 300); ?>px;
}
#vina-copyright<?php echo $module->id; ?> {
	font-size: 12px;
	<?php if(!$params->get('copyRightText', 0)) : ?>
	height: 1px;
	overflow: hidden;
	<?php endif; ?>
}
</style>
<div id="vina-content-slider<?php echo $module->id; ?>" class="vina-content-slider-wrapper" style="width: <?php echo $params->get('maxWidth', 980); ?>px; height: <?php echo $params->get('maxHeight', 400); ?>px;">
	<!-- Loading Screen -->
	<div u="loading" class="vcs-loading">
		<div class="vcs-mask"></div>
		<div class="vcs-icon">
		</div>
	</div>
	
	<!-- Slides Container -->
	<div u="slides" class="vcs-slides-container" style="width: <?php echo $params->get('maxWidth', 980); ?>px; height: <?php echo $params->get('maxHeight', 400); ?>px; overflow: hidden;">
		<?php foreach($slides as $slide) : ?>
		<?php
			$title = $slide->name;
			$image = $slide->img;
			$image = (strpos($image, 'http://') === false) ? JURI::base() . $image : $image;
			
			$w = $params->get('imageWidth', 500);
			$h = $params->get('imageHeight', 300);
			
			// render large image
			$largeImage = '<img class="vcs-slide-image" alt="'.$title.'" src="'.$image.'" />';
			if($params->get('resizeImage', 0) == 1) {
				$rImage 	= $timthumb . '&w=' . $w . '&h=' . $h . '&src=' . $image;
				$largeImage = '<img class="vcs-slide-image" alt="'.$title.'" src="'.$rImage.'" />';
			}
			if($params->get('resizeImage', 0) == 2) {
				$largeImage = '<img width="'.$w.'" height="'.$h.'" class="vcs-slide-image" alt="'.$title.'" src="'.$image.'" />';
			}
			
			// render thumbnail image
			$smallImage = '<img u="thumb" width="62" height="32" title="'.$title.'" src="'.$image.'" />';
			if($params->get('resizeImage', 0) == 1) {
				$rImage = $timthumb . '&w=62&h=32&src=' . $image;
				$smallImage = '<img u="thumb" title="'.$title.'" src="'.$rImage.'" />';
			}
		?>
		<div class="vcs-slide-container">
			<?php echo $slide->text; ?>
			<?php echo $largeImage; ?>
			<?php echo $smallImage; ?>
		</div>
		<?php endforeach; ?>
	</div>
	
	<!-- Direction Navigator Skin Begin -->
	<span u="arrowleft" class="jssord07l" style="width: 50px; height: 50px; top: 123px; left: 8px;"></span>
	<span u="arrowright" class="jssord07r" style="width: 50px; height: 50px; top: 123px; right: 8px"></span>
	
	<!-- Navigator Skin Begin -->
	<div u="navigator" class="slider1-N" style="position: absolute; bottom: 16px; right: 10px;">
		<div u="prototype" style="POSITION: absolute; WIDTH: 12px; HEIGHT: 12px;"></div>
	</div>
	
	<!-- ThumbnailNavigator Skin Begin -->
	<div u="thumbnavigator" class="jssort04" style="position: absolute; width: 600px; height: 60px; right: 0px; bottom: 0px;">
		<div u="slides" style="bottom: 25px; right: 30px;">
			<div u="prototype" class="p" style="position: absolute; width: 62px; height: 32px; top: 0; left: 0;">
				<div class="w">
					<thumbnailtemplate style="width: 100%; height: 100%; border: none; position: absolute; top: 0; left: 0;"></thumbnailtemplate>
				</div>
				<div class="c" style="position: absolute; background-color: #000; top: 0; left: 0">
				</div>
			</div>
		</div>
	</div>
</div>

<script>
jQuery(document).ready(function ($) {
	
	<?php if($params->get('imageTransitions', 1)) : ?>
	var _ImageStransitions = [
		<?php echo $params->get('imageTransitionList', '{$Duration:1200,$Opacity:2}'); ?>
	];
	<?php endif; ?>
	
	<?php if($params->get('captionTransitions', 1)) : ?>
	var _CaptionTransitions = [
		<?php echo $params->get('captionTransitionList', '{$Duration:900,$FlyDirection:1,$Easing:{$Left:$JssorEasing$.$EaseInOutSine},$ScaleHorizontal:0.6,$Opacity:2}'); ?>
	];
	<?php endif; ?>
	
	var options<?php echo $module->id; ?> = {
		$AutoPlay: <?php echo ($params->get('autoPlay', 1)) ? 'true' : 'false'; ?>, 
		$AutoPlayInterval: <?php echo $params->get('autoPlayInterval', 4000); ?>,
		$PauseOnHover: <?php echo $params->get('pauseOnHover', 3); ?>,
		$ArrowKeyNavigation: <?php echo ($params->get('arrowKeyNavigation', 1)) ? 'true' : 'false'; ?>,
		$SlideDuration: <?php echo $params->get('slideDuration', 800); ?>,
		$PlayOrientation: <?php echo $params->get('playOrientation', 1); ?>,                                
		$DragOrientation: <?php echo $params->get('dragOrientation', 1); ?>,
		
		<?php if($params->get('imageTransitions', 1)) : ?>
		$SlideshowOptions: {
			$Class: $JssorSlideshowRunner$,
			$Transitions: _ImageStransitions,
			$TransitionsOrder: 0,
			$ShowLink: true 
		},
		<?php endif; ?>
		
		<?php if($params->get('captionTransitions', 1)) : ?>
		$CaptionSliderOptions: {
			$Class: $JssorCaptionSlider$,
			$CaptionTransitions: _CaptionTransitions,
			$PlayInMode: 1,
			$PlayOutMode: 3,
		},
		<?php endif; ?>
		
		$DirectionNavigatorOptions: {
			$Class: $JssorDirectionNavigator$,
			$ChanceToShow: <?php echo $params->get('showNavigator', 3); ?>,
			$AutoCenter: 2,
			$Steps: 1
		},

		$ThumbnailNavigatorOptions: {
			$Class: $JssorThumbnailNavigator$,
			$ChanceToShow: <?php echo $params->get('showThumbnail', 3); ?>,
			$ActionMode: <?php echo $params->get('thumbnailActionMode', 2); ?>,
			$AutoCenter: 0,
			$Lanes: 1,
			$SpacingX: 3,
			$SpacingY: 3,
			$DisplayPieces: 9,
			$ParkingPosition: 260,
			$Orientation: 1,
			$DisableDrag: false
		},
	};

	var jssor_slider<?php echo $module->id; ?> = new $JssorSlider$("vina-content-slider<?php echo $module->id; ?>", options<?php echo $module->id; ?>);

	function ScaleSlider<?php echo $module->id; ?>() {
		var bodyWidth = document.body.clientWidth;
		if (bodyWidth)
			jssor_slider<?php echo $module->id; ?>.$SetScaleWidth(Math.min(bodyWidth, <?php echo $params->get('scaleWidth', 980); ?>));
		else
			window.setTimeout(ScaleSlider<?php echo $module->id; ?>, 30);
	}

	ScaleSlider<?php echo $module->id; ?>();
	$(window).bind('resize', ScaleSlider<?php echo $module->id; ?>);
});
</script>