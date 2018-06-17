// JavaScript Document

// document ready
$(function() {
	// hide a few elements
	$("#blackOut, .inputForm, #formHolder, #error, .inputForm.reminder div:nth-child(4), .fieldHeader button span").hide(); 
	
	// some stuff for the jScrollPane plugin
    $(".fieldContent, .moreContent").jScrollPane({
		autoReinitialise: true
	});
	
	$('.jspScrollable').on("mouseenter", function() {
		$(this).find('.jspDrag').stop(true, true).fadeIn('slow');
		$(this).find('.jspVerticalBar').stop(true, true).fadeIn('slow');
	});
	
	$('.jspScrollable').on("mouseleave", function(){
		$(this).find('.jspDrag').stop(true, true).fadeOut('slow');
		$(this).find('.jspVerticalBar').stop(true, true).fadeOut('slow');
	});
	/* *************************************** */
	/* *************************************** */	
	
	// date picker stuff
	$(".fieldContent").on("focus", "input[name=date]", function() { 
		$(this).datepicker({
			changeMonth : true,
			changeYear : true,
			dateFormat : "dd/mm/yy"
		});
	});
	
	/* *************************************** */
	/* *************************************** */
	
	rearrange(".moreContent.workdone .jspPane > div");
	rearrange(".moreContent.payments .jspPane > div");
	rearrange(".moreContent.paymentcategories .jspPane > div");
	rearrange(".moreContent.companies .jspPane > div");
	
	
	// displaying of the blackout and morecontent overlay	
	$(".fieldHeader .more").on("click", function() {
		var classes = $(this).attr("class").split(" ");
		var thisClass = ".moreContent." + classes[1];
		
		$(thisClass).animate({top: "8%"}, 800);
		$("#blackOut").fadeIn(800);
	});
	
	$("#blackOut").on("click", function(){ // close all overlays
		$("#blackOut").fadeOut(800);
		$(".moreContent").animate({top: "-600%"}, 800);
	});
	/* *************************************** */
	/* *************************************** */	
	
	// show forms section
	$(".button_group button, .fieldContent button, .moreContent button").on("click", function() {
		showForm($(this));
	});
	/* *************************************** */
	/* *************************************** */
	
	
	// close the form when close button is clicked
	$("#formHolder").on("click", "input[type=button]", function() { 
		var changed = ".inputForm.reminder.shown";
	
		$("#formHolder").slideUp(600);
		$("#error").fadeOut(600);
		
		$(changed + " div:nth-child(4)").hide();
		$(changed + " div:first-child, " + changed + " div:nth-child(2)").animate({
			"width" : "23.8%"
		}, 800);;
	});
	/* *************************************** */
	/* *************************************** */
			
	
	// fieldHeader button
	$(".fieldHeader button").hover(function() {
		$(this).animate({
			width : "+=180"	
		}, 350, function() {
			$(this).animate({
				height : "+=8"
			}, 150);
				
			$(this).find("span").fadeIn(150);
		});
	}, function() {
		$(this).animate({
			height : "-=8"
		}, 250, function() {
			$(this).find("span").fadeOut(150);
			
			$(this).animate({
				width : "-=180"
			}, 150);
		});
	});
	
	
	// validate forms section 
	// on blur for each form element
	$(".fieldContent").on("blur", ".shown input[type=text], .shown select", function() {	
		validateFormField($(this));
	});
	
	// on submit for the entire form
	$(".fieldContent").on("submit", ".shown", function() {
		return checkFormOnSubmit($(this));
	});
	/* *************************************** */
	/* *************************************** */
	
	
	// changing occurrence
	$(".fieldContent").on("change", ".inputForm.shown select[name=occurrence]", function() {
		const PHONE_WIDTH = 580;
		var pageWidth = $("html").width();
		var changed = ".inputForm.reminder.shown";
		
		var changedElements = $(changed + " div:first-child, " + changed + " div:nth-child(2)");
		var element = $(changed + " div:nth-child(4)");
		
		if($(this).val() != 1) {	// show the repeats part of the form 
			if(pageWidth > PHONE_WIDTH) {
				var width = "15.32%";

				$(changedElements).animate({
					"width" : width
				}, 800, function() {
					if($(element).css("display") == "none") {
						$(element).width(0).css("display", "block").animate({
							"width" : width,
							opacity : "1"
						}, 800);
					}
				});
			}
			else {
				if($(element).css("display") == "none") {
					$(element).width(0).css("display", "block").animate({
						"width" : "95%",
						opacity : "1"
					}, 800);
				}
			}
		}
		else { // hide the repeats part of the form
			if(pageWidth > PHONE_WIDTH) {
				$(element).animate({"width" : "0px"}, 800, function() {
					$(changedElements).animate({"width" : "23.8%"}, 800);
				}).dequeue().fadeOut(800);
			}
			else {
				$(element).animate({"width" : "0px"}, 800).dequeue().fadeOut(800);
			}
		}
	});
	
	// visualisation stuff  
	$("input[type=text], select").on("focus", function() {
		$(this).animate({"backgroundColor" : "rgba(0, 102, 204, 0.1)"}, 800);
	});	
});