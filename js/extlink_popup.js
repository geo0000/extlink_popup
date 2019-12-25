/**
 * @file
 * Contains functionality to display JQuery modal dialog
 * when clicking on external links.
 */

(function ($, Drupal, drupalSettings) {

	'use strict';

	/**
	 * External links popup.
	 */
	var extlinkModalDialog;

	Drupal.extlink = Drupal.extlink || {};

	/**
	 * Overrides popupClickHandler from extlink module.
	 */
	Drupal.extlink.popupClickHandler = function (e, externalLink) {

		/**
		 * Get markup for external links JQuery dialog.
		 *
		 * @returns {string}
		 *   Markup for external links JQuery dialog.
		 */
		function getDialogMarkup(externalLinkHref) {
			var titleMarkup = '<h3>' + drupalSettings.data.extlinkPopup.extPopupTitle + '</h3>';
			var bodyMarkup = '<p>' + drupalSettings.data.extlinkPopup.extPopupBody + '</p>';
			var closeButtonMarkup = '<span class="popup-close js-popup-close"></span>';
			var continueButtonMarkup = $("<a/>", {
				'href': externalLinkHref,
				'target': '_blank',
				'class': 'js-popup-continue'
			}).text(drupalSettings.data.extlinkPopup.extPopupButtonTitle).prop('outerHTML');
			return '<div>' + titleMarkup + closeButtonMarkup + bodyMarkup + continueButtonMarkup + '</div>'
		}

		if (drupalSettings.data.extlinkPopup.extPopup) {
			extlinkModalDialog = Drupal.dialog(getDialogMarkup($(externalLink).attr('href')), {
				dialogClass: 'extlink-modal',
				autoResize: true,
				open: function (event, ui) {
					$(this).parent().children('.ui-dialog-titlebar').hide();
				}
			});

			extlinkModalDialog.showModal();
			return false;
		}
		else if (drupalSettings.data.extlink.extAlert) {
			return confirm(drupalSettings.data.extlink.extAlertText);
		}
	};

	Drupal.behaviors.extlinkPopup = {
		attach: function (context) {
			$(document).on('click', '.js-popup-continue, .js-popup-close', function (e) {
				extlinkModalDialog.close();
			});

		}
	};

})(jQuery, Drupal, drupalSettings);
