-- Sample data for 'users' table
INSERT INTO users (type_, info_id)
VALUES
    ('Member', 1),
    ('Member', 2),
    ('Administrator', 3);

-- Sample data for 'user_info' table
INSERT INTO user_info (username, password, user_id)
VALUES
    ('user1', 'password1', 1),
    ('user2', 'password2', 2),
    ('admin', 'adminpass', 3);

-- Sample data for 'member' table
INSERT INTO member (user_id, name, birthday, description, picture, email)
VALUES
    (1, 'John Doe', '1990-05-15', 'Sample description', 'john.jpg', 'john@example.com'),
    (2, 'Jane Smith', '1985-09-22', 'Another description', 'jane.jpg', 'jane@example.com');

-- Sample data for 'friend' table
INSERT INTO friend (member_id, friend_id)
VALUES
    (1, 2),
    (2, 1);

-- Sample data for 'world' table
INSERT INTO world (name, description, picture, owner_id)
VALUES
    ('World 1', 'Sample world description', 'world1.jpg', 1),
    ('World 2', 'Another world description', 'world2.jpg', 2);

-- Sample data for 'world_membership' table
INSERT INTO world_membership (member_id, world_id, is_admin)
VALUES
    (1, 1, true),
    (2, 1, false),
    (2, 2, true);

-- Sample data for 'world_timeline' table
INSERT INTO world_timeline (date_, description, world_id)
VALUES
    ('2023-01-15', 'First event', 1),
    ('2023-02-20', 'Another event', 1);

-- Sample data for 'favorite_world' table
INSERT INTO favorite_world (member_id, world_id)
VALUES
    (1, 1),
    (2, 1);

-- Sample data for 'project' table
INSERT INTO project (name, status, description, picture, world_id)
VALUES
    ('Project 1', 'Active', 'Sample project description', 'project1.jpg', 1),
    ('Project 2', 'Archived', 'Another project description', 'project2.jpg', 1);

-- Sample data for 'project_membership' table
INSERT INTO project_membership (member_id, project_id, permission_level)
VALUES
    (1, 1, 'Project Leader'),
    (2, 1, 'Member');

-- Sample data for 'favorite_project' table
INSERT INTO favorite_project (member_id, project_id)
VALUES
    (1, 1),
    (2, 1);

-- Sample data for 'task' table
INSERT INTO task (title, description, created_at, due_at, status, effort, priority, project_id)
VALUES
    ('Task 1', 'Sample task description', '2023-03-01', '2023-03-10', 'In Progress', 5, 'High', 1),
    ('Task 2', 'Another task description', '2023-03-05', '2023-03-15', 'Upcoming', 3, 'Medium', 1);

-- Sample data for 'assignee' table
INSERT INTO assignee (member_id, task_id)
VALUES
    (1, 1),
    (2, 2);

-- Sample data for 'tag' table
INSERT INTO tag (name)
VALUES
    ('Tag1'),
    ('Tag2');

-- Sample data for 'world_tag' table
INSERT INTO world_tag (tag_id, world_id)
VALUES
    (1, 1),
    (2, 2);

-- Sample data for 'project_tag' table
INSERT INTO project_tag (tag_id, project_id)
VALUES
    (1, 1),
    (2, 2);

-- Sample data for 'member_tag' table
INSERT INTO member_tag (tag_id, member_id)
VALUES
    (1, 1),
    (2, 2);

-- Sample data for 'task_comment' table
INSERT INTO task_comment (content, date_, task_id, member_id)
VALUES
    ('Comment 1', '2023-03-02', 1, 1),
    ('Comment 2', '2023-03-08', 2, 2);

-- Sample data for 'world_comment' table
INSERT INTO world_comment (content, date_, world_id, member_id)
VALUES
    ('Comment for World 1', '2023-03-02', 1, 1),
    ('Comment for World 2', '2023-03-08', 2, 2);

-- Sample data for 'faq_item' table
INSERT INTO faq_item (question, answer)
VALUES
    ('Question 1', 'Answer 1'),
    ('Question 2', 'Answer 2');

-- Sample data for 'notifications' table
INSERT INTO notifications (text, level, world_id, project_id, task_id)
VALUES
    ('Notification 1', 'High', 1, null, null),
    ('Notification 2', 'Medium', null, 1, null);

-- Sample data for 'user_notification' table
INSERT INTO user_notification (notification_id, member_id)
VALUES
    (1, 1),
    (2, 2);