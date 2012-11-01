@echo off

set /p instance="Enter server instance you wish to update: "
set /p world="Enter world of instance '%instance%': "

echo.
echo BattlEye Updater started!
echo.

..\perl\bin\perl -w script\scripts.pl -world %world% "..\..\@DayZCC_Config\%instance%\BattlEye"

echo.
echo Files were overwritten with latest changes!
echo Press any key to exit ...
pause>nul