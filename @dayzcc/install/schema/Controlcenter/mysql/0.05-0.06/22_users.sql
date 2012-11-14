update users set permissions = replace(permissions, 'list', 'table');
update users set permissions = replace(permissions, 'whitetable', 'whitelist');

alter table users
  modify permissions varchar(50) not null default 'whitelist, table, map, control';