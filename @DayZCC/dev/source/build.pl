#!/usr/bin/perl -w

use Getopt::Long qw(:config pass_through);

use File::Copy;
use File::Path qw(make_path remove_tree);
use File::Slurp;
use File::Basename;
use File::DirCompare;

use Text::Diff;
use Text::Patch;

use Digest::SHA1 qw(sha1_hex);
use Time::HiRes qw(time);
use List::Util qw(max min);

our %args;
GetOptions(
	\%args,
	'world|w|map|mission|m=s',
	'instance|id|i=s',
	'list',
	'clean',
	'help'
);

# Set defaults if options are not specified
$args{'world'} = ($args{'world'}) ? lc($args{'world'}) : 'chernarus';
$args{'instance'} = '1' unless $args{'instance'};

# Initialize paths
my $base_dir  = dirname(__FILE__);
my $tmp_dir   = "$base_dir/tmp";
my $world_dir = "$base_dir/world";
my $bliss_dir = "$base_dir/bliss";
my $build_dir = "$tmp_dir/dayz_server";
my $src_dir   = "$base_dir/official";
my $dst_dir   = "$base_dir/../..";

if ($args{'help'}) {
	print "usage: build.pl [--world <world>] [--instance <id>] [--with-<option>] [--clean] [--list]\n";
	print "    --world <world>: build an instance for the specified map/world\n";
	print "    --instance <id>: build an instance with the specified integer instance id\n";
	print "\n";
	print "    --with-<package>: merge in changes from ./pkg/<package>/ during build\n";
	print "    --clean: remove all files in ./tmp/ and perform no further action\n";
	print "    --list: lists all available worlds and packages\n";
	exit;
} elsif ($args{'list'}) {
	opendir (my $dh, $world_dir);
	my @worlds = readdir $dh;
	closedir $dh;

	# Append default
	push(@worlds, 'chernarus');

	print "Available worlds:\n";
	foreach my $world (@worlds) {
		print "    $world\n" unless ($world =~ m/^\./);
	}
	print "\n";

	opendir $dh, "$base_dir/pkg";
	my @pkgs = readdir $dh;
	closedir $dh;

	print "Available options:\n";
	foreach my $pkg (@pkgs) {
		print "    --with-$pkg\n" unless ($pkg =~ m/(^\.|world|bliss|mission)/);
	}
	exit;
} elsif ($args{'clean'}) {
	print "INFO: Removing $tmp_dir\n";
	remove_tree($tmp_dir);
	make_path($tmp_dir);
	exit;
}

die "FATAL: Source dir $src_dir does not exist\n" unless (-d $src_dir);
die "FATAL: Output dir $dst_dir does not exist\n" unless (-d $dst_dir);

# Clean up existing dayz_server before starting work
remove_tree($build_dir) if (-d $build_dir);

# Apply core Bliss changes to build directory
print "INFO: Merging Bliss code into official server\n";
merge_base($bliss_dir, $src_dir, $build_dir);

# Optionally merge in world-specific modifications
if (-d "$world_dir/$args{'world'}") {
	print "INFO: Merging changes for world $args{'world'}\n";
	merge_package("$world_dir/$args{'world'}", $build_dir);
}

# For each --with-<package> option, attempt to merge in its changes
while (my $option = shift(@ARGV)) {
	next unless ($option =~ m/with-([a-zA-Z0-9]+)/);
	my $pkg_dir = "$base_dir/pkg/$1";
	if (!-d $pkg_dir) {
		print "ERROR: Package dir $pkg_dir does not exist\n";
		next;
	}

	print "INFO: Merging changes for package $1\n";
	merge_package($pkg_dir, $build_dir);
}

# Create the dayz_server PBO
pack_world("$tmp_dir/dayz_server", "$dst_dir/\@DayZCC_w$args{'world'}/addons");

# Create the mission PBO
pack_mission($args{'instance'}, $args{'world'}, "$base_dir/mission/$args{'world'}", "$dst_dir/MPMissions");

print "INFO: Build completed successfully!\n";
exit;

sub pack_world {
	my ($src, $dst) = @_;

	print "INFO: Creating dayz_server.pbo\n";
	make_path($dst) unless (-d $dst);
	pack_pbo($src, "$dst/dayz_server.pbo");
	remove_tree($src);
}

sub pack_mission {
	my ($instance, $world, $src, $dst) = @_;
	my $name = "dayz_$instance.$world";

	# Substitute the instance ID into init.sqf
	replace_text("s/dayZ_instance\\s=\\s[0-9]*/dayZ_instance = $instance/", "$src/init.sqf");

	print "INFO: Creating $name.pbo\n";
	make_path($dst) unless (-d $dst);
	pack_pbo($src, "$dst/$name.pbo");

	# Reset the instance ID in init.sqf
	replace_text("s/dayZ_instance\\s=\\s[0-9]*/dayZ_instance = 1/", "$src/init.sqf");
}

