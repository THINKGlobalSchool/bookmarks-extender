<?php
/**
 * Elgg Bookmarks Extender Preview
 *
 * @package BookmarksExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 * @uses $vars['title']
 * @uses $vars['image']
 */

$title = elgg_extract('title', $vars);
$description = elgg_extract('description', $vars);
$image = elgg_extract('image', $vars);
$url = elgg_extract('url', $vars);

if ($image) {
	$image_preview = elgg_view('output/img', array(
		'src' => $image,
		'alt' => $title
	));
} else {
	$image_preview = elgg_echo('bookmarks-extender:label:noimage');
	$image = FALSE;
}

$image_label = elgg_echo('bookmarks-extender:label:image');

echo "<div><label>{$image_label}</label><br /><br />$image_preview</div>";
echo elgg_view('input/hidden', array(
	'name' => 'preview_image',
	'value' => $image
));