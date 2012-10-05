@echo off
cd "%1">nul
cd ..\install>nul
echo -------------------------------------------------------------------------------------------
echo.
echo Database Migration started for Chernarus!
echo.
..\perl\bin\perl -w Utils\migrate.pl -database dayz_chernarus -user dayz -password dayz
echo.
echo Database Migration started for Lingor!
echo.
..\perl\bin\perl -w Utils\migrate.pl -database dayz_lingor -user dayz -password dayz
echo.
echo -------------------------------------------------------------------------------------------
echo.
echo Database Migration finished!
echo.
echo -------------------------------------------------------------------------------------------
pause>nul