# Build a PBO from the given directory
sub pack_pbo {
	my ($dir, $pbo) = @_;
	die "FATAL: PBO directory $dir does not exist\n" unless (-d $dir);

	my $cmd = (($^O =~ m/MSWin32/) ? '' : 'wine ') . 'util/cpbo.exe -y -p';
	system("$cmd \"$dir\" \"$pbo\"");
}

# Peform three-way merge of source code with world changes into output dir
sub merge_base {
	my ($src, $dst, $out) = @_;

	die "FATAL: Source path $src does not exist\n" unless (-d $src);
	die "FATAL: Destination path $dst does not exist\n" unless (-d $dst);
	make_path($out);

	File::DirCompare->compare($src, $dst, sub {
		my ($srcPath, $dstPath) = @_;

		if (!$dstPath) {
			# New file, copy it from $srcPath
			my @outSplit = File::Spec->splitdir($out);
			my @srcSplit = File::Spec->splitdir(dirname($srcPath));
			my $outLast = pop(@outSplit);
			my $srcLast = pop(@srcSplit);
			$dstPath = "$out/" . (($srcLast ne $outLast) ? "$srcLast/" : '') . basename($srcPath);

			#print "SRC $srcPath -> $dstPath\n";
			make_path(dirname($dstPath)) unless (-d dirname($dstPath));
			copy($srcPath, $dstPath) unless (-d $dstPath);
		} elsif (!$srcPath) {
			# Unmodified file, copy it from $dstPath
			my @outSplit = File::Spec->splitdir($out);
			my @dstSplit = File::Spec->splitdir(dirname($dstPath));
			my $outLast = pop(@outSplit);
			my $dstLast = pop(@dstSplit);
			$srcPath = "$out/" . (($dstLast ne $outLast) ? "$dstLast/" : '') . basename($dstPath);

			#print "DST $dstPath -> $srcPath\n";
			make_path(dirname($srcPath)) unless (-d dirname($srcPath));
			copy($dstPath, $srcPath) unless (-d $srcPath);
		} else {
			# Existing file, merge the changes from source into dest and copy resulting file to $out
			my $diff = diff($dstPath, $srcPath, { STYLE => 'Unified' });
			my $srcData = read_file($dstPath);
			my $dstData = patch($srcData, $diff, { STYLE => 'Unified' });

			my @outSplit = File::Spec->splitdir($out);
			my @srcSplit = File::Spec->splitdir(dirname($srcPath));
			my $outLast = pop(@outSplit);
			my $srcLast = pop(@srcSplit);
			$dstPath = "$out/" . (($srcLast ne $outLast) ? "$srcLast/" : '') . basename($srcPath);

			#print "MRG $srcPath -> $dstPath\n";
			make_path(dirname($dstPath));
			write_file($dstPath, $dstData);
		}
	});
}

# Perform merge of package changes into output dir
sub merge_package {
	my ($src, $dst) = @_;

	die "FATAL: Source path $src does not exist\n" unless (-d $src);
	#make_path($dst) unless (-d $dst);

	File::DirCompare->compare($src, $dst, sub {
		my ($srcPath, $dstPath) = @_;

		if (!$dstPath) {
			# New file, copy it from $srcPath
			my @srcSplit = File::Spec->splitdir(dirname($srcPath));
			my $srcLast = pop(@srcSplit);
			$dstPath = "$dst/$srcLast/" . basename($srcPath);

			#print "SRC $srcPath -> $dstPath\n";
			make_path(dirname($dstPath)) unless (-d dirname($dstPath));
			copy($srcPath, $dstPath) unless (-d $dstPath);
		} elsif ($srcPath) {
			#print "MRG $srcPath -> $dstPath\n";

			# Existing file, merge the changes from source into dest and copy resulting file to $out
			my $diff = diff($dstPath, $srcPath, { STYLE => 'Unified' });
			my $srcData = read_file($dstPath);
			my $dstData = patch($srcData, $diff, { STYLE => 'Unified' });

			my @srcSplit = File::Spec->splitdir(dirname($srcPath));
			my $srcLast = pop(@srcSplit);
			$dstPath = "$dst/$srcLast/" . basename($srcPath);

			make_path(dirname($dstPath)) unless (-d dirname($dstPath));
			write_file($dstPath, $dstData);
		}
	});
}

# Cross-platform recursive dir copy using system()
sub copy_dir {
	my ($src, $dst) = @_;
	my $cmd = (($^O =~ m/MSWin32/) ? 'xcopy /s /q /y' : 'cp -r');
	my $path = "\"$src\" \"$dst\/\"";
	$path =~ s/\//\\/g if ($^O =~ m/MSWin32/);
	system("$cmd $path");
}
