<?php
	require('../ajax.php');
	$_SESSION['valid'] = 1;
	require('../navbar.php');
?>
	<html>
		<head>
			<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		</head>
		<body>
			<p>Testing ajax getAppRecord function</p>
			<form>
				<?php include('../../app1.php'); ?> // page 1 of application
			</form>
			<div id="here"></div>
		</body>
	</html>
	<script>
	$(document).ready(function() {       
		$.post("../ajax.php",
			{ "getAppRecord" : "true", "studyNumber":"2015004"},
			function(data) {
				$.each(data, function(key, val) {
					var el = $('[name="'+key+'"]'),
				     type = el.attr('type');
				   if(el.length > 0) {
				      switch(type){
				        case 'checkbox':
				            el.attr('checked', 'checked');
				            break;
				        case 'radio':
				            el.filter('[value="'+val+'"]').attr('checked', 'checked');
				            break;
				        default:
				            el.val(val);
				      }
					}
				});
			},
			"json"
		);
	});
	</script>
