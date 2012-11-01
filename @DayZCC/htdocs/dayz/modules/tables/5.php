<?
	if (isset($_POST["deployable"])) {
		$aDoor = $_POST["deployable"];
		$N = count($aDoor);
		
		for($i=0; $i < $N; $i++)
		{
			$query2 = "SELECT deployable.class_name, instance_deployable.* FROM `deployable`, `instance_deployable` AS `instance_deployable` WHERE deployable.id = instance_deployable.deployable_id AND instance_deployable.unique_id = ".$aDoor[$i].""; 
			$res2 = mysql_query($query2) or die(mysql_error());
			while ($row2=mysql_fetch_array($res2)) {
				$query2 = "INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('DELETE VEHICLE: ".$row2['class_name']." - ".$row2['unique_id']."','{$_SESSION['login']}',NOW())";
				$sql2 = mysql_query($query2) or die(mysql_error());
				$query2 = "DELETE FROM `instance_deployable` WHERE unique_id ='".$aDoor[$i]."'";
				$sql2 = mysql_query($query2) or die(mysql_error());
				$delresult = "Deployable ".$row2['class_name']." - ".$row2['unique_id']." successfully removed!";
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
		$formhead = '<form action="index.php?view=table&show=5" method="post">';
		$formfoot = '<input type="submit" class="submit-login"  /></form>';
	}
	
	$tableheader = header_deployable($show, $chbox);
	
	while ($row=mysql_fetch_array($res)) {
		if (!$serverrunning){$chbox = "<td class=\"gear_preview\"><input name=\"deployable[]\" value=\"".$row['unique_id']."\" type=\"checkbox\"/></td>";}	
		$tablerows .= row_deployable($row, $chbox, $serverworld);
	}
	include ('paging.php');
?>