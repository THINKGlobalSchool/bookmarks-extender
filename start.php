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
elgg_register_event_handler('pagesetup', 'system', 'bookmarks_extender_pagesetup');

// Init bookmarks extender
function bookmarks_extender_init() {
	// Set a bookmarklet version
	define('BOOKMARKLET_VERSION', '1');

	// Register library
	elgg_register_library('elgg:bookmarksextender', elgg_get_plugins_path() . 'bookmarks-extender/lib/extender.php');
	elgg_load_library('elgg:bookmarksextender');

	// Register bookmarks extender JS
	$js = elgg_get_simplecache_url('js', 'bookmarksextender/extender');
	elgg_register_simplecache_view('js/bookmarksextender/extender');
	elgg_register_js('elgg.bookmarksextender', $js);

	// Register colorbox JS
	$js = elgg_get_simplecache_url('js', 'colobox');
	elgg_register_simplecache_view('js/colorbox');
	elgg_register_js('elgg.colorbox', $js);

	$css = elgg_get_simplecache_url('css', 'colorbox');
	elgg_register_simplecache_view('css/colorbox');
	elgg_register_css('elgg.colorbox', $css);

	// Register fb link preview library
	elgg_register_library('facebook-link-preview', elgg_get_plugins_path() . 'bookmarks-extender/vendors/fblinkpreview/php/classes/LinkPreview.php');

	// Extend main CSS
	elgg_extend_view('css/elgg', 'css/bookmarks-extender/css');

	// Create handler for bookmarks
	elgg_register_event_handler('create', 'all', 'bookmarks_save');

	// Extend bookmarks page handler
	elgg_register_plugin_hook_handler('route', 'bookmarks', 'bookmarks_extender_route_handler');

	// Icon hook
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'bookmarks_icon_url_override');

	// Actions
	$action_base = elgg_get_plugins_path() . "bookmarks-extender/actions/bookmarks-extender";
	elgg_register_action('bookmarks/preview', "$action_base/preview.php");

	// Ajax view whitelist
	elgg_register_ajax_view('bookmarks-extender/video');
	elgg_register_ajax_view('bookmarks-extender/bookmarks_form');
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
		bookmarks_extender_populate_preview($object);
	}
	return TRUE;
}


/**
 * Extend the bookmarks page handler
 *
 * @param string $hook
 * @param string $type
 * @param bool   $value
 * @param array  $params
 * @return array|null
 */
function bookmarks_extender_route_handler($hook, $type, $value, $params) {
	if (is_array($value['segments']) && $value['segments'][0] == 'add') {
		$address = get_input('address');
		$title = get_input('title');
		$version = get_input('v', FALSE);

		if ($version == BOOKMARKLET_VERSION) {
			elgg_load_library('elgg:bookmarks');

			$content = elgg_view('bookmarks-extender/bookmarklet', array(
				'page_owner_guid' => $page[1],
				'address' => get_input('address'),
				'title' => get_input('title'),
			));
			
			echo elgg_view_page($title, $content, 'bookmarklet');
			return false;
		}
	}
	return $value;
}

/**
 * Bookmarks extender page setup
 *
 * @return void
 */
function bookmarks_extender_pagesetup() {
	/** Add bookmarklet title button **/
	if (elgg_is_logged_in() && elgg_in_context('bookmarks') && !strpos(current_page_url(), 'bookmarklet')) {
		
		$page_owner = elgg_get_logged_in_user_entity();

		$title = elgg_echo('bookmarks:bookmarklet');

		elgg_register_menu_item('title', array(
			'name' => 'bookmarklet',
			'href' => 'bookmarks/bookmarklet/' . $page_owner->guid,
			'text' => $title,
			'link_class' => 'bookmarks-extender-bookmarklet-title',
		));
	}
}

/**
 * Override the default entity icon for bookmarks
 *
 * @return string Relative URL
 */
function bookmarks_icon_url_override($hook, $type, $value, $params) {
	$bookmark = $params['entity'];
	$size = $params['size'];
	
	if (elgg_instanceof($bookmark, 'object', 'bookmarks') && $bookmark->preview_image) {
		$value = $bookmark->preview_image;
	}
	return $value;
}
