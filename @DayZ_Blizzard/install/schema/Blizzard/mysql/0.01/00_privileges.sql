-- create dayz user on databases
GRANT SUPER ON dayz_chernarus.* TO 'dayz'@'localhost' IDENTIFIED BY 'dayz';
GRANT SUPER ON dayz_lingor.* TO 'dayz'@'localhost' IDENTIFIED BY 'dayz';
GRANT ALL PRIVILEGES ON mysql.proc TO 'dayz'@'localhost';