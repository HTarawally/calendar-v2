// JavaScript Document
function rearrange(chosen) {
	var height = 0;
	
	// sort out display of payments and workdone breakdown
	$(chosen).each(function(index, element) {
        var thisClass = $(this).attr("class");
		
		$("article." + thisClass).each(function() {
			$(element).append("<article class='seperated container'>" + $(this).html() + "</article>");
			$(this).remove();
		});
		
		height = (height < $(this).height()) ? $(this).height() : height;
		$(this).addClass("container");
    });
	
	$(chosen).height(height + 4);
} // end function rearrange

function formatDate(thisDate) {
	var dateValues = thisDate.split("/");
			
	if(dateValues[0].length == 1) {
		dateValues[0] = '0' + dateValues[0];	
	}
	
	if(dateValues[1].length == 1) {
		dateValues[1] = '0' + dateValues[1];	
	}
	
	return dateValues[0] + "/" + dateValues[1] + "/" + dateValues[2];
} // end function formatDate

function formatAmount(thisAmount) {
	if(thisAmount.match("\\.")) { // if the amount contains a period
		var amountSplit = thisAmount.split("."); // split into pounds and pence;
		
		for(var x = amountSplit[1].length; x < 2; x++) {
			amountSplit[1] += '0';	
		}

		return amountSplit[0] + "." + amountSplit[1];
	}
	else {
		return thisAmount + ".00";	
	}	
} // end function formatAmount

function formatHours(thisHours) {
	if(thisHours.match(":")) { // if the hours contains a colon
		var hoursSplit = thisHours.split(":"); // split into hours and minutes;
		
		for(var x = hoursSplit[1].length; x < 2; x++) {
			hoursSplit[1] += '0';	
		}

		if(hoursSplit[1] >= 60) {
			hoursSplit[1] = 59;
		}
		
		return hoursSplit[0] + ":" + hoursSplit[1];
	}
	else {
		return thisHours + ":00";	
	}	
}

function showForm(clickedElement) {
	var formClass = "." + $(clickedElement).attr("class") + ".inputForm";
	var originalFormHTML = $(formClass).html();
	var section = $(clickedElement).parents("article");
	var formValues;
	
	if(section.is("article")) {
		var id = $(section).find("input[name=id]").val();
		
		switch($(clickedElement).attr("class")) {
			case "birthday":
				var date = formatDate($(section).find("input[name=date]").val());
				var name = $(section).find("input[name=name]").val();
									
				formValues = [id, date, name];
			break;	
			
			case "reminder":
				var date = formatDate($(section).find("input[name=date]").val());
				var comment = $(section).find("input[name=comment]").val();
				var occ = $(section).find("input[name=occurrence]").val();
				var repeats = $(section).find("input[name=repeats]").val();
			
				formValues = [id, date, comment, occ, repeats];
			break;
			
			case "payment":
				var date = formatDate($(section).find("input[name=date]").val());
				var amount = formatAmount($(section).find("input[name=amount]").val());
				var type = $(section).find("input[name=type]").val();
				var category = $(section).find("input[name=category]").val();
			
				formValues = [id, date, amount, type, category];
			break;
			
			case "workdone":
				var date = formatDate($(section).find("input[name=date]").val());
				var company = $(section).find("input[name=company]").val();
				var hours = formatHours($(section).find("input[name=hours]").val());
				var wage = formatAmount($(section).find("input[name=wage]").val());
				var oHours = formatHours($(section).find("input[name=oHours]").val());
				var oWage = formatAmount($(section).find("input[name=oWage]").val());
			
				formValues = [id, date, company, hours, wage, oHours, oWage];
			break;
			
			case "paymentcategory":
				var category = $(section).find("input[name=category]").val();
			
				formValues = [id, category];
			break;
			
			case "company": 
				var company = $(section).find("input[name=company]").val();
				
				formValues = [id, company];
			break;
		}
	}
	
	$("#formHolder")
		.html("")
		.html($(formClass).not($(".shown")).clone(true, true).css("display", "block").addClass("shown"))
		.width("100%").slideDown(800);
	
	if(section.is("article")) {
		var shownForm = formClass + ".shown";
		
		$(shownForm).find("input[name=op]").val("edit");
		$(shownForm).find("input[name=id]").val(formValues[0]);
		
		switch($(clickedElement).attr("class")) {
			case "birthday":
				$(shownForm).find("input[name=date]").val(formValues[1]);
				$(shownForm).find("input[name=name]").val(formValues[2]);
			break;	
			
			case "reminder":
				$(shownForm).find("input[name=date]").val(formValues[1]);
				$(shownForm).find("input[name=comment]").val(formValues[2]);
				$(shownForm).find("select[name=occurrence]").val(formValues[3]);
				$(shownForm).find("input[name=repeats]").val(formValues[4]);
				
				$(shownForm).find("select[name=occurrence]").trigger("change");
			break;
			
			case "payment":
				$(shownForm).find("input[name=date]").val(formValues[1]);
				$(shownForm).find("input[name=amount]").val(formValues[2]);
				$(shownForm).find("select[name=type]").val(formValues[3]);
				$(shownForm).find("select[name=category]").val(formValues[4]);
			break;
			
			case "workdone": 
				$(shownForm).find("input[name=date]").val(formValues[1]);
				$(shownForm).find("select[name=company]").val(formValues[2]);
				$(shownForm).find("input[name=hours]").val(formValues[3]);
				$(shownForm).find("input[name=wage]").val(formValues[4]);
				$(shownForm).find("input[name=oHours]").val(formValues[5]);
				$(shownForm).find("input[name=oWage]").val(formValues[6]);
			break;
			
			case "paymentcategory":
				$(shownForm).find("input[name=category]").val(formValues[1]);
			break;
			
			case "company":
				$(shownForm).find("input[name=company]").val(formValues[1]);
			break;
		}
	}
	
	$("#blackOut").trigger("click");
	$("#error").fadeOut(600);
}

