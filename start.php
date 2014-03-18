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

	// Register fb link preview library
	elgg_register_library('facebook-link-preview', elgg_get_plugins_path() . 'bookmarks-extender/vendors/fblinkpreview/php/classes/LinkPreview.php');

	// Extend main CSS
	elgg_extend_view('css/elgg', 'css/bookmarks-extender/css');
}