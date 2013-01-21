<?php
/* This script was written by ChemicalBliss. */

define("ROOT_DIR", dirname(__FILE__)."/");

Class Object_Management {
	
	// Bitwise Flag Options
#	public static $bitflags = array(
#		"generate_vehicles"		=>	0x01,
#		"clean_bounds"			=>	0x02,
#		"clean_old"				=>	0x04
#	);
	
	private $maxVec = 0;		// Maximum Vehicle Count
	#private $flags = 0x01;		// Current Flags Set
	
	private $generateFlag=false;	// Flag to generate the vehicles
	private $boundaryFlag=false;	// Flag to remove objects out of bounds
	private $cleanUnusedFlag=false;	// Flag to remove objects not used for x days.
	
	private $mysqli=NULL;		// MySQL Link Ref
	private $currentWorld=NULL;	// Current World Name
	private $executed=FALSE;
	private $worldid=0;
	
	// Construct
	public function __construct($mysqli){
		
		if($mysqli->connect_errno){
			echo("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
			return FALSE;
		}
		$this->mysqli = $mysqli;
	}
	
	public function setMaxVehicles($int){
		if(!is_int($int)){ return FALSE; }
		$this->maxVec = $int;
		return $this;
	}
	
	public function setWorld($str){
		if(!is_string($str)){ return FALSE; }
		if($str !== "chernarus"){
			return FALSE;
		}
		$this->currentWorld = $str;
		return $this;
	}
	
	public function setDBName($str){
		if(!is_string($str)){ return FALSE; }
		$this->dbnamed = $str;
		return $this;
	}
	
	public function getDatabaseName(){
		return $this->dbnamed;
	}
	
	public function getWorldID(){
		return $this->worldid;
	}
	
	public function setWorldID($int){
		if(!is_int($int)){ return FALSE; }
		$this->worldid = $int;
		return $this;
	}
	
	public function setGenerateVehicles($bool){
		if(!is_bool($bool)){ return FALSE; }
		$this->generateFlag = $bool;
		return $this;
	}
	
	public function setCleanBoundary($bool){
		if(!is_bool($bool)){ return FALSE; }
		$this->boundaryFlag = $bool;
		return $this;
	}
	
	public function setCleanUnused($bool){
		if(!is_bool($bool)){ return FALSE; }
		$this->cleanUnusedFlag = $bool;
		return $this;
	}
	
	// Public Set Flags
	public function setFlags($flags){
		
		// should check flag bits here...
		$this->flags = $flags;
		
	}
	
	// Gets a lot of parsed information regarding Vehicles and Vehicle Spawn Points.
	private function getVehicleData(){
		$query = "
			SELECT
				`vehicle_spawns`.`id` as `world_vehicle_id`,
				`vehicle_spawns`.`vehicle_id`,
				`vehicle_spawns`.`world_id`,
				`vehicle_spawns`.`worldspace` as `spawn_worldspace`,
				`vehicle_spawns`.`description`,
				`vehicle_spawns`.`chance`,
				`vehicle_spawns`.`last_modified`,
				`vehicle_list`.`class_name`,
				`vehicle_list`.`damage_min`,
				`vehicle_list`.`damage_max`,
				`vehicle_list`.`fuel_min`,
				`vehicle_list`.`fuel_max`,
				`vehicle_list`.`limit_min`,
				`vehicle_list`.`limit_max`,
				`vehicle_list`.`parts` as `spawn_parts`,
				`vehicle_list`.`inventory` as `spawn_inventory`,
				`vehicles_ingame`.`id` as vehicle_live_id,
				`vehicles_ingame`.`instance_id`,
				`vehicles_ingame`.`worldspace`,
				`vehicles_ingame`.`inventory`,
				`vehicles_ingame`.`parts`,
				`vehicles_ingame`.`fuel`,
				`vehicles_ingame`.`damage`,
				`vehicles_ingame`.`last_updated`,
				`vehicles_ingame`.`created`
			FROM `".$this->getDatabaseName()."`.`world_vehicle` as `vehicle_spawns`
			LEFT JOIN `".$this->getDatabaseName()."`.`instance_vehicle` as `vehicles_ingame`
				ON `vehicles_ingame`.`world_vehicle_id`=`vehicle_spawns`.`id` AND `vehicles_ingame`.`instance_id`=1
			LEFT JOIN `".$this->getDatabaseName()."`.`vehicle` as `vehicle_list`
				ON `vehicle_spawns`.`vehicle_id`=`vehicle_list`.`id`
			WHERE `vehicle_spawns`.`world_id`='".$this->getWorldID()."'
		";
		
		$res = $this->mysqli->query($query);
		if(!$res){
			echo "Error: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		$res->data_seek(0);
		
		// Very Handy Counts
		$vehicle_counts = array(
			"total" => 0,
			"ingame_total" => 0,
			"ingame_healthy" => 0,
			"ingame_broken" => 0,
			"unused_spawns" => 0,
			"duped_spawns" => 0,
			"ingame_offmap" => 0,
			"not_used_old" => 0,
			"spawn_spots" => 0
		);
		
		// Temp Variables
		$lastid = NULL;
		$spawn_spots = array();
		$duped_spawn_spots = array();
		$damaged = array();
		$healthy = array();
		$unused_spawns = array();
		$spawns_with_broken_vec = array();
		$spawns_with_healthy_vec = array();
		$spawn_type_list = array();
		$part_list = array();
		$gear_list = array();
		$v_counts = array();
		
		/*
			# Most of the calculation to determine which spawn spots and which vehicles to spawn is done in PHP rather than the Query.
		*/
		// Loop each vehicle/Spawn
		while ($row = $res->fetch_assoc()) {
			$spawnlist[$row['world_vehicle_id']] = $row;
			$vehicle_counts['total']++;
			
            // Get Maximums
            if(!isset($v_max[$row['class_name']])){
                $v_max[$row['class_name']] = $row['limit_max'];
            }
			
			// add parts to part list
			if(!isset($part_list[$row['class_name']])){
				$part_list[$row['class_name']] = explode(",",$row['spawn_parts']);
			}
			// gear
			if(!isset($gear_list[$row['class_name']])){
				$gear_list[$row['class_name']] = $row['spawn_inventory'];
			}
			
			// Count Unique Spawn Spots/Locations
			if(!in_array($row['world_vehicle_id'], $spawn_spots)){
				$vehicle_counts['spawn_spots']++;
				$spawn_spots[] = $row['world_vehicle_id'];
				$spawn_type_list[$row['world_vehicle_id']] = $row['class_name'];
			}else{
				if(!in_array($row['world_vehicle_id'], $duped_spawn_spots)){
					$duped_spawn_spots[] = $row['world_vehicle_id'];
				}
				$vehicle_counts['duped_spawns']++;
			}
			
			// check if item is vehicle (ingame, not just a spawn point)
			if($row['worldspace'] !== NULL){
				$vehicle_counts['ingame_total']++;	// count ingame
				if($row['damage'] >= 0.95){
					$vehicle_counts['ingame_broken']++;
					$damaged[] = $row['vehicle_live_id'];
					$spawns_with_broken_vec[] = $row['world_vehicle_id'];
				}else{
					if(!isset($v_counts[$row['class_name']])){
						$v_counts[$row['class_name']] = 1;
					}else{
						$v_counts[$row['class_name']]++;
					}
					$vehicle_counts['ingame_healthy']++;
					$healthy[] = $row['vehicle_live_id'];
					$spawns_with_healthy_vec[] = $row['world_vehicle_id'];
				}
			}else{
				$unused_spawns[] = $row['world_vehicle_id'];
				$vehicle_counts['unused_spawns']++;	// count unused spawn
			}
			
			// DEBUG (Show Spawn Dupes)
		#	if($row['world_vehicle_id'] == $lastid){
		#		echo("ID: ".$row['world_vehicle_id']."<----<br/>\n");
		#	}else{
		#		echo("ID: ".$row['world_vehicle_id']."<br/>\n");
		#	}
			
			$lastid = $row['world_vehicle_id'];
		}
		
		// Get list of spawn spots we can spawn stuff at.
		$available_spawns = array();
		
		foreach($spawns_with_broken_vec as $brokenSpawn){
			if(!in_array($brokenSpawn, $spawns_with_healthy_vec)){
				$available_spawns[] = $brokenSpawn;
			}
		}
		$available_spawns = array_merge($available_spawns, $unused_spawns);
		
		// Create return array
		$VehicleData = array(
			"vehicle_counts" => $vehicle_counts,
			"duped_spawn_ids" => $duped_spawn_spots,
			"spawn_ids" => $spawn_spots,
			"unused_ids" => $unused_spawns,
			"damaged_vec_ids" => $damaged,
			"healthy_vec_ids" => $healthy,
			"spawns_healthy" => $spawns_with_healthy_vec,
			"spawns_broken" => $spawns_with_broken_vec,
			"available_spawns" => $available_spawns,
			"spawnspot_typelist" => $spawn_type_list,
			"part_list" => $part_list,
			"v_counts" => $v_counts,
			"spawnlist" => $spawnlist,
			"v_max" => $v_max
		);
		
		return $VehicleData;
	}
	
	private function pickRandomSpawns($vData, $toSpawnCount){
		
		// Check we have the vData array
		if(
			!isset($vData['available_spawns']) || 
			!isset($vData['v_counts']) ||
			!isset($vData['v_max']) ||
			!isset($vData['spawnspot_typelist'])
		){
			return FALSE;
		}
		
		$spotList = array_values($vData['available_spawns']);
		$newSpotList = array();
		
		$echoReachedMax = array();
		
		while(count($newSpotList) < $toSpawnCount){
			$keys = array_flip($spotList);
			$spot = $spotList[rand(0,count($spotList)-1)];
			
			// check this spot is ok to choose (if not, remove from spotlist).
			$vehicle = $vData['spawnspot_typelist'][$spot];
			
			$v_count = (isset($vData['v_counts'][$vehicle]))? $vData['v_counts'][$vehicle] : 0;
			$v_max = (isset($vData['v_max'][$vehicle]))? $vData['v_max'][$vehicle] : 0;
			
			if($v_count >= $v_max){
				// skip this spawn, removed from list anyway.
				if( !isset($echoReachedMax[$vehicle]) )
				{
					$echoReachedMax[$vehicle] = 1;
					echo("Vehicle ".$vehicle." Reached it's maximum.\n<br/>");
				}
			}else{
				// otherwise add it
				$newSpotList[] = $spot;
				
				// forgot to increment
				$vData['v_counts'][$vehicle] = (!isset($vData['v_counts'][$vehicle]))? 1 : $vData['v_counts'][$vehicle]+1;
			}
			
			// check if we have any more spots to choose from, if not, return results prematurely (hehe)
			if(count($spotList) <= 1){
				break;
			}else{
				unset($spotList[$keys[$spot]]);
				$spotList = array_values($spotList);
			}
		}
		return $newSpotList;
	}
	
	private function genDamageParts($parts){
		
		$number_of_damaged_parts = rand(1,count($parts));
		
		$orig_part_list = $parts;
		$damaged_part_list = array();
		
		$partKeys = array_flip($parts);
		
		// check if chopper, if so, force full damage (so cant fly).
		if(in_array("velka vrtule",$parts)){
			// Use this to force chopper engine damaged
			// $damaged_part_list[] = "[\"motor\",1]";
			// unset($orig_part_list[$partKeys['motor']]);
			// $number_of_damaged_parts--;

			// Edited to force all parts fully damaged
			$damaged_part_list[] = "[\"motor\",1]";
			$damaged_part_list[] = "[\"glass1\",1]";
			$damaged_part_list[] = "[\"glass2\",1]";
			$damaged_part_list[] = "[\"glass3\",1]";
			$damaged_part_list[] = "[\"glass4\",1]";
			$damaged_part_list[] = "[\"glass5\",1]";
			$damaged_part_list[] = "[\"glass6\",1]";
			$damaged_part_list[] = "[\"elektronika\",1]";
			$damaged_part_list[] = "[\"mala vrtule\",1]";
			$damaged_part_list[] = "[\"velka vrtule\",1]";
			$number_of_damaged_parts = 0;
			// Edited by SilverShot to force all choppers fully damaged
		}
		// boat or motorbike
		else if(count($parts) == 1 && $parts[0] == "motor"){
			// motorbike or boat (chance of full engine damage)
			if(rand(1,4) > 1){ // 1 in 4 chance the vehicle will be healthy
				$damaged_part_list[] = "[\"motor\",1]";
				unset($orig_part_list[$partKeys['motor']]);
				$number_of_damaged_parts--;
			}
		}
		//Cars/buses/wagons/trucks/atvs etc
		else if(count($parts) > 1){
			// is not pushbike or any of above
			// force at least 1 wheel or engine full damage, prevent moving initially.
			if(rand(1,4) == 1){ // 1 in 4 chance engine will be needed
				// engine
				$tPart = "motor";
			}else{
				//wheel
				$tPart = "wheel_1_1_steering";
				unset($orig_part_list[$partKeys['motor']]);
				$number_of_damaged_parts--;
			}
			$damaged_part_list[] = "[\"".$tPart."\",1]";
			unset($orig_part_list[$partKeys[$tPart]]);
			$number_of_damaged_parts--;
		}
		
		$orig_part_list = array_values($orig_part_list);
		for($i=1;$i<$number_of_damaged_parts;$i++){
			
			// get random part
			$part_id = rand(0,count($orig_part_list)-1);
			$part = $orig_part_list[$part_id];
			unset($orig_part_list[$part_id]);
			$orig_part_list = array_values($orig_part_list);
			
			// remove part from list
			
			// get random part damage
			$ran_dam = 0.01 * rand(1,100);
			
			// if glass force full damage
			if(substr($part,0,5) == "glass"){
				$ran_dam = 1;
			
			// Force Wheels full damage by chance
			}else if(substr($part,0,5) == "wheel"){
				$ran_dam = ($ran_dam >= 0.50)? 1 : $ran_dam;
			
			// Engine parts max damage is 0.8 (or vehicle could explode) NEEDS TESTING
			}else{
				// NOT IMPLEMENTED
				$ran_dam = ($ran_dam >= 0.50)? 1 : $ran_dam;
			}
			$damaged_part_list[] = "[\"".$part."\",".$ran_dam."]";
		}
		
		return "[".implode(",",$damaged_part_list)."]";
	}
	
	public function worldspaceToGrid($worldspaceStr){
		if(!preg_match("#\[([0-9.-]+)\,\[([0-9.-]+),([0-9.-]+)\,([0-9.-]+)\]\]#i", $worldspaceStr, $matches)){
			return "ERROR IN CONVERSION. (".$worldspaceStr.")";
		}else{
			$calcX = $matches[2] / 100;
			$calcY = 153.4 - ($matches[3] / 100);
			
			return "(".round($calcX,2)." ".round($calcY,2).") -- ".$worldspaceStr;
		}
	}
	
	// generate vehicle inventory
	public function echoSpawnedVehicles($list){
	
		echo("\n<br/>Displaying Vehicle Information:<br/><br/>\n\n");
		foreach($list as $vehicle){
			echo(
				"Name: <b>".$vehicle[0]."</b><br/>\n"
				."Location: <b>".$this->worldspaceToGrid($vehicle[2])."</b><br/>\n"
				."Inventory: ".($vehicle[3])."<br/>\n"
				."Parts: ".($vehicle[4])."<br/>\n"
				."Fuel: ".$vehicle[5]." Damage: ".round($vehicle[6],3)."<br/>\n<br/>\n"
			);
		}
	}
	
	// Public Execute
	public function execute(){
		if($this->executed==true){
			exit("ERROR, you must use a new object if you are going to use multiple spawn scripts.");
			return FALSE;
		}
		
		// Clean First, Generate Last
		
	/*	if(($this->flags & self::$bitflags['clean_bounds']) == self::$bitflags['clean_bounds']){
			echo("(NOT IMPLEMENTED) Cleaning Out-of-Bounds Objects...<br/>");
		}
		
		if(($this->flags & self::$bitflags['clean_old']) == self::$bitflags['clean_old']){
			echo("(NOT IMPLEMENTED) Cleaning Old, Unused Objects...<br/>");
		}
	*/	
		
		// gear generator
		include(ROOT_DIR."class.generate.php");
		$vGearGen = new inventory_generator();
		
		if($this->generateFlag === true){
			echo("Generating Vehicles...<br/>");
			$vData = $this->getVehicleData();
			
			// if($this->maxVec > count($vData['spawn_ids'])){
				// echo("Cannot generate vehicles. Maximum vehicle count is above physical spawn maximum. Either lower your maximum vehicles or add new spawn points in your database. (Spawns: ".count($vData['spawn_ids'])."; Max: ".$this->maxVec.")<br/>");
				// return;
			// }
			
			// if($vData['vehicle_counts']['ingame_healthy'] >= $this->maxVec){
				// echo("Cannot generate vehicles. Maximum total vehicle count reached or exceeded. (Cur: ".$vData['vehicle_counts']['ingame_healthy']."; Max: ".$this->maxVec.")<br/>");
				// return;
			// }
			
			$resultQueries = array();

			// $targetCount = $this->maxVec - $vData['vehicle_counts']['ingame_healthy'];
			$targetCount = ($this->maxVec == 0) ? 999 : $this->maxVec - $vData['vehicle_counts']['ingame_healthy'];
			
			// CLEANUP BROKEN VEHICLES
			if($vData['vehicle_counts']['ingame_broken'] >= 1){
				echo("Removing ".$vData['vehicle_counts']['ingame_broken']." broken vehicles...<br/>");
				
				// remove/delete broken vehicles.
				$brokenVehicle_query = "DELETE FROM `".$this->getDatabaseName()."`.`instance_vehicle` WHERE \n\t\t\t   ";
				$qArr = array();	// easier to condense multi queries
				
				foreach($vData['damaged_vec_ids'] as $vId){
					$qArr[] = "`id`='".$vId."'";
				}
				$brokenVehicle_query .= implode("\n\t\t\tOR ", $qArr)." \n\t\t\tLIMIT ".count($qArr).";";
				
				$resultQueries[] = $brokenVehicle_query;
			}
			
			// GENERATE NEW RANDOM VEHICLES
			
			// Picks totally random available spawns. This can be changed to reflect time-implemented spawns or other similar stuff.
			$newSpawns = $this->pickRandomSpawns($vData, $targetCount);
			
			// Check if we can actually generate any individual vehicles (with individual v max applied)
			if(count($newSpawns) <= 0){	
				echo("Cannot generate any new vehicles. Individual vehicle limits have been reached.");
				return FALSE;
			}
			echo("Creating ".count($newSpawns)."/".$targetCount." Random Vehicles...<br/>");
			
			
			# DEBUG
			/*
			echo("MAX:\n");
			print_r($vData['v_max']);
			echo("COUNTS:\n");
			print_r($vData['v_counts']);
			echo("SPAWN TYPELIST:\n");
			print_r($vData['spawnspot_typelist']);
			echo("AVAILABLE SPAWNS:\n");
			print_r($vData['available_spawns']);
			*/
			
			$insertQueries = array();
			$spawnedVehicles = array();
			
			
			/*
			// DEBUG
			print_r($newSpawns);
			print_r($vData['available_spawns']);
			print_r($vData['spawnlist']);
			
			$ss = array();
			foreach($newSpawns as $s){
				if(isset($ss[$s])){
					echo ("DUPE: ".$s."<br/>\n\n");
				}
				$ss[$s] = true;
			}
			exit();*/
			
			// Create each new spawn
			foreach($newSpawns as $world_v_id){
				$class_name = $vData['spawnspot_typelist'][$world_v_id];
				
				$instance_id = 1;
				$worldspace = str_replace(" ","",$vData['spawnlist'][$world_v_id]['spawn_worldspace']);
				$inventory = $vGearGen->generate_loadout($class_name);
				#echo("generating parts for: ".$class_name."<br/>");
				$parts = $this->genDamageParts($vData['part_list'][$class_name]);
				$fuel = (strpos($parts,"palivo") !== FALSE)? 0 : 0.01*rand(5,85);
				$damage = 0.000000001 * rand(100000000,700000000);
				$last_updated = "CURRENT_TIMESTAMP";
				$created = "CURRENT_TIMESTAMP";
				
				$spawnedVehicles[] = array(
					$class_name,
					$instance_id,
					$worldspace,
					$inventory,
					$parts,
					$fuel,
					$damage
				);
				
				$insertQueries[] = "\t\t\t\t\t('".$world_v_id."','".$instance_id."','".$worldspace."','".$inventory."','".$parts."','".$fuel."','".$damage."',".$last_updated.",".$created.")";
			}
			
			$resultQueries[] = "INSERT INTO `instance_vehicle` 
				(
					`world_vehicle_id`,
					`instance_id`,
					`worldspace`,
					`inventory`,
					`parts`,
					`fuel`,
					`damage`,
					`last_updated`,
					`created`
				)
				VALUES \n".implode(",\n",$insertQueries);
			
			# DEBUG (prevent Query Execution)
			# exit(implode("\n\n<Br/>\n\n", $resultQueries));
			
			foreach($resultQueries As $query){
				if(!$this->mysqli->query($query)){
					exit("There was a problem generating vehicles! MySQL Said: [" . $this->mysqli->errno . "] " . $this->mysqli->error . "<br /><br />".$query);
				}
			}
			
			echo("Removed ".$vData['vehicle_counts']['ingame_broken']." Broken Vehicles");
			
			// Move out of loop to prevent duped messages.
			$this->echoSpawnedVehicles($spawnedVehicles);
			
			// Close connection and execute queued queries.
			$this->mysqli->close();
			$this->executed=true; # disable use of class (execute only runs once)
			return TRUE;
		}
	}
}
?>