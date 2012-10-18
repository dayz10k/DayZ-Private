<? 
function world_pos($Worldspace, $world){
	$x = 0;
	$y = 0;
	if(array_key_exists(2,$Worldspace)){$x = $Worldspace[2];}
	if(array_key_exists(1,$Worldspace)){$y = $Worldspace[1];}
	
	if($world=="lingor") {
		return sprintf("%03d",round($y/100)).sprintf("%03d",round($x/100));
	} else if($world=="chernarus") {
		return sprintf("%03d",round($y/100)).sprintf("%03d",round((154-($x/100))));
	} else if($world=="utes") {
		return sprintf("%03d",round($y/100)).sprintf("%03d",round($x/100));
	} else if($world=="panthera2") {
		return sprintf("%03d",round($y/100)).sprintf("%03d",round($x/100));
	}
}

function world_pos_x($Worldspace, $world){
	$x = 0;
	$y = 0;
	if(array_key_exists(2,$Worldspace)){$x = $Worldspace[2];}
	if(array_key_exists(1,$Worldspace)){$y = $Worldspace[1];}
	
	if($world=="lingor") {
		return $x+1024;
	} else if($world=="chernarus") {
		return $x+1024;
	} else if($world=="utes") {
		return $x+1024;
	} else if($world=="panthera2") {
		return $x+1024;
	}
}

function world_pos_y($Worldspace, $world){
	$x = 0;
	$y = 0;
	if(array_key_exists(2,$Worldspace)){$x = $Worldspace[2];}
	if(array_key_exists(1,$Worldspace)){$y = $Worldspace[1];}
	
	if($world=="lingor") {
		return $y;
	} else if($world=="chernarus") {
		return $y;
	} else if($world=="utes") {
		return $y;
	} else if($world=="panthera2") {
		return $y;
	}
}

function world_pos_x_crash($Worldspace, $world){
	$x = 0;
	$y = 0;
	if(array_key_exists(1,$Worldspace)){$x = $Worldspace[1];}
	if(array_key_exists(0,$Worldspace)){$y = $Worldspace[0];}
	
	if($world=="lingor") {
		return $x+1024;
	} else if($world=="chernarus") {
		return $x+1024;
	} else if($world=="utes") {
		return $x+1024;
	} else if($world=="panthera2") {
		return $x+1024;
	}
}

function world_pos_y_crash($Worldspace, $world){
	$x = 0;
	$y = 0;
	if(array_key_exists(1,$Worldspace)){$x = $Worldspace[1];}
	if(array_key_exists(0,$Worldspace)){$y = $Worldspace[0];}
	
	if($world=="lingor") {
		return $y;
	} else if($world=="chernarus") {
		return $y;
	} else if($world=="utes") {
		return $y;
	} else if($world=="panthera2") {
		return $y;
	}
}

function world_pos_x_gps($Worldspace, $world){
	$x = 0;
	$y = 0;
	if(array_key_exists(2,$Worldspace)){$x = $Worldspace[2];}
	if(array_key_exists(1,$Worldspace)){$y = $Worldspace[1];}
	
	if($world=="lingor") {
		return sprintf("%03d",round($x/100));
	} else if($world=="chernarus") {
		return sprintf("%03d",round((154-($x/100))));
	} else if($world=="utes") {
		return sprintf("%03d",round($x/100));
	} else if($world=="panthera2") {
		return sprintf("%03d",round($x/100));
	}
}

function world_pos_y_gps($Worldspace, $world){
	$x = 0;
	$y = 0;
	if(array_key_exists(2,$Worldspace)){$x = $Worldspace[2];}
	if(array_key_exists(1,$Worldspace)){$y = $Worldspace[1];}
	
	if($world=="lingor") {
		return sprintf("%03d",round($y/100));
	} else if($world=="chernarus") {
		return sprintf("%03d",round($y/100));
	} else if($world=="utes") {
		return sprintf("%03d",round($y/100));
	} else if($world=="panthera2") {
		return sprintf("%03d",round($y/100));
	}
}

function world_pos2($Worldspace, $world){
	$x = 0;
	$y = 0;
	if(array_key_exists(2,$Worldspace)){$x = $Worldspace[2];}
	if(array_key_exists(1,$Worldspace)){$y = $Worldspace[1];}
	
	if($world=="lingor") {
		return "left:".round($y/100)." top:".round((15360-$x)/100);
	} else if($world=="chernarus") {
		return "left:".round($y/100)." top:".round(154-($x/100));
	} else if($world=="utes") {
		return "left:".round($y/100)." top:".round(154-($x/100));
	} else if($world=="panthera2") {
		return "left:".round($y/100)." top:".round(154-($x/100));
	}
}

function world_pos2_crash($Worldspace, $world){
	$x = 0;
	$y = 0;
	if(array_key_exists(2,$Worldspace)){$x = $Worldspace[2];}
	if(array_key_exists(1,$Worldspace)){$y = $Worldspace[1];}
	
	if($world=="lingor") {
		return "left:".round($y/100)." top:".round((15360-$x)/100);
	} else if($world=="chernarus") {
		return "left:".round($y/100)." top:".round(154-($x/100));
	} else if($world=="utes") {
		return "left:".round($y/100)." top:".round(154-($x/100));
	} else if($world=="panthera2") {
		return "left:".round($y/100)." top:".round(154-($x/100));
	}
}
?>