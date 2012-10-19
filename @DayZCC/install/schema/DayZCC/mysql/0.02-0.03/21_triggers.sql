create trigger trig_feed before update on survivor for each row
begin
    IF NEW.survivor_kills > OLD.survivor_kills THEN INSERT INTO log_kills (`id`,`unique_id`,`name`,`pos`,`created`,`code`) VALUES (NEW.id,NEW.unique_id,(select name from profile where unique_id = NEW.unique_id limit 1),NEW.pos,now(),1); END IF; 
    IF NEW.bandit_kills > OLD.bandit_kills THEN INSERT INTO log_kills (`id`,`unique_id`,`name`,`pos`,`created`,`code`) VALUES (NEW.id,NEW.unique_id,(select name from profile where unique_id = NEW.unique_id limit 1),NEW.pos,now(),2); END IF; 
    IF NEW.is_dead = 1 AND OLD.is_dead = 0 THEN INSERT INTO log_kills (`id`,`unique_id`,`name`,`pos`,`created`,`code`) VALUES (NEW.id,NEW.unique_id,(select name from profile where unique_id = NEW.unique_id limit 1),NEW.pos,now(),3); END IF; 
end