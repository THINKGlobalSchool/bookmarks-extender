<?php
/**
 * Elgg Bookmarks Extender Save Form
 *
 * @package BookmarksExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */

elgg_load_js('elgg.bookmarksextender');

$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$address = elgg_extract('address', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
$guid = elgg_extract('guid', $vars, null);
//$shares = elgg_extract('shares', $vars, array()); // What is this?

// Title
$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array('name' => 'title', 'value' => $title));

// Address
$address_label = elgg_echo('bookmarks:address');
$address_input = elgg_view('input/text', array('name' => 'address', 'value' => $address));

// Description
$description_label = elgg_echo('description');
$description_input = elgg_view('input/longtext', array('name' => 'description', 'value' => $desc));

// Tags
$tags_label = elgg_echo('tags');
$tags_input = elgg_view('input/tags', array('name' => 'tags', 'value' => $tags));

// Categories
if ($categories) {
	$categories_input = elgg_view('input/categories', $vars);	
}

// Access
$access_label = elgg_echo('access');
$access_input = elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id));

// Container
$container_input = elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

// Guid
if ($guid) {
	$guid_input = elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
}

// Search? Go? Check?
$check = elgg_view('input/submit', array(
	'value' => elgg_echo('bookmarks-extender:label:check'),
	'id' => 'bookmarks-extender-check'
));

// Submit
$submit = elgg_view('input/submit', array('value' => elgg_echo('save')));

$content = <<<HTML
	<div>
		<label>$title_label</label><br />
		$title_input
	</div>
	<div>
		<label>$address_label</label><br />
		<span class='bookmarks-address'>$address_input</span>
		<span class='bookmarks-check'>$check</span>
	</div>
	<div id='bookmarks-loader' class='elgg-ajax-loader'></div>
	<div id="bookmarks-extender-preview-container">
	</div>
	<div id='bookmarks-extender-hidden' class='hidden'>
		<div>
			<label>$description_label</label><br />
			$description_input
		</div>
		<div>
			<label>$tags_label</label><br />
			$tags_input
		</div>
		$categories_input
		<div>
			<label>$access_label</label><br />
			$access_input
		</div>
		<div class="elgg-foot">
			$container_input
			$guid_input
			$submit
		</div>
	</div>
HTML;

echo $content;