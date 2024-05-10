CREATE TABLE members (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  fio varchar(150) NOT NULL DEFAULT '',
  tel varchar(12) NOT NULL DEFAULT '',
  email varchar(50) NOT NULL DEFAULT '',
  birth varchar(10) NOT NULL DEFAULT '',
  gender varchar(5) NOT NULL DEFAULT '',
  post varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id) 
);

CREATE TABLE events_members (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  id_event int(10) NOT NULL DEFAULT 0,
  id_member int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
);

CREATE TABLE events (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL DEFAULT '',
  city varchar(100) NOT NULL DEFAULT '',
  place varchar(100) NOT NULL DEFAULT '',
  date varchar(10) NOT NULL DEFAULT '',
  time varchar(5) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);

CREATE TABLE cities (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  id_event int(10) NOT NULL DEFAULT 0,
  city varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);