-- Sample data for the 'users' table
INSERT INTO users (type_) VALUES
    ('Member'),
    ('Administrator'),
    ('Member'),
    ('Member');

-- Sample data for the 'user_info' table
INSERT INTO user_info (username, password, user_id) VALUES
    ('user1', 'password1', 1),
    ('admin1', 'adminpass1', 2),
    ('user2', 'password2', 3),
    ('user3', 'password3', 4);

-- Sample data for the 'member' table
INSERT INTO member (user_id, name, birthday, description, picture, email) VALUES
    (1, 'John Doe', '1990-05-15', 'Member 1 Description', 'image1.jpg', 'user1@example.com'),
    (3, 'Alice Smith', '1985-12-30', 'Member 2 Description', 'image2.jpg', 'user2@example.com'),
    (4, 'Bob Johnson', '1992-08-20', 'Member 3 Description', 'image3.jpg', 'user3@example.com');

-- Sample data for the 'friend' table (assuming members are friends with each other)
INSERT INTO friend (member_id, friend_id) VALUES
    (1, 3),
    (3, 4);

-- Sample data for the 'world' table
INSERT INTO world (name, description, picture, owner_id) VALUES
    ('World 1', 'Description of World 1', 'world_image1.jpg', 1),
    ('World 2', 'Description of World 2', 'world_image2.jpg', 3);

-- Sample data for the 'world_membership' table (assuming members are part of worlds)
INSERT INTO world_membership (member_id, world_id, is_admin) VALUES
    (1, 1, true),
    (3, 1, false),
    (3, 2, true),
    (4, 2, false);

-- Sample data for the 'world_timeline' table
INSERT INTO world_timeline (date_, description, world_id) VALUES
    ('2023-01-01', 'Event in World 1', 1),
    ('2023-02-15', 'Event in World 2', 2);

-- Sample data for the 'favorite_world' table
INSERT INTO favorite_world (member_id, world_id) VALUES
    (1, 2),
    (3, 1);

-- Sample data for the 'project' table
INSERT INTO project (name, status, description, picture, world_id) VALUES
    ('Project 1', 'Active', 'Description of Project 1', 'project_image1.jpg', 1),
    ('Project 2', 'Active', 'Description of Project 2', 'project_image2.jpg', 2);

-- Sample data for the 'project_membership' table (assuming members are part of projects)
INSERT INTO project_membership (member_id, project_id, permission_level) VALUES
    (1, 1, 'Project Leader'),
    (3, 1, 'Member'),
    (3, 2, 'Project Leader'),
    (4, 2, 'Member');

-- Sample data for the 'favorite_project' table
INSERT INTO favorite_project (member_id, project_id) VALUES
    (1, 1),
    (3, 2);

-- Sample data for the 'task' table
INSERT INTO task (title, description, due_at, status, effort, priority, project_id) VALUES
    ('Task 1', 'Description of Task 1', '2024-03-15', 'Upcoming', 5, 'High', 1),
    ('Task 2', 'Description of Task 2', '2024-04-01', 'In Progress', 8, 'Medium', 2);

-- Sample data for the 'assignee' table (assigning tasks to members)
INSERT INTO assignee (member_id, task_id) VALUES
    (1, 1),
    (3, 2);

-- Sample data for the 'tag' table
INSERT INTO tag (name) VALUES
    ('Tag 1'),
    ('Tag 2'),
    ('Tag 3');

-- Sample data for the 'world_tag' table (associating tags with worlds)
INSERT INTO world_tag (tag_id, world_id) VALUES
    (1, 1),
    (2, 1),
    (2, 2);

-- Sample data for the 'project_tag' table (associating tags with projects)
INSERT INTO project_tag (tag_id, project_id) VALUES
    (2, 1),
    (1, 2),
    (3, 2);

-- Sample data for the 'member_tag' table (associating tags with members)
INSERT INTO member_tag (tag_id, member_id) VALUES
    (1, 1),
    (2, 1),
    (2, 3);

-- Sample data for the 'task_comment' table (comments on tasks)
INSERT INTO task_comment (content, date_, task_id, member_id) VALUES
    ('Comment 1 on Task 1', '2023-03-01', 1, 1),
    ('Comment 2 on Task 2', '2023-04-02', 2, 3);

-- Sample data for the 'world_comment' table (comments on worlds)
INSERT INTO world_comment (content, date_, world_id, member_id) VALUES
    ('Comment 1 on World 1', '2023-01-05', 1, 1),
    ('Comment 2 on World 2', '2023-02-20', 2, 3);

-- Sample data for the 'faq_item' table
INSERT INTO faq_item (question, answer) VALUES
    ('FAQ 1 Question', 'FAQ 1 Answer'),
    ('FAQ 2 Question', 'FAQ 2 Answer');

-- Sample data for the 'notifications' table
INSERT INTO notifications (text, level, world_id, project_id, task_id) VALUES
    ('Notification 1', 'Low', 1, NULL, NULL),
    ('Notification 2', 'Medium', NULL, 1, NULL);

-- Sample data for the 'user_notification' table (associating notifications with members)
INSERT INTO user_notification (notification_id, member_id) VALUES
    (1, 1),
    (2, 3);