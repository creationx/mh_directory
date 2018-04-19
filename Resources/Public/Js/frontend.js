jQuery(function () {

	var sHash = window.location.hash;
	var oAlphaMenu = jQuery('div.tx_mhdirectory > ul.alphabetical_menu');
	var bStateAllLetter = false;


	if (sHash.length > 0 && oAlphaMenu.length > 0) {
		openLetterEntry(sHash.substring(1));
	}

	if (jQuery('ul.alphabetical_menu').length > 0) {
		var oTarget = jQuery('ul.alphabetical_menu > li.active');
		if (oTarget.length == 1)
			openLetterEntry(oTarget.html());
	}

	jQuery('body').on('click', 'div.tx_mhdirectory > ul.alphabetical_menu > li', function (e) {
		var sChar = jQuery(this).html();
		openLetterEntry(sChar);
	});

	jQuery('body').on('click', 'div.tx_mhdirectory > ul.alphabetical_menu > li.abc_all', function (e) {
		openAllLetter();
	});

	function openLetterEntry(key) {
		var oTarget = jQuery('div.letter_' + key + ' > div');
		var oLi = jQuery('li[rel="letter_li_' + key + '"]');

		if (oTarget.length > 0) {
			// fix the "hidden div" bug for gmap
			oTarget.each(function (i, v) {
				var sMapId = jQuery('div.mh_directory_gmap', v).attr('id');
				if (typeof sMapId != 'undefined') {
					setTimeout(function () {
						var oTmpMapDom = jQuery('#' + sMapId)[0];
						google.maps.event.trigger(oTmpMapDom, 'resize');
						var aTmpMapId = sMapId.split('_')
						var oTmpMap = 'map_' + aTmpMapId[1];
						eval(oTmpMap).setCenter(aMapPos[aTmpMapId[1]]);
					}, 1000);
				}
			});

			jQuery('div.letter_entries').hide();
			jQuery('div.letter_choose').hide();
			oTarget.parent().show();

			jQuery('div.tx_mhdirectory > ul.alphabetical_menu > li.active').removeClass('active');
			oLi.addClass('active');
		}
	}

	function openAllLetter() {
		if (!bStateAllLetter) {
			jQuery('div.letter_entries').show();
			jQuery('div.letter_choose').hide();
			bStateAllLetter = true;
		} else {
			jQuery('div.letter_entries').hide();
			jQuery('div.letter_choose').show();
			bStateAllLetter = false;
		}
	}
});