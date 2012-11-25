<?
	error_reporting (E_ALL ^ E_NOTICE);

	if (isset($_POST["deployable"])) {
		$aDoor = $_POST["deployable"];
		$N = count($aDoor);
		
		for ($i = 0; $i < $N; $i++)
		{
			mysql_query("INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('DELETE VEHICLE: ".$aDoor[$i]."', '{$_SESSION['login']}', NOW())");
			mysql_query("DELETE FROM `instance_deployable` WHERE unique_id = '".$aDoor[$i]."'") or die(mysql_error());
			$delresult = "Deployable ".$aDoor[$i]." successfully removed!";
			//echo($aDoor[$i]);
		}
	}
	
	$serverexestatus = exec('tasklist /FI "IMAGENAME eq '.$exeserver.'" /FO CSV');
	$serverexestatus = explode(",", strtolower($serverexestatus));
	$serverexestatus = $serverexestatus[0];
	$serverexestatus = str_replace('"', "", $serverexestatus);
	if ($serverexestatus == strtolower($exeserver)) {$serverrunning = true;} else {$serverrunning = false;}
	
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
		  $nav .= " $page ";
	   }
	   else
	   {
		  $nav .= "$self&page=$page";
	   }
	}
	
	$query = $query." LIMIT ".$offset.",".$rowsPerPage.";";
	$res = mysql_query($query) or die(mysql_error());
	$number = mysql_num_rows($res);
	
	$chbox = "";
	
	if (!$serverrunning){ 
		$chbox = "<th class=\"table-header-repeat line-left\"><a href=\"\">Delete</a></th>";
		$formhead = '<form action="index.php?view=table&show=5" method="post">';
		$formfoot = '<input type="submit" class="submit-login"  /></form>';
	}
	
	$tableheader = header_deployable($show, $chbox, $order);
	
	while ($row = mysql_fetch_array($res)) {
		if (!$serverrunning) {$chbox = "<td align=\"center\" class=\"gear_preview\" style=\"vertical-align:middle;\"><input name=\"deployable[]\" value=\"".$row['unique_id']."\" type=\"checkbox\"/></td>";}	
		$tablerows .= row_deployable($row, $chbox, $serverworld);
	}
	
	include ('paging.php');
?>