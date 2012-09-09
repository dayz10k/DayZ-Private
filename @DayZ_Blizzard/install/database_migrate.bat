@echo off
cd ..\developer
..\perl\bin\perl -w Schema\db_migrate.pl -database %1
..\perl\bin\perl -w Schema\db_migrate.pl -database %2