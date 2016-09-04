CREATE DATABASE "deezer-api" IF NOT EXIST;

CREATE TABLE user
(
  user_id int NOT NULL,
  name varchar(255),
  email varchar(255),
  PRIMARY KEY (user_id)
);

CREATE TABLE song
(
  song_id int NOT NULL,
  name varchar(255),
  duration int,
  PRIMARY KEY (song_id)
);

CREATE TABLE user_song_list
(
  user_song_list_id int NOT NULL,
  user_id int NOT NULL,
  song_id int NOT NULL,
  PRIMARY KEY (user_song_list_id),
  FOREIGN KEY (user_id) REFERENCES user(user_id),
  FOREIGN KEY (song_id) REFERENCES song(song_id)
);
