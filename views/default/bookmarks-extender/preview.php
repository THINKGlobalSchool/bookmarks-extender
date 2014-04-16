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
 * @uses $vars['video']
 * @uses $vars['video_iframe']
 */

$title = elgg_extract('title', $vars);
$description = elgg_extract('description', $vars);
$image = elgg_extract('image', $vars);
$video = elgg_extract('video', $vars, false);
$url = elgg_extract('url', $vars);

if ($image || $video) {
	if (!$video) {
		$preview = elgg_view('output/img', array(
			'src' => $image,
			'alt' => $title
		));
	} else {
		$video_iframe = elgg_extract('video_iframe', $vars);
		$preview = bookmarks_extender_filter_video_iframe($video_iframe);
	}
} else {
	$preview = elgg_echo('bookmarks-extender:label:nopreview');
	$image = FALSE;
}

$preview_label = elgg_echo('bookmarks-extender:label:preview');

echo "<div><label>{$preview_label}</label><br /><br />$preview</div>";
echo elgg_view('input/hidden', array(
	'name' => 'preview_image',
	'value' => $image
));