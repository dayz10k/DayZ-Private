DayZ Server Controlcenter by Crosire
====================================

Contents:
=========

1. Introduction
2. Requirements
3. Installation
4. The Controlcenter
5. Default Logins
6. Troubleshooting


1. Introduction:
================

 Thanks for downloading my Server Controlcenter. Hours of work went into this, so a thank you and some support would be nice :) Enjoy!
 
 
2. Requirements:
================

 - .Net Framework 2 and/or 4 (http://www.microsoft.com/download/en/details.aspx?id=24872)
 - [Microsoft Visual C++ 2008 Redistributable Update (http://www.microsoft.com/en-us/download/details.aspx?id=11895)]
 - [Microsoft Visual C++ 2010 Redistributable (http://www.microsoft.com/en-us/download/details.aspx?id=8328)]
 - [ArmA 2 Combined Operations with recommended Beta Patch (http://www.arma2.com/beta-patch.php)]
 - DayZ 1.7.3 (http://dayzmod.com/?Download)

 The "[...]" requirements can be installed right from the setup wizard.

 
3. Installation:
================

 If you have steam: Start ArmA 2 OA once with steam and quit again (even if you can't play because of no VGA). Now copy the "Addons" folder in your "ArmA 2" folder into your "ArmA 2 Operation Arrowhead" folder to have Combined Operations. Start Combined Operations through Steam at least one time again for the keys to generate!

 Make sure no previous server package is installed (better start fresh).
 Start the setup wizard and follow the instructions on screen, if you already have a MySQL server running, don't forget to enter its login details!
 After installation you are ready to run the Controlcenter. Please read the next paragraph for more detailed information on how to use it before posting any topics on the web and do not forget to change default passwords!

 
4. The Controlcenter:
=====================

 These three options are available after installation:

 - "Configuration" allows you to change every single aspect of your server. Name, password, timezone ...

 - "Administration" combines an easy to use webfrontend with a realtime log monitor. Start and manage your server here.

 - "Database" is the door to your characters and vehicles on the server. Using Chive you can edit all ingame data or backup, restore and reset your whole database.

 - "Information" displays you all the relevant application information and lets you change the language.


 **Database**
 ------------
 To start editing wait until Chive has connected to MySQL sucessfully, login using default MySQL information
 and select the dayz database ("dayz_chernarus" for example). Enter a table to edit its contents (click on "Browse") and edit them like you want.

 - instance:
   Everything here can be configurated from the Controlcenter, so it's not interesting.

 - instance_vehicles:
   Contains all ingame vehicles, which can be spawned from the "Vehicles" Tab ("Vehicle Generating Script") found under "Configuration" in the Controlcenter. Changeable options are damage, damaged parts, fuel, inventory and more.

 - instance_deployables:
   Contains all ingame tents and sandbags.

 - log_code:
   Description for log. Not interesting.

 - log_entry:
   Server logging.

 - log_tool:
   Action log from the admin tool.

 - profile:
   Stores player data including their unique_id and global humanity. Match the unique_id to a character in the survivor table for more details about him.

 - survivor:
   Player data is saved here. Every new character gets a new id. To match the character to a player just compare the unique_id with the profile table! You can change inventory, health and everything character related here.

   Position Line: [direction|[X|Y|Z]]

   Medical Line:  [dead|unconscious|infected|injured|pain|cardiac arrest|low blood|blood count|[wounds]|[leg fractures|arm fractures]|time unconscious|[X|X]]

   To display the profile name in the survivor table, run the following sql qery: "SELECT survivor.id as survivor_id, profile.name, profile.unique_id, survivor.inventory, survivor.backpack, survivor.medical, survivor.model FROM survivor LEFT JOIN profile ON profile.unique_id = survivor.unique_id WHERE survivor.is_dead = 0"

 - vehicle, world_vehicle:
   All possible spawn locations for vehicles here. They are used by the vehicle generation script, so you can add new vehicle spawn positions and their chance in the table.

 - users:
   Contains users from the admin tool, their hashed passwords and permissions.


 **Administration**
 ------------------
 Wait until the login page is displayed and login using default user and password  found below (can be changed when clicking on the "account" button).


 - Dashbord:
   Overview of your server: which mods are running, how many players are allowed and online and the ability
   to write into the global server chat when BattlEye is enabled.

 - Control:
   Allows you to start and stop your server and BattlEye Extended Controls!

 - Entitys & Info:
   Lists of ingame vehicles, spawn locations or player information.

 - Map:
   Display all the entitys on a map of your current selected mission. New feature is the crash site map.


 To logout again, press the button on the top right corner.


5. Default Login information:
=============================

(It is highly recommended to change these!)

 - Admin Tool:
 Username: admin
 Password: adminpass (Delete the user and create a new one in "Account")

 - Chive/MySQL:
 Username: dayz
 Password: dayz (Change this on the local tab in the Controlcenter)

 - BattlEye Rcon:
 Password: adminpass (Change this on the configuration tab in the Controlcenter)

 - DayZ Server:
 Administration Password: (Random)


6. Troubleshooting:
===================

 --------------------------------------------------------------------------------------------------------------------------------------------------------------

 **Problem**:	MySQL Server/Apache won't start, they crash or do nothing.
 **Solution**:	Update the server with "reconfigurate" option in the Set Up Wizard and make sure port 78 is not blocked!

 --------------------------------------------------------------------------------------------------------------------------------------------------------------

 **Problem**:	Server does not appear in online server list.
 **Solution**:	Open these ports: UDP 2300-2400, 47624-47624, 28800-28900; TCP 2300-2400, 47624-47624 (in the router too) and make sure reporting Ip is set to "master.gamespy.com".

 --------------------------------------------------------------------------------------------------------------------------------------------------------------

 **Problem**:	Stuck at waiting for host and "Mission read from bank" spam in the server window.
 **Solution**:	Make sure you have installed DayZ and Combined Operations (and the DayZ maps if enabled). Use a tool like DayZCommander to update!

 --------------------------------------------------------------------------------------------------------------------------------------------------------------