<?php
/**
 * Elgg Bookmarks Extender CSS
 *
 * @package BookmarksExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */
?>
/** <style> /**/
.bookmarks-address, .bookmarks-check {
	display: inline-block;
}

.bookmarks-address {
	width: 90%;
}

.bookmarks-check {
	width: 9%;
	text-align: right;
}

#bookmarks-loader {
	display: none;
}

.bookmarks-image-left {
	float: left;
	max-width: 40%;
	margin-right: 10px;
}

.bookmarks-video-iframe {
	margin-bottom: 15px;
}

.bookmarks-video-iframe > iframe {
	margin-left: auto;
	margin-right: auto;
	display: block;
}

/** Bookmarklet **/
#elgg-bookmarklet-content {
	min-width: 600px;
	overflow: hidden;
}

#elgg-bookmarklet-content * {
}

#elgg-bookmarklet-content .bookmarks-address {
	width: 88%;
}

#bookmarks-extender-preview-container img {
	max-width: 600px;
}

body#elgg-bookmarklet-body {
	background-color: transparent;
	overflow: hidden;
}

div#elgg-bookmarklet-wrapper  {
	width: 400px;
}

div#elgg-bookmarklet-form {
	padding: 10px;
}
