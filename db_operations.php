<?php
	include "database.php";
	/* Turn autocommit off */
	mysqli_autocommit($mysqli, false);
	
	
	$sql = "CREATE Table "." IF NOT EXISTS "."controllerdb.dbinfo ( `id` INT NOT NULL AUTO_INCREMENT ,  `dbname` VARCHAR(50) NOT NULL ,  `location` INT NOT NULL,`status` INT NOT NULL DEFAULT '1' ,    PRIMARY KEY  (`id`), UNIQUE KEY `unq_dbname` (`dbname`))";
	if ($mysqli->query($sql) === TRUE) {
		
	} else {
		echo "Error creating database: " . $mysqli->error;
		
	}
	$sql = "CREATE Table "." IF NOT EXISTS "."controllerdb.queries ( `id` INT NOT NULL AUTO_INCREMENT ,  `query` TEXT NOT NULL ,  `status` INT NOT NULL DEFAULT '1' ,    PRIMARY KEY  (`id`))";
	if ($mysqli->query($sql) === TRUE) {
		
	} else {
		echo "Error creating database: " . $mysqli->error;
		
	}
	//$mysqli->commit();
	
	/*
	$sql = "CREATE TABLE distance (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		tableName VARCHAR(30) NOT NULL, 
		theNumber VARCHAR(30) NOT NULL, 
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		)";
	mysqli_query($mysqli, $sql);


	$sql = "CREATE TABLE sqlSave (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		sqlData VARCHAR(30) NOT NULL,  
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		)";
	mysqli_query($mysqli, $sql);
	// */


 /*	if(isset($_POST["submitClick"])){
		$siteData = $_POST["siteData"];
		$distanceData = $_POST["distanceData"];
		$queryData = $_POST["queryData"];
		foreach ($siteData as $key => $value) { 
			$sql = "CREATE TABLE $value (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				theData VARCHAR(30) NOT NULL, 
				created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
				)"; 
			if (mysqli_query($mysqli, $sql)) { 
				$tempDistance = $distanceData[$key];
				$insertSql = "INSERT into distance(tableName, theNumber) values('$value', '$tempDistance')";
				mysqli_query($mysqli, $insertSql);
			} else {
				echo "Error creating table: " . mysqli_error($mysqli);
			}
		}

		foreach ($queryData as $key => $value) {
			$insertSql = "INSERT into sqlSave(sqlData) values('$value')";
			mysqli_query($mysqli, $insertSql);
		}
	}
// */

	if(isset($_POST["submitsites"])){
		//echo "<br/><br/><br/><br/><br/><br/><br/>Hurray";
		$sitenames = $_POST["sites"];
		$locations = $_POST["locations"];
		insert_into_dbinfo($sitenames,$locations,$mysqli);
	}
	if(isset($_POST["submitqueries"])){
		$queries = $_POST["queries"];
		insert_into_queriestbl($queries,$mysqli);
	}

	
	function insert_into_dbinfo($sitenames,$locations,$mysqli){
		$sql="insert into controllerdb.dbinfo(dbname,location) VALUES(?,?)";
		try{
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('si', $dbname,$location);
			foreach ($sitenames as $key => $value) {
				createDB($value,$mysqli);
				$dbname=$value;
				$location=$locations[$key];
				$stmt->execute();
			}
			$mysqli->commit();
			$stmt->close();
		} catch (mysqli_sql_exception $exception) {
			$mysqli->rollback();
			throw $exception;
		}
	}
	
	function insert_into_queriestbl($queries,$mysqli){
		$sql="insert into controllerdb.queries(query) VALUES(?)";
		try{
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('s', $query);
			foreach ($queries as $key => $value) {
				$query=$value;
				$stmt->execute();
			}
			$mysqli->commit();
			$stmt->close();
		} catch (mysqli_sql_exception $exception) {
			$mysqli->rollback();
			throw $exception;
		}
	}
	function createDB($dbname,$conn){
		$sql = "CREATE DATABASE "." IF NOT EXISTS ".$dbname;
		if ($conn->query($sql) === TRUE) {
			createTables($dbname,$conn);
			return true;
		} else {
			echo "Error creating table: " . $conn->error;
			return false;
		}
	}
	function createTables($dbname,$conn){
		$sql = "CREATE TABLE ".$dbname.".`data` ( `id` INT NOT NULL AUTO_INCREMENT ,  `data` VARCHAR(50) NOT NULL ,  `score` INT NULL DEFAULT '1' ,    PRIMARY KEY  (`id`),    UNIQUE  `unq_data` (`data`))";
		if ($conn->query($sql) === TRUE) {
			return true;
		} else {
			echo "Error creating table: " . $conn->error;
			return false;
		}		
	}
	function dropDB($dbname,$conn){
		$sql = "DROP DATABASE "." IF EXISTS ".$dbname;
		if ($conn->query($sql) === TRUE) {
			return true;
		} else {
			echo "Error creating database: " . $conn->error;
			return false;
		}
	}
	function autocommit_status($mysqli){
		$result = mysqli_query($mysqli, "SELECT @@autocommit");
		$row = mysqli_fetch_row($result);
		printf("Autocommit is %s\n", $row[0]);
	}
	function hard_reset($mysqli){
		// while all databases in controldb
			//drop each db
			//delete entry in controldb
		$sql = "SELECT id,dbname from controllerdb.dbinfo where status>0";
		$result = $mysqli->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				if(dropDB($row["dbname"],$mysqli))
					delete_controllerdb_entry($row["id"],$mysqli);
			}
			truncate_queries($mysqli);
		} else {
			echo "Nothing to do.";
		}
		$mysqli->commit();
		echo "Databases reset task complete.";
	}
	function delete_controllerdb_entry($id,$mysqli){
		$sql="delete from controllerdb.dbinfo where id=".$id;
		$result=$mysqli->query($sql);
		if ( !$result ) {
			$result->free();
			throw new Exception($mysqli->error);
		}
	}
	function truncate_queries($conn){
		$sql = "TRUNCATE TABLE controllerdb.queries";
		if ($conn->query($sql) === TRUE) {
			return true;
		} else {
			echo "Error creating database: " . $conn->error;
			return false;
		}
	}
	function loadSitesInfo($mysqli){
		$query = "SELECT id,dbname, location FROM controllerdb.dbinfo ORDER by dbname";
		$rows=json_encode(array());
		if ($result = $mysqli->query($query)) {
			$rows_row  =   $mysqli->fetch_all(MYSQLI_ASSOC);
			$rows= json_encode($data);
			/*
			while ($row = $result->fetch_assoc())
				$rows[$row["id"]]=$row;
			/* free result set */
			$result->free();
		}
		return $rows;
	}
	function loadSitesInfoArray($mysqli){
		$query = "SELECT id,dbname, location FROM controllerdb.dbinfo ORDER by dbname";
		$rows=array();
		if ($result = $mysqli->query($query)) {
			while ($row = $result->fetch_assoc())
				$rows[$row["id"]]=$row;
			/* free result set */
			$result->free();
		}
		return $rows;
	}
	function loadQueriesArray($mysqli){
		$query = "SELECT id,query FROM controllerdb.queries ORDER by id";
		$rows=array();
		if ($result = $mysqli->query($query)) {
			while ($row = $result->fetch_assoc())
				$rows[$row["id"]]=$row;
			/* free result set */
			$result->free();
		}
		return $rows;
	}

	function loadSitesDataArray($mysqli,$sitename){
		$query = "SELECT id,data,score FROM $sitename.`data` order by score desc"; //data, score
		$rows=array(); 
		if ($result = $mysqli->query($query)) {
			while ($row = $result->fetch_assoc())
				$rows[$row["id"]]=$row;
			/* free result set */
			$result->free();
		}
		return $rows;
	}
	function nearestSite($location,$mysqli){
		$mindist=1111110; $minsite='';
		$sites=loadSitesInfoArray($mysqli);
		if (!empty($sites)) { 
			$i=0;
			foreach ($sites as $row){
				if($mindist>abs($row["location"]-$location)){
					$mindist=abs($row["location"]-$location);
					$minsite=$row["dbname"];
				}
			}
		}
		return $minsite;
	}
	function insertUserData($udata,$uscore,$mysqli){
		if(isset($_SESSION['user_location'])){
			$sql="insert into ". nearestSite($_SESSION['user_location'],$mysqli).".data(data,score) VALUES(?,?)";
			try{
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('si', $data,$score);
				$data=$udata;
				$score=$uscore;
				$stmt->execute();
				$mysqli->commit();
				$stmt->close();
				return 1;
			} catch (mysqli_sql_exception $exception) {
				$mysqli->rollback();
				throw $exception;
				//return 0;
			}
		}else{
			return 0;
		}
	}
	
	function loadUserQuery($query,$mysqli){
		
		if(isset($_SESSION['user_location'])){
			$mysqli -> select_db(nearestSite($_SESSION['user_location'],$mysqli));
			$rows=array();
			if ($result = $mysqli->query($query)) {
				while ($row = $result->fetch_assoc())
					$rows[]=$row;

				$result->free();
			}
			return $rows;
		}
	}
?>

<?php
	//test
	//autocommit_status($mysqli); echo "<br/>";
	//hard_reset($mysqli);
	//if(createDB("site1",$mysqli)){ 		echo "DB creation success."; 	}  echo "<br/>";
	//if(dropDB("site1",$mysqli)){		echo "DB deleted.";	}  echo "<br/>";
	
?>