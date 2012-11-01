create table if not exists whitelist (
	`id`				int(11) unsigned not null auto_increment,
	`name`				varchar(64) not null default '',
	`guid`				varchar(32) not null default '',
	`is_whitelisted`	tinyint(1) default 0,

	primary key (`id`)
) character set utf8 engine=InnoDB;