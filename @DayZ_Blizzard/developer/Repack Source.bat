@echo off
mkdir ..\addons
mkdir ..\..\MPMissions
Utils\cpbo.exe -y -p Source\dayz_server ..\addons\dayz_server.pbo
Utils\cpbo.exe -y -p Source\dayz_lingor ..\addons\dayz_server_lingor.bak
Utils\cpbo.exe -y -p Source\missions\dayz.lingor ..\..\MPMissions\dayz.lingor.pbo
Utils\cpbo.exe -y -p Source\missions\dayz.chernarus ..\..\MPMissions\dayz.chernarus.pbo
pause