#!/usr/bin/perl -w

use Getopt::Long;
use DBIx::Migration::Directories;
use DBIx::Transaction;
use DBI;

our %args;
GetOptions(
\%args,
	'hostname|host|h=s',
	'username|user|u=s',
	'password|pass|p=s',
	'database|name|dbname|d=s',
	'port=s',
	'schema|s=s',
	'version|v=s',
	'help'
);

my %db = (
	'host' => $args{'hostname'} ? $args{'hostname'} : 'localhost',
	'user' => $args{'username'} ? $args{'username'} : 'root',
	'pass' => $args{'password'} ? $args{'password'} : '',
	'name' => $args{'database'} ? $args{'database'} : 'dayz_chernarus',
	'port' => $args{'port'} ? $args{'port'} : '3306'
);

if ($args{'help'}) {print "usage: db_migrate.pl [--host <hostname>] [--user <username>] [--pass <password>] [--name <dbname>] [--port <port>] [--schema <schema>] [--version <version>]\n"; exit;}
my $version1 = $args{'version'} ? $args{'version'} : "0.22";
my $version2 = "0.02";
my $schema1 = 'Bliss';
my $schema2 = 'DayZCC';

print "Trying to connect to MySQL server on $db{'host'}, database $db{'name'} as $db{'user'}\n";
my $dbh = DBIx::Transaction->connect("dbi:mysql:$db{'name'}:$db{'host'}:$db{'port'}", $db{'user'}, $db{'pass'}) or die "> Error: MySQL Error: ".DBI->errstr."\n";
print "> Sucessfully connected!\n\n";
my $m1 = DBIx::Migration::Directories->new(base => 'schema', schema => $schema1, desired_version => $version1, dbh => $dbh);
my $m2 = DBIx::Migration::Directories->new(base => 'schema', schema => $schema2, desired_version => $version2, dbh => $dbh);

if ($m1->get_current_version()) {printf("Current Bliss schema version is %.2f\n", $m1->get_current_version());} else {print "No existing Bliss schema was found!\n";}
if ($m2->get_current_version()) {printf("Current Controlcenter schema version is %.2f\n", $m2->get_current_version());} else {print "No existing Controlcenter schema was found!\n";}

print "\n";
print "Running database migration ...\n\n";
$m1->migrate or die "> Error: Migration failed!\n";
$m2->migrate or die "> Error: Migration failed!\n";
print "\n";
print "> Completed Bliss update to version $version1\n";
print "> Completed Controlcenter update to version $version2\n";
print "\n";