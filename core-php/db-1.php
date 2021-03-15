<?php
require_once "pdo.php";

// sql query to fetch data
$stmt = $pdo->query("SELECT * FROM Users");


// raw data
$html = NULL;
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$html .= <<<HTML
		<table border = "1">
			<tr>
				<td>$row[user_id]</td>
				<td>$row[name]</td>
				<td>$row[email]</td>
				<td>$row[password]</td>
				<td>
					<form method="post">
						<input type="hidden" name="user_id" value="$row[user_id]">
						<input type="submit" name="delete" value="Del">
					</form>
				</td>
			</tr>
		</table>
	HTML;
}
echo $html;

?>