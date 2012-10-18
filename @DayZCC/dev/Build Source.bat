@echo off
set /p world="Enter the template you wish to build: "
Set /p instance="Enter instance number: "
echo Running build script ...

echo.
..\perl\bin\perl.exe -w source\build.pl --world %world% --instance %instance% --with-killmsgs --with-messaging
echo.

echo Done! Press any key to exit ...
pause>nul