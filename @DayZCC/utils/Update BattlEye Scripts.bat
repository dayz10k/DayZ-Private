@echo off

set /p instance="Enter server instance you wish to update: "

cd wget>nul
echo Downloading BattlEye community scripts ....
echo.

wget.exe --quiet -N http://dayz-community-banlist.googlecode.com/git/filters/scripts.txt
wget.exe --quiet -N http://dayz-community-banlist.googlecode.com/git/filters/remoteexec.txt
wget.exe --quiet -N http://dayz-community-banlist.googlecode.com/git/filters/createvehicle.txt
wget.exe --quiet -N http://dayz-community-banlist.googlecode.com/git/filters/publicvariable.txt
wget.exe --quiet -N http://dayz-community-banlist.googlecode.com/git/filters/publicvariableval.txt
wget.exe --quiet -N http://dayz-community-banlist.googlecode.com/git/filters/publicvariablevar.txt
wget.exe --quiet -N http://dayz-community-banlist.googlecode.com/git/filters/setpos.txt
wget.exe --quiet -N http://dayz-community-banlist.googlecode.com/git/filters/mpeventhandler.txt

echo.
echo Download finished!
echo.

cd ..\..\@DayZCC_Config\%instance%\BattlEye>nul
echo Updating scripts for instance %instance%!
echo.

move ..\..\..\@DayZCC\utils\wget\scripts.txt scripts.txt
move ..\..\..\@DayZCC\utils\wget\remoteexec.txt remoteexec.txt
move ..\..\..\@DayZCC\utils\wget\createvehicle.txt createvehicle.txt
move ..\..\..\@DayZCC\utils\wget\publicvariable.txt publicvariable.txt
move ..\..\..\@DayZCC\utils\wget\publicvariableval.txt publicvariableval.txt
move ..\..\..\@DayZCC\utils\wget\publicvariablevar.txt publicvariablevar.txt
move ..\..\..\@DayZCC\utils\wget\setpos.txt setpos.txt
move ..\..\..\@DayZCC\utils\wget\mpeventhandler.txt mpeventhandler.txt

echo.
echo Files were overwritten with newest changes!
echo Press any key to exit ...
pause>nul