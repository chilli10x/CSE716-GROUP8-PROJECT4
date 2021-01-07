<?php
include "../db_operations.php";

//echo loadSitesInfoArray($mysqli);

$sites=loadSitesInfoArray($mysqli);
if (!empty($sites)) { $i=0; 
	foreach ($sites as $siterow){ 
		$sitename=$siterow["dbname"];
		$tabledata=loadSitesDataArray($mysqli,$sitename); echo $sitename; //print_r($tabledata);
		?>
		<table id="<?php echo $sitename ?>" cellspacing="0" cellpadding="0" style="max-width:300px;">
			<tr>
				<th>Data</th>
				<th>Score</th>
			</tr>
			<?php if (!empty($tabledata)) { $i=0; foreach ($tabledata as $row){ ?>
			<tr>
				<td><?php echo $row["data"]; ?></td>
				<td><?php echo $row["score"]; ?></td>
			</tr>
			<?php } }?>
		</table><br/>
<?php		
	}
}
