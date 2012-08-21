@echo off
cd ..\@DayZ_Blizzard\config\BattlEye
..\..\..\Scripts\util\wget.exe -N http://dayz-community-banlist.googlecode.com/git/bans/bans.txt
..\..\..\Scripts\util\wget.exe -N http://dayz-community-banlist.googlecode.com/git/filters/scripts.txt
..\..\..\Scripts\util\wget.exe -N http://dayz-community-banlist.googlecode.com/git/filters/remoteexec.txt
..\..\..\Scripts\util\wget.exe -N http://dayz-community-banlist.googlecode.com/git/filters/createvehicle.txt
pause
