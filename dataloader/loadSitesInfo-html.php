<?php
include "../db_operations.php";

//echo loadSitesInfoArray($mysqli);

$tabledata=loadSitesInfoArray($mysqli);// print_r($tabledata); ?>
<table id="SitesTable" cellspacing="0" cellpadding="0" style="max-width:300px;">
	<tr>
		<th>Site</th>
		<th>Location</th>
	</tr>
	<?php if (!empty($tabledata)) { foreach ($tabledata as $row){ ?>
	<tr>
		<td><?php echo $row["dbname"]; ?></td>
		<td><?php echo $row["location"]; ?></td>
	</tr>			
	<?php } }?>																			
</table>