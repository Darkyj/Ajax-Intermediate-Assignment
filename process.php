<?php 
require('connection.php');

	if(empty($_POST['from']))
	{
		 $_POST['from_date'] = "01/01/1900" ;
	}
	if(empty($_POST['to_date']))
	{
		 $_POST['to_date'] = "01/01/2200" ;
	}
	if(empty($_POST['name']))
	{
		$_POST['name'] = '';
	}	

	$number_of_rows = 25;
	
	//This grabs all the data from the lead DB
	$query = "SELECT * FROM leads WHERE (first_name LIKE '{$_POST['name']}%' OR last_name LIKE '{$_POST['name']}%') 
	AND (registered_datetime >= STR_TO_DATE('{$_POST['from']}','%m/%d/%Y') 
	AND registered_datetime <= STR_TO_DATE('{$_POST['to_date']}','%m/%d/%Y'))";

	//Runs the query
	$users = fetch_all($query);
	//This counts the array of users
	$counting = count($users);
	//This divides the number of users by 25 and rounds up to the nearest number
	$numberofpages = floor($counting/$number_of_rows);
	//This checks to see if the form hidden value is set.
	if(isset($_POST['page1'])) 
	{
		$query2 = $query .= " LIMIT {$_POST['page1']},{$number_of_rows}";
		$rows = fetch_all($query2);
	}
	//This loops through the number of users in order to create the requires number of 
	//Hyper links needed. As well as limits each link to 25 results.	
	$html = "";
	for ($i=1; $i <= $numberofpages; $i++) 
	{ 
	//what's an easy way to fix this issue? Currently there are 14 pages correctly, but the last one is blank. And page 1 is only showing 25 results
	$j= $i*$number_of_rows;
	$html .= "
		<a href='#' value='{$j}' class='pagelink'>{$i}</a>/
		";
	}
	
	//Sets table
	$html .= "
		<table>
			<thead>
				<tr>
					<th>leads_id</th>
					<th>first_name</th>
					<th>last_name</th>
					<th>registered_datetime</th>
					<th>email</th>
				</tr>
			</thead>
			<tbody>
		";
	//If the hidden value in the form is set, then loop through the array of users and create
	//table data
	if(isset($_POST['page1'])) 
	{
		foreach ($rows as $user) 
		{
			$html .= "
				<tr>
					<td>{$user['leads_id']}</td>
					<td>{$user['first_name']}</td>
					<td>{$user['last_name']}</td>
					<td>{$user['registered_datetime']}</td>
					<td>{$user['email']}</td>
				</tr>
			";
		}
	}
	else
	{
		// echo "Oh Oh, something went wrong. Might not be looping through the array of users correctly.";
		// var_dump($_POST);
		// var_dump($users);
	}
	

	$html .= "
		</tbody>
	</table>
	";

	echo json_encode($html);

 ?>