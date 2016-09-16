var checkEmail = function(email)	{			
			var syntax = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@hanover.edu$/;						
			var passed = syntax.test(email);			
			return passed;
		}

var studentEmail = function(email) {
			return !isNaN(email.split('@')[0].slice(-2));
			// true if student email (ending in 2 numbers)
			// false otherwise
		}

var checkRequired = function() {
			var checking = true;
			$('input:required').each(function() { // check each required field
				if($(this).val() === "") { 
					$(this).parent().addClass('has-error').removeClass('has-succes');
					checking = false;
				} else {
					$(this).parent().addClass('has-success').removeClass('has-error');
				}				
			});
			return checking;
		}

function getInputNames() {
	return $("input").map(function(){return $(this).attr("name");}).get();
	// returns an array of the names of all input elements in a page
}

function getInputValues() {
	return $('input').filter(function() { return $(this).val() != ""; }).serializeJSON();
	// requires loading the jquery.serializejson.min.js file
	// cuts out all empty input fields
	// returns an object ready for import into MongoDB
}

function getEmailValues() {
	// requires all email fields to have class '.email'
	var els = $('.email').filter(function() { return $(this).val() != ""; }); // non-empty email input elements
	return els.map(function(){return $(this).val();}).get();
	// requires loading the jquery.serializejson.min.js file
	// cuts out all empty input fields
	// returns an object ready for import into MongoDB
}

function getUrlParameter(sParam) {
		    var sPageURL = window.location.search.substring(1);
		    var sURLVariables = sPageURL.split('&');
		    for (var i = 0; i < sURLVariables.length; i++) {
		        var sParameterName = sURLVariables[i].split('=');
		        if (sParameterName[0] == sParam) {
		            return sParameterName[1];
		        }
		    }
	  }
