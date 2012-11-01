<?
	if (isset($_POST["vehicle"])) {
		$aDoor = $_POST["vehicle"];
		$N = count($aDoor);
		
		for($i=0; $i < $N; $i++)
		{
			$query2 = "SELECT world_vehicle.vehicle_id, vehicle.class_name, instance_vehicle.* FROM `world_vehicle`, `vehicle`, `instance_vehicle` AS `instance_vehicle` WHERE vehicle.id = world_vehicle.vehicle_id AND instance_vehicle.world_vehicle_id = world_vehicle.id AND id = ".$aDoor[$i].""; 
			$res2 = mysql_query($query2) or die(mysql_error());
			while ($row2=mysql_fetch_array($res2)) {
				$query2 = "INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('DELETE VEHICLE: ".$row2['class_name']." - ".$row2['uid']."','{$_SESSION['login']}',NOW())";
				$sql2 = mysql_query($query2) or die(mysql_error());
				$query2 = "DELETE FROM `objects` WHERE id='".$aDoor[$i]."'";
				$sql2 = mysql_query($query2) or die(mysql_error());
				$delresult = "Vehicle ".$row2['class_name']." - ".$row2['id']." successfully removed!";
			}		
			//echo($aDoor[$i] . " ");
		}
		//echo $_GET["deluser"];
	}
	
	error_reporting (E_ALL ^ E_NOTICE);
	
	$res = mysql_query($query) or die(mysql_error());
	$pnumber = mysql_num_rows($res);			

	if(isset($_GET['page']))
	{
		$pageNum = $_GET['page'];
	}
	$offset = ($pageNum - 1) * $rowsPerPage;
	$maxPage = ceil($pnumber/$rowsPerPage);			

	for($page = 1; $page <= $maxPage; $page++)
	{
	   if ($page == $pageNum)
	   {
		  $nav .= " $page "; // no need to create a link to current page
	   }
	   else
	   {
		  $nav .= "$self&page=$page";
	   }
	}

			
	$query = $query." LIMIT ".$offset.",".$rowsPerPage;
	$res = mysql_query($query) or die(mysql_error());
	$number = mysql_num_rows($res);
	
	$chbox = "";
	
	if (!$serverrunning){ 
		$chbox = "<th class=\"table-header-repeat line-left\"><a href=\"\">Delete</a></th>";
		$formhead = '<form action="index.php?view=table&show=4" method="post">';
		$formfoot = '<input type="submit" class="submit-login"  /></form>';
	}
	
	$tableheader = header_vehicle($show, $chbox);
	
	
	while ($row=mysql_fetch_array($res)) {
		if (!$serverrunning){$chbox = "<td class=\"gear_preview\"><input name=\"vehicle[]\" value=\"".$row['id']."\" type=\"checkbox\"/></td>";}	
		$tablerows .= row_vehicle($row, $chbox, $serverworld);
	}
	include ('paging.php');
?>