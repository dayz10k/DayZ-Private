#!/usr/bin/perl -w
# Database schema migration utility 
# by ayan4m1 and Crosire

use Getopt::Long;
use File::Basename;
use DBIx::Migration::Directories;
use DBIx::Transaction;
use DBI;

our %args;
GetOptions(
	\%args,
	'hostname|host|h=s',
	'username|user|u=s',
	'password|pass|dbpass|p=s',
	'database|name|dbname|d=s',
	'port|dbport=s',
	'help'
);

my %db = (
	'host' => $args{'hostname'} ? $args{'hostname'} : '127.0.0.1',
	'user' => $args{'username'} ? $args{'username'} : 'dayz',
	'pass' => $args{'password'} ? $args{'password'} : '',
	'name' => $args{'database'} ? $args{'database'} : 'dayz_chernarus',
	'port' => $args{'port'} ? $args{'port'} : '3306'
);

if ($args{'help'}) {
	print "Usage: migrate.pl [--host <hostname>] [--user <username>] [--pass <password>] [--name <dbname>] [--port <port>] [--schema <schema>] [--version <version>]\n";
	exit;
}

print "Starting up ...\n";
die "> Error: Schema version must be specified for a non-standard schema!\n" if ($args{'schema'} && !defined $args{'version'});
print "\n";

my $schema1 = "Bliss";
my $schema2 = "Controlcenter";
my $version1 = "0.36";
my $version2 = "0.08";

print "Trying to connect to MySQL server on $db{'host'}, database $db{'name'} as $db{'user'}\n";
my $dbh = DBIx::Transaction->connect("dbi:mysql:$db{'name'}:$db{'host'}:$db{'port'}", $db{'user'}, $db{'pass'}) or die "> Error: MySQL Error: ".DBI->errstr."\n";
print "> Sucessfully connected!\n\n";

my $m1 = DBIx::Migration::Directories->new(base => dirname(__FILE__).'/schema', schema => $schema1, desired_version => $version1, dbh => $dbh);
my $m2 = DBIx::Migration::Directories->new(base => dirname(__FILE__).'/schema', schema => $schema2, desired_version => $version2, dbh => $dbh);
if ($m1->get_current_version()) { printf("Current ".$schema1." schema version is %.2f\n", $m1->get_current_version()); } else { print "No existing ".$schema1." schema was found!\n"; }
if ($m2->get_current_version()) { printf("Current ".$schema2." schema version is %.2f\n", $m2->get_current_version()); } else { print "No existing ".$schema2." schema was found!\n"; }
print "\n";

print "Running database migration ...\n\n";
$m1->migrate or die "> Error: Migration failed!\n";
$m2->migrate or die "> Error: Migration failed!\n";
print "\n";
print "> Completed ".$schema1." update to version $version1\n";
print "> Completed ".$schema2." update to version $version2\n";
print "\n";

print "Running optional package migration ...\n\n";
$m1 = DBIx::Migration::Directories->new(base => dirname(__FILE__).'/schema', schema => "BlissBuildings", desired_version => "0.01", dbh => $dbh);
$m1->migrate;
$m1 = DBIx::Migration::Directories->new(base => dirname(__FILE__).'/schema', schema => "BlissInvCust", desired_version => "0.02", dbh => $dbh);
$m1->migrate;
print "\n> Completed optional package update";