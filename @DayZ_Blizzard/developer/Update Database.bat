@echo off
echo -------------------------------------------------------------------------------------------
echo.
echo Database Migration started for Chernarus!
echo.
..\perl\bin\perl -w Schema\db_migrate.pl -database dayz_chernarus
echo.
echo Database Migration started for Lingor!
echo.
..\perl\bin\perl -w Schema\db_migrate.pl -database dayz_lingor
echo.
echo -------------------------------------------------------------------------------------------
echo.
echo Database Migration finished!
echo.
echo -------------------------------------------------------------------------------------------
pause>nul