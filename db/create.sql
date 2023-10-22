DROP TYPE IF EXISTS permission_levels CASCADE;
CREATE TYPE permission_levels AS ENUM ('Member', 'Project Leader', 'World Administrator');
DROP TYPE IF EXISTS notification_levels CASCADE;
CREATE TYPE notification_levels AS ENUM ('Low', 'Medium', 'High');
DROP TYPE IF EXISTS project_status CASCADE;
CREATE TYPE project_status AS ENUM ('Active', 'Archived');
DROP TYPE IF EXISTS user_type CASCADE;
CREATE TYPE user_type AS ENUM ('Member', 'Administrator', 'Blocked', 'Deleted');
DROP TYPE IF EXISTS task_status CASCADE;
CREATE TYPE task_status AS ENUM ('BackLog', 'Upcoming', 'In Progress', 'Finalizing', 'Done');


DROP TABLE IF EXISTS users CASCADE;
/* Needs a trigger to ensure no delete with 1 admin left*/
CREATE TABLE users(
  id SERIAL PRIMARY KEY,
  created_at DATE NOT NULL DEFAULT CURRENT_DATE,
  type_ user_type NOT NULL,
  CONSTRAINT ck_creation_date CHECK(created_at <= CURRENT_DATE)
);


DROP TABLE IF EXISTS user_info CASCADE;
CREATE TABLE user_info(
  id SERIAL PRIMARY KEY,
  username VARCHAR NOT NULL,
  password VARCHAR NOT NULL,
  user_id INT,
  UNIQUE(username),
  FOREIGN KEY(user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS member CASCADE;
CREATE TABLE  member(
  user_id SERIAL PRIMARY KEY,
  name VARCHAR NOT NULL,
  birthday DATE CHECK(birthday <= CURRENT_DATE),
  description VARCHAR,
  picture VARCHAR NOT NULL,
  email VARCHAR NOT NULL,
  UNIQUE(email),
  FOREIGN KEY(user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS friend CASCADE;
CREATE TABLE friend(
  member_id INT,
  friend_id INT,
  PRIMARY KEY(member_id,friend_id),
  FOREIGN KEY(member_id) REFERENCES member(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(friend_id) REFERENCES member(user_id) ON UPDATE CASCADE ON DELETE CASCADE 
);


DROP TABLE IF EXISTS world CASCADE;
CREATE TABLE world(
  id SERIAL PRIMARY KEY,
  name VARCHAR NOT NULL,
  description VARCHAR,
  created_at DATE DEFAULT CURRENT_DATE NOT NULL CHECK(created_at <= CURRENT_DATE),
  picture VARCHAR NOT NULL,
  owner_id INT NOT NULL,
  FOREIGN KEY(owner_id) REFERENCES member(user_id)
);



DROP TABLE IF EXISTS world_membership CASCADE;
CREATE TABLE world_membership(
  member_id INT,
  world_id INT,
  joined_at DATE DEFAULT CURRENT_DATE NOT NULL CHECK(joined_at <= CURRENT_DATE),
  is_admin BOOLEAN NOT NULL,
  PRIMARY KEY(member_id,world_id),
  FOREIGN KEY (member_id) REFERENCES member(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (world_id) REFERENCES world(id) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS world_timeline CASCADE;
CREATE TABLE world_timeline(
  id SERIAL PRIMARY KEY, /*ID NOT AUTOMATICALLY GENERATED*/
  date_ DATE NOT NULL DEFAULT CURRENT_DATE CHECK(date_ <= CURRENT_DATE),
  description VARCHAR NOT NULL,
  world_id INT,
  FOREIGN KEY(world_id) REFERENCES World(id)
);

DROP TABLE IF EXISTS favorite_world CASCADE;
CREATE TABLE favorite_world(
  member_id INT,
  world_id INT,
  PRIMARY KEY(member_id, world_id),
  FOREIGN KEY(member_id) REFERENCES member(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(world_id) REFERENCES world(id) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS project CASCADE;
CREATE TABLE project(
  id SERIAL PRIMARY KEY,
  name VARCHAR NOT NULL,
  status project_status NOT NULL,
  description VARCHAR,
  created_at DATE NOT NULL DEFAULT CURRENT_DATE CHECK(created_at <= CURRENT_DATE),
  picture VARCHAR NOT NULL,
  world_id INT,
  FOREIGN KEY(world_id) REFERENCES world(id) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS project_membership CASCADE;
CREATE TABLE project_membership(
  member_id INT,
  project_id INT,
  joined_at DATE DEFAULT CURRENT_DATE NOT NULL CHECK(joined_at <= CURRENT_DATE),
  permission_level permission_levels NOT NULL,
  PRIMARY KEY(member_id,project_id),
  FOREIGN KEY(member_id) REFERENCES member(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(project_id) REFERENCES project(id) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS favorite_project CASCADE;
CREATE TABLE favorite_project(
  member_id INT,
  project_id INT,
  PRIMARY KEY(member_id, project_id),
  FOREIGN KEY(member_id) REFERENCES member(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(project_id) REFERENCES project(id) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS task CASCADE;
CREATE TABLE task(
  id SERIAL PRIMARY KEY,
  title VARCHAR NOT NULL,
  description VARCHAR,
  created_at DATE NOT NULL DEFAULT CURRENT_DATE CHECK(created_at <= CURRENT_DATE),
  due_at DATE CHECK(due_at >= created_at),
  status task_status NOT NULL,
  effort INT CHECK(effort >= 0),
  priority VARCHAR,
  project_id INT,
  FOREIGN KEY(project_id) REFERENCES project(id) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS assignee CASCADE;
CREATE TABLE assignee(
  member_id INT,
  task_id INT,
  PRIMARY KEY(member_id, task_id),
  FOREIGN KEY(member_id) REFERENCES member(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(task_id) REFERENCES task(id) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS tag CASCADE;
/* Needs a trigger to ensure by deleting or updating the child ___Tag tables the parent TAG is deleted or updated*/
CREATE TABLE tag(
  id SERIAL PRIMARY KEY,
  name VARCHAR NOT NULL
);

DROP TABLE IF EXISTS world_tag CASCADE;
CREATE TABLE world_tag(
  tag_id INT,
  world_id INT,
  PRIMARY KEY(tag_id, world_id),
  FOREIGN KEY(tag_id) REFERENCES tag(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(world_id) REFERENCES world(id) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS project_tag CASCADE;
CREATE TABLE project_tag(
  tag_id INT,
  project_id INT,
  PRIMARY KEY(tag_id, project_id),
  FOREIGN KEY(tag_id) REFERENCES tag(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(project_id) REFERENCES project(id) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS member_tag CASCADE;
CREATE TABLE member_tag(
  tag_id INT,
  member_id INT,
  PRIMARY KEY(tag_id, member_id),
  FOREIGN KEY(tag_id) REFERENCES tag(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(member_id) REFERENCES member(user_id) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS task_comment CASCADE; 
CREATE TABLE task_comment(
  id SERIAL PRIMARY KEY,
  content VARCHAR NOT NULL,
  date_ DATE NOT NULL DEFAULT CURRENT_DATE CHECK(date_ <= CURRENT_DATE),
  task_id INT NOT NULL,
  member_id INT NOT NULL,
  FOREIGN KEY(task_id) REFERENCES task(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(member_id) REFERENCES member(user_id) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS world_comment CASCADE;
CREATE TABLE world_comment(
  id SERIAL PRIMARY KEY,
  content VARCHAR NOT NULL,
  date_ DATE NOT NULL DEFAULT CURRENT_DATE CHECK(date_ <= CURRENT_DATE),
  world_id INT NOT NULL,
  member_id INT,
  FOREIGN KEY(world_id) REFERENCES world(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(member_id) REFERENCES member(user_id) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS faq_item CASCADE;
CREATE TABLE faq_item(
  id SERIAL PRIMARY KEY,
  question VARCHAR NOT NULL,
  answer VARCHAR NOT NULL,
  UNIQUE(question)
);

DROP TABLE IF EXISTS notifications CASCADE;
CREATE TABLE notifications(
  id SERIAL PRIMARY KEY,
  text VARCHAR NOT NULL,
  level notification_levels,
  date_ DATE DEFAULT CURRENT_DATE,
  world_id INT DEFAULT NULL,
  project_id INT DEFAULT NULL,
  task_id INT DEFAULT NULL,
  FOREIGN KEY(world_id) REFERENCES world(id),
  FOREIGN KEY(project_id) REFERENCES project(id),
  FOREIGN KEY(task_id) REFERENCES task(id)
);

DROP TABLE IF EXISTS user_notification CASCADE;
CREATE TABLE user_notification(
  notification_id INT,
  member_id INT,
  PRIMARY KEY(notification_id, member_id),
  FOREIGN KEY(notification_id) REFERENCES notifications(id),
  FOREIGN KEY(member_id) REFERENCES member(user_id)
);


/**  TRIGGERS  **/
DROP FUNCTION IF EXISTS check_world_membership() CASCADE;
CREATE FUNCTION check_world_membership() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NOT EXISTS (SELECT * FROM world_membership JOIN project USING (world_id) WHERE member_id = NEW.member_id AND id = NEW.project_id) THEN
  RAISE EXCEPTION '% DOES NOT BELONG TO PROJECT PARENT', NEW.member_id;
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS check_world_membership ON project_membership CASCADE;
CREATE TRIGGER check_world_membership
  BEFORE INSERT ON project_membership
  FOR EACH ROW
  EXECUTE PROCEDURE check_world_membership();


DROP FUNCTION IF EXISTS check_project_membership() CASCADE;
CREATE FUNCTION check_project_membership() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NOT EXISTS (SELECT * FROM project_membership JOIN task USING (project_id) WHERE member_id = NEW.member_id AND id = NEW.task_id) THEN
  RAISE EXCEPTION '% DOES NOT BELONG TO TASK PARENT', NEW.member_id;
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS check_project_membership ON assignee CASCADE;
CREATE TRIGGER check_project_membership
  BEFORE INSERT ON assignee
  FOR EACH ROW
  EXECUTE PROCEDURE check_project_membership();


DROP FUNCTION IF EXISTS check_task_membership() CASCADE;
CREATE FUNCTION check_task_membership() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NOT EXISTS (SELECT * FROM (assignee a JOIN task t ON t.id = a.task_id) JOIN project_membership m USING (project_id) WHERE a.member_id = NEW.member_id AND a.task_id = NEW.task_id AND (m.member_id = NEW.member_id OR m.permission_level = 'Project Leader')) THEN
  RAISE EXCEPTION '% DOES NOT BELONG TO TASK', NEW.member_id;
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS check_task_membership ON task_comment CASCADE;
CREATE TRIGGER check_task_membership
  BEFORE INSERT ON task_comment
  FOR EACH ROW
  EXECUTE PROCEDURE check_task_membership();  


DROP FUNCTION IF EXISTS new_project_log() CASCADE;
CREATE FUNCTION new_project_log() RETURNS TRIGGER AS
$BODY$
BEGIN
  INSERT INTO world_timeline(description, world_id)
  VALUES ('NEW PROJECT CREATED: ' || NEW.name, NEW.world_id);
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS new_project_log ON project CASCADE;
CREATE TRIGGER new_project_log
  AFTER INSERT ON project
  FOR EACH ROW
  EXECUTE PROCEDURE new_project_log();


DROP FUNCTION IF EXISTS archived_project_log() CASCADE;
CREATE FUNCTION archived_project_log() RETURNS TRIGGER AS
$BODY$
BEGIN
  INSERT INTO world_timeline(description, world_id)
  VALUES ('PROJECT ARCHIVED: ' || NEW.name, NEW.world_id);
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS archived_project_log ON project CASCADE;
CREATE TRIGGER archived_project_log
  AFTER UPDATE ON project
  FOR EACH ROW
  WHEN (NEW.status = 'Archived')
  EXECUTE PROCEDURE archived_project_log();


DROP FUNCTION IF EXISTS world_admin_log() CASCADE;
CREATE FUNCTION world_admin_log() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NEW.is_admin = TRUE AND (TG_OP = 'INSERT' OR TG_OP = 'UPDATE' AND old.is_admin = FALSE) THEN 
  INSERT INTO world_timeline(description, world_id)
  VALUES ('NEW ADMINISTRATOR: ' || (SELECT username FROM world_membership JOIN user_info ON id = member_id WHERE member_id = NEW.member_id AND world_id = NEW.world_id), NEW.world_id);
  END IF;
  IF TG_OP = 'UPDATE' AND OLD.is_admin = TRUE AND NEW.is_admin = FALSE THEN
  INSERT INTO world_timeline(description, world_id)
  VALUES ('ADMINISTRATOR DEMOTED: ' || (SELECT username FROM world_membership JOIN user_info ON id = member_id WHERE member_id = NEW.member_id AND world_id = NEW.world_id), NEW.world_id);
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS world_admin_log ON project CASCADE;
CREATE TRIGGER world_admin_log
  AFTER UPDATE OR INSERT ON world_membership
  FOR EACH ROW
  EXECUTE PROCEDURE world_admin_log();


DROP FUNCTION IF EXISTS check_admin() CASCADE;
CREATE FUNCTION check_admin() RETURNS TRIGGER AS 
$BODY$
BEGIN
  IF (SELECT COUNT(*) FROM users WHERE type_='Administrator') < 2 THEN 
  RAISE EXCEPTION 'Cannot delete when there is only 1 admin';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS check_admin ON users CASCADE;
CREATE TRIGGER check_admin
  BEFORE DELETE ON users
  FOR EACH ROW
  EXECUTE PROCEDURE check_admin();


DROP FUNCTION IF EXISTS delete_notification() CASCADE;
CREATE FUNCTION delete_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NOT EXISTS (SELECT * FROM user_notification WHERE notification_id = OLD.notification_id) THEN
  DELETE FROM notifications WHERE id = OLD.notification_id;
  END IF;
  RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS delete_notification ON user_notification CASCADE; 
CREATE TRIGGER delete_notification
  AFTER DELETE ON user_notification
  FOR EACH ROW
  EXECUTE PROCEDURE delete_notification();

DROP INDEX IF EXISTS task_project CASCADE;
CREATE INDEX task_project ON task USING hash (project_id);

DROP INDEX IF EXISTS project_world CASCADE;
CREATE INDEX project_world ON project USING hash (world_id);

DROP INDEX IF EXISTS member_world CASCADE;
CREATE INDEX member_world ON world_membership USING hash (member_id);

ALTER TABLE world ADD COLUMN tsvectors TSVECTOR;

DROP FUNCTION IF EXISTS world_search_update() CASCADE;
CREATE FUNCTION world_search_update() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
            setweight(to_tsvector('english', NEW.name), 'A') ||
            setweight(to_tsvector('english', NEW.description), 'B')
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.name <> OLD.name OR NEW.obs <> OLD.obs) THEN
            NEW.tsvectors = (
                setweight(to_tsvector('english', NEW.name), 'A') ||
                setweight(to_tsvector('english', NEW.description), 'B')
            );
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS world_search_update ON world CASCADE;
CREATE TRIGGER world_search_update
  BEFORE INSERT OR UPDATE ON world
  FOR EACH ROW
  EXECUTE PROCEDURE world_search_update();

DROP INDEX IF EXISTS world_search_idx CASCADE;
CREATE INDEX world_search_idx ON world USING GIN (tsvectors);

ALTER TABLE task ADD COLUMN tsvectors TSVECTOR;

DROP FUNCTION IF EXISTS task_search_update() CASCADE;
CREATE FUNCTION task_search_update() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
            setweight(to_tsvector('english', NEW.title), 'A') ||
            setweight(to_tsvector('english', NEW.description),'B')
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.name <> OLD.name OR NEW.obs <> OLD.obs) THEN
            NEW.tsvectors = (
                setweight(to_tsvector('english', NEW.title), 'A') ||
                setweight(to_tsvector('english', NEW.description), 'B')
            );
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS task_search_update ON task CASCADE;
CREATE TRIGGER task_search_update
  BEFORE INSERT OR UPDATE ON task
  FOR EACH ROW
  EXECUTE PROCEDURE task_search_update();

DROP INDEX IF EXISTS task_search_idx CASCADE;
CREATE INDEX task_search_idx ON task USING GIN (tsvectors);