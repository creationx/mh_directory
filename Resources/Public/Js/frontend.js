jQuery(function() {

	var sHash 		= window.location.hash;
	var oAlphaMenu 	= jQuery('div.tx_mhdirectory > ul.alphabetical_menu');

	if(sHash.length > 0 && oAlphaMenu.length > 0) {
		openLetterEntry(sHash.substring(1));
	}

	jQuery('body').on('click', 'div.tx_mhdirectory > ul.alphabetical_menu > li', function(e) {
		var sChar = jQuery(this).html();
		openLetterEntry(sChar);
	});

	function openLetterEntry(key) {
		var oTarget = jQuery('div.letter_' + key + ' > div');
		var oLi = jQuery('li[rel="letter_li_' + key + '"]');

		if(oTarget.length > 0) {
			jQuery('div.letter_entries').hide();
			jQuery('div.letter_choose').hide();
			oTarget.parent().show();

			jQuery('div.tx_mhdirectory > ul.alphabetical_menu > li.active').removeClass('active');
			oLi.addClass('active');

			var moo = ["map_1"];

			var center = moo[0].getCenter(); 
		    google.maps.event.trigger(moo[0], 'resize'); 
		    moo[0].setCenter(center); 
		}
	}
});

