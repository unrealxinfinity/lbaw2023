-- Sample data for the 'member' table
INSERT INTO member (username, password, birthday, description, picture, email)
VALUES
  ('user1', 'password1', '1990-01-15', 'Sample description 1', 'user1.jpg', 'user1@example.com'),
  ('user2', 'password2', '1985-04-22', 'Sample description 2', 'user2.jpg', 'user2@example.com'),
  ('user3', 'password3', '1992-09-10', 'Sample description 3', 'user3.jpg', 'user3@example.com');

-- Sample data for the 'world' table
INSERT INTO world (name, description, owner_id)
VALUES
  ('World 1', 'Sample world description 1', 1),
  ('World 2', 'Sample world description 2', 2);

-- Sample data for the 'world_membership' table
INSERT INTO world_membership (member_id, world_id, is_admin, joined_at)
VALUES
  (1, 1, true, '2023-01-01'),
  (2, 1, false, '2023-01-02'),
  (2, 2, true, '2023-01-01');

-- Sample data for the 'world_timeline' table
INSERT INTO world_timeline (date_, description, world_id)
VALUES
  ('2023-01-03', 'World 1 timeline event 1', 1),
  ('2023-01-04', 'World 1 timeline event 2', 1);

-- Sample data for the 'project' table
INSERT INTO project (title, status, description, world_id)
VALUES
  ('Project 1', 'In Progress', 'Sample project description 1', 1),
  ('Project 2', 'Completed', 'Sample project description 2', 2);

-- Sample data for the 'project_membership' table
INSERT INTO project_membership (member_id, project_id, permission_level, joined_at)
VALUES
  (1, 1, 'Member', '2023-01-01'),
  (2, 1, 'Project Leader', '2023-01-02'),
  (2, 2, 'Member', '2023-01-01');

-- Sample data for the 'task' table
INSERT INTO task (title, description, due_at, status, effort, priority, project_id)
VALUES
  ('Task 1', 'Sample task description 1', '2024-01-15', 'In Progress', 3, 'High', 1),
  ('Task 2', 'Sample task description 2', '2024-01-20', 'Completed', 2, 'Medium', 1),
  ('Task 3', 'Sample task description 3', '2024-01-10', 'New', 1, 'Low', 2);
  
INSERT INTO assignee (task_id, member_id)
VALUES
  (1, 1),
  (1, 2);

-- Sample data for the 'tag' table
INSERT INTO tag (name)
VALUES
  ('Tag 1'),
  ('Tag 2'),
  ('Tag 3');

-- Sample data for the 'world_tag' table
INSERT INTO world_tag (tag_id, world_id)
VALUES
  (1, 1),
  (2, 1);

-- Sample data for the 'project_tag' table
INSERT INTO project_tag (tag_id, project_id)
VALUES
  (2, 1),
  (3, 2);

-- Sample data for the 'member_tag' table
INSERT INTO member_tag (tag_id, member_id)
VALUES
  (1, 1),
  (1, 2);

-- Sample data for the 'task_comment' table
INSERT INTO task_comment (content, date_, task_id, member_id)
VALUES
  ('Comment 1 on Task 1', '2023-01-05', 1, 1),
  ('Comment 2 on Task 1', '2023-01-07', 1, 2);

-- Sample data for the 'world_comment' table
INSERT INTO world_comment (content, date_, world_id, member_id)
VALUES
  ('Comment 1 on World 1', '2023-01-10', 1, 1),
  ('Comment 2 on World 1', '2023-01-12', 1, 2);

-- Sample data for the 'faq_item' table
INSERT INTO faq_item (question, answer)
VALUES
  ('FAQ Question 1', 'FAQ Answer 1'),
  ('FAQ Question 2', 'FAQ Answer 2');

-- Sample data for the 'notifications' table
INSERT INTO notifications (text, level)
VALUES
  ('Notification 1', 'Low'),
  ('Notification 2', 'Medium');

-- Sample data for the 'user_notification' table
INSERT INTO user_notification (notification_id, member_id)
VALUES
  (1, 1),
  (2, 2);