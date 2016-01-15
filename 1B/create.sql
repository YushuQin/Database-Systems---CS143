
# set id to the primary key

create table Movie (
id int NOT NULL,
title VARCHAR(100) NOT NULL,
year int NOT NULL,
rating VARCHAR(10),
company VARCHAR(50),
PRIMARY KEY (id)
)ENGINE = INNODB;

# set id to the primary key
# check that sex is male or female
CREATE TABLE Actor(
	id INT NOT NULL,
	last VARCHAR(20) NOT NULL,
	first VARCHAR(20) NOT NULL,
	sex VARCHAR(6) NOT NULL,
	dob date NOT NULL,
	dod date,
	PRIMARY KEY (id),
	CHECK (sex = 'Female' OR sex = 'Male')
) ENGINE=INNODB;

# set id to the primary key

CREATE TABLE Director(
	id int NOT NULL,
	last varchar(20) NOT NULL,
	first varchar(20) NOT NULL,
	dob date NOT NULL,
	dod date,
	PRIMARY KEY (id)
) ENGINE=INNODB;


CREATE TABLE MovieActor(
	mid int NOT NULL,
	aid int NOT NULL,
	role varchar(50),
	FOREIGN KEY (mid) references Movie(id),
	FOREIGN KEY (aid) references Actor(id)
) ENGINE=INNODB;


CREATE TABLE MovieDirector(
	mid int NOT NULL,
	did int NOT NULL,
	FOREIGN KEY (mid) references Movie(id),
	FOREIGN KEY (did) references Director(id)
) ENGINE=INNODB;


CREATE TABLE MovieGenre(
	mid int NOT NULL,
	genre varchar(20) NOT NULL,
	FOREIGN KEY (mid) references Movie(id)
) ENGINE=INNODB;


CREATE TABLE Review(
	name varchar(20) NOT NULL,
	time timestamp NOT NULL,
	mid int NOT NULL,
	rating int NOT NULL,
	comment varchar(500),
	FOREIGN KEY (mid) references Movie(id),
	CHECK (rating >=0 AND rating <= 5)
) ENGINE=INNODB;


CREATE TABLE MaxPersonID(
	id int NOT NULL
) ENGINE=INNODB;


CREATE TABLE MaxMovieID(
	id int NOT NULL
) ENGINE=INNODB;