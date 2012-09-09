@echo off
cd ..\developer

if "%3"=="" (
..\perl\bin\perl -w Schema\db_migrate.pl -database %1 -username root
..\perl\bin\perl -w Schema\db_migrate.pl -database %2 -username root
) else (
..\perl\bin\perl -w Schema\db_migrate.pl -database %1 -username root -password %3
..\perl\bin\perl -w Schema\db_migrate.pl -database %2 -username root -password %3
)