<?php
/**
 * Barebones pageshell for bookmarklet
 *
 * @package BookmarksExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */

// Set the content type
header("Content-type: text/html; charset=UTF-8");

$lang = get_current_language();

$content = $vars['body'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>">
<head>
<?php echo elgg_view('page/elements/head', $vars); ?>
</head>
<body id='elgg-bookmarklet-body'>
<div class="elgg-page elgg-page-default">
	<?php echo $content; ?>
</div>
</body>
</html>