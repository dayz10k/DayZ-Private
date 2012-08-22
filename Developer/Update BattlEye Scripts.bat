@echo off
cd ..\@DayZ_Blizzard\config\BattlEye
..\..\..\Developer\utils\wget.exe -N http://dayz-community-banlist.googlecode.com/git/bans/bans.txt
..\..\..\Developer\utils\wget.exe -N http://dayz-community-banlist.googlecode.com/git/filters/scripts.txt
..\..\..\Developer\utils\wget.exe -N http://dayz-community-banlist.googlecode.com/git/filters/remoteexec.txt
..\..\..\Developer\utils\wget.exe -N http://dayz-community-banlist.googlecode.com/git/filters/createvehicle.txt
pause
