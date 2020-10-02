

-- DELETE TABLES
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Thread;
DROP TABLE IF EXISTS Tag;
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS Tag_2_Thread;
DROP TABLE IF EXISTS Answer;



-- CREATE USER TABLE
CREATE TABLE User (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "username" TEXT NOT NULL,
    "password" TEXT NOT NULL,
    "qoute" TEXT,
    "gravitar" TEXT,
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
    "points" INTEGER DEFAULT 1,
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
    "points" INTEGER DEFAULT 1,
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "deleted_at" TIMESTAMP DEFAULT NULL,

    -- edited_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY(thread_id) REFERENCES Thread(id),
    FOREIGN KEY(user_id) REFERENCES User(id)
);

-- CREATE TAG_2_THREAD TABLE
CREATE TABLE Tag_2_Thread (
    "id" INTEGER PRIMARY KEY NOT NULL,
    thread_id INTEGER,
    tag_id INTEGER,

    FOREIGN KEY(thread_id) REFERENCES Thread(id),
    FOREIGN KEY(tag_id) REFERENCES Tag(id)
);

-- CREATE ANSWER TABLE
CREATE TABLE Answer (
    "id" INTEGER PRIMARY KEY NOT NULL,
    thread_id INTEGER,
    comment_id INTEGER,

    FOREIGN KEY(thread_id) REFERENCES Thread(id),
    FOREIGN KEY(comment_id) REFERENCES Comment(id)
);


