DROP TYPE IF EXISTS permissionLevels CASCADE;
CREATE TYPE permissionLevels AS ENUM ('Member', 'Project Leader', 'World Administrator');
DROP TYPE IF EXISTS notificationLevels CASCADE;
CREATE TYPE notificationLevels AS ENUM ('Low', 'Medium', 'High');




DROP TABLE IF EXISTS Users CASCADE;
CREATE TABLE Users(
  id SERIAL PRIMARY KEY NOT NULL,
  username VARCHAR NOT NULL,
  password VARCHAR NOT NULL,
  createdAt DATE NOT NULL DEFAULT CURRENT_DATE ,
  UNIQUE(username),
  CONSTRAINT ckCreationDate CHECK(createdAt <= CURRENT_DATE)
);


DROP TABLE IF EXISTS Member CASCADE;
CREATE TABLE  Member(
  id INT,
  birthday DATE CHECK(birthday <= CURRENT_DATE),
  description VARCHAR,
  picture VARCHAR NOT NULL,
  email VARCHAR NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (id) REFERENCES Users(id) ON UPDATE CASCADE ON DELETE CASCADE,
  UNIQUE(email)
);


DROP TABLE IF EXISTS Friend CASCADE;
CREATE TABLE Friend(
  memberID INT,
  friendID INT,
  PRIMARY KEY(memberID,friendID),
  FOREIGN KEY(memberID) REFERENCES Users(id) ON UPDATE CASCADE ON DELETE CASCADE ,
  FOREIGN KEY(friendID) REFERENCES Users(id) ON UPDATE CASCADE ON DELETE CASCADE
 
);


