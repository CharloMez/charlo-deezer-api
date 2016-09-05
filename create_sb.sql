SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `deezer-api` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;

USE `deezer-api`;

CREATE TABLE user
(
  user_id int NOT NULL AUTO_INCREMENT,
  name varchar(255),
  email varchar(255),
  PRIMARY KEY (user_id)
);

CREATE TABLE song
(
  song_id int NOT NULL AUTO_INCREMENT,
  name varchar(255),
  duration int,
  PRIMARY KEY (song_id)
);

CREATE TABLE user_song_list
(
  user_song_list_id int NOT NULL AUTO_INCREMENT,
  user_id int NOT NULL,
  song_id int NOT NULL,
  PRIMARY KEY (user_song_list_id),
  FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (song_id) REFERENCES song(song_id) ON DELETE CASCADE ON UPDATE CASCADE,
  UNIQUE KEY (user_id, song_id)
);
