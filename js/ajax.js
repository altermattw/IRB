function getAccount(email) {
	$.ajax({
			type: "POST",
			url: "../php/ajax.php",
			data: {getRecord: "true", key: "email", value: email, collection: "IRBacc"},				
			dataType: "json"
			})	
		.done(function( data ) { 			
			fillHTML(data); 			
		});
			
		// .done(function( data ) {
		// 		$.each(data, function(key,value) {
		// 			$("#display").append('<p>'+key+': '+value+'</p>');
		// 		});
		// 	});				
}

function getUserApps(email) {
		$.ajax({
			type: "POST",
			url: "../php/ajax.php",
			data: {getRecord: "true", key: "email", value: email, collection: "IRBacc"},				
			dataType: "json"
			})	
		.done(function( data ) { 			
			fillHTML(data); 			
		});
}

function listAccount(data) {
	// just for testing
	$.each(data, function(key,value) {
		$("#display").append('<p>'+key+': '+value+'</p>');
	});
}

// function updateLastLogin(data) {
// 	var loginDate = new Date(data["lastLogin"]*1000).toDateString();
// 	// console.log(loginDate);
// 	$("#lastLogin").html('Last login: '+loginDate);
// }

function fillHTML(data) {		
	$.each(data, function(key,value) {
		$("#"+key).html(value); // useful for table cells that need to be filled with .html(value)
	});
}

function fillVal(data) {
	$.each(data, function(key,value) {
		$("#"+key).val(value);  // useful for inputs that are filled with .val(value)
	});	
}

function updateAccountInfo(email,new_object) {	
	// TODO:  get rid of 'upsert' - only want to modify existing, not create new
	// TODO:  check for '$set' at beginning and insert it if missing
	console.log("begin updateAccountInfo");
	$.ajax({
			type: "POST",
			url: "../php/ajax.php",
			data: {updateDoc: "true", indexName: "email", indexValue: email, new_object: new_object, collection: "IRBacc"}			
			})
		.done(function(response) {
			console.log(response);
		});
}

function findNfill(_id,format) {

	$.ajax({
			type: "POST",
			url: "../php/ajax.php",
			data: {getRecord: "true", key: "_id", value: _id, collection: 'IRBapps'}, // first getting the year
			dataType: "json"
			})	
		.done(function( data ) { // data should be IRB + a four-digit year				
				fillApp(_id,data["year"],format); 
			});
}

function fillApp(_id,year,format) {
	console.log("fillApp started");
	$.ajax({
			type: "POST",
			url: "../php/ajax.php",
			data: {getRecord: "true", key: "_id", value: _id, collection: year}, // collection is 'IRB' + a 4-digit year, e.g., IRB2014
			dataType: "json"
			})	
		.done(function( data ) { 			
			if(format==="html") { 
				fillHTML(data); 
			} else {
				if(format==="val") {
					fillVal(data);
				}
			}
		});
}

function updateApp(_id,new_object,year) {
	console.log("updating that app!");
	$.ajax({
			type: "POST",
			url: "../php/ajax.php",			
			data: { updateDoc: "true", indexName: "_id", indexValue: _id, new_object: new_object, collection: 'IRB'+year }
			})
		.always(function () {
      $('.loading').button('reset');
    });
}

function registerApp(_id,year,title,emails) {
	
	// emails is an array, to be serialized before posting
	
	emailString = JSON.stringify(emails);
	
	$.ajax({
			type: "POST",
			url: "../php/ajax.php",
			data: {registerApp: "true", _id: _id, year: year, title: title , emails: emailString }
			})
		.always(function () {
      $('.loading').button('reset');
    });
}


function getSessionRecord() {
	$.ajax({
			type: "POST",
			url: "../php/ajax.php",			
			data: {getSessionRecord: "true"}
			})
		.done(function( data ) { tableAccount(data) });		
}

function putSessionRecord(new_object) {
	$.ajax({
			type: "POST",
			url: "../php/ajax.php",			
			data: {putSessionRecord: "true",new_object: new_object}
			});		
}


// function recordExists(index,value,collection) {
// 	var query = { valueExists: true, key: index, value: value, collection: collection };
// 	$.post("../php/ajax.php", query)
// 			.done(function( data ) {
// 				// if(data===1) { var val="yes"; } else { var val="no"; }
// 				// $.each(data, function( key, value ) {
// 				// 	$("#display").append(value);
// 				// });
// 				$("#display").append( 'email '+email+': '+ data );
				
// 			})
// 			.fail(function(xhr, textStatus, errorThrown) {
// 				alert(xhr.responseText);
// 			});
// }
		
// 		