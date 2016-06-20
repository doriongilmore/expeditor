$(document).ready(function(){
	$('body').addClass('js-ok');
	activeInputFocusBlur();
	activeNavigationMenus();
	$(window).load(function() {
		activeFixMainNavigation();
	});
	activeOpenLogin();
	clearLauraTextarea();
});

// ############################################################
// ############################################################
// SPECIFICS FUNCTIONS
// ############################################################
// Input auto Focus/Blur
// ############################################################

function activeInputFocusBlur() {
	$("input.js-focus-blur, textarea.js-focus-blur").each(function() {
		var defaultText = $(this).val();
		$(this).bind("focus", function(e){
			if ($(this).val() == defaultText) {
				$(this).attr("value","");
			}
		});
		$(this).bind("blur", function(e){
			if ($(this).val() == "") {
				$(this).attr("value", defaultText);
			}
		});
	});
}

// ############################################################
// Navigation menus
// ############################################################
//function isLogged() {
//	try {
//		if (market_id == "")
//			return false;
//		else
//			return ($.cookie(market_id) != null);
//	} catch(e) {
//		return false;
//	}
//}

function activeNavigationMenus() {
	// Menus de navigation du Template (Header et Navigation principale)
	
	$("#Page #MainNavigation.special>.wrap>ul.mainMenu").each(function() {
		// Menu spécial formatage largeur des boutons (pour régler problème des libellés trops longs)
		var maxWidth = $(this).width();
		var realWidth = 0;
		$(this).find('>li').each(function() {
			realWidth = realWidth+$(this).width();
		});
		if(realWidth>maxWidth) {
			$(this).find('>li>a').css('padding-right','9px');
			$(this).find('>li>a').not('.home').css('padding-left','10px');
			$(this).find('>li>a.home').css({
				'padding-left'			:	'36px',
				'background-position'	:	'9px 9px'
			});
			$(this).find('>li>a.home').hover(function(){
					$(this).css('background-position','9px -32px')
				},function(){
					$(this).css('background-position','9px 9px')
			});
			// On enlève le premier (accueil) et on recalcule avec nouveaux paddings
			maxWidth = $(this).width()-$(this).find('>li').eq(0).width();
			var itemNbr = ($(this).find('>li').length)-1
			var itemWidth = parseInt(maxWidth/itemNbr);
			$(this).find('>li').not(':first').width(itemWidth);
			//$(this).find('>li').not(':first').css('max-width',itemWidth+'px');
		}
	});
	// Remplacement alignement vertical table-cell pour IE7
	$("#Page #MainNavigation>.wrap>ul>li>a").each(function() {
		if($(this).height()>20) {
			$(this).css({
				'padding-top':'5px',
				'height':'29px'
			});
		} else {
			$(this).css({
				'padding-top':'10px',
				'height':'24px'
			});
		}
	});
	//Test input focus sur menu identification
	var loginMenuInputHasFocus = false;
    $('#HlLoginMenu').find('input').each(function() {
		$(this).focus(function(){
			loginMenuInputHasFocus = true;
		}).blur(function(){
			loginMenuInputHasFocus = false;
		});
	});
	hiConfig = {
		sensitivity: 20, // number = sensitivity threshold (must be 1 or higher)        
		interval: 100, // number = milliseconds for onMouseOver polling interval        
		timeout: 200, // number = milliseconds delay before onMouseOut        
		over: function() {
			if($(this).parent().parent().hasClass('mainMenu') || $(this).parent().attr("id") == "HlSitesMenu") {
				var hs = $(this).parent().find(">ul").height();
				$(this).parent().find(">ul>li").css({"height":(hs)+"px"});
			}
			if($(this).parent().find(">ul").length>0) {
				$(this).parent().addClass("hoverActive");
				$(this).parent().find(">ul").slideDown(300);
			}
			$(this).parent().hover(function() {
			}, function() {
				if($(this).parent().attr("id") == "HlLoginMenu") {
					//Test input focus (saisie en cours) avant fermeture
					if(loginMenuInputHasFocus) {
						return false;
					}
				}
				$(this).parent().find("li.hoverActive>ul").slideUp(100);
				$(this).parent().find("li.hoverActive").removeClass("hoverActive");
			})
				
		},
		out: function() {
		} 
	}
//	if (isLogged()) {
//		var items = $.cookie(market_id).split("|");
//		if (items.length >= 3) {
//			if (lan_s_id == "fr")
//				var bonjour = "Bonjour ";
//			else
//				var bonjour = "Hello ";
//			$("#HeaderWelcome").text(bonjour + items[1] + " " + items[3] + " " + items[2]);
//		}
//		$("#HeaderLogin").remove();
//	} else {
//		$("#HeaderLogout").remove();
//	}
//	$("#Menu1, #Menu2, #HlUrgencesMenu, #HlSitesMenu, #HaCountryMenu, #HlLoginMenu").removeClass("cssonly");
//	$("#Menu1>li>a, #Menu2>li>a, #HlUrgencesMenu>a, #HlSitesMenu>a, #HaCountryMenu>li>a, #HlLoginMenu>li>a").hoverIntent(hiConfig);
}

function activeOpenLogin() {
	$("a.js-open-login").each(function() {
		$(this).click(function() {
			$("#HlLoginMenu>li>ul").slideDown(300);
			$("#HlLoginMenu>li").addClass('hoverActive');
		});
	});
}

// ############################################################
// Fix main navigation position (on scroll)
// ############################################################

function activeFixMainNavigation() {
	var newHeaderHeight = 46;
	var limit = $("#Header").outerHeight(true)-newHeaderHeight;
	var space = $("#Header").outerHeight(true)+$("#MainNavigation").outerHeight(true);
	var newLogoHeight = $("#Logo img").height()/2;
	var newLogoWidth = $("#Logo img").width()/2;
	$(window).scroll(function () {
		if($(document).scrollTop() > limit){
			$("#Header").addClass('fixed');
			$("#Logo img").height(newLogoHeight);
			$("#Logo img").width(newLogoWidth);
			$("#HeaderIdentification,#HeaderIdentity").css('bottom','10px');
			$("#HeaderTop,#HeaderRight,#Baseline").hide();
		} else if($(document).scrollTop() < 15){
			$("#Logo img,#HeaderIdentification,#HeaderIdentity,#HeaderTop,#HeaderRight,#Baseline").removeAttr('style');
			$("#Header").removeClass('fixed');
		}
		if($(document).scrollTop() > limit){
			$("#MainNavigation").css({
				'position'	:	'fixed',
				'top'		:	newHeaderHeight+'px'
			});
			$("#Header").css({
				'position'	:	'fixed',
				'height'	:	newHeaderHeight+'px'
			});
			$("#Header>.wrap").css('height',newHeaderHeight+'px');
			$("#Page").css('padding-top',space+'px');
			$("#Header").addClass('fixed');
		} else {
			$("#MainNavigation,#Header,#Header>.wrap,#Page").removeAttr('style');
			$("#Header").removeClass('fixed');
		}
	});
}

//############################################################
//Laura //
//############################################################


function clearLauraTextarea() {
	$('#FormLauraQuestion').focus(function() {	
		$(this).val(''); // clear value
	});
}