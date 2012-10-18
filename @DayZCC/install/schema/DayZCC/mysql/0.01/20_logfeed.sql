-- log_feed table holds log added by table triggers
create table if not exists log_feed (
	`id` 			int(10) unsigned not null,
	`unique_id`		varchar(128) not null,
	`name`			varchar(64) not null,
	`pos`			varchar(255) not null,
	`created`		timestamp not null on update current_timestamp,
	`code`			int(1) not null
) character set utf8 engine=InnoDB;