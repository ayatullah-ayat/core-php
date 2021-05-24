<?php 
include('bootstrap.php');
include('pdo.php');
session_start();

// fetch data and populate in a variable
$query = $pdo->query("SELECT name, email, password, user_id FROM users");

$table_html = '';
$count = 1;
while($q_data = $query->fetch(PDO::FETCH_ASSOC)) {
	$table_html .= '<tr><th scope="row">'.$count.'</th>'.'<td>'.htmlentities($q_data['name'])."</td>".'<td>'.htmlentities($q_data['email']).'</td>'.'<td>'.htmlentities($q_data['password']).'</td>'.'<td><a href="edit.php?user_id='.$q_data['user_id'].'"> Edit / </a>'.'<a href="delete.php?user_id='.$q_data['user_id'].'"> Delete</a>';
	$count++;
}



?>

<div class="container text-center">
	<h2 class="text-center">User history</h2>
	<?php
		if(isset($_SESSION['error'])) {
			echo '<p class="text-warning">'.$_SESSION['error'].'</p>';
			unset($_SESSION['error']);
		}if(isset($_SESSION['success'])) {
			echo '<p class="text-success">'.$_SESSION['success'].'</p>';
			unset($_SESSION['success']);
		}
	?>

	<table class="table table-dark m-auto" style="width: 80%;">
	  <thead>
	    <tr>
	      <th scope="col">No.</th>
	      <th scope="col">Name</th>
	      <th scope="col">Email</th>
	      <th scope="col">Pass</th>
	      <th scope="col">Edit/Delete</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php
	  		echo $table_html;
	  	?>
	  </tbody>
	</table>
	<div class="pt-3">
		<a class="btn btn-secondary text-warning" href="add.php">Add New</a>
	</div>
	
</div>