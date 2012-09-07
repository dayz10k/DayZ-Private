<?
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

	$tableheader = header_player(0);
		
	while ($row=mysql_fetch_array($res)) {
		$query2 = "SELECT `name` FROM `profile` WHERE `unique_id`= ".$row['unique_id'];
		$res2 = mysql_query($query2) or die(mysql_error());
		while ($row2=mysql_fetch_array($res2)) {
			if ($dbName=="dayz_lingor"){$tablerows .= row_player($row, $row2, "lingor");} else {$tablerows .= row_player($row, $row2, "chernarus");}
		}
	}
	include ('paging.php');
?>