function validateFormField(element) {
	var message = "";
	
	switch($(element).attr("name")) {	
		case "category":
		case "company":
		case "comment": // validate a reminder commment
			var commentRegExp = new RegExp("^[\\w '.!?,&]+$");
			
			if(!commentRegExp.test($(element).val())) {
				message = "Cannot include any special characters and cannot be empty.";	
			}
		break;
		
		case "name": // validate person's name
			var nameRegExp = new RegExp("^[A-Za-z .'-]{2,}$");
			
			if(!nameRegExp.test($(element).val())) {
				message = "Please enter a valid name.";
			}
		break;
		
		case "date": // validate all dates input in any form
			var date = $(element).val().split("/");
			var dateRegExp = new RegExp("^[0-9]{2}/[0-9]{2}/[0-9]{4}$");
			
			if(!dateRegExp.test($(element).val())) { // if the wrong format
				message = "Enter in the format dd/mm/yyyy.";
			}
			else { 
				if(date[2] < 1000) {
					$(element).val(date[0] + "/" + date[1] + "/2015");
					date = $(element).val().split("/");
				}
			
				if(date[1] > 12) { // if month is more than twelve
					$(element).val(date[0] + "/12/" + date[2]);
					date = $(element).val().split("/");
				}
				else if(date[1] < 1) {
					$(element).val(date[0] + "/01/" + date[2]);
					date = $(element).val().split("/");	
				}
				
				if(date[0] > 31) { // if day is more than 31
					$(element).val("31/" + date[1] + "/" + date[2]);
				}
				else if(date[0] < 1) {
					$(element).val("01/" + date[1] + "/" + date[2]);	
				}
			}
		break;
		
		// validate all fields that require money to be input
		case "amount":
		case "wage":
		case "oWage":
			var moneyRegExp = new RegExp("^[0-9]+[.]?[0-9]{0,2}$");
		
			if(!moneyRegExp.test($(element).val())) {
				message = "Enter a valid money value.";
			}
			else {
				$(element).val(formatAmount($(element).val()));
			}
		break;
		
		// validate all fields that require hours to be input 
		case "hours":
		case "oHours":
			var hoursRegExp = new RegExp("^[0-9]+[:]?[0-9]{0,2}$");
			
			if(!hoursRegExp.test($(element).val())) { // if the wrong format
				message = "Enter a valid hours valid.";
			}
			else {
				$(element).val(formatHours($(element).val()));	
			}
		break;
		
		case "repeats": // validate number of reminder repeats 
			if($(element).val() < 2 && $(element).val() != -1) {
				$(element).val(2);
			}
		break;
	}
	
	if(message.length != 0) { // if there is an error, return true
		showError($(element), message);
		return true;
	}
	else {
		$(element).animate({"backgroundColor" : "#fff"}, 600);	
		$("#error").fadeOut(600);
		return false;
	}
} // end function validateFormField

function checkFormOnSubmit(form) {
	var error = false;
	var formClasses = $(form).attr("class").split(" ");
	var usedClass = "";
	
	for(var x = 0; x < formClasses.length; x++) {
		usedClass += "." + formClasses[x];
	}
	
	$(usedClass + " input[type=text]").each(function(index, element) {
		return !(error = validateFormField($(element)));
	});
	
	return !error;
} // end function checkFormOnSubmit

function showError(element, message) {	
	var position = $(element).offset();
	var pageX = position.left;
	var pageY = position.top + 1.1 * $(element).height();

	$("#error").html(message);
	
	$(element).animate({"backgroundColor" : "rgba(255, 81, 81, 0.3)"});
	
	$("#error").animate({
		left : pageX,
		top : pageY
	}).fadeIn(600);
} // end function showError