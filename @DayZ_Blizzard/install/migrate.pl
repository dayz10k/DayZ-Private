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
	'version|v=s',
	'help'
);

my %db = (
	'host' => $args{'hostname'} ? $args{'hostname'} : 'localhost',
	'user' => $args{'username'} ? $args{'username'} : 'dayz',
	'pass' => $args{'password'} ? $args{'password'} : '',
	'name' => $args{'database'} ? $args{'database'} : 'dayz_chernarus',
	'port' => $args{'port'} ? $args{'port'} : '3306'
);

if ($args{'help'}) {print "usage: db_migrate.pl [--host <hostname>] [--user <username>] [--pass <password>] [--name <dbname>] [--port <port>] [--version_bliss <version>] [--version_blizzard <version>]\n"; exit;}

my $version_bliss = $args{'version_bliss'} ? $args{'version_bliss'} : "0.19";
my $version_blizzard = $args{'version_blizzard'} ? $args{'version_blizzard'} : "0.01";

print "INFO: Trying to connect to $db{'host'}, database $db{'name'} as $db{'user'}\n";
my $dbh = DBIx::Transaction->connect("dbi:mysql:$db{'name'}:$db{'host'}:$db{'port'}", $db{'user'}, $db{'pass'}) or die "FATAL: Could not connect to MySQL - " . DBI->errstr . "\n";

my $m_bliss = DBIx::Migration::Directories->new(base => 'schema', schema => 'Bliss', desired_version => $version_bliss,	dbh => $dbh);
my $m_blizzard = DBIx::Migration::Directories->new(base => 'schema', schema => 'Blizzard', desired_version => $version_blizzard, dbh => $dbh);

if ($m_bliss->get_current_version()) {printf("INFO: Current bliss schema version is %.2f\n", $m_bliss->get_current_version());} else {print "INFO: Did not find an existing bliss schema\n";}
if ($m_blizzard->get_current_version()) {printf("INFO: Current blizzard schema version is %.2f\n", $m_blizzard->get_current_version());} else {print "INFO: Did not find an existing blizzard schema\n";}

$m_bliss->migrate or die "FATAL: Database migration failed!\n";
print "INFO: Completed the migration of bliss to version $version_bliss\n";

$m_blizzard->migrate or die "FATAL: Database migration failed!\n";
print "INFO: Completed the migration of blizzard to version $version_blizzard\n";