CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR NOT NULL,
    description VARCHAR
);

CREATE TABLE tokens (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    token VARCHAR NOT NULL,
    expiredate DATETIME
);

INSERT INTO users (username,description) VALUES ('test1','info');
INSERT INTO users (username,description) VALUES ('test2','info2');
INSERT INTO users (username,description) VALUES ('test3','info3');