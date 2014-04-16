<?php
/**
 * Elgg Bookmarks Extender
 *
 * @package BookmarksExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */

$address = get_input('address', false);

$url_regex = '/(https?\:\/\/|\s)[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})(\/+[a-z0-9_.\:\;-]*)*(\?[\&\%\|\+a-z0-9_=,\.\:\;-]*)?([\&\%\|\+&a-z0-9_=,\:\;\.-]*)([\!\#\/\&\%\|\+a-z0-9_=,\:\;\.-]*)}*/i';

// Check url
if (preg_match($url_regex, $address) !== 0) {

	$result = bookmarks_extender_get_preview_data($address);

	// Vars for preview
	// $preview_vars['description'] = $result->description;
	$preview_vars['image'] = $result->images;
	$preview_vars['title'] = $result->title;
	$preview_vars['video'] = $result->video == 'yes';
	$preview_vars['video_iframe'] = $result->videoIframe;
	// $preview_vars['url'] = $address;

	$output['view'] = elgg_view('bookmarks-extender/preview', $preview_vars);
	$output['result'] = $result;

	echo json_encode($output);

} else {
	register_error(elgg_echo('bookmarks-extender:error:invalidurl'));
}

forward(REFERER);