CREATE TABLE application (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(128) NOT NULL DEFAULT '',
  year int(10) NOT NULL DEFAULT 0,
  ability_god int(1) NOT NULL DEFAULT 0,
  ability_fly int(1) NOT NULL DEFAULT 0,
  ability_idclip int(1) NOT NULL DEFAULT 0,
  ability_fireball int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
);

--  мои базы данных

CREATE TABLE users (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  fio varchar(150) NOT NULL DEFAULT '',
  tel varchar(12) NOT NULL DEFAULT '',
  email varchar(40) NOT NULL DEFAULT '',
  birth varchar(30) NOT NULL DEFAULT '',
  gender varchar(10) NOT NULL DEFAULT '',
  biography varchar(200) NOT NULL DEFAULT '',
  checkBut BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (id)
);

CREATE TABLE users_languages (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  id_user int(10) NOT NULL DEFAULT 0,
  id_lang varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);

CREATE TABLE languages (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);

