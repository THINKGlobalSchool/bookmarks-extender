<?php
/**
 * Elgg Bookmarks Extender Helper Lib
 *
 * @package BookmarksExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */

/**
 * Helper function to ensure that a bookmarks preview image is populated
 * 
 * @param  ElggEntity $bookmark The bookmark to check
 * @return void
 */
function bookmarks_extender_populate_preview($bookmark) {
	if (elgg_instanceof($bookmark, 'object', 'bookmarks') && !$bookmark->preview_populated) {
		elgg_load_library('facebook-link-preview');

		// Get url info
		$text = $bookmark->address;
		$imageQuantity = 1;
		$text = " " . str_replace("\n", " ", $text);
		$header = "";

		$linkPreview = new LinkPreview();
		$result = $linkPreview->crawl($text, $imageQuantity, $header);

		$decoded_response = json_decode($result);

		if ($decoded_response) {
			if ($decoded_response->images) {
				$bookmark->preview_image = $decoded_response->images;
			} 

			// if ($decoded_response->description) {
			// 	$bookmark->preview_description = $decoded_response->description;
			// }
		}

		SetUp::finish();

		$bookmark->preview_populated = true;
	}
}