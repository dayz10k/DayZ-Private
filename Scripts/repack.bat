@echo off
mkdir ..\@DayZ_Blizzard\addons
mkdir ..\@DayZ_Blizzard\addons
mkdir ..\MPMissions
util\cpbo.exe -y -p dayz_server ..\@DayZ_Blizzard\addons\dayz_server.pbo
util\cpbo.exe -y -p dayz_lingor ..\@DayZ_Blizzard\addons\dayz_server_lingor.bak
util\cpbo.exe -y -p missions\dayz.lingor ..\MPMissions\dayz.lingor.pbo
util\cpbo.exe -y -p missions\dayz.chernarus ..\MPMissions\dayz.chernarus.pbo
pause