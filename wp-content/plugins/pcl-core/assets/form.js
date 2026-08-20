/**
 * PCL Core — Form interaction: validation, AJAX submit, status display.
 * Uses vanilla JS; depends on jQuery only enqueued by the plugin.
 */

(function ($) {
	'use strict';

	var PCL_CORE = {

		init: function () {
			$(document).on('submit', '[data-pcl-form]', this.handleSubmit.bind(this));
		},

		handleSubmit: function (e) {
			e.preventDefault();

			var $form = $(e.currentTarget);
			var $status = $form.find('.pcl-form-status');
			var $submitBtn = $form.find('button[type="submit"]');
			var formData = new FormData(e.target);

			if (!this.validate($form)) {
				this.showStatus($status, 'is-error', 'Please fill in all required fields.');
				return;
			}

			var nonce = formData.get('nonce') || $('input[name=nonce]', $form).val();
			formData.set('action', 'pcl_submit_form');
			formData.set('nonce', nonce);

			$submitBtn.prop('disabled', true).text('Sending…');

			var self = this;
			$.ajax({
				url: pclCoreAjax ? pclCoreAjax.ajax_url : '/wp-admin/admin-ajax.php',
				method: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json'
			})
				.done(function (resp) {
					if (resp.success) {
						self.showStatus($status, 'is-success', resp.data.messages[0]);
						$form[0].reset();
						window.__pclInst && window.__pclAfford && window.__pclAfford();
					} else {
						var msgs = resp.data && resp.data.messages ? resp.data.messages.join(' ') : 'Something went wrong. Please try again.';
						self.showStatus($status, 'is-error', msgs);
					}
				})
				.fail(function () {
					self.showStatus($status, 'is-error', 'Connection error. Please try again or call us directly.');
				})
				.always(function () {
					$submitBtn.prop('disabled', false).text('Submit');
				});
		},

		validate: function ($form) {
			var valid = true;
			$form.find('[required]').each(function () {
				if (!$(this).val().trim()) {
					valid = false;
					$(this).attr('aria-invalid', 'true');
				} else {
					$(this).removeAttr('aria-invalid');
				}
			});
			return valid;
		},

		showStatus: function ($el, cls, msg) {
			$el.removeClass('is-success is-error')
				.addClass(cls)
				.text(msg)
				.show();
		}

	};

	$(function () {
		PCL_CORE.init();
	});

	window.PCL_CORE = PCL_CORE;
})(jQuery);
