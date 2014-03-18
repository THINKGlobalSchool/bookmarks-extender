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

bookmarks_extender_populate_preview($object);

$attachments = elgg_view('output/url', array('href' => $object->address));
$attachments .= "<br /><br />" . elgg_view('output/img', array('src' => $object->preview_image), false, false, 'default');

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'message' => $excerpt,
	'attachments' => $attachments
));
