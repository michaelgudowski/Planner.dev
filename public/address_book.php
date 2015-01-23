<?php

$filename = "address_book.csv";
function read($filename)
{
	$handle = fopen($filename, 'r');

	$addressBook = [];

	while (!feof($handle))
	{
		$row = fgetcsv($handle);

		if (!empty($row)) 
		{
			$addressBook[] = $row;
		}
	}
	fclose($handle);
	return $addressBook;
}

function savefile($filename,$addressBook){
	$handle = fopen($filename, 'w');

	foreach ($addressBook as $row) {
	    fputcsv($handle, $row);
	}

	fclose($handle);
}

$addressBook = read($filename);



if(!empty($_POST)) {
	
	// var_dump($_POST);
	
	// foreach ($_POST as $key => $value) {
			
	// }
		// for each loop checking to see if every field has data entered by user
	foreach ($_POST as $key => $value) {
		$_POST[$key] = strip_tags($value);
		$error = false;
		//checking to see if one of the fields are blank
		if (empty($value)){
			$error = true;
		}
	}

	if ($error) {
		$message = "Please enter information in all fields";
	}
	// combining the $post (user entered data) with the existing addressbook data
	 else {
		array_push($addressBook, $_POST);
		//saving both arrays together into the address_book.cvs using a function
		savefile($filename,$addressBook);
	}
}

if (isset($_GET['remove'])){ 
	$id = $_GET['remove'];
	unset($addressBook[$id]);
	savefile($filename,$addressBook);
}


	// $addressBook[] = htmlentities(strip_tags($_POST['todoitem']));
	// savefile('address_book.csv',$addressBook);
    // endif;



?>


<html>
<head>
	
	  <body background = "alice-grafixx-68.png">

	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<title>Address Book</title>
</head>
<body>
	
	<center><h1><u><b>Address Book<b></u></ht></center>

	<table  class="table table-bordered">
		<tr>
			<th>Location</th>
			<th>Address</th>
			<th>City</th>
			<th>State</th>
			<th>Zip</th>
		</tr>
			<!-- for each loop for the address book using rows and columns-->
		
		
			
		
		<? foreach($addressBook as $index=> $entry) : ?>
			<tr>
				<? foreach ($entry as $key => $value): ?>
				<td>
				<?=$value ?> 
				</td>	
			    <? endforeach; ?>
				<td>
					<a href=?remove=<?=$index?>><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
				</td> 
			</tr>
		<? endforeach; ?>
			


	<h2 class="header-underline">Create New Entry</h2>

	<? if (isset($message)): ?>
		<p><?= $message ?></p>
	<? endif ?>

	 <form method="POST" action="address_book.php">
        <p>
            <label for="name"></label>
			<input type="text" id="name" name="name" value="" placeholder="Name">
        </p>

        <p>
            <label for="address"></label>
			<input type="text" id="address" name="address" value="" placeholder="Address">
        </p>

		<p>
            <label for="city"></label>
			<input type="text" id="city" name="city" value="" placeholder="City">
        </p>

        <p>
            <label for="state"></label>
			<input type="text" id="state" name="state" value="" placeholder="State">
        </p>

		<p>
            <label for="zip code"></label>
			<input type="text" id="zip code" name="zipcode" value="" placeholder="Zip Code">
        </p>

		<button type="submit">Submit</button>
	</form>


	</table>	
</body>
</html>