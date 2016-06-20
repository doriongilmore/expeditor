/** =========================================================================== *
 * 		Fichier :		FRONT/NetExpress/scripts/site_blocsModulaires.js		*
 * 		Auteur :		Benoît FETIVEAU											*
 * 		Description :	Javascript utilisées par le générateur					*
 *						de blocs modulaires du répertoire classes/T1P1Blocks	*
 * ============================================================================ */
 
$(document).ready(function(){
	activeCarousels();
	sizeBlockHeight();
});

// ############################################################
// ############################################################
// SPECIFICS FUNCTIONS
// ############################################################
// Formattage en hauteur des blocs dans une même ligne
// ############################################################

function sizeBlockHeight() {
	$('.cols').each(function(iCols, eCols) {
		var blockHeight = 0;
		var blockWrapHeight = 0;
		$(eCols).find('>.col>.js-auto-height').each(function(i, e) {
			blockHeight = Math.max(blockHeight, $(e).height());
		});
		$(eCols).find('>.col>.js-auto-height').each(function(i, e) {
			blockWrapHeight = blockHeight - $(e).find('>h2,>.title').outerHeight(true) - $(e).find('>.action').outerHeight(true);
			$(e).find('>.wrap').height(blockWrapHeight);
		});
		
		// Fix for old IE with PIE.htc whose elements need to be redraw
		if ($('.ie-7:first, .ie-8:first').length) {
			$(eCols).find('>.col>.js-auto-height').trigger('move');
		}
	});
}

// ############################################################
// Carousels //
// ############################################################

function activeCarousels() {
	$('.carousel').each(function() {
		var carousel = $(this);
		var itemLabel = 1;
		var itemHeight = 0;
		var carTimer;
		$(this).prepend('<div class="carousel-control"></div>');
		$(this).find('>.group').each(function(i) {
			itemHeight = Math.max(itemHeight, $(this).height());
			$(this).hide();
			itemLabel = i+1;
			$(this).parent().find('.carousel-control').append('<a href="#">'+itemLabel+'</a>');
		});
		$(this).find('>.group').each(function() {
			$(this).height(itemHeight);
		});
		$(this).find('>.carousel-control>a').each(function(j) {
			$(this).click(function(event,autoClick) {
				$(this).parent().parent().find('>.group.active').removeClass('active').hide();
				$(this).parent().parent().find('>.group').eq(j).addClass('active').show();
				$(this).parent().find('>a.active').removeClass('active');
				$(this).addClass('active');
				if (typeof(autoClick)=="undefined"){
					clearInterval(carTimer);
				}
				return false;
			});
		});
		$(this).find('>.carousel-control>a').eq(0).click();
		carTimer = setInterval(function(){
			if($(carousel).find('>.carousel-control>a.active').next('a').length>0) {
				$(carousel).find('>.carousel-control>a.active').next('a').trigger("click", [true]);
			} else {
				$(carousel).find('>.carousel-control>a').eq(0).trigger("click", [true]);
			}
		},3000);
	});
}