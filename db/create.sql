	DROP TYPE IF EXISTS permission_levels CASCADE;
	CREATE TYPE permission_levels AS ENUM ('Member', 'Project Leader', 'World Administrator');
	DROP TYPE IF EXISTS notification_levels CASCADE;
	CREATE TYPE notification_levels AS ENUM ('Low', 'Medium', 'High');


	DROP TABLE IF EXISTS users CASCADE;
	CREATE TABLE users(
	  id SERIAL PRIMARY KEY NOT NULL,
	  username VARCHAR NOT NULL,
	  password VARCHAR NOT NULL,
	  created_at DATE NOT NULL DEFAULT CURRENT_DATE ,
	  UNIQUE(username),
	  CONSTRAINT ck_creation_date CHECK(created_at <= CURRENT_DATE)
	);

	DROP TABLE IF EXISTS member CASCADE;
	CREATE TABLE  member(
	  id INT,
	  birthday DATE CHECK(birthday <= CURRENT_DATE),
	  description VARCHAR,
	  picture VARCHAR NOT NULL,
	  email VARCHAR NOT NULL,
	  PRIMARY KEY(id),
	  FOREIGN KEY (id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
	  UNIQUE(email)
	);

	DROP TABLE IF EXISTS friend CASCADE;
	CREATE TABLE friend(
	  member_id INT,
	  friend_id INT,
	  PRIMARY KEY(member_id,friend_id),
	  FOREIGN KEY(member_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE ,
	  FOREIGN KEY(friend_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE 
	);

	DROP TABLE IF EXISTS administrator CASCADE;
	/* Needs a trigger to ensure no delete with 1 admin left*/
	CREATE TABLE administrator(
	  id INT,
	  PRIMARY KEY(id),
	  FOREIGN KEY (id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE
	);


	DROP TABLE IF EXISTS world CASCADE;
	CREATE TABLE world(
	  id SERIAL PRIMARY KEY,
	  name VARCHAR NOT NULL,
	  description VARCHAR,
	  created_at DATE DEFAULT CURRENT_DATE NOT NULL CHECK(created_at <= CURRENT_DATE),
	  owner_id INT,
	  FOREIGN KEY (owner_id) REFERENCES member(id)
	);



	DROP TABLE IF EXISTS world_membership CASCADE;
	CREATE TABLE world_membership(
	  member_id INT,
	  world_id INT,
	  joined_at DATE DEFAULT CURRENT_DATE NOT NULL CHECK(joined_at <= CURRENT_DATE),
	  is_admin BOOLEAN NOT NULL,
	  /* I meant this place here:
	  pk acho q vai dar syntax error as 2 PKS,
	  Also forget the CONSTRAINTS para dar nome , temos que dar nomes unicos que é lixado de nomear*/
	  PRIMARY KEY(member_id,world_id),
	    FOREIGN KEY (member_id) REFERENCES member(id) ON UPDATE CASCADE ON DELETE CASCADE,
	    FOREIGN KEY (world_id) REFERENCES world(id) ON UPDATE CASCADE ON DELETE CASCADE
	);


	/*DROP TABLE IF EXISTS WorldOwner;
	CREATE TABLE WorldOwner(
	memberID INT,
	worldID INT,
	PRIMARY KEY(memberID,worldID),
	FOREIGN KEY (memberID) REFERENCES Member(id) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(worldID) REFERENCES World(id) ON UPDATE CASCADE ON DELETE CASCADE
	);*/


	DROP TABLE IF EXISTS world_timeline CASCADE;
	CREATE TABLE world_timeline(
	  id INT, /*ID NOT AUTOMATICALLY GENERATED*/
	  date_ DATE NOT NULL DEFAULT CURRENT_DATE CHECK(date_ <= CURRENT_DATE),
	  description VARCHAR NOT NULL,
	  world_id INT,
	  PRIMARY KEY(id,world_id),
	  FOREIGN KEY(world_id) REFERENCES World(id) ON UPDATE CASCADE ON DELETE CASCADE
	);

	DROP TABLE IF EXISTS favorite_world CASCADE;
	CREATE TABLE favorite_world(
	  member_id INT,
	  world_id INT,
	  PRIMARY KEY(member_id, world_id),
	  FOREIGN KEY(member_id) REFERENCES member(id) ON UPDATE CASCADE ON DELETE CASCADE,
	  FOREIGN KEY(world_id) REFERENCES world(id) ON UPDATE CASCADE ON DELETE CASCADE
	);

	DROP TABLE IF EXISTS project CASCADE;
	CREATE TABLE project(
	  id SERIAL PRIMARY KEY,
	  title VARCHAR NOT NULL,
	  status VARCHAR,
	  description VARCHAR,
	  created_at DATE NOT NULL DEFAULT CURRENT_DATE CHECK(created_at <= CURRENT_DATE),
	  world_id INT,
	  FOREIGN KEY(world_id) REFERENCES world(id)ON UPDATE CASCADE ON DELETE CASCADE
	);

	DROP TABLE IF EXISTS project_membership CASCADE;
	CREATE TABLE project_membership(
	  member_id INT,
	  project_id INT,
	  joined_at DATE DEFAULT CURRENT_DATE CHECK(joined_at <= CURRENT_DATE),
	  permission_level permission_levels NOT NULL /*CHECK(permissionLevel IN permissionLevels) - isto nao da, n existe maneira de ver se um value pertence a um item de enum aqui a n ser durante a query*/,
	  PRIMARY KEY(member_id,project_id),
	  FOREIGN KEY(member_id) REFERENCES member(id) ON UPDATE CASCADE ON DELETE CASCADE,
	  FOREIGN KEY(project_id) REFERENCES project(id) ON UPDATE CASCADE ON DELETE CASCADE
	);

	DROP TABLE IF EXISTS favorite_project CASCADE;
	CREATE TABLE favorite_project(
	  member_id INT,
	  project_id INT,
	  PRIMARY KEY(member_id, project_id),
	  FOREIGN KEY(member_id) REFERENCES member(id) ON UPDATE CASCADE ON DELETE CASCADE,
	  FOREIGN KEY(project_id) REFERENCES project(id) ON UPDATE CASCADE ON DELETE CASCADE
	);

	DROP TABLE IF EXISTS task CASCADE;
	CREATE TABLE task(
	  id SERIAL PRIMARY KEY,
	  title VARCHAR NOT NULL,
	  description VARCHAR,
	  created_at DATE NOT NULL DEFAULT CURRENT_DATE CHECK(created_at <= CURRENT_DATE),
	  due_at DATE CHECK(due_at >= created_at),
	  status VARCHAR NOT NULL,
	  effort INT,
	  priority INT,
	  project_id INT,
	  FOREIGN KEY(project_id) REFERENCES project(id) ON UPDATE CASCADE ON DELETE CASCADE
	);

	DROP TABLE IF EXISTS assignee CASCADE;
	CREATE TABLE assignee(
	  member_id INT,
	  task_id INT,
	  PRIMARY KEY(member_id, task_id),
	  FOREIGN KEY(member_id) REFERENCES member(id) ON UPDATE CASCADE ON DELETE CASCADE,
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
	  FOREIGN KEY(member_id) REFERENCES member(id)ON UPDATE CASCADE ON DELETE CASCADE
	);

	DROP TABLE IF EXISTS comment CASCADE;
	/*Needs a trigger to delete or update when child ___Comment is deleted or updated*/
	CREATE TABLE comment(
	  id SERIAL PRIMARY KEY,
	  content VARCHAR NOT NULL,
	  date_ DATE NOT NULL DEFAULT CURRENT_DATE CHECK(date_ <= CURRENT_DATE)
	);

	DROP TABLE IF EXISTS task_comment CASCADE; 
	CREATE TABLE task_comment(
	  comment_id INT,
	  task_id INT NOT NULL,
	  member_id INT,
	  PRIMARY KEY(comment_id),
	  FOREIGN KEY(comment_id) REFERENCES comment(id) ON UPDATE CASCADE ON DELETE CASCADE,
	  FOREIGN KEY(task_id) REFERENCES task(id) ON UPDATE CASCADE ON DELETE CASCADE,
	  FOREIGN KEY(member_id) REFERENCES member(id) ON UPDATE CASCADE ON DELETE CASCADE
	);

	DROP TABLE IF EXISTS world_comment CASCADE;
	CREATE TABLE world_comment(
	  comment_id INT,
	  world_id INT NOT NULL,
	  member_id INT NOT NULL,
	  PRIMARY KEY(comment_id),
	  FOREIGN KEY(comment_id) REFERENCES comment(id),
	  FOREIGN KEY(world_id) REFERENCES world(id) ON UPDATE CASCADE ON DELETE CASCADE,
	  FOREIGN KEY(member_id) REFERENCES member(id) ON UPDATE CASCADE ON DELETE CASCADE
	);

	DROP TABLE IF EXISTS faq_item CASCADE;
	CREATE TABLE faq_item(
	  id SERIAL PRIMARY KEY,
	  question VARCHAR NOT NULL UNIQUE,
	  answer VARCHAR NOT NULL
	);

	DROP TABLE IF EXISTS Notification CASCADE;
	CREATE TABLE notification(
	  id SERIAL PRIMARY KEY,
	  text VARCHAR NOT NULL,
	  level notification_levels /* CHECK IF level IN notificationLevels - ask teacher about how to make this approach */,
	  date_ DATE DEFAULT CURRENT_DATE
	);

	DROP FUNCTION IF EXISTS new_log_id() CASCADE;
	CREATE FUNCTION new_log_id() RETURNS TRIGGER AS
	$BODY$
	BEGIN
	  NEW.id := (SELECT max() + 1 FROM world_timeline WHERE world_id = NEW.world_id);
	  RETURN NEW;
	END
	$BODY$
	LANGUAGE plpgsql;


	DROP TRIGGER IF EXISTS new_log_id ON world_timeline CASCADE;
	CREATE TRIGGER new_log_id
	  BEFORE INSERT ON world_timeline
	  FOR EACH ROW
	  EXECUTE PROCEDURE new_log_id();

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
	  IF NOT EXISTS (SELECT * FROM assignee WHERE member_id = NEW.member_id AND task_id = NEW.task_id) THEN
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
	  VALUES ('NEW PROJECT CREATED: ' || NEW.title, NEW.world_id);
	END
	$BODY$
	LANGUAGE plpgsql;

	DROP TRIGGER IF EXISTS new_project_log ON project CASCADE;
	CREATE TRIGGER new_project_log
	  AFTER INSERT ON project
	  FOR EACH ROW
	  EXECUTE PROCEDURE new_project_log();
	 
	DROP FUNCTION IF EXISTS check_admin();
	CREATE FUNCTION check_admin() RETURNS TRIGGER AS 
	$BODY$
	BEGIN
	  IF (SELECT count(*) FROM administrator) < 2 THEN 
	    RAISE EXCEPTION 'Cannot delete when there is only 1 admin';
	  END IF;
	  RETURN NEW;
	END
	$BODY$
	LANGUAGE plpgsql;
	
	DROP TRIGGER IF EXISTS do_nothing_admin ON administrator;
	CREATE TRIGGER do_nothing_admin
	  BEFORE DELETE ON Administrator
	  FOR EACH ROW
	  EXECUTE PROCEDURE check_admin();

	  
	 

	 

