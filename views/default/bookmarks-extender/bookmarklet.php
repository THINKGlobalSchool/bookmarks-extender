<?php
/**
 * Bookmarks Extender Bookmarklet View
 *
 * @package BookmarksExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */

// Show the form for logged in users
if (elgg_is_logged_in()) {
	$vars = bookmarks_prepare_form_vars();
	$header = elgg_view_title(elgg_echo('bookmarklet:bookmarkthis', array(elgg_get_site_entity()->name)));
	elgg_push_context('bookmarklet');
	$content = elgg_view_form('bookmarks/save', array(), $vars);
} else { // Show login form

	// Grab input to reconstruct the bookmarklet url
	$page_owner_guid = elgg_extract('page_owner_guid', $vars);
	$title = elgg_extract('title', $vars);
	$address = elgg_extract('address', $vars);

	$login_url = elgg_get_site_url();
	if (elgg_get_config('https_login')) {
		$login_url = str_replace("http:", "https:", elgg_get_site_url());
	}

	// Set last_forward_from so form redirects back here after login
	$url = elgg_get_site_url() . "bookmarks/add/{$page_owner_guid}?title={$title}&address={$address}&v=" . BOOKMARKLET_VERSION;
	$_SESSION['last_forward_from'] = $url;

	$header = elgg_view_title(elgg_echo('bookmarklet:login'));
	$content = elgg_view_form('login', array('action' => "{$login_url}action/login"));
}

echo <<<HTML
	<div id='elgg-bookmarklet-wrapper'>
		<div style='display: none;'>
			<div id='elgg-bookmarklet-content'>
				$header<br />
				$content
			</div>
		</div>
	</div>
	<a href='#elgg-bookmarklet-content' class='bookmarklet-lightbox'></a>
HTML;

echo <<<JAVASCRIPT
	<script type='text/javascript'>
		$(document).ready(function() {
			// Close the bookmarklet
			var destroy = function() {
				window.parent.postMessage("destroy_bookmarklet","*");
			};

			var resizeFancyBox = function() {

			}

			// Init bookmarklet lightbox, and trigger immediately
			$(".bookmarklet-lightbox").fancybox({
				scrolling: 'no',
				onStart: function() {
					//$(window).bind('resize', resizeFancyBox);
				},
				onClosed: function() {
					//$(window).unbind('resize', resizeFancyBox);
					destroy();
				}
			}).trigger('click');

			// Ajax submit the bookmark form
			$('form.elgg-form-bookmarks-save').submit(function(event) {
				event.preventDefault();

				// Make sure we grab tinymce content
				if (typeof(tinyMCE) != 'undefined') {
					tinyMCE.triggerSave();
				}

				$('#elgg-bookmarklet-content').addClass('elgg-ajax-loader');

				elgg.action($(this).attr('action'), {
					data: $(this).serialize(),
					success: function(json) {
						$('#fancybox-close').hide();
						$('#elgg-bookmarklet-content').removeClass('elgg-ajax-loader');
						$('#elgg-bookmarklet-content').html("<h2 style='text-align: center;'>" + elgg.echo('bookmarklet:saved') + "</h2>");
						setTimeout(function() {
							$.fancybox.close();
							destroy();
						}, 1500);
					}
				});
			});

			// Grab bookmarklet element
			bookmarklet = $('#elgg-bookmarklet-content');

			// Get the initial, full height
			initial_height = bookmarklet.height();

			// Force the lightbox to resize
			setInterval(function(){
				// Move lightbox
				$.fancybox.resize();

				// Get new window height
				window_height = $(window).height();

				// Shrink bookmarklet div and set overflow
				if (bookmarklet.height() > (window_height - 60)) {
					bookmarklet.height(window_height - 50);
					bookmarklet.css('overflow-y', 'scroll');
				} else { // Reset bookmarklet height, unset overflow
					bookmarklet.height(initial_height + 50);
					bookmarklet.css('overflow-y', 'hidden');
				}	

			},300);

			// Open any other links in login form in a new tab
			$('form.elgg-form-login a').click(function(event) {
				destroy(); // Kill the bookmarklet first
				$(this).attr('target', '_blank');
			});
		});
	</script>
JAVASCRIPT;
?>