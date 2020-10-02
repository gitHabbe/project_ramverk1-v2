INSERT INTO User ("username", "password") VALUES ("BashLord", "password1");
INSERT INTO Tag ("name") VALUES("asdf");

INSERT INTO Thread ("user_id", "topic", "content") VALUES
    (1, "Help", "Help me with this content"),
    (1, "Another thread", "Thread 2 content")
;

INSERT INTO Comment ("thread_id", "user_id", "name") VALUES
    (1, 2, "Comment 1"),
    (1, 2, "Comment 2")
;

SELECT * FROM User;
SELECT * FROM Thread;