@echo off
cd ..\config\BattlEye
..\..\developer\Utils\wget.exe -N http://dayz-community-banlist.googlecode.com/git/bans/bans.txt
..\..\developer\Utils\wget.exe -N http://dayz-community-banlist.googlecode.com/git/filters/scripts.txt
..\..\developer\Utils\wget.exe -N http://dayz-community-banlist.googlecode.com/git/filters/remoteexec.txt
..\..\developer\Utils\wget.exe -N http://dayz-community-banlist.googlecode.com/git/filters/createvehicle.txt
pause
