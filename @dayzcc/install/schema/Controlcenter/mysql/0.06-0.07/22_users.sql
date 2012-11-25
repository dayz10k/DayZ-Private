update users set permissions = 'map, table, user, control, whitelist, tools' where permissions = 'map,table,user,control,whitelist';

alter table users
  modify permissions varchar(50) not null default 'whitelist, table, map, control, tools';