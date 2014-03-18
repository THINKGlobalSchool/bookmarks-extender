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

bookmarks_extender_populate_preview($object);

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
	$image = elgg_view('output/img', array('src' => $object->preview_image), false, false, 'default');
	$attachments = "<div class='spiffyactivity-item-image'>$image</div>";
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