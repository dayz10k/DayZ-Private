-- log_tool table holds action log added by the admin tool
create table if not exists log_tool (
	`id` 			int(10) unsigned not null auto_increment,
	`action`		varchar(255) not null,
	`user`			varchar(255) not null default '',
	`timestamp`		timestamp not null on update current_timestamp,

	unique key `id` (`id`)
) character set utf8 engine=InnoDB auto_increment=224;