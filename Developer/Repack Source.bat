@echo off
mkdir ..\@DayZ_Blizzard\addons
mkdir ..\MPMissions
util\cpbo.exe -y -p Source\dayz_server ..\@DayZ_Blizzard\addons\dayz_server.pbo
util\cpbo.exe -y -p Source\dayz_lingor ..\@DayZ_Blizzard\addons\dayz_server_lingor.bak
util\cpbo.exe -y -p Source\missions\dayz.lingor ..\MPMissions\dayz.lingor.pbo
util\cpbo.exe -y -p Source\missions\dayz.chernarus ..\MPMissions\dayz.chernarus.pbo
pause