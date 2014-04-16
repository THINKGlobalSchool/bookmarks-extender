<?php
/**
 * Elgg Bookmarks Extender custom icon view
 *
 * @package BookmarksExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 * @uses $vars['entity']     The entity the icon represents - uses getIconURL() method
 * @uses $vars['size']       topbar, tiny, small, medium (default), large, master
 * @uses $vars['href']       Optional override for link
 * @uses $vars['link_class'] The class to pass to the output/url view.
 */

$entity = $vars['entity'];

$class = elgg_extract('img_class', $vars, '');

$sizes = array('small', 'medium', 'large', 'tiny', 'master', 'topbar');
// Get size
if (!in_array($vars['size'], $sizes)) {
	$vars['size'] = "medium";
}

if (isset($entity->name)) {
	$title = $entity->name;
} else {
	$title = $entity->title;
}

$url = $entity->getURL();
if (isset($vars['href'])) {
	$url = $vars['href'];
}

$icon_sizes = elgg_get_config('icon_sizes');
$size = $vars['size'];

if (!isset($vars['width'])) {
	$vars['width'] = $size != 'master' ? $icon_sizes[$size]['w'] : null;
}

$img_params = array(
	'src' => $entity->getIconURL($vars['size']),
	'alt' => $title,	
);

if (!empty($class)) {
	$img_params['class'] = $class;
}

if (!empty($vars['width'])) {
	$img_params['width'] = $vars['width'];
}

$img = elgg_view('output/img', $img_params);

if ($url) {
	$params = array(
		'href' => $url,
		'text' => $img,
		'is_trusted' => true,
	);
	$class = elgg_extract('link_class', $vars, '');
	if ($class) {
		$params['class'] = $class;
	}

	echo elgg_view('output/url', $params);
} else {
	echo $img;
}
