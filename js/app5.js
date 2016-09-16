console.log("app5.js has been accessed");

function checkClassification() { 
	// is at least one classification set for the proposal?
	var oneChecked = false;
	$('input[name="Classification"]').each() {
		var value = $(this).val(); 
		if (value == "Exempt" || value == "Expedited" || value == "Full Review") {
			oneChecked = true;
		} 
	});
	if(oneChecked) {
		$('#IRBapproval').prop("disabled",false);
	} else {
		$('#IRBapproval').prop("disabled",true);
	}
}

$('input[name="Classification"]').change(function() {
	checkClassification();
});