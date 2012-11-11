drop table if exists log_whitelist;
create table if not exists log_whitelist (
  id int(11) unsigned not null auto_increment,
  whitelist_id int(11) unsigned not null,
  log_code_id int(11) unsigned not null,
  created timestamp not null default current_timestamp,

  constraint pk_log_whitelist primary key (id)
) character set utf8 engine=MyISAM;

insert ignore into log_code (id, name, description) values
  (6, 'Authorized Login', 'Whitelisted player connected'),
  (7, 'Kicked', 'Not whitelisted player connected');