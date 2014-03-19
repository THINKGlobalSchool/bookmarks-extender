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

elgg_register_event_handler('init', 'system', 'bookmarks_extender_init');

// Init bookmarks extender
function bookmarks_extender_init() {
	// Register library
	elgg_register_library('elgg:bookmarksextender', elgg_get_plugins_path() . 'bookmarks-extender/lib/extender.php');
	elgg_load_library('elgg:bookmarksextender');

	// Register bookmarks extender JS
	$js = elgg_get_simplecache_url('js', 'bookmarksextender/extender');
	elgg_register_simplecache_view('js/bookmarksextender/extender');
	elgg_register_js('elgg.bookmarksextender', $js);

	// Register fb link preview library
	elgg_register_library('facebook-link-preview', elgg_get_plugins_path() . 'bookmarks-extender/vendors/fblinkpreview/php/classes/LinkPreview.php');

	// Extend main CSS
	elgg_extend_view('css/elgg', 'css/bookmarks-extender/css');

	// Create handler for bookmarks
	elgg_register_event_handler('create', 'all', 'bookmarks_save');

	// Actions
	$action_base = elgg_get_plugins_path() . "bookmarks-extender/actions/bookmarks-extender";
	elgg_register_action('bookmarks/preview', "$action_base/preview.php");
}

/**
 * Save preview image metadata to bookmarks on create
 *
 * @param string $event       create
 * @param string $object_type mixed
 * @param mixed  $object      The object created
 *
 * @return bool
 */
function bookmarks_save($event, $object_type, $object) {
	if (elgg_instanceof($object, 'object', 'bookmarks')) {
		$image = get_input('preview_image');

		if ($image) {
			$object->preview_image = $image;
		}
	}
	return TRUE;
}