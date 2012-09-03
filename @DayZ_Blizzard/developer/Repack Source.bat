@echo off
mkdir ..\addons
mkdir ..\..\MPMissions
Utils\cpbo.exe -y -p Source\dayz_server ..\addons\dayz_server.pbo
Utils\cpbo.exe -y -p Source\dayz_lingor ..\addons\dayz_server_lingor.bak
Utils\cpbo.exe -y -p Source\missions\dayz_1.lingor ..\..\MPMissions\dayz_1.lingor.pbo
Utils\cpbo.exe -y -p Source\missions\dayz_1.chernarus ..\..\MPMissions\dayz_1.chernarus.pbo
pause