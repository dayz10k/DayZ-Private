#!/usr/bin/perl -w

use warnings;

use POSIX;
use DBI;
use DBD::mysql;
use Getopt::Long;
use List::Util qw(min max);

my %args = ();
GetOptions(
	\%args,
	'instance|index|i=s',
	'hostname|host|dbhost|h=s',
	'username|user|dbuser|u=s',
	'password|pass|dbpass|p=s',
	'database|name|dbname|d=s',
	'port|dbport=s',
	'limit|l=s',
	'cleanup=s',
	'help'
);

my %db = (
	'host' => $args{'hostname'} ? $args{'hostname'} : 'localhost',
	'user' => $args{'username'} ? $args{'username'} : 'dayz',
	'pass' => $args{'password'} ? $args{'password'} : 'dayz',
	'name' => $args{'database'} ? $args{'database'} : 'dayz',
	'port' => $args{'port'} ? $args{'port'} : '3306',
	'instance' => $args{'instance'} ? $args{'instance'} : '1',
	'limit' => $args{'limit'} ? $args{'limit'} : '70',
);

if ($args{'help'}) {
	print "Usage: vehicles.pl [--instance <id>] [--limit <limit>] [--host <hostname>] [--user <username>] [--pass <password>] [--name <dbname>] [--port <port>] [--cleanup tents|bounds|all]\n";
	exit;
}

print "Connecting to MySQL server at $db{'host'}:$db{'name'} as user $db{'user'}\n";
my $dbh = DBI->connect("dbi:mysql:$db{'name'}:$db{'host'}:$db{'port'}",	$db{'user'}, $db{'pass'}) or die "> Error: MySQL Error: ".DBI->errstr."\n\n";

print "Using instance dayz_$db{'instance'}.$world_name ...\n";
my ($world_id, $world_name) = $dbh->selectrow_array("select w.id, w.name from instance i join world w on i.world_id = w.id where i.id = ?", undef, ($db{'instance'}));
die "> Error: Invalid instance ID\n\n" unless (defined $world_id && defined $world_name);
print "\n";

# Clean up database
my $cleanup = ($args{'cleanup'}) ? $args{'cleanup'} : 'none';
if ($cleanup ne 'none') {
	print "Cleaning up ...\n";
	print "> Cleaning up damaged vehicles\n";
	my $sth = $dbh->prepare(
<<EndSQL 
		delete from iv using instance_vehicle iv inner join vehicle v on iv.vehicle_id = v.id where iv.damage = 1
EndSQL
	) or die "> Error: MySQL Error: ".DBI->errstr."\n\n";
	$sth->execute() or die "> Error: Exception: ".$sth->errstr."\n\n";

	print "> Cleaning up old deployables\n";
	$sth = $dbh->prepare(
<<EndSQL
		delete from id using instance_deployable id inner join deployable d on id.deployable_id = d.id where (d.class_name = 'Wire_cat1' and id.last_updated < now() - interval 3 day) or (d.class_name = 'Hedgehog_DZ' and id.last_updated < now() - interval 4 day) or (d.class_name = 'TrapBear' and id.last_updated < now() - interval 5 day) or (d.class_name = 'Sandbag1_DZ' and id.last_updated < now() - interval 8 day)
EndSQL
	) or die "> Error: MySQL Error: ".DBI->errstr."\n\n";
	$sth->execute() or die "> Error: Exception: ".$sth->errstr."\n\n";
}
if ($cleanup eq 'tents' || $cleanup eq 'all') {
	print "Cleaning up tents with dead owners older than four days ...\n";
	
	$sth = $dbh->prepare(
<<EndSQL
		delete from id using instance_deployable id inner join deployable d on id.deployable_id = d.id inner join survivor s on id.owner_id = s.id and s.is_dead = 1 here d.class_name = 'TentStorage' and id.last_updated < now() - interval 4 day
EndSQL
	) or die "> Error: MySQL Error: ".DBI->errstr."\n\n";
	$sth->execute() or die "> Error: Exception: ".$sth->errstr."\n\n";
}
if ($cleanup eq 'bounds' || $cleanup eq 'all') {
	print "Starting boundary check for objects ...\n";
	
	$sth = $dbh->prepare(
<<EndSQL
		select
  id.id dep_id,
  0 veh_id,
  id.worldspace,
  w.max_x,
  w.max_y
from
  instance_deployable id
  inner join instance i on id.instance_id = i.id
  inner join world w on i.world_id = w.id
union
select
  0 dep_id,
  iv.id veh_id,
  iv.worldspace,
  w.max_x,
  w.max_y
from
  instance_vehicle iv
  inner join instance i on iv.instance_id = i.id
  inner join world w on i.world_id = w.id
EndSQL
	);
	$sth->execute() or die "> Error: Could not get list of object positions\n\n";
	
	my $depDelSth = $dbh->prepare("delete from instance_deployable where id = ?");
	my $vehDelSth = $dbh->prepare("delete from instance_vehicle where id = ?");
	while (my $row = $sth->fetchrow_hashref()) {
		$row->{worldspace} =~ s/[\[\]\s]//g;
		$row->{worldspace} =~ s/\|/,/g;
		my @pos = split(',', $row->{worldspace});
		next unless ($pos[1] < 0 || $pos[2] < 0 || $pos[1] > $row->{max_x} || $pos[2] > $row->{max_y});
		if ($row->{veh_id} == 0) {$depDelSth->execute($row->{dep_id}) or die "> Error: Exception while deleting out-of-bounds deployable\n";} else {$vehDelSth->execute($row->{veh_id}) or die "> Error: Exception while deleting out-of-bounds vehicle\n";}
		print "> Object at $pos[1], $pos[2] was out of bounds and was deleted successfully\n";
	}
	$depDelSth->finish();
	$vehDelSth->finish();
}
print "\n";

