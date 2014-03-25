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
 * Helper function to grab the address preview data
 *
 * @param  string The address to scrape
 * @return array  Preview data
 */
function bookmarks_extender_get_preview_data($address) {
	elgg_load_library('facebook-link-preview');

	// Get url info
	$text = $address;
	$text = " " . str_replace("\n", " ", $text);
	$header = "";

	$linkPreview = new LinkPreview();
	$result = $linkPreview->crawl($text, $imageQty, $header);

	$decoded_response = json_decode($result);

	SetUp::finish();

	return $decoded_response;
}

/**
 * Helper function to ensure that a bookmarks preview image is populated
 * 
 * @param  ElggEntity $bookmark The bookmark to check
 * @param  int        $imageQty Image count (default 1)
 * @return void
 */
function bookmarks_extender_populate_preview($bookmark, $imageQty = 1) {

	if (elgg_instanceof($bookmark, 'object', 'bookmarks')) {
		
		$preview_data = bookmarks_extender_get_preview_data($bookmark->address);

		// Preview fields
		$preview_fields = array(
			'images' => 'preview_image',
			'pageUrl' => 'preview_page_url',
			'video' => 'preview_video',
			'videoIframe' => 'preview_video_iframe'
		);

		$populated = true;

		// Check each field to see if this bookmark has been populated
		foreach ($preview_fields as $resultId => $field) {
			if ($bookmark->$field === null) {
				$populated = false;
				break;
			}
		}

		if (!$populated && $preview_data) {
			echo 'populating';
			foreach ($preview_fields as $resultId => $field) {
				if ($preview_data->$resultId) {
					$bookmark->$field = $preview_data->$resultId;
				} else {
					$bookmark->$field = false; // Set to false, may not exist (video or images)
				}
			}
		}
	}
}