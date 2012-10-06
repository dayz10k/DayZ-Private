@echo off
cd ..\install>nul
set /p pass="Enter password for user 'dayz': "

echo -------------------------------------------------------------------------------------------


echo.
echo Database Migration started for Chernarus!
echo.
..\perl\bin\perl -w migrate.pl -database dayz_chernarus -user dayz -password %pass%
echo.
echo Database Migration started for Lingor!
echo.
..\perl\bin\perl -w migrate.pl -database dayz_lingor -user dayz -password %pass%
echo.


echo -------------------------------------------------------------------------------------------
echo.
echo Database Migration finished! Press any key to close ...
echo.
echo -------------------------------------------------------------------------------------------
pause>nul