# Determine if we are over the vehicle limit
print "Checking vehicle limits ...\n";
my $vehicleCount = $dbh->selectrow_array("select count(*) from instance_vehicle where instance_id = ?", undef, $db{'instance'});
die "> Error: Count of $vehicleCount is greater than limit of $db{'limit'}\n\n" if ($vehicleCount > $db{'limit'});
print "\n";

# Get spawn information
print "Fetching spawn information ...\n";
my $spawns = $dbh->prepare(
<<EndSQL
select
  wv.vehicle_id,
  wv.worldspace,
  v.inventory,
  coalesce(v.parts, '') parts,
  v.limit_max,
  round(least(greatest(rand(), v.damage_min), v.damage_max), 3) damage,
  round(least(greatest(rand(), v.fuel_min), v.fuel_max), 3) fuel
from
  world_vehicle wv 
  inner join vehicle v on wv.vehicle_id = v.id
  left join instance_vehicle iv on wv.worldspace = iv.worldspace and iv.instance_id = ?
  left join (
    select
      count(*) as count,
      vehicle_id
    from
      instance_vehicle
    where instance_id = ?
    group by vehicle_id
  ) vc on vc.vehicle_id = v.id
where
  wv.world_id = ?
  and iv.id is null
  and (rand() < wv.chance)
  and (vc.count is null or vc.count between v.limit_min and v.limit_max)
EndSQL
) or die "> Error: MySQL Error: ".DBI->errstr."\n";
$spawns->execute($db{'instance'}, $db{'instance'}, $world_id);
my $insert = $dbh->prepare(
<<EndSQL
insert into
  instance_vehicle (vehicle_id, worldspace, inventory, parts, damage, fuel, instance_id, created)
values (?, ?, ?, ?, ?, ?, ?, current_timestamp())
EndSQL
) or die "> Error: MySQL Error: ".DBI->errstr."\n";
print "> Fetched ".$spawns->rows." vehicle spawns\n\n";

# Loop through each spawn
print "Spawning new vehicles ...";
my $spawnCount = 0;
while (my $vehicle = $spawns->fetchrow_hashref) {
	# If over the global limit, end prematurely
	if (($vehicleCount + $spawnCount) > $db{'limit'}) {print "> Exiting because global limit has been reached\n"; last;}

	# If over the per-type limit, skip this spawn
	my $count = $dbh->selectrow_array("select count(*) from instance_vehicle where instance_id = ? and vehicle_id = ?", undef, ($db{'instance'}, $vehicle->{vehicle_id}));
	next unless ($count < $vehicle->{limit_max});

	# Generate parts damage
	my $health = "[" . join(',', map { (sprintf(rand(), "%.3f") > 0.85) ? "[\"$_\",1]" : () } split(/,/, $vehicle->{parts})) . "]";

	# Execute insert
	$spawnCount++;
	$insert->execute($vehicle->{vehicle_id}, $vehicle->{worldspace}, $vehicle->{inventory}, $health, $vehicle->{damage}, $vehicle->{fuel}, $db{'instance'});
	print "> Called insert with ($vehicle->{vehicle_id}, $vehicle->{worldspace}, $vehicle->{inventory}, $health, $vehicle->{damage}, $vehicle->{fuel}, $db{'instance'})\n";
}

print "\n";
print "Spawned $spawnCount vehicles\n";

$spawns->finish();
$insert->finish();
$dbh->disconnect();