<?php
/**
 * Elgg Bookmarks Extender Bookmarks River view
 *
 * @package BookmarksExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */

$object = $vars['item']->getObjectEntity();
$excerpt = elgg_get_excerpt($object->description);

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
			'class' => 'bookmarks-image-left'
		)), 
		'href' => $href,
		'class' => $class
	));
}

$attachments = elgg_view('output/url', array('href' => $object->address));
$attachments .= "<br /><br />" . $image_preview;

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'message' => $excerpt,
	'attachments' => $attachments
));
