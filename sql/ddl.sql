

-- DELETE TABLES
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Thread;
DROP TABLE IF EXISTS Tag;
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS Tag_2_Thread;
DROP TABLE IF EXISTS Point_2_Thread;
DROP TABLE IF EXISTS Point_2_Comment;
DROP TABLE IF EXISTS Answer;
DROP TABLE IF EXISTS Point_2_User;
DROP TRIGGER IF EXISTS update_user_and_thread_points;
DROP TRIGGER IF EXISTS update_user_and_comment_points;



-- CREATE USER TABLE
CREATE TABLE User (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "username" TEXT NOT NULL,
    "password" TEXT NOT NULL,
    "quote" TEXT,
    "gravatar" TEXT,
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "deleted_at" TIMESTAMP DEFAULT NULL

    -- edited_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
);

-- CREATE THREAD TABLE
CREATE TABLE Thread (
    "id" INTEGER PRIMARY KEY NOT NULL,
    user_id INTEGER,
    "topic" TEXT NOT NULL,
    "content" TEXT NOT NULL,
    "points" INTEGER DEFAULT 0,
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "deleted_at" TIMESTAMP DEFAULT NULL,

    -- edited_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,


    FOREIGN KEY(user_id) REFERENCES User(id)
);

-- CREATE TAG TABLE
CREATE TABLE Tag (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "name" TEXT NOT NULL,
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CREATE COMMENT TABLE
CREATE TABLE Comment (
    "id" INTEGER PRIMARY KEY NOT NULL,
    thread_id INTEGER,
    user_id INTEGER,
    "name" TEXT NOT NULL,
    "points" INTEGER DEFAULT 0,
    "reply_num" INTEGER DEFAULT 0,
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "deleted_at" TIMESTAMP DEFAULT NULL,

    -- edited_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY(thread_id) REFERENCES Thread(id),
    FOREIGN KEY(user_id) REFERENCES User(id)
);

-- CREATE TAG_2_THREAD TABLE
CREATE TABLE Tag_2_Thread (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "thread_id" INTEGER,
    "tag_id" INTEGER,

    FOREIGN KEY(thread_id) REFERENCES Thread(id),
    FOREIGN KEY(tag_id) REFERENCES Tag(id)
);

-- CREATE POINT_2_THREAD TABLE
CREATE TABLE Point_2_Thread (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "positive" INTEGER,
    thread_id INTEGER,
    user_id INTEGER,

    FOREIGN KEY(thread_id) REFERENCES Thread(id),
    FOREIGN KEY(user_id) REFERENCES User(id)
);

-- CREATE POINT_2_COMMENT TABLE
CREATE TABLE Point_2_Comment (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "positive" INTEGER,
    comment_id INTEGER,
    user_id INTEGER,

    FOREIGN KEY(comment_id) REFERENCES Comment(id),
    FOREIGN KEY(user_id) REFERENCES User(id)
);

-- CREATE POINT_2_COMMENT TABLE
CREATE TABLE Point_2_User (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "amount" INTEGER,
    user_id INTEGER,

    FOREIGN KEY(user_id) REFERENCES User(id)
);

-- CREATE ANSWER TABLE
CREATE TABLE Answer (
    "id" INTEGER PRIMARY KEY NOT NULL,
    thread_id INTEGER,
    comment_id INTEGER,

    FOREIGN KEY(thread_id) REFERENCES Thread(id),
    FOREIGN KEY(comment_id) REFERENCES Comment(id)
);


-- TRIGGERS

CREATE TRIGGER IF NOT EXISTS update_user_and_thread_points
AFTER INSERT ON Thread
BEGIN
    INSERT INTO Point_2_User ("amount", "user_id")
    VALUES (5, NEW.user_id);

    UPDATE Thread
    SET points = 1
    WHERE id = NEW.id;

    INSERT INTO Point_2_Thread ("positive", "thread_id", "user_id")
    VALUES (1, NEW.id, NEW.user_id);
END;

CREATE TRIGGER IF NOT EXISTS update_user_and_comment_points
AFTER INSERT ON Comment
BEGIN
    INSERT INTO Point_2_User ("amount", "user_id")
    VALUES (3, NEW.user_id);

    UPDATE Comment
    SET points = 1
    WHERE id = NEW.id;

    INSERT INTO Point_2_Comment ("positive", "comment_id", "user_id")
    VALUES (1, NEW.id, NEW.user_id);
END;