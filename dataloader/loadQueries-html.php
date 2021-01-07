<?php
include "../db_operations.php";

//echo loadSitesInfoArray($mysqli);

$tabledata=loadQueriesArray($mysqli);// print_r($tabledata); ?>
<table id="QueriesTable" cellspacing="0" cellpadding="0" style="max-width:300px;">
	<tr>
		<th>Sl</th>
		<th>Query</th>
	</tr>
	<?php if (!empty($tabledata)) { $i=0; foreach ($tabledata as $row){ ?>
	<tr>
		<td><?php echo ++$i; ?></td>
		<td><?php echo $row["query"]; ?></td>
	</tr>			
	<?php } }?>																			
</table>