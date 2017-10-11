
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
			$('#submitExiftoolPosition').on('click', _.bind(this._onClickSubmitExifTool, this));
		},

		_onClickSubmitExifTool: function () {
			OC.msg.startSaving('#exiftoolPositionSettingsMsg');

			var request = $.ajax({
				url: OC.generateUrl('/apps/rawpreview/settings/setExif'),
				type: 'POST',
				data: {
					maxUploadSize: $('#maxUploadSize').val()
				}
			});

			request.done(function (data) {
				$('#exiftoolPosition').val(data.exiftoolPosition);
				OC.msg.finishedSuccess('#exiftoolPositionSettingsMsg', 'Saved');
			});

			request.fail(function () {
				OC.msg.finishedError('#exiftoolPositionSettingsMsg', 'Error');
			});
		}
	}
})();

$(document).ready(function() {
	OCA.RawPreview.Admin.initialize();
});
