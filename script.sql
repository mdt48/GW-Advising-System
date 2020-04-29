use gradymcpeak;
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS student CASCADE;
DROP TABLE IF EXISTS form CASCADE;
DROP TABLE IF EXISTS staff CASCADE;
DROP TABLE IF EXISTS transcript CASCADE;
DROP TABLE IF EXISTS course CASCADE;
DROP TABLE IF EXISTS people CASCADE;
DROP TABLE IF EXISTS applicant CASCADE;
DROP TABLE IF EXISTS degree CASCADE;
DROP TABLE IF EXISTS examScore CASCADE;
DROP TABLE IF EXISTS recs CASCADE;
DROP TABLE IF EXISTS recReview CASCADE;
DROP TABLE IF EXISTS reviewForm CASCADE;
DROP TABLE IF EXISTS prereqs CASCADE;
DROP TABLE IF EXISTS transcript CASCADE;
DROP TABLE IF EXISTS schedule CASCADE;
DROP TABLE IF EXISTS takes cascade;
DROP TABLE IF EXISTS teaches;
DROP TABLE IF EXISTS people;


CREATE TABLE form(
	`uid` int, 
	`department` VARCHAR(32),
  `fid` int,
	`cid` int, 
	PRIMARY KEY(`fid`),
	FOREIGN KEY (`cid`) REFERENCES course(`cid`),
	FOREIGN KEY (`uid`) REFERENCES student(`uid`)
);

CREATE TABLE people (
  `uid` int AUTO_INCREMENT,
  `username` VARCHAR(32),
  `password` VARCHAR(40),
  `fname` VARCHAR(32),
  `lname` VARCHAR(32),
  `address` VARCHAR(256),
  `email` VARCHAR(32),
  `birthDate` date,
  `ssn` int unique, 
  PRIMARY KEY (`uid`)
);

CREATE TABLE student(
  `uid` int,
  `grad_status` varchar(32),
  
  `thesis` boolean,
  `audited` boolean,
  `advisoruid` int,
  `program` VARCHAR(32),
  `grad_year` int,
  `department` varchar(32),
  primary key (`uid`),
  foreign key (`uid`) references people(`uid`)
);

CREATE TABLE staff(
  `uid` int,
  `type` int,
  `department` VARCHAR(32),
  `yearsWorking` int,
  primary key (`uid`),
  foreign key (`uid`) references people(`uid`)
);

CREATE TABLE applicant (
	`uid` int,
  `aoi` varchar(256),
  `appExp` varchar(256),
  `degProgram` varchar(40),
  `appStatus` int,
  `transcript` boolean,
  `admissionYear` year,
  `admissionSemester` varchar(10),
  `adv` int,
  primary key (`uid`),
  foreign key (`uid`) references people(`uid`)
);

CREATE TABLE degree (
  uid int,
  degType varchar(3),
  school varchar(256),
  gpa decimal(3,2),
  major varchar(256),
  yearGrad year,
  primary key(degType, major,uid),
  FOREIGN KEY (uid) REFERENCES applicant (uid)
);

CREATE TABLE examScore (
  uid int,
  examSubject varchar(256),
  score int,
  yearTake year,
  PRIMARY KEY (uid,examSubject),
  FOREIGN KEY (uid) REFERENCES applicant (uid)
);

CREATE TABLE recs (
  uid int,
  recId int AUTO_INCREMENT,
  recName varchar(50),
  job varchar(40),
  relation varchar(20),
  email varchar(32),
  content varchar(255),
  org varchar(30),
  PRIMARY KEY (recId),
  FOREIGN KEY (uid) REFERENCES applicant (uid)
);

CREATE TABLE recReview (
  uid int,
  studentUid int,
  recId int,
  rating int,
  generic bool,
  credible bool,
  PRIMARY KEY (uid,studentUid, recId),
  FOREIGN KEY (uid) REFERENCES reviewForm (uid),
  FOREIGN KEY (studentUid) REFERENCES reviewForm (studentUid)
);