DROP TABLE IF EXISTS Administrator CASCADE;
/* Needs a trigger to ensure no delete with 1 admin left*/
CREATE TABLE Administrator(
  id INT,
PRIMARY KEY(id),
    FOREIGN KEY (id) REFERENCES Users(id) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS World CASCADE;
CREATE TABLE World(
  id SERIAL PRIMARY KEY,
  name VARCHAR NOT NULL,
  description VARCHAR,
  createdAt DATE DEFAULT CURRENT_DATE NOT NULL CHECK(createdAt <= CURRENT_DATE),
  ownerID INT,
  FOREIGN KEY (ownerID) REFERENCES Member(id)
);


DROP TABLE IF EXISTS WorldMembership CASCADE;
CREATE TABLE WorldMembership(
  memberID INT,
  worldID INT,
  joinedAt DATE DEFAULT CURRENT_DATE NOT NULL CHECK(joinedAt <= CURRENT_DATE),
  isAdmin BOOLEAN NOT NULL,
  /* I meant this place here:
  pk acho q vai dar syntax error as 2 PKS,
  Also forget the CONSTRAINTS para dar nome , temos que dar nomes unicos que é lixado de nomear*/
  PRIMARY KEY(memberID,worldID),
    FOREIGN KEY (memberID) REFERENCES Member(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (worldID) REFERENCES World(id) ON UPDATE CASCADE ON DELETE CASCADE
);


/*DROP TABLE IF EXISTS WorldOwner;
CREATE TABLE WorldOwner(
memberID INT,
worldID INT,
PRIMARY KEY(memberID,worldID),
FOREIGN KEY (memberID) REFERENCES Member(id) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN KEY(worldID) REFERENCES World(id) ON UPDATE CASCADE ON DELETE CASCADE
);*/


DROP TABLE IF EXISTS WorldTimeline CASCADE;
CREATE TABLE WorldTimeline(
  id INT, /*ID NOT AUTOMATICALLY GENERATED*/
  date_ DATE NOT NULL DEFAULT CURRENT_DATE CHECK(date_ <= CURRENT_DATE),
  description VARCHAR NOT NULL,
  worldID INT,
  PRIMARY KEY(id,worldID),
  FOREIGN KEY(worldID) REFERENCES World(id) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS FavoriteWorld CASCADE;
CREATE TABLE FavoriteWorld(
  memberID INT,
  worldID INT,
  PRIMARY KEY(memberID,worldID),
  FOREIGN KEY(memberID) REFERENCES Member(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(worldID) REFERENCES World(id) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS Project CASCADE;
CREATE TABLE Project(
  id SERIAL PRIMARY KEY,
  title VARCHAR NOT NULL,
  status VARCHAR,
  description VARCHAR,
  createdAt DATE NOT NULL DEFAULT CURRENT_DATE CHECK(createdAt <= CURRENT_DATE),
  worldID INT,
  FOREIGN KEY(worldID) REFERENCES World(id)ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS ProjectMembership CASCADE;
CREATE TABLE ProjectMembership(
  memberID INT,
  projectID INT,
  joinedAt DATE DEFAULT CURRENT_DATE CHECK(joinedAt <= CURRENT_DATE),
  permissionLevel permissionLevels NOT NULL /*CHECK(permissionLevel IN permissionLevels) - isto nao da, n existe maneira de ver se um value pertence a um item de enum aqui a n ser durante a query*/,
  PRIMARY KEY(memberID,projectID),
  FOREIGN KEY(memberID) REFERENCES Member(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(projectID) REFERENCES Project(id) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS FavoriteProject CASCADE;
CREATE TABLE FavoriteProject(
  memberID INT,
  projectID INT,
  PRIMARY KEY(memberID,projectID),
  FOREIGN KEY(memberID) REFERENCES Member(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(projectID) REFERENCES Project(id) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS Task CASCADE;
CREATE TABLE Task(
  id SERIAL PRIMARY KEY,
  title VARCHAR NOT NULL,
  description VARCHAR,
  createdAt DATE NOT NULL DEFAULT CURRENT_DATE CHECK(createdAt<=CURRENT_DATE),
  dueAt DATE CHECK(dueAt >= createdAt),
  status VARCHAR NOT NULL,
  effort INT,
  priority INT,
  projectID INT,
  FOREIGN KEY(projectID) REFERENCES Project(id) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS Assignee CASCADE;
CREATE TABLE Assignee(
  memberID INT,
  taskID INT,
  PRIMARY KEY(memberID,taskID),
  FOREIGN KEY(memberID) REFERENCES Member(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(taskID) REFERENCES Task(id) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS Tag CASCADE;
/* Needs a trigger to ensure by deleting or updating the child ___Tag tables the parent TAG is deleted or updated*/
CREATE TABLE Tag(
  id SERIAL PRIMARY KEY,
  name VARCHAR NOT NULL
);


DROP TABLE IF EXISTS WorldTag CASCADE;
CREATE TABLE WorldTag(
  tagID INT,
  worldID INT,
  PRIMARY KEY(tagID,worldID),
  FOREIGN KEY(tagID) REFERENCES Tag(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(worldID) REFERENCES World(id) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS ProjectTag CASCADE;
CREATE TABLE ProjectTag(
  tagID INT,
  projectID INT,
  PRIMARY KEY(tagID,projectID),
  FOREIGN KEY(tagID) REFERENCES Tag(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(projectID) REFERENCES Project(id) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS MemberTag CASCADE;
CREATE TABLE MemberTag(
  tagID INT,
  memberID INT,
  PRIMARY KEY(tagID,memberID),
  FOREIGN KEY(tagID) REFERENCES Tag(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(memberID) REFERENCES Member(id)ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS Comment CASCADE;
/*Needs a trigger to delete or update when child ___Comment is deleted or updated*/
CREATE TABLE Comment(
  id SERIAL PRIMARY KEY,
  content VARCHAR NOT NULL,
  date_ DATE NOT NULL DEFAULT CURRENT_DATE CHECK(date_ <= CURRENT_DATE)
);


DROP TABLE IF EXISTS TaskComment CASCADE; 
CREATE TABLE TaskComment(
  commentID INT,
  taskID INT NOT NULL,
  memberID INT,
  PRIMARY KEY(commentID),
  FOREIGN KEY(commentID) REFERENCES Comment(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(taskID) REFERENCES Task(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(memberID) REFERENCES Member(id) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS WorldComment CASCADE;
CREATE TABLE WorldComment(
  commentID INT,
  worldID INT NOT NULL,
  memberID INT NOT NULL,
  PRIMARY KEY(commentID),
  FOREIGN KEY(commentID) REFERENCES Comment(id),
  FOREIGN KEY(worldID) REFERENCES World(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(memberID) REFERENCES Member(id) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS FAQItem CASCADE;
CREATE TABLE FAQItem(
  id SERIAL PRIMARY KEY,
  question VARCHAR NOT NULL UNIQUE,
  answer VARCHAR NOT NULL
);


DROP TABLE IF EXISTS Notification CASCADE;
CREATE TABLE Notification(
  id SERIAL PRIMARY KEY,
  text VARCHAR NOT NULL,
  level notificationLevels /* CHECK IF level IN notificationLevels - ask teacher about how to make this approach */,
  date_ DATE DEFAULT CURRENT_DATE
);

DROP FUNCTION IF EXISTS new_log_id();
CREATE FUNCTION new_log_id() RETURNS TRIGGER AS
$BODY$
BEGIN
  NEW.id := (SELECT max() + 1 FROM WorldTimeline WHERE worldID = NEW.worldID);
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;


DROP TRIGGER IF EXISTS new_log_id ON WorldTimeline;
CREATE TRIGGER new_log_id
  BEFORE INSERT ON WorldTimeline
  FOR EACH ROW
  EXECUTE PROCEDURE new_log_id();

DROP FUNCTION IF EXISTS check_world_membership();
CREATE FUNCTION check_world_membership() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NOT EXISTS (SELECT * FROM WorldMembership JOIN Project USING (worldID) WHERE memberID = NEW.memberID AND id = NEW.projectID) THEN
    RAISE EXCEPTION '% DOES NOT BELONG TO PROJECT PARENT', NEW.memberID;
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS check_world_membership ON ProjectMembership;
CREATE TRIGGER check_world_membership
  BEFORE INSERT ON ProjectMembership
  FOR EACH ROW
  EXECUTE PROCEDURE check_world_membership();

DROP FUNCTION IF EXISTS check_project_membership();
CREATE FUNCTION check_project_membership() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NOT EXISTS (SELECT * FROM ProjectMembership JOIN Task USING (projectID) WHERE memberID = NEW.memberID AND id = NEW.taskID) THEN
    RAISE EXCEPTION '% DOES NOT BELONG TO TASK PARENT', NEW.memberID;
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS check_project_membership ON Assignee;
CREATE TRIGGER check_project_membership
  BEFORE INSERT ON Assignee
  FOR EACH ROW
  EXECUTE PROCEDURE check_project_membership();

DROP FUNCTION IF EXISTS check_task_membership();
CREATE FUNCTION check_task_membership() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NOT EXISTS (SELECT * FROM Assignee WHERE memberID = NEW.memberID AND taskID = NEW.taskID) THEN
    RAISE EXCEPTION '% DOES NOT BELONG TO TASK', NEW.memberID;
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS check_task_membership ON TaskComment;
CREATE TRIGGER check_task_membership
  BEFORE INSERT ON TaskComment
  FOR EACH ROW
  EXECUTE PROCEDURE check_task_membership();  

DROP FUNCTION IF EXISTS new_project_log();
CREATE FUNCTION new_project_log() RETURNS TRIGGER AS
$BODY$
BEGIN
  INSERT INTO WorldTimeline(description, worldID)
  VALUES ('NEW PROJECT CREATED: ' || NEW.title, NEW.worldID);
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS new_project_log ON Project;
CREATE TRIGGER new_project_log
  AFTER INSERT ON Project
  FOR EACH ROW
  EXECUTE PROCEDURE new_project_log();
