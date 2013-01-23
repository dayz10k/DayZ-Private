update users set permissions = 'map, table, user, control, manage, whitelist, tools, feed' where permissions = 'map, table, user, control, whitelist, tools, feed';

alter table users
  modify permissions varchar(50) not null default 'whitelist, table, map, control, manage, tools, feed';