CREATE TABLE reviewForm (
  uid int,
  studentuid int,
  missingC varchar(50),
  gas int,
  gasComm varchar(255),
  reasonReject char,
  adv varchar(50),
  PRIMARY KEY (uid, studentuid),
  FOREIGN KEY (uid) REFERENCES faculty (uid),
  FOREIGN KEY (studentuid) REFERENCES applicant (uid)
);

CREATE TABLE course(
  `cid` int,
  `department` VARCHAR(32),
  `subject` VARCHAR(32),
  `credit` int,
  PRIMARY KEY (`cid`, `department`)
);

CREATE TABLE prereqs(
  cid int,
  pcid int,
  PRIMARY KEY (cid, pcid),
  FOREIGN KEY (cid) REFERENCES course (cid)
);

CREATE TABLE transcript(
  `tid` int,
  `uid` int,
  `subject` VARCHAR(32),
  `cid` int,
  `grade` VARCHAR(2),
  `yeartaken` int,
  `program` VARCHAR(32),
  `formindex` int, 
  PRIMARY KEY (`tid`),
  FOREIGN KEY (`cid`) REFERENCES course(`cid`)
);

CREATE TABLE schedule (
	cid int,
	department VARCHAR(32),
	year CHAR(4),
	section INT(2),
	semester VARCHAR(10),
	day CHAR(1),
	start_time DECIMAL(30,2),
	end_time DECIMAL(30,2),
	room VARCHAR(15),
	PRIMARY KEY (cid, department, year, section, semester),
	FOREIGN KEY (cid, department) references course(cid, department)
);

CREATE TABLE takes (
  cid int,
  department varchar(32),
  year CHAR(4),
  section INT(2),
  semester VARCHAR(10),
  uid int,
  grade CHAR(2),
  PRIMARY KEY (uid, cid, department, year, section, semester),
  FOREIGN KEY (`uid`) references student(`uid`),
  FOREIGN KEY (cid, department, year, section, semester) references schedule(cid, department, year, section, semester)
);

CREATE TABLE teaches (
  cid int,
  department varchar(32),
  year CHAR(4),
  section INT(2),
  semester VARCHAR(10),
  uid int,
  PRIMARY KEY (cid, department, year, section, semester),
  FOREIGN KEY (cid, department, year, section, semester) references schedule(cid, department, year, section, semester)
);

SET FOREIGN_KEY_CHECKS = 1;

-- students
-- INSERT INTO people VALUES (55555555 ,'paul','pass','Paul','McCartney','addr','email','2000-09-28', 99999999);
-- INSERT INTO people VALUES (66666666 ,'george','pass','George','Harrison','addr','email','2000-09-28', 99998999);
-- INSERT INTO people VALUES (77777777 ,'eric','pass','Eric','Clapton','addr','email','2000-09-28', 99999996);

-- INSERT INTO student VALUES (55555555 , 0, null, null, 10, 'masters', null, "CSCI");
-- INSERT INTO student VALUES (66666666 , 0, null, null, 20, 'masters', null, "CSCI");
-- INSERT INTO student VALUES (77777777 , 0, null, null, 10, 'masters', 2014, "CSCI");

