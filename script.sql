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
DROP TABLE IF EXISTS thesis;
DROP TABLE IF EXISTS courseForm CASCADE;


CREATE TABLE form(
	`uid` int, 
	`department` VARCHAR(32),
	`cid` int, 	
	FOREIGN KEY (`cid`) REFERENCES course(`cid`),
	FOREIGN KEY (`uid`) REFERENCES student(`uid`)
);

CREATE TABLE people (
  `uid` int AUTO_INCREMENT,
  `username` VARCHAR(32) unique,
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
  ayear int,
  asem varchar(12),
  gsem varchar(12),
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
  `appDate` date,
  `accDate` date,
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

CREATE TABLE prereqs (
	cid            int,
	reqcid         int,
	ismain          BOOLEAN,
	dept            CHAR(4),
	reqdept        CHAR(4),
	PRIMARY KEY (cid, reqcid, dept),
	FOREIGN KEY (cid, dept) references course(cid, department),
	FOREIGN KEY (reqcid, reqdept) references course(cid, department)

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

CREATE TABLE courseForm (
  uid int,
  cid1 int,
  dept1 varchar(4),
  cid2 int,
  dept2 varchar(4),
  cid3 int,
  dept3 varchar(4),
  cid4 int,
  dept4 varchar(4),
  cid5 int,
  dept5 varchar(4),
  cid6 int,
  dept6 varchar(4),
  PRIMARY KEY (uid),
  FOREIGN KEY (cid1, dept1) references course(cid, department),
  FOREIGN KEY (cid2, dept2) references course(cid, department),
  FOREIGN KEY (cid3, dept3) references course(cid, department),
  FOREIGN KEY (cid4, dept4) references course(cid, department),
  FOREIGN KEY (cid5, dept5) references course(cid, department),
  FOREIGN KEY (cid6, dept6) references course(cid, department)
);

create table thesis (
	uid int,
    th varchar(250),
    PRIMARY KEY (uid),
    FOREIGN KEY (`uid`) references student(`uid`)
);

SET FOREIGN_KEY_CHECKS = 1;

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



-- staff
insert into people (fname, lname, uid, username, password, email) values ('Bhagi', 'Narahari', 1, 'bnarahari', 'pass', 'pass');
insert into people (fname, lname, uid, username, password, email) values ('Admin', 'Admin', 2, 'admin', 'pass', 'pass');
insert into people (fname, lname, uid, username, password, email) values ('Gabe', 'Parmer', 3, 'gparmer', 'pass', 'pass');
insert into people (fname, lname, uid, username, password, email) values ('Tim', 'Wood', 4, 'twood', 'pass', 'pass');
insert into people (fname, lname, uid, username, password, email) values ('Shelly', 'Heller', 5, 'sheller', 'pass', 'pass');
insert into people (fname, lname, uid, username, password, email) values ('Sarah', 'Morin', 6, 'smorin', 'pass', 'pass');
insert into people (fname, lname, uid, username, password, email) values ('Kevin', 'Deems', 7, 'kdeems', 'pass', 'pass');
insert into people (fname, lname, uid, username, password, email) values ('Graduate', 'Secretary', 8, 'gs', 'pass', 'pass');
insert into people (fname, lname, uid, username, password, email) values ('Hyeong-Ah', 'Choi', 9, 'hchoi', 'pass', 'pass');
insert into people (fname, lname, uid, username, password, email) values ('Robert', 'Pless', 10, 'rpless', 'pass', 'pass');

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


INSERT into people (uid, username, password, fname, lname, email) values (77777777, 'eclapton', 'pass', 'Eric', 'Clapton', 'pass');
INSERT into student values (77777777, 'alumni', 1, 1, 6, 'masters', 2014, 'CSCI', null, null, "spring");

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


INSERT into people (uid, username, password, fname, lname, email) values (34567890, 'kcobain', 'pass', 'Kurt', 'Cobain', 'pass');
INSERT into student values (34567890, 'alumni', 1, 1, 3, 'masters', 2015, 'CSCI', null, null, "spring");

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
insert into student values (88888888, 0, null, 0, 6, "masters", null, "CSCI", 2018, null, null);

insert into people values (99999999, "Krall", "pass", "Diana", "Krall", "address", "email@gwu.edu", "1990-02-20", 2873191);
insert into student values (99999999, 0, null, 0, 3, "masters", null, "CSCI", 2019, "fall", null);

insert into people values (23456789, "Ella", "pass", "Ella", "Fitzgerald", "address", "email@gwu.edu", "1990-02-20", 2873190);
insert into student values (23456789, 0, null, 0, 1, "phd", null, "CSCI", 2019, "fall", null);

insert into people values (87654321, "Eva", "pass", "Eva", "Cassidy", "address", "email@gwu.edu", "1990-02-20", 2873193);
insert into student values (87654321, null, null, 0, 1, "masters", null, "CSCI", 2017, "fall", null);
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
insert into student values (45678901, null , null, 0, 4, "masters", null, "CSCI", 2017, "fall", null);
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
insert into student values (1444444, null , null, 0, 1, "masters", null, "CSCI", 2017, "fall", null);
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
insert into student values (16666666, null , null, 0, 4, "masters", null, "CSCI", 2016, "fall", null);
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
insert into student values (12345678, null , 0, 0, 6, "phd", null, "CSCI", 2017, "fall", null);
insert into thesis values(12345678, "This is my thesis");
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

INSERT INTO schedule VALUES
(6221, "CSCI", 2020, 1, "Spring", "M", 15.00, 17.30, "SEH 1400");
INSERT INTO schedule VALUES
(6461, "CSCI", 2020, 1, "Spring", "T", 15.00, 17.30, "SEH 4040");
INSERT INTO schedule VALUES
(6212, "CSCI", 2020, 1, "Spring", "W", 15.00, 17.30, "SEH 3030");
INSERT INTO schedule VALUES
(6232, "CSCI", 2020, 1, "Spring", "M", 15.00, 17.30, "SEH 2020");
INSERT INTO schedule VALUES
(6233, "CSCI", 2020, 1, "Spring", "T", 15.00, 17.30, "SEH 1400");
INSERT INTO schedule VALUES
(6241, "CSCI", 2020, 1, "Spring", "W", 18.00, 20.30, "SEH 1500");
INSERT INTO schedule VALUES
(6242, "CSCI", 2020, 1, "Spring", "R", 18.00, 20.30, "SEH 4040");
INSERT INTO schedule VALUES
(6246, "CSCI", 2020, 1, "Spring", "T", 15.00, 17.30, "SEH 2020");
INSERT INTO schedule VALUES
(6251, "CSCI", 2020, 1, "Spring", "M", 15.00, 17.30, "SEH 4040");
INSERT INTO schedule VALUES
(6254, "CSCI", 2020, 1, "Spring", "M", 15.30, 18.00, "SEH 3030");
INSERT INTO schedule VALUES
(6260, "CSCI", 2020, 1, "Spring", "R", 18.00, 20.30, "SEH 1500");
INSERT INTO schedule VALUES
(6262, "CSCI", 2020, 1, "Spring", "W", 18.00, 20.30, "SEH 4040");
INSERT INTO schedule VALUES
(6283, "CSCI", 2020, 1, "Spring", "T", 18.00, 20.30, "SEH 3030");
INSERT INTO schedule VALUES
(6284, "CSCI", 2020, 1, "Spring", "M", 18.00, 20.30, "SEH 1400");
INSERT INTO schedule VALUES
(6286, "CSCI", 2020, 1, "Spring", "W", 18.00, 20.30, "SEH 2020");
INSERT INTO schedule VALUES
(6384, "CSCI", 2020, 1, "Spring", "W", 15.00, 17.30, "SEH 1400");
INSERT INTO schedule VALUES
(6241, "ECE", 2020, 1, "Spring", "M", 17.00, 19.30, "SEH 4040");
INSERT INTO schedule VALUES
(6242, "ECE", 2020, 1, "Spring", "T", 18.00, 20.30, "SEH 2020");
INSERT INTO schedule VALUES
(6210, "MATH", 2020, 1, "Spring", "W", 18.00, 20.30, "SEH 3030");
INSERT INTO schedule VALUES
(6339, "CSCI", 2020, 1, "Spring", "R", 16.00, 18.30, "SEH 2020");



insert into people (ssn, username, email, birthDate, password, uid, fname, lname, address) values (111111111, 'jlennon', 'jlennon@gmail.com', '1940-10-09', 'pass', 55555555, 'John', 'Lennon', '72nd St & Central Park West, New York, NY, 10023');

insert into applicant (uid, aoi, appExp, degProgram, appStatus, transcript, admissionYear, admissionSemester, appDate) values (55555555, 'Music', 'Member of The Beatles, formerly', 'md', 2, 'Registrar link', 2020, 'fall', '2019-05-07');

insert into degree values (55555555, 'BA', 'Berkley', '4.0', 'Boyband', 1960);
insert into degree values (55555555, 'BA', 'Columbia', '3.5', 'Rocket Science', 1969);


insert into examScore values (55555555, 'total', 340, 1980);
insert into examScore values (55555555, 'verbal', 170, 1980);
insert into examScore values (55555555, 'quantitative', 170, 1980);

insert into recs (uid, recName, job, relation, email, content, org) values (55555555, 'Billy Joel', 'Musician', 'Friend', 'bjoel@aol.com', 'Excellent man, would 100% work with him again.', 'The road');
insert into recs (uid, recName, job, relation, email, content, org) values (55555555, 'Freddy Mercury', 'Rock Star', 'Acquaintance', 'freddomercury@hotmail.com', 'Every time we work together this man leaves me absolutely speechless.', 'The stage');
insert into recs (uid, recName, job, relation, email, content, org) values (55555555, 'Yono Oko', 'Artist', 'Significant other', 'yo@gmail.com', 'Quality man, you would be lucky to have him in your program.', 'Art');

insert into people (ssn, username, email, birthDate, password, uid, fname, lname, address) values (222111111, 'rstarr', 'rstarr@gmail.com', '1940-07-07', 'pass', 66666666, 'Ringo', 'Starr', '2 Glynde Mews, Chelsea, London SW3 1SB, United Kingdom');

insert into applicant (uid, aoi, appExp, degProgram, appStatus, transcript, admissionYear, admissionSemester, appDate) values (66666666, 'Music', 'Member of The Beatles, formerly', 'md', 1, NULL, 2020, 'fall', '2020-05-07');

insert into degree values (66666666, 'BA', 'NYU', '3.8', 'Boyband', 1968);

insert into examScore values (66666666, 'total', 340, 1983);
insert into examScore values (66666666, 'verbal', 170, 1983);
insert into examScore values (66666666, 'quantitative', 170, 1983);

insert into recs (uid, recName, job, relation, email, content, org) values (66666666, 'Daffy Duck', 'Duck', 'Acquaintance', 'dduck@aol.com', 'Not a rabbit, cannot complain', 'Toons');
insert into recs (uid, recName, job, relation, email, content, org) values (66666666, 'Rogger Rabbit', 'Rock Star', 'Employer', 'rrabbit@hotmail.com', 'Wonderful man.', 'Wouldnt you like to know');
-- insert into recs (uid, email) values (66666666, 'madonna@gmail.com');

insert into people (ssn, username, email, password, uid, fname, lname) values (555111111, 'larmstrong', 'larmstrong@gmail.com', 'pass', 00001234, 'Louis', 'Armstrong');

insert into applicant (uid, aoi, degProgram, appStatus, transcript, admissionYear, admissionSemester) values (00001234, 'Music', 'md', 5, "Link", 2017, 'fall');

insert into examScore values (00001234, 'total', 200, 1983);
insert into examScore values (00001234, 'verbal', 100, 1983);
insert into examScore values (00001234, 'quantitative', 100, 1983);

insert into people (ssn, username, email, password, uid, fname, lname) values (666111111, 'afranklin', 'afranklin@gmail.com', 'pass', 00001235, 'Aretha', 'Franklin');

insert into applicant (uid, aoi, degProgram, appStatus, transcript, admissionYear, admissionSemester) values (00001235, 'Music', 'md', 4, "Link", 2017, 'fall');

insert into examScore values (00001235, 'total', 250, 1983);
insert into examScore values (00001235, 'verbal', 150, 1983);
insert into examScore values (00001235, 'quantitative', 100, 1983);

insert into people (ssn, username, email, password, uid, fname, lname) values (777111111, 'csantana', 'csantana@gmail.com', 'pass', 00001236, 'Carlos', 'Santana');

insert into applicant (uid, aoi, degProgram, appStatus, transcript, admissionYear, admissionSemester) values (00001236, 'Music', 'phd', 4, "Link", 2017, 'fall');

insert into examScore values (00001236, 'total', 200, 1983);
insert into examScore values (00001236, 'verbal', 100, 1983);
insert into examScore values (00001236, 'quantitative', 100, 1983);

insert into teaches values (6254, 'CSCI', 2020, 1, 'Spring', 4);
insert into teaches values (6461, 'CSCI', 2020, 1, 'Spring', 1);
insert into teaches values (6262, 'CSCI', 2020, 1, 'Spring', 10);
insert into teaches values (6251, 'CSCI', 2020, 1, 'Spring', 9);
insert into teaches values (6246, 'CSCI', 2020, 1, 'Spring', 3);
insert into teaches values (6260, 'CSCI', 2020, 1, 'Spring', 4);


INSERT INTO prereqs VALUES (6233, 6232, true, "CSCI", "CSCI");
INSERT INTO prereqs VALUES (6242, 6241, true, "ECE", "ECE");
INSERT INTO prereqs VALUES (6246, 6461, true, "CSCI", "CSCI");
INSERT INTO prereqs VALUES (6246, 6212, false, "CSCI", "CSCI");
INSERT INTO prereqs VALUES (6251, 6461, true, "CSCI", "CSCI");
INSERT INTO prereqs VALUES (6254, 6221, true, "CSCI", "CSCI");
INSERT INTO prereqs VALUES (6283, 6212, true, "CSCI", "CSCI");
INSERT INTO prereqs VALUES (6284, 6212, true, "CSCI", "CSCI");
INSERT INTO prereqs VALUES (6286, 6283, true, "CSCI", "CSCI");
INSERT INTO prereqs VALUES (6286, 6232, false, "CSCI", "CSCI");
INSERT INTO prereqs VALUES (6325, 6212, true, "CSCI", "CSCI");
INSERT INTO prereqs VALUES (6339, 6461, true, "CSCI", "CSCI");
INSERT INTO prereqs VALUES (6339, 6212, false, "CSCI", "CSCI");
INSERT INTO prereqs VALUES (6384, 6284, true, "CSCI", "CSCI");