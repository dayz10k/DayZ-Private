-- create mysql user
grant usage on *.* to 'dayz'@'localhost' identified by 'dayz';
grant all privileges on mysql.* to 'dayz'@'localhost';