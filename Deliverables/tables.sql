SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS applicant CASCADE;
DROP TABLE IF EXISTS degree CASCADE;
DROP TABLE IF EXISTS examScore CASCADE;
DROP TABLE IF EXISTS recs CASCADE;
DROP TABLE IF EXISTS faculty CASCADE;
DROP TABLE IF EXISTS recReview CASCADE;
DROP TABLE IF EXISTS reviewForm CASCADE;

CREATE TABLE users (
  ssn int UNIQUE,
  username varchar(25) PRIMARY KEY,
  email varchar(35),
  birthDate date,
  userPassword varchar(25),
  gwid int UNIQUE AUTO_INCREMENT,
  fname varchar(256),
  lname varchar(256),
  userAddress varchar(256)
);

CREATE TABLE applicant (
  gwid int PRIMARY KEY,
  aoi varchar(256),
  appExp varchar(256),
  degProgram varchar(40),
  appStatus int,
  transcript bool,
  admissionYear year,
  admissionSemester varchar(10),
  FOREIGN KEY (gwid) REFERENCES users (gwid)
);

CREATE TABLE degree (
  gwid int,
  degType varchar(3),
  school varchar(256),
  gpa decimal(3,2),
  major varchar(256),
  yearGrad year,
  PRIMARY KEY (gwid, degType, major),
  FOREIGN KEY (gwid) REFERENCES applicant (gwid)
);

CREATE TABLE examScore (
  gwid int,
  examSubject varchar(256),
  score int,
  yearTake year,
  PRIMARY KEY (gwid, examSubject),
  FOREIGN KEY (gwid) REFERENCES applicant (gwid)
);

CREATE TABLE recs (
  gwid int,
  recId int AUTO_INCREMENT,
  recName varchar(50),
  job varchar(40),
  relation varchar(20),
  email varchar(32),
  content varchar(255),
  org varchar(30),
  PRIMARY KEY (recId),
  FOREIGN KEY (gwid) REFERENCES applicant (gwid)
);

CREATE TABLE faculty (
  gwid int PRIMARY KEY,
  facultyType varchar(4),
  yearsWorking int,
  department varchar(30),
  FOREIGN KEY (gwid) REFERENCES users (gwid)
);

CREATE TABLE recReview (
  gwid int,
  studentGwid int,
  recId int,
  rating int,
  generic bool,
  credible bool,
  PRIMARY KEY (gwid, studentGwid, recId),
  FOREIGN KEY (gwid) REFERENCES reviewForm (gwid),
  FOREIGN KEY (studentGwid) REFERENCES reviewForm (studentGwid)
);

CREATE TABLE reviewForm (
  gwid int,
  studentGwid int,
  missingC varchar(50),
  gas int,
  gasComm varchar(255),
  reasonReject char,
  PRIMARY KEY (gwid, studentGwid),
  FOREIGN KEY (gwid) REFERENCES faculty (gwid),
  FOREIGN KEY (studentGwid) REFERENCES applicant (gwid)
);

SET FOREIGN_KEY_CHECKS = 1;

insert into users (fname, lname, gwid, username, userPassword) values ('Bhagirath', 'Narahari', 1, 'bnarahari', '9876');
insert into users (fname, lname, gwid, username, userPassword) values ('Heller', 'Wood', 2, 'hwood', 'abcd');
insert into users (fname, lname, gwid, username, userPassword) values ('Nicole', 'Campagna', 3, 'ncampagna', '1111');
insert into users (fname, lname, gwid, username, userPassword) values ('Alyssa', 'Ilaria', 4, 'ailaria', '2222');
insert into users (fname, lname, gwid, username, userPassword) values ('Ethan', 'Baron', 5, 'ebaron', '3333');

insert into faculty values (1, 0, 15, 'CS');
insert into faculty values (2, 0, 20, 'CS');
insert into faculty values (3, 1, 2, 'CS');
insert into faculty (gwid, facultyType) values (4, 2);
insert into faculty (gwid, facultyType) values (5, 3);

insert into users values (111111111, 'jlennon', 'jlennon@gmail.com', '1940-10-09', '1234', 55555555, 'John', 'Lennon', '72nd St & Central Park West, New York, NY, 10023');

insert into applicant values (55555555, 'Music', 'Member of The Beatles, formerly', 'md', 2, 1, 2021, 'spring');

insert into degree values (55555555, 'BA', 'Berkley', '4.0', 'Boyband', 1960);
insert into degree values (55555555, 'BA', 'Columbia', '3.5', 'Rocket Science', 1969);


insert into examScore values (55555555, 'total', 340, 1980);
insert into examScore values (55555555, 'verbal', 170, 1980);
insert into examScore values (55555555, 'quantitative', 170, 1980);

insert into recs (gwid, recName, job, relation, email, content, org) values (55555555, 'Billy Joel', 'Musician', 'Friend', 'bjoel@aol.com', 'Excellent man, would 100% work with him again.', 'The road');
insert into recs (gwid, recName, job, relation, email, content, org) values (55555555, 'Freddy Mercury', 'Rock Star', 'Acquaintance', 'freddomercury@hotmail.com', 'Every time we work together this man leaves me absolutely speechless.', 'The stage');
insert into recs (gwid, recName, job, relation, email, content, org) values (55555555, 'Yono Oko', 'Artist', 'Significant other', 'yo@gmail.com', 'Quality man, you would be lucky to have him in your program.', 'Art');

insert into users values (222111111, 'rstarr', 'rstarr@gmail.com', '1940-07-07', '5678', 66666666, 'Ringo', 'Starr', '2 Glynde Mews, Chelsea, London SW3 1SB, United Kingdom');

insert into applicant values (66666666, 'Music', 'Member of The Beatles, formerly', 'phd', 1, 0, 2022, 'fall');

insert into degree values (66666666, 'BA', 'NYU', '3.8', 'Boyband', 1968);

insert into examScore values (66666666, 'total', 340, 1983);
insert into examScore values (66666666, 'verbal', 170, 1983);
insert into examScore values (66666666, 'quantitative', 170, 1983);

insert into recs (gwid, recName, job, relation, email, content, org) values (66666666, 'Billy Joel', 'Musician', 'Friend', 'bjoel@aol.com', 'Excellent man, would 100% work with him again.', 'The road');
insert into recs (gwid, recName, job, relation, email, content, org) values (66666666, 'Freddy Mercury', 'Rock Star', 'Acquaintance', 'freddomercury@hotmail.com', 'Every time we work together this man leaves me absolutely speechless.', 'The stage');
insert into recs (gwid, recName, job, relation, email, content, org) values (66666666, 'Madonna', 'Queen', 'Significant other', 'madonna@gmail.com', 'Quality man, you would be lucky to have him in your program.', 'You should know');
