DayZ Server Controlcenter 5 by Crosire
====================================
________________________________________________________________________________

Contents:
=========

1. Introduction
2. Requirements
3. Installation
4. The Controlcenter
5. Default Logins
6. Troubleshooting

________________________________________________________________________________

1. Introduction:
================

 Thanks for downloading my Server Controlcenter. I hope it will help you and everybody using this to set
 up your own DayZ server without any big problems. This is designed to let even people, that hove no idea
 on how the server and Co. works to host their own one.

 Hours of work went into this, so a thank you would be nice :) Enjoy!

2. Requirements:
================

 - .Net Framework 2/4 (http://www.microsoft.com/download/en/details.aspx?id=24872)
 - [Microsoft Visual C++ 2008 Redistributable Update (http://www.microsoft.com/en-us/download/details.aspx?id=11895)]
 - [Microsoft Visual C++ 2010 Redistributable (http://www.microsoft.com/en-us/download/details.aspx?id=8328)]
 - [ArmA 2 Combined Operations with OA Beta Patch 96584 (ftp://downloads.bistudio.com/arma2.com/update/beta/ARMA2_OA_Build_96584.zip)]
 - DayZ 1.7.2.6 (http://dayzmod.com/?Download)
 - DayZ Lingor if you want to play it: (http://http://dayzlingor.tk)

 The "[...]" requirements can be installed from the setup wizard.

3. Installation:
================

 If you have steam: Start ArmA 2 once with steam and quit again, repeat the same with OA. Now copy the "Addons" folder in your "ArmA 2" folder into your "ArmA 2 Operation Arrowhead" folder to have Combined Operations. Now start Combined Operations through Steam one time for the keys to generate!

 Make sure no previous server package is installed (please install from a fresh ArmA with latest patch).
 Start the setup wizard and follow the instruction to install the server to your system.
 After installing you can start using the Controlcenter. Please read the next paragraph for
 more information on how to run your server! And do not forget to change default passwords!

 Updating is done with the setup wizard too! Just run it with that options and everything else is done automaticly!

4. The Controlcenter:
=====================

 These three options are available after installation:

 - "Configuration" allows you to change every single aspect of your server. Starting with its name over more 
 security related things like a password, cheat protection and precise tuning options like the timezone or daytime only mode activation.

 - "Administration" combines an easy to use interface with options to control your server.

 - "Database" is the controldesk to your characters and vehicles on the server. Using Chive you can change
 your inventory, move whole vehicles around the map and backup or restore your database.

 - "Information" displays you all the relevant status information and monitors the servers performance.


 **Database**
 ------------

 To start editing wait until Chive has connected to MySQL sucessfully, login using default MySQL information
 and select the database "dayz_chernarus" or "dayz_lingor" if you run a lingor server. Now you can see and edit all information (To view the contents of a
 table you have to click on "Browse") ...

 - instances:
   Everything here can be configurated from the Controlcenter, so it's not interesting.

 - log_code:
   Description for log. Not interesting.

 - log_entry:
   Server logging feature.

 - log_tool:
   Action log from the admin tool.

 - profile:
   Stores player data including their unique_id and global humanity. Match the unique_id to a character in the survivor table for more details about him.

 - survivor:
   Player data is saved here. Every new character gets a unique id. To match the character to a player just compare the unique_id! You can change the inventory, health and everything character related here. Look at the description for each column.

   Position Line: [direction|[X|Y|Z]]

   Medical Line:  [dead|unconscious|infected|injured|pain|cardiac arrest|low blood|blood count|[wounds]|[leg fractures|arm fractures]|time unconscious|[X|X]]

   To display the profile name in the survivor table, run the following sql qery: "SELECT survivor.id as survivor_id, profile.name, profile.unique_id, survivor.inventory, survivor.backpack, survivor.medical, survivor.model FROM survivor LEFT JOIN profile ON profile.unique_id = survivor.unique_id WHERE survivor.is_dead = 0"

 - objects:
   Contains all ingame vehicles, tents and similar, which can be spawned from the "Vehicles" Tab ("Vehicle Generating Script") found under "Configuration" in the Controlcenter. Changeable options are damage, damaged parts, fuel, inventory and more.

 - objects_classes:
   Uninteresting, used by the admin tool.

 - scheduler:
   You can create messages and scripts here, that will be shown or executed ingame.

 - spawns:
   All possible spawn locations for vehicles here. They are used by the vehicle generation script, so you can add new vehicle spawn positions and their chance in the table.

 - users:
   Contains users from the admin tool, their hashed passwords and permissions.


 **Administration**
 ------------------

 Wait until the login page is displayer (can take some time). Login using default user and password 
 found below. This nice little interface allows you a lot of things. The server is started and stopped
 through it for example.

 - Dashbord:
   Overview of your server: which mods are running, how many players are allowed and online and the ability
   to write into the global server chat when BattlEye is enabled.

 - Control:
   Allows you to start and stop your server, BattlEye Extended Controls and DayZ AntiHax!

 - Configuration:
   Goto "Users" to manage administrators and other users plus their permissions.

 - Entitys:
   Lists of ingame vehicles, spawn locations or player information. Basicly it is a graphical interface
   that shows you everything which can be seen in the database too (but editing is not possible yet).

 - Map:
   Display all the entitys on a map of chernarus or lingor. If you do not know where you are, simply look here 
   or get information about near vehicles and other players.

 To logout again, press that button on the right top corner.


5. Default Login information:
=============================

(It is highly recommended to change these!)

 - Admin Tool:
 Username: admin
 Password: adminpass (You should change that by deleting the user and creating a new one)

 - Chive/MySQL:
 Username: dayz
 Password: dayz

 - BattlEye Rcon:
 Password: adminpass

 - DayZ Server:
 Administration Password: adminpass


6. Troubleshooting:
===================

 --------------------------------------------------------------------------------------------------------------------------------------------------------------

 **Problem**:	Connection to admin tool or chive failes. "Apache" is not running.
 **Solution**:	Start Apache ("Local Administration" > "Start Apache Webserver")!

 --------------------------------------------------------------------------------------------------------------------------------------------------------------

 **Problem**:	MySQL Erros when admin tool and/or Chive are connecting.
 **Solution**:	Start MySQL ("Local Administration" > "Start MySQL Server")!

 --------------------------------------------------------------------------------------------------------------------------------------------------------------

 **Problem**:	MySQL Server/Apache don't start, they crash or do nothing.
 **Solution**:	Update the server with "reconfigurate" option in the Set Up Wizard and make sure port 78 is not blocked!

 --------------------------------------------------------------------------------------------------------------------------------------------------------------

 **Problem**:	Server does not appear in online server list.
 **Solution**:	Open these ports: UDP 2300-2400, 47624-47624, 28800-28900; TCP 2300-2400, 47624-47624 and make sure reporting Ip is set to "master.gamespy.com" and your router does not block anything.

 --------------------------------------------------------------------------------------------------------------------------------------------------------------

 **Problem**:	Stuck at waiting for host and "Mission read from bank" spam in the server window.
 **Solution**:	Make sure you have installed DayZ and Combined Operations. Look in the admin tool configuration and check if @DayZ is loaded!

 --------------------------------------------------------------------------------------------------------------------------------------------------------------

 **Problem**:	Stuck at loading on the server.
 **Solution**:	Make sure the database according to your setup and a mysql user "dayz" with the right password and privileges exist!

 --------------------------------------------------------------------------------------------------------------------------------------------------------------