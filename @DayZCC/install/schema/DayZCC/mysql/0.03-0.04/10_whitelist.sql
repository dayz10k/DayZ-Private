alter table profile
  add column guid varchar(32) not null after unique_id;