-- courses 
INSERT INTO course VALUES (6221,'CSCI','SW Paradigms',3);
INSERT INTO course VALUES (6461,'CSCI','Computer Architecture',3);
INSERT INTO course VALUES (6212,'CSCI','Algorithms',3);
INSERT INTO course VALUES (6220,'CSCI','Machine Learning',3);
INSERT INTO course VALUES (6232,'CSCI','Networks 1',3);
INSERT INTO course VALUES (6233,'CSCI','Networks 2',3);
INSERT INTO course VALUES (6241,'CSCI','Database 1',3);
INSERT INTO course VALUES (6242,'CSCI','Database 2',3);
INSERT INTO course VALUES (6246,'CSCI','Compilers',3);
INSERT INTO course VALUES (6260,'CSCI','Multimedia',3);
INSERT INTO course VALUES (6251,'CSCI','Cloud Computing',3);
INSERT INTO course VALUES (6254,'CSCI','SW Engineering',3);
INSERT INTO course VALUES (6262,'CSCI','Graphics 1',3);
INSERT INTO course VALUES (6283,'CSCI','Security 1',3);
INSERT INTO course VALUES (6284,'CSCI','Cryptography',3);
INSERT INTO course VALUES (6286,'CSCI','Network Security',3);
INSERT INTO course VALUES (6325,'CSCI','Algorithms 2',3);
INSERT INTO course VALUES (6339,'CSCI','Embedded Systems',3);
INSERT INTO course VALUES (6384,'CSCI','Cryptography 2',3);
INSERT INTO course VALUES (6241,'ECE','Communication Theory',3);
INSERT INTO course VALUES (6242,'ECE','Information Theory',2);
INSERT INTO course VALUES (6210,'MATH','Logic',2);

-- student trans
INSERT INTO transcript VALUES (14,55555555,'CSCI',6221,'A',2019,'MS', 0);
INSERT INTO transcript VALUES (15,55555555,'CSCI',6212,'A',2019,'MS',0);
INSERT INTO transcript VALUES (16,55555555,'CSCI',6461,'A',2019,'MS',0);
INSERT INTO transcript VALUES (17,55555555,'CSCI',6232,'A',2019,'MS',0);
INSERT INTO transcript VALUES (18,55555555,'CSCI',6233,'A',2019,'MS',0);
INSERT INTO transcript VALUES (19,55555555,'CSCI',6241,'B',2019,'MS',0);
INSERT INTO transcript VALUES (20,55555555,'CSCI',6246,'B',2019,'MS',0);
INSERT INTO transcript VALUES (21,55555555,'CSCI',6262,'B',2019,'MS',0);
INSERT INTO transcript VALUES (22,55555555,'CSCI',6283,'B',2019,'MS',0);
INSERT INTO transcript VALUES (23,55555555,'CSCI',6242,'B',2019,'MS',0);

-- staff
-- insert into people values (10, 'B', 'pass', 'B', 'Narahari', 'address', 'email@gwu.edu','2000-09-28', 89999999);
-- insert into people values (20, 'G', 'pass', 'G', 'Parmer', 'address', 'email@gwu.edu', '2000-09-28', 99959999);
-- insert into people values (30, 'gs', 'pass', 'GS', 'GS', 'address', 'email@gwu.edu', '2000-09-28', 99950999);
-- insert into people values (40, 'admin', 'pass', 'admin', 'admin', 'address', 'email@gwu.edu', '2000-09-28', 39950999);

-- INSERT INTO staff VALUES (10 , 4, 'CSCI', 4);
-- INSERT INTO staff VALUES (20 , 4, 'CSCI', 4);
-- INSERT INTO staff VALUES (30 , 1, 'CSCI', 4);
-- INSERT INTO staff VALUES (40 , 0, 'CSCI', 4);



-- this is the data for the apps side
insert into people (ssn, username, email, birthDate, password, uid, fname, lname, address) values (111111111, 'jlennon', 'jlennon@gmail.com', '1940-10-09', '1234', 55555554, 'John', 'Lennon', '72nd St & Central Park West, New York, NY, 10023');

insert into applicant values (55555554, 'Music', 'Member of The Beatles, formerly', 'md', 2, 1, 2020, 'fall', null);

insert into degree values (55555554, 'BA', 'Berkley', '4.0', 'Boyband', 1960);
insert into degree values (55555554, 'BA', 'Columbia', '3.5', 'Rocket Science', 1969);


