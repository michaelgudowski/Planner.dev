<?php

require_once('../inc/AddressDataStore.php');

// Create a new instance of Conversation
$address_object = new AddressDataStore('address_book.csv');
// Set the $name variable

$addressBook = $address_object->read();

if(!empty($_POST)) {
	try {
		$newEntry = [];

		// for each loop checking to see if every field has data entered by user
		foreach ($_POST as $key => $value) {
		
			//checking to see if one of the fields are blank or over 125 characters
			
			if (empty($value)) {
				throw new Exception('All fields must be completed');
			} 
			else if (strlen($value)>=125)
			{
				throw new Exception('Input is too long');
			}

			else {
				$newEntry[$key] = strip_tags($value);
			}
		}

		// combining the $post (user entered data) with the existing addressbook data
		array_push($addressBook, $newEntry);
		//saving both arrays together into the address_book.cvs using a function
		$address_object->write($addressBook);

	} catch (Exception $e) {
		echo $e->getMessage();
	}


}

if (isset($_GET['remove'])){ 
	$id = $_GET['remove'];
	unset($addressBook[$id]);
	$address_object->write($addressBook);
}


/* Begin File Upload Section */

// Verify there were uploaded files and no errors
if (count($_FILES) < 0) {
	try {

		if ($_FILES['file1']['error'] !== UPLOAD_ERR_OK) {
			throw new Exception('Upload file has a error');
		}
	    // Set the destination directory for uploads
	    $uploadDir = '/vagrant/sites/planner.dev/public/uploads/';

	    // Grab the filename from the uploaded file by using basename
	    $filename = basename($_FILES['file1']['name']);

	    // Create the saved filename using the file's original name and our upload directory
	    $savedFilename = $uploadDir . $filename;

	    $uploadedAddressData = new AddressDataStore ($savedFilename); 
	    $uploadedAddressBook =  $uploadedAddressData -> read();
	    $addressBook = array_merge($addressBook, $uploadedAddressBook);
	    $address_object->write($addressBook);
	}
	 	
	catch (Exception $e) {
		echo $e->getMessage();
	}
}

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
	
		<? foreach($addressBook as $index => $entry): ?>
			<tr>
				<? foreach ($entry as $value): ?>
				<td>
				<?= $value ?> 
				</td>	
			    <? endforeach; ?>
				<td>
					<a href="?remove=<?=$index?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
				</td> 
			</tr>
		<? endforeach; ?>
			


	<h2 class="header-underline">Create New Entry</h2>

	<!--Creating the table where user enters in data-->
	 <form method="POST" action="address_book_class.php">
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

	<!--Area where user can upload a file on the page-->
	<h1>Upload a Text/CSV File</h1>

     <!-- Check if we saved a file -->
    <? if (isset($savedFilename)) : ?>
         <!-- If we did, show a link to the uploaded file -->
    <?    echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
    endif;
    ?>

    <form method="POST" enctype="multipart/form-data" action="/address_book_class.php">
        <p>
            <label for="file1">File to upload: </label>
            <input type="file" id="file1" name="file1">
        </p>
        <p>
            <input type="submit" value="Upload">
        </p>
    </form>



	</table>	
</body>
</html>