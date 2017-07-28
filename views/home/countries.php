<article class='mb'>
	<div class='header'>
		<span class='title'>Country codes</span>
	</div><div class='text ta-c'>
<?php
	$db = DB::getInstance();
	$query = $db->query("SELECT * FROM `country`");
	echo "<table border='1'>
		<tr><th>Country</th>
		<th>Code</th></tr>";
	foreach($query->results() as $c) {
		echo "<tr>
			<td>$c->name</td>
			<td>$c->code</td>
		</tr>";
	}
	echo "</table>";
?>
</div>
</article>