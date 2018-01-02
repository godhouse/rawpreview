
(function() {
	if (!OCA.RawPreview) {
		/**
		 * Namespace for the files app
		 * @namespace OCA.RawPreview
		 */
		OCA.RawPreview = {};
	}

	/**
	 * @namespace OCA.RawPreview.Admin
	 */
	OCA.RawPreview.Admin = {
		initialize: function() {
			$('#submitRawPreview').on('click', _.bind(this._onClickSubmitRawPreview, this));
		},

		_onClickSubmitRawPreview: function () {
			OC.msg.startSaving('#rawPreviewSettingsMsg');

			var request = $.ajax({
				url: OC.generateUrl('/apps/rawpreview/settings/setExif'),
				type: 'POST',
				data: {
					exiftool: $('#exiftoolPosition').val(),
                    ffmpeg: $('#ffmpegPosition').val(),
                    libreoffice: $('#libreofficePosition').val()
				}
			});

			request.done(function (data) {
				$('#exiftoolPosition').val(data.exiftoolPosition);
                $('#ffmpegPosition').val(data.ffmpegPosition);
                $('#libreofficePosition').val(data.libreofficePosition);
				OC.msg.finishedSuccess('#rawPreviewSettingsMsg', 'Saved');
			});

			request.fail(function () {
				OC.msg.finishedError('#rawPreviewSettingsMsg', 'Error');
			});
		}
	}
})();

$(document).ready(function() {
	OCA.RawPreview.Admin.initialize();
});
