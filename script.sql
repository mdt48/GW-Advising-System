
use mdt_;
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS student CASCADE;
DROP TABLE IF EXISTS form CASCADE;
DROP TABLE IF EXISTS staff CASCADE;
DROP TABLE IF EXISTS transcript CASCADE;
DROP TABLE IF EXISTS course CASCADE;
DROP TABLE IF EXISTS people CASCADE;
DROP TABLE IF EXISTS applicant CASCADE;
DROP TABLE IF EXISTS degree CASCADE;
DROP TABLE IF EXISTS examasterscore CASCADE;
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
	`cid` int, 	
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
  `transcript` varchar(256),
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

CREATE TABLE examasterscore (
  uid int,
  examastersubject varchar(256),
  score int,
  yearTake year,
  PRIMARY KEY (uid,examastersubject),
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
  studentuid int,
  recId int,
  rating int,
  generic bool,
  credible bool,
  PRIMARY KEY (uid,studentuid, recId),
  FOREIGN KEY (uid) REFERENCES reviewForm (uid),
  FOREIGN KEY (studentuid) REFERENCES reviewForm (studentuid)
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
  FOREIGN KEY (uid) REFERENCES staff (uid),
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
  `uid` int,
  `subject` VARCHAR(32),
  `cid` int,
  `grade` VARCHAR(2),
  `yeartaken` int,
  `program` VARCHAR(32),
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

-- courses 
INSERT INTO course VALUES (6221,'CSCI','SW Paradigmasters',3);
INSERT INTO course VALUES (6461,'CSCI','Computer Architecture',3);
INSERT INTO course VALUES (6212,'CSCI','Algorithmasters',3);
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
INSERT INTO course VALUES (6325,'CSCI','Algorithmasters 2',3);
INSERT INTO course VALUES (6339,'CSCI','Embedded Systemasters',3);
INSERT INTO course VALUES (6384,'CSCI','Cryptography 2',3);
INSERT INTO course VALUES (6241,'ECE','Communication Theory',3);
INSERT INTO course VALUES (6242,'ECE','Information Theory',2);
INSERT INTO course VALUES (6210,'MATH','Logic',2);



-- staff
insert into people (fname, lname, uid, username, password) values ('Bhagi', 'Narahari', 1, 'bnarahari', '1234');
insert into people (fname, lname, uid, username, password) values ('Admin', 'Admin', 2, 'admin', '1234');
insert into people (fname, lname, uid, username, password) values ('Gabe', 'Parmer', 3, 'gparmer', '1234');
insert into people (fname, lname, uid, username, password) values ('Tim', 'Wood', 4, 'twood', '1234');
insert into people (fname, lname, uid, username, password) values ('Shelly', 'Heller', 5, 'sheller', '1234');
insert into people (fname, lname, uid, username, password) values ('Sarah', 'Morin', 6, 'smorin', '1234');
insert into people (fname, lname, uid, username, password) values ('Kevin', 'Deemasters', 7, 'kdeemasters', '1234');
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


INSERT into people (uid, username, password, fname, lname) values (77777777, 'eclapton', '1234', 'Eric', 'Clapton');
INSERT into student values (77777777, 'alumni', 1, 1, 6, 'masters', 2014, 'CS');

-- student trans
INSERT INTO transcript VALUES (77777777,'CSCI',6221,'B',2014,'masters');
INSERT INTO transcript VALUES (77777777,'CSCI',6212,'B',2014,'masters');
INSERT INTO transcript VALUES (77777777,'CSCI',6461,'B',2014,'masters');
INSERT INTO transcript VALUES (77777777,'CSCI',6232,'B',2014,'masters');
INSERT INTO transcript VALUES (77777777,'CSCI',6233,'B',2014,'masters');
INSERT INTO transcript VALUES (77777777,'CSCI',6241,'B',2014,'masters');
INSERT INTO transcript VALUES (77777777,'CSCI',6242,'B',2014,'masters');
INSERT INTO transcript VALUES (77777777,'CSCI',6283,'B',2014,'masters');
INSERT INTO transcript VALUES (77777777,'CSCI',6284,'B',2014,'masters');
INSERT INTO transcript VALUES (77777777,'CSCI',6286,'B',2014,'masters');


INSERT into people (uid, username, password, fname, lname) values (34567890, 'kcobain', '1234', 'Kurt', 'Cobain');
INSERT into student values (34567890, 'alumni', 1, 1, 3, 'masters', 2015, 'CS');

-- student trans
INSERT INTO transcript VALUES (34567890,'CSCI',6221,'A',2015,'masters');
INSERT INTO transcript VALUES (34567890,'CSCI',6212,'A',2015,'masters');
INSERT INTO transcript VALUES (34567890,'CSCI',6461,'A',2015,'masters');
INSERT INTO transcript VALUES (34567890,'CSCI',6232,'A',2015,'masters');
INSERT INTO transcript VALUES (34567890,'CSCI',6233,'A',2015,'masters');
INSERT INTO transcript VALUES (34567890,'CSCI',6241,'A',2015,'masters');
INSERT INTO transcript VALUES (34567890,'CSCI',6283,'A',2015,'masters');
INSERT INTO transcript VALUES (34567890,'CSCI',6284,'A',2015,'masters');
INSERT INTO transcript VALUES (34567890,'CSCI',6286,'A',2015,'masters');
INSERT INTO transcript VALUES (34567890,'CSCI',6242,'B',2015,'masters');
INSERT INTO transcript VALUES (34567890,'CSCI',6251,'B',2015,'masters');
INSERT INTO transcript VALUES (34567890,'CSCI',6254,'B',2015,'masters');

-- students
insert into people values (88888888, "Billy", "pass", "Billy", "Holliday", "address", "email@gwu.edu", "1990-02-20", 2873192);
insert into student values (88888888, 0, null, 0, 6, "masters", null, "CSCI");

insert into people values (99999999, "Krall", "pass", "Diana", "Krall", "address", "email@gwu.edu", "1990-02-20", 2873191);
insert into student values (99999999, 0, null, 0, 3, "masters", null, "CSCI");

insert into people values (23456789, "Ella", "pass", "Ella", "Fitzgerald", "address", "email@gwu.edu", "1990-02-20", 2873190);
insert into student values (23456789, 0, null, 0, 1, "phd", null, "CSCI");

insert into people values (87654321, "Eva", "pass", "Eva", "Cassidy", "address", "email@gwu.edu", "1990-02-20", 2873193);
insert into student values (87654321, null, null, 0, 1, "masters", null, "CSCI");
insert into transcript values(87654321, "CSCI", 6221, "C", 2017, "masters");
insert into transcript values(87654321, "CSCI", 6212, "C", 2017, "masters");
insert into transcript values(87654321, "CSCI", 6461, "C", 2017, "masters");
insert into transcript values(87654321, "CSCI", 6232, "C", 2017, "masters");
insert into transcript values(87654321, "CSCI", 6233, "C", 2017, "masters");
insert into transcript values(87654321, "CSCI", 6284, "C", 2017, "masters");
insert into transcript values(87654321, "CSCI", 6286, "C", 2017, "masters");
insert into form values (87654321, "CSCI", 6221);
insert into form values (87654321, "CSCI", 6212);
insert into form values (87654321, "CSCI", 6461);
insert into form values (87654321, "CSCI", 6232);
insert into form values (87654321, "CSCI", 6233);
insert into form values (87654321, "CSCI", 6284);
insert into form values (87654321, "CSCI", 6286);

insert into people values (45678901, "Jimi", "pass", "Jimi", "Hendrix", "address", "email@gwu.edu", "1990-02-20", 2873198);
insert into student values (45678901, null , null, 0, 4, "masters", null, "CSCI");
insert into transcript values(45678901, "CSCI", 6221, "A", 2017, "masters");
insert into transcript values(45678901, "CSCI", 6212, "A", 2017, "masters");
insert into transcript values(45678901, "CSCI", 6461, "A", 2017, "masters");
insert into transcript values(45678901, "CSCI", 6232, "A", 2017, "masters");
insert into transcript values(45678901, "CSCI", 6233, "A", 2017, "masters");
insert into transcript values(45678901, "CSCI", 6284, "A", 2017, "masters");
insert into transcript values(45678901, "CSCI", 6286, "A", 2017, "masters");
insert into transcript values(45678901, "CSCI", 6241, "A", 2017, "masters");
insert into transcript values(45678901, "ECE", 6241, "B", 2017, "masters");
insert into transcript values(45678901, "ECE", 6242, "B", 2017, "masters");
insert into transcript values(45678901, "MATH", 6210, "B", 2017, "masters");


insert into people values (1444444, "Paul", "pass", "Paul", "Mccartney", "address", "email@gwu.edu", "1990-02-20", 2873188);
insert into student values (1444444, null , null, 0, 1, "masters", null, "CSCI");
insert into transcript values(1444444, "CSCI", 6221, "A", 2017, "masters");
insert into transcript values(1444444, "CSCI", 6212, "A", 2017, "masters");
insert into transcript values(1444444, "CSCI", 6461, "A", 2017, "masters");
insert into transcript values(1444444, "CSCI", 6232, "A", 2017, "masters");
insert into transcript values(1444444, "CSCI", 6233, "A", 2017, "masters");
insert into transcript values(1444444, "CSCI", 6241, "B", 2017, "masters");
insert into transcript values(1444444, "CSCI", 6246, "B", 2017, "masters");
insert into transcript values(1444444, "CSCI", 6262, "B", 2017, "masters");
insert into transcript values(1444444, "CSCI", 6283, "B", 2017, "masters");
insert into transcript values(1444444, "CSCI", 6242, "B", 2017, "masters");
insert into form values (1444444, "CSCI", 6221);
insert into form values (1444444, "CSCI", 6212);
insert into form values (1444444, "CSCI", 6461);
insert into form values (1444444, "CSCI", 6232);
insert into form values (1444444, "CSCI", 6233);
insert into form values (1444444, "CSCI", 6241);
insert into form values (1444444, "CSCI", 6246);
insert into form values (1444444, "CSCI", 6262);
insert into form values (1444444, "CSCI", 6283);
insert into form values (1444444, "CSCI", 6242);


insert into people values (16666666, "George", "pass", "George", "Harrison", "address", "email@gwu.edu", "1990-02-20", 2875188);
insert into student values (16666666, null , null, 0, 4, "masters", null, "CSCI");
insert into transcript values(16666666, "ECE", 6242, "C", 2017, "masters");
insert into transcript values(16666666, "CSCI", 6221, "B", 2017, "masters");
insert into transcript values(16666666, "CSCI", 6461, "B", 2017, "masters");
insert into transcript values(16666666, "CSCI", 6212, "B", 2017, "masters");
insert into transcript values(16666666, "CSCI", 6232, "B", 2017, "masters");
insert into transcript values(16666666, "CSCI", 6233, "B", 2017, "masters");
insert into transcript values(16666666, "CSCI", 6241, "B", 2017, "masters");
insert into transcript values(16666666, "CSCI", 6242, "B", 2017, "masters");
insert into transcript values(16666666, "CSCI", 6283, "B", 2017, "masters");
insert into transcript values(16666666, "CSCI", 6284, "B", 2017, "masters");


insert into people values (12345678, "Stevie", "pass", "Stevie", "Nicks", "address", "email@gwu.edu", "1990-02-20", 2173188);
insert into student values (12345678, null , 0, 0, 6, "phd", null, "CSCI");
insert into transcript values(12345678, "CSCI", 6221, "A", 2017, "phd");
insert into transcript values(12345678, "CSCI", 6212, "A", 2017, "phd");
insert into transcript values(12345678, "CSCI", 6461, "A", 2017, "phd");
insert into transcript values(12345678, "CSCI", 6232, "A", 2017, "phd");
insert into transcript values(12345678, "CSCI", 6233, "A", 2017, "phd");
insert into transcript values(12345678, "CSCI", 6284, "A", 2017, "phd");
insert into transcript values(12345678, "CSCI", 6286, "A", 2017, "phd");
insert into transcript values(12345678, "CSCI", 6241, "B", 2017, "phd");
insert into transcript values(12345678, "CSCI", 6246, "B", 2017, "phd");
insert into transcript values(12345678, "CSCI", 6262, "B", 2017, "phd");
insert into transcript values(12345678, "CSCI", 6283, "B", 2017, "phd");
insert into transcript values(12345678, "CSCI", 6242, "B", 2017, "phd");
insert into form values (12345678, "CSCI", 6221);
insert into form values (12345678, "CSCI", 6212);
insert into form values (12345678, "CSCI", 6461);
insert into form values (12345678, "CSCI", 6232);
insert into form values (12345678, "CSCI", 6233);
insert into form values (12345678, "CSCI", 6284);
insert into form values (12345678, "CSCI", 6241);
insert into form values (12345678, "CSCI", 6246);
insert into form values (12345678, "CSCI", 6262);
insert into form values (12345678, "CSCI", 6242);
insert into form values (12345678, "CSCI", 6283);
insert into form values (12345678, "CSCI", 6242);
