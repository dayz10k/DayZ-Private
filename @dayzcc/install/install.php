<?php

// XAMPP Installer by Kay Vogelgesang & Carsten Wiedmann for www.apachefriends.org
// Highyl modified and completly rewritten by Crosire

$curdir = getcwd();
list($partition, $nonpartition) = preg_split ("/:/", $curdir);
$partwampp = substr(realpath(__FILE__), 0, strrpos(dirname(realpath(__FILE__)), '\\'));
$confhttpdroot = $partwampp."\apache\\conf\\httpd.conf";

if (file_exists("$partwampp\install\\paths.php")) {
	include_once ("$partwampp\install\\paths.php");
}

$awkexe = ".\install\awk.exe";
$awk = ".\install\config.awk";
$awknewdir = "\"".(str_replace("&", "\\\\&", eregi_replace ("\\\\", "\\\\", $nonpartition)))."\"";
$awkslashdir = "\"".(str_replace("&", "\\\\&", ereg_replace ("\\\\", "/", $nonpartition)))."\"";

$substit = "\\\\\\\\xampp";
$substitslash = "/xampp";

$substit = "\"".$substit."\"";
$trans = array(
	"^" => "\\\\^",
	"." => "\\\\.",
	"[" => "\\\\[",
	"$" => "\\\\$",
	"(" => "\\\\(",
	")" => "\\\\)",
	"+" => "\\\\+",
	"{" => "\\\\{"
);
$substit = strtr($substit, $trans);

for ($i = 0; $i <= count($backslashrootreal); $i++)
{
	if ($backslash[$i] == "")
	{
		$upbackslashrootreal = $backslashrootreal[$i];
	}
	else
	{
		$configname = $backslash[$i];
		$upbackslashrootreal = $backslashrootreal[$configname].$configname;
	}

	$backslashawk = eregi_replace("\\\\", "\\\\", $upbackslashrootreal);
	$backslashawk = "\"".$backslashawk;

	$awkconfig = $backslashawk."\"";
	$awkconfigtemp = $backslashawk."temp\"";
	$configreal = $upbackslashrootreal;
	$configtemp = $upbackslashrootreal."temp";

	$awkrealm = $awkexe." -v DIR=".$awknewdir." -v CONFIG=".$awkconfig. " -v CONFIGNEW=".$awkconfigtemp. "  -v SUBSTIT=".$substit." -f ".$awk;

	if (file_exists($awk) && file_exists($awkexe) && file_exists($configreal))
	{
		$handle = popen($awkrealm, 'w');
		pclose($handle);
	}

	if (file_exists($configtemp) && file_exists($configreal))
	{
		if (@copy($configtemp, $configreal))
		{
			unlink($configtemp);
		}
	}
}

$substitslash = "\"".$substitslash."\"";
$trans = array(
	"^" => "\\\\^",
	"." => "\\\\.",
	"[" => "\\\\[",
	"$" => "\\\\$",
	"(" => "\\\\(",
	")" => "\\\\)",
	"+" => "\\\\+",
	"{" => "\\\\{"
);
$substitslash = strtr($substitslash, $trans);

for ($i = 0; $i <= count($slashrootreal); $i++)
{
	if ($slash[$i] == "")
	{
		$upslashrootreal = $slashrootreal[$i];
	}
	else
	{
		$configname = $slash[$i];
		$upslashrootreal = $slashrootreal[$configname].$configname;
	}

	$slashawk = eregi_replace("\\\\", "\\\\", $upslashrootreal);
	$slashawk = "\"".$slashawk;
	$awkconfig = $slashawk."\"";
	$awkconfigtemp = $slashawk."temp\"";
	$configreal = $upslashrootreal;
	$configtemp=$upslashrootreal."temp";

	$awkrealm = $awkexe." -v DIR=".$awkslashdir." -v CONFIG=".$awkconfig. " -v CONFIGNEW=".$awkconfigtemp. "  -v SUBSTIT=".$substitslash." -f ".$awk;

	if (file_exists($awk) && file_exists($awkexe) && file_exists($configreal))
	{
		$handle = popen($awkrealm, 'w'); // Fix by Wiedmann
		pclose($handle);
	}

	if (file_exists($configtemp) && file_exists($configreal))
	{
		if (@copy($configtemp, $configreal))
		{
			unlink($configtemp);
		}
	}
}

exit;

?>