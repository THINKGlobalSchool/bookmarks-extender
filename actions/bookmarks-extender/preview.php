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

elgg_load_library('facebook-link-preview');

$address = get_input('address', false);

$url_regex = '/(https?\:\/\/|\s)[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})(\/+[a-z0-9_.\:\;-]*)*(\?[\&\%\|\+a-z0-9_=,\.\:\;-]*)?([\&\%\|\+&a-z0-9_=,\:\;\.-]*)([\!\#\/\&\%\|\+a-z0-9_=,\:\;\.-]*)}*/i';

// Check url
if (preg_match($url_regex, $address) !== 0) {
	$linkPreview = new LinkPreview();
	$result = $linkPreview->crawl($address, 1, "");

	$result = json_decode($result);

	// Vars for preview
	// $preview_vars['description'] = $result->description;
	$preview_vars['image'] = $result->images;
	$preview_vars['title'] = $result->title;
	// $preview_vars['url'] = $address;

	$output['view'] = elgg_view('bookmarks-extender/preview', $preview_vars);
	$output['result'] = $result;

	echo json_encode($output);

} else {
	register_error(elgg_echo('bookmarks-extender:error:invalidurl'));
}

forward(REFERER);