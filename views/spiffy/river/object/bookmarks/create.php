<?php
/**
 * Elgg Bookmarks Extender Spiffy Bookmarks River view
 *
 * @package BookmarksExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */

$object = $vars['item']->getObjectEntity();

$subtitle = elgg_view('output/url', 
	array(
		'href' => $object->address,
		'text' => "<span class='elgg-subtext spiffyactivity-attachment-url'>" . elgg_get_excerpt($object->address, 44) . "</span>"
	), 
	false, 
	false, 
	'default'
);

if ($object->preview_image) {
	if ($object->preview_video == 'yes') {
		$class = 'elgg-lightbox';
		$href = elgg_normalize_url('ajax/view/bookmarks-extender/video?entity_guid=' . $object->guid);
	} else {
		$href = $object->preview_page_url;
	}

	$image_preview = elgg_view('output/url', array(
		'text' => elgg_view('output/img', array(
			'src' => $object->preview_image,
			'alt' => $object->title,
		), false, false, 'default'), 
		'href' => $href,
		'class' => $class
	), false, false, 'default');

	$attachments = "<div class='spiffyactivity-item-image'>$image_preview</div>";
}

if (!$object->description && $object->preview_description) {
	$message = $object->preview_description;
} else {
	$message = $object->description;
}

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'subtitle' => $subtitle,
	'message' => $message,
	'attachments' => $attachments,
	'layout' => 'horizontal'
)); 