<?php
/**
 * Bookmarklet
 *
 * OVERRIDE
 *
 * @package Bookmarks
 */

$page_owner = elgg_get_page_owner_entity();

$site_name = elgg_get_site_entity()->name;

if ($page_owner instanceof ElggGroup) {
	$title = elgg_echo("bookmarks:this:group", array($page_owner->name, $site_name));
} else {
	$title = elgg_echo("bookmarks:this", array($site_name));
}

$guid = $page_owner->getGUID();

if (!$name && ($user = elgg_get_logged_in_user_entity())) {
	$name = $user->username;
}

$url = elgg_get_site_url();
$url = str_replace("http://", "https://", $url);
$img = elgg_view('output/img', array(
	'src' => 'mod/bookmarks/graphics/bookmarklet.gif',
	'alt' => $title,
));

$version = BOOKMARKLET_VERSION;

// Shameful C&P from delicious.. but it works
$bookmarklet = '<a href=\'javascript:(function(e,t){var n=e.document;setTimeout(function(){function a(e){if(e.data==="destroy_bookmarklet"){var r=n.getElementById(t);if(r){n.body.removeChild(r);r=null}}}var t="elgg-bookmarklet-iframe",r=n.getElementById(t);if(r){return}var i="'  . "{$url}bookmarks/add/$guid" . '?",s=n.createElement("iframe");s.id=t;s.src=i+"address="+encodeURIComponent(e.location.href)+"&title="+encodeURIComponent(n.title)+"&v=' . $version . '";s.style.position="fixed";s.style.top="0";s.style.left="0";s.style.height="100%25";s.style.width="100%25";s.style.zIndex="16777270";s.style.border="none";s.style.visibility="hidden";s.onload=function(){this.style.visibility="visible"};n.body.appendChild(s);var o=e.addEventListener?"addEventListener":"attachEvent";var u=o=="attachEvent"?"onmessage":"message";e[o](u,a,false)},1)})(window)\'>'. $img . "</a>";

?>
<p><?php echo elgg_echo("bookmarks:bookmarklet:description"); ?></p>
<p><?php echo $bookmarklet; ?></p>
<p><?php echo elgg_echo("bookmarks:bookmarklet:descriptionie"); ?></p>
<p><?php echo elgg_echo("bookmarks:bookmarklet:description:conclusion"); ?></p>