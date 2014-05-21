<?php
/**
 * Elgg Bookmarks Extender JS Lib
 *
 * @package BookmarksExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */
?>
//<script>
elgg.provide('elgg.bookmarksextender');

// General init
elgg.bookmarksextender.init = function() {
	// Bind check input
	$(document).delegate('#bookmarks-extender-check', 'click', elgg.bookmarksextender.check);

	// Trigger check automatically if we're loading the save form in the bookmarklet popup
	if ($('#elgg-bookmarklet-body').length !== 0) {
		$('#bookmarks-extender-check').trigger('click');
	}
}

/**
 * Click handler for bookmarks check input
 */
elgg.bookmarksextender.check = function(event) {
	var $_this = $(this);
	$_this.attr('disabled', 'DISABLED')
	$_this.addClass('elgg-state-disabled');

	$('#bookmarks-extender-preview-container').fadeOut('fast');
	$('#bookmarks-loader').fadeIn('fast');

	// Valid URL regex
	var urlRegex = /(https?\:\/\/|\s)[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})(\/+[a-z0-9_.\:\;-]*)*(\?[\&\%\|\+a-z0-9_=,\.\:\;-]*)?([\&\%\|\+&a-z0-9_=,\:\;\.-]*)([\!\#\/\&\%\|\+a-z0-9_=,\:\;\.-]*)}*/i;

	// Address input value
	var address = $('input[name="address"]').val();

	// Check for valid address
	if (urlRegex.test(address)) {
		elgg.action('bookmarks/preview', {
			data: {
				'address': address
			},
			success: function(response) {
				// Ouput image preview
				$('#bookmarks-extender-preview-container').html(response.output.view);

				// Hide the check input
				$('#bookmarks-check').fadeOut('fast');

				// Set title content
				$('input[name="title"]').val(response.output.result.title);

				// Get description input
				var $desc_input = $('textarea[name="description"]');

				// Update description, may be tinymce
				if (typeof(tinyMCE) !== 'undefined') {
					setTimeout(function() {
						tinyMCE.get($desc_input.attr('id')).setContent(response.output.result.description);
					}, 1000);
				} else {
					$desc_input.val(response.output.result.description);
				}

				$('#bookmarks-loader').fadeOut('fast');
				$('#bookmarks-extender-preview-container').fadeIn('fast');
				$('#bookmarks-extender-hidden').fadeIn('fast');
				$_this.removeAttr('disabled');
				$_this.removeClass('elgg-state-disabled');
			}
		});
	} else {
		// Invalid address
		elgg.register_error(elgg.echo('bookmarks-extender:error:invalidurl'));
		$_this.removeAttr('disabled');
		$_this.removeClass('elgg-state-disabled');
		$('#bookmarks-loader').fadeOut('fast');
	}

	event.preventDefault();
}

elgg.register_hook_handler('init', 'system', elgg.bookmarksextender.init);