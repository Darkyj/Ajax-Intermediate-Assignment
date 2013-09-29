<?php 
	require('connection.php');
 ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ajax Example</title>
	<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function()
	{

		$('.datepicker').datepicker();

		$('#test_form').submit(function(){
			var test_form = $(this)
			$.post(
				test_form.attr('action'),
				test_form.serialize(),
				function(data){
					$('#results').html(data);

				},"json"
			);
			return false;
		});

		$('#search_text').keyup(function()
		{
			$('#test_form').submit();
		});

		$(document).on("click",".pagelink",function()
		{

			$('.page').attr('value', $(this).attr('value'));
			$('#test_form').submit();

		});

		$('#test_form').submit();
	});

	</script>
</head>
<body>
	<form action="process.php" method="post" id="test_form">
		<input type="hidden" class="page" name="page1" value="0">
		Name:<input id="search_text" type="text" name="name">
		From: <input class="datepicker" type="text" name="from">
		To: <input class="datepicker" type="text" name="to_date">
		<input type="submit" value="Submit">
	</form>
	<div name="pageination">

	</div>
	<div id="results">
		
	</div>
</body>
</html>