insert into examScore values (55555555, 'total', 340, 1980);
insert into examScore values (55555555, 'verbal', 170, 1980);
insert into examScore values (55555555, 'quantitative', 170, 1980);

insert into recs (uid, recName, job, relation, email, content, org) values (55555555, 'Billy Joel', 'Musician', 'Friend', 'bjoel@aol.com', 'Excellent man, would 100% work with him again.', 'The road');
insert into recs (uid, recName, job, relation, email, content, org) values (55555555, 'Freddy Mercury', 'Rock Star', 'Acquaintance', 'freddomercury@hotmail.com', 'Every time we work together this man leaves me absolutely speechless.', 'The stage');
insert into recs (uid, recName, job, relation, email, content, org) values (55555555, 'Yono Oko', 'Artist', 'Significant other', 'yo@gmail.com', 'Quality man, you would be lucky to have him in your program.', 'Art');

insert into people (ssn, username, email, birthDate, password, uid, fname, lname, address) values (222111111, 'rstarr', 'rstarr@gmail.com', '1940-07-07', '1234', 66666666, 'Ringo', 'Starr', '2 Glynde Mews, Chelsea, London SW3 1SB, United Kingdom');

insert into applicant (uid, aoi, appExp, degProgram, appStatus, transcript, admissionYear, admissionSemester) values (66666666, 'Music', 'Member of The Beatles, formerly', 'md', 1, 1, 2020, 'fall');

insert into degree values (66666666, 'BA', 'NYU', '3.8', 'Boyband', 1968);

insert into examScore values (66666666, 'total', 340, 1983);
insert into examScore values (66666666, 'verbal', 170, 1983);
insert into examScore values (66666666, 'quantitative', 170, 1983);

insert into recs (uid, recName, job, relation, email, content, org) values (66666666, 'Daffy Duck', 'Duck', 'Acquaintance', 'dduck@aol.com', 'Not a rabbit, cannot complain', 'Toons');
insert into recs (uid, recName, job, relation, email, content, org) values (66666666, 'Rogger Rabbit', 'Rock Star', 'Employer', 'rrabbit@hotmail.com', 'Wonderful man.', 'Wouldnt you like to know');
insert into recs (uid, email) values (66666666, 'madonna@gmail.com');

-- staff
insert into people (fname, lname, uid, username, password) values ('Bhagi', 'Narahari', 1, 'bnarahari', '1234');
insert into people (fname, lname, uid, username, password) values ('Admin', 'Admin', 2, 'admin', '1234');
insert into people (fname, lname, uid, username, password) values ('Gabe', 'Parmer', 3, 'gparmer', '1234');
insert into people (fname, lname, uid, username, password) values ('Tim', 'Wood', 4, 'twood', '1234');
insert into people (fname, lname, uid, username, password) values ('Shelly', 'Heller', 5, 'sheller', '1234');
insert into people (fname, lname, uid, username, password) values ('Sarah', 'Morin', 6, 'smorin', '1234');
insert into people (fname, lname, uid, username, password) values ('Kevin', 'Deems', 7, 'kdeems', '1234');
insert into people (fname, lname, uid, username, password) values ('Graduate', 'Secretary', 8, 'gs', '1234');
insert into people (fname, lname, uid, username, password) values ('Hyeong-Ah', 'Choi', 9, 'hchoi', '1234');
insert into people (fname, lname, uid, username, password) values ('Robert', 'Pless', 10, 'rpless', '1234');

insert into staff (uid, type) values (1, 9);
insert into staff (uid, type) values (2, 0);
insert into staff (uid, type) values (3, 4);
insert into staff (uid, type) values (4, 7);
insert into staff (uid, type) values (5, 3);
insert into staff (uid, type) values (6, 4);
insert into staff (uid, type) values (7, 5);
insert into staff (uid, type) values (8, 1);
insert into staff (uid, type) values (9, 5);
insert into staff (uid, type) values (10, 2);
