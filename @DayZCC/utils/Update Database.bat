@echo off
cd ..\install>nul

set /p user="Enter MySQL user to use for migration: "
set /p pass="Enter password for user '%user%': "
Set /p base="Enter database name you want to update: "

echo.
echo Database migration started for %base%!
echo.

..\perl\bin\perl -w migrate.pl -database %base% -user %user% -password %pass%

echo.
echo Finished migration! Press any key to exit ...
pause>nul