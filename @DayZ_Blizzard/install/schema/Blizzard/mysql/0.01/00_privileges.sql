-- create dayz user on databases
grant all on dayz_chernarus.* to 'dayz'@'localhost' identified by 'dayz';
grant all on dayz_lingor.* to 'dayz'@'localhost' identified by 'dayz';
grant all privileges on mysql.proc to 'dayz'@'localhost';
grant all privileges on mysql.user to 'dayz'@'localhost';