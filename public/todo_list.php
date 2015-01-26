<?php	
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'todo_db');
define('DB_USER', 'codeup');
define('DB_PASS', '');
// insert password


require('../db_connect.php');

function gettodo($dbc) {
    // Bring the $dbc variable into scope 
    return $dbc->query('SELECT * FROM todolist')->fetchAll(PDO::FETCH_ASSOC);
}// add limit
// adding the todo data field into the database
if (!empty($_POST["todo"])) {
	$query = "INSERT INTO todolist (things_to_do) VALUES (:todo)";
    $stmt = $dbc->prepare($query);
	$stmt->bindValue(':todo', $_POST['todo'], PDO::PARAM_STR);
	$stmt->execute();	
}


$offset = 0;
$todo = gettodo($dbc);
 
?>


<!DOCTYLE html>
<html>
<head>
	<title>To Do list</title>
	
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</head>

	<body>

		<table class ="table table-hover">	
		<h1 class="header-underline">Todo List</h1>

		<th>To Do Item</th>


		<? foreach($todo as $key => $value): ?>
				<tr>
					<td>
						<?= $value['things_to_do'] ?>
					</td>	
			 	
				</tr>
		<? endforeach; ?>
		</table>
			<h1 class="header-underline">Enter items that need to be done</h1>

			<form method="POST" action="todo_list.php">

	       	<p>
	            	<label for="todo"></label>
					<input type="text" id="todo" name="todo" value="" placeholder="List Item">
	        	</p>
				<button type="submit">Submit</button>
				</form>

<nav>
  <ul class="pager">
    <li><a href="#">Previous</a></li>
    <li><a href="#">Next</a></li>
  </ul>
</nav>
	 
 	</body>                                  
</html>