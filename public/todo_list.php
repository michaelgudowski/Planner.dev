<?php	
require_once('../inc/ToDoDataStore.php');


$listObject = new ToDoDataStore('data/list.txt');
$listObject->todoarray = $listObject->read();
//Checking to see if the file exist. If not, create a blank file
 if (!(file_exists($listObject->filename))){
 	touch ($listObject->filename);
 }


if(!empty($_POST)) {
	try{

		if(isset($_POST['todoitem'])) {
			$listObject->todoarray[] = htmlentities(strip_tags($_POST['todoitem']));
			$listObject->write($listObject->todoarray);
		 }
	}	catch (Exception $e) {
		echo $e->getMessage();
	}

 }
 if (isset($_GET['remove']))
 { 
 	$id = $_GET['remove'];
 	unset($listObject->todoarray[$id]);
 	$listObject->write($listObject->todoarray);
 }

/* Begin File Upload Section */

// Verify there were uploaded files and no errors
if (count($_FILES) > 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {

    // Set the destination directory for uploads
    $uploadDir = '/vagrant/sites/planner.dev/public/uploads/';

    // Grab the filename from the uploaded file by using basename
    $filename = basename($_FILES['file1']['name']);

    // Create the saved filename using the file's original name and our upload directory
    $savedFilename = $uploadDir . $filename;

 	// Checks to see if the file type is txt by checking the last 3 letters in the file name
    if(substr($filename, -3) == 'txt'){

    	// Move the file from the temp location to our uploads directory
    	move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);
  
		// Opening the uploaded file
		if ((isset($savedFilename)) && (filesize($savedFilename) > 0)){
	 		$handle = fopen($savedFilename, 'r');
	 		$contents = trim(fread($handle, filesize($savedFilename)));
	 		$uploadedFile = explode("\n", $contents);
	 		fclose($handle);
		}
		// Merge the old array with the uploaded into the old array
		$listObject->todoarray = array_merge($listObject->todoarray,$uploadedFile);
		$ToDoDataStore->write($listObject->todoarray);
	}
	else{
		echo "The file is not a text file";
	}
	
}
 

?>


<!DOCTYLE html>
<html>
<head>
	<title>To Do list</title>
	
	<!--Link To CSS Stylesheet-->
	<link href="CSS/todostylesheet.css" rel='stylesheet'>
</head>

<body>

	<center><h1 class="header-underline">Todo List</h1></center>



	<!--Asking user to enter in to do items-->
<?php
	if(!empty($_POST)) {
		try{
			foreach($listObject->todoarray as $key=> $value) {
				if (empty($value)) {
					throw new Exception('All fields must be completed');
				} 
				else if (strlen($value)>=240){
					throw new Exception('Input is too long');
				
				}	
	
				echo "<li class='stitched'>{$value} | <a href=\"/todo_list.php?remove=$key\">X</a></li>";
				    
			}
		}catch (Exception $e) {
			echo $e->getMessage();
	  	}
	}
?>
	<h1 class="header-underline">Enter items that need to be done</h1>

	   <form method="POST" action="/todo_list.php">
        <p>
            <label for="todoitem"></label>
			<input type="text" id="todoitem" name="todoitem" value="" placeholder="Items to be done">
        </p>


		<button type="submit">Submit</button>
		</form>
 
<h1 class="header-underline">Upload a Text File</h1>

     <!-- Check if we saved a file -->
    <? if (isset($savedFilename)) : ?>
         <!-- If we did, show a link to the uploaded file -->
    <?    echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
    endif;
    ?>

    <form method="POST" enctype="multipart/form-data" action="/todo_list.php">
        <p>
            <label for="file1">File to upload: </label>
            <input type="file" id="file1" name="file1">
        </p>
        <p>
            <input type="submit" value="Upload">
        </p>
    </form>
 </body>                                  

</html>