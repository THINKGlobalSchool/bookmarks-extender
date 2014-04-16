<?php
/**
 * Elgg Bookmarks Extender Bookmark Video Popup View
 *
 * @package BookmarksExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */

$guid = elgg_extract('entity_guid', $vars);

$bookmark = get_entity($guid);

if (elgg_instanceof($bookmark, 'object', 'bookmarks')) {
	echo bookmarks_extender_filter_video_iframe($bookmark->preview_video_iframe);
} else {
	return false;
}

