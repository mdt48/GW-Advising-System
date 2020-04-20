use phase2;
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS student CASCADE;
DROP TABLE IF EXISTS form CASCADE;
DROP TABLE IF EXISTS staff CASCADE;
DROP TABLE IF EXISTS transcript CASCADE;
DROP TABLE IF EXISTS course CASCADE;
DROP TABLE IF EXISTS person CASCADE;
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

CREATE TABLE form(
	`uid` int, 
	`department` VARCHAR(32),
  	`fid` int,
	`cid` int, 
	PRIMARY KEY(`fid`),
	FOREIGN KEY (`cid`) REFERENCES donotshowerror(`cid`),
	FOREIGN KEY (`uid`) REFERENCES student(`uid`)
);

CREATE TABLE person (
  `uid` int,
  `username` VARCHAR(32),
  `password` VARCHAR(40),
  `fname` VARCHAR(32),
  `lname` VARCHAR(32),
  `address` VARCHAR(32),
  `email` VARCHAR(32),
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
  foreign key (`uid`) references person(`uid`)
);

CREATE TABLE staff(
  `uid` int,
  `type` int,
  `department` VARCHAR(32),
  yearsWorking int,
  foreign key (`uid`) references person(`uid`)
);

CREATE TABLE applicant (
	`uid` int,
    `aoi` varchar(256),
    `appExp` varchar(256),
    `depPrpgram` varchar(40),
    `appStatus` int,
    `transcript` boolean,
    `admissionYear` year,
    `admissionSemester` varchar(10),
    foreign key (`uid`) references person(`uid`)
);

CREATE TABLE degree (
  uid int,
  degType varchar(3),
  school varchar(256),
  gpa decimal(3,2),
  major varchar(256),
  yearGrad year,
  FOREIGN KEY (uid) REFERENCES applicant (uid)
);

CREATE TABLE examScore (
  uid int,
  examSubject varchar(256),
  score int,
  yearTake year,
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
  PRIMARY KEY (recId),
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
  `cid` int,
  `department` VARCHAR(32),
  `subject` VARCHAR(32),
  `credit` int,
  primary key (`department`),
  FOREIGN KEY (`cid`) REFERENCES course (`cid`)
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
	cid            int,
	department        VARCHAR(32),
	year          CHAR(4),
	section         INT(2),
	semester        VARCHAR(10),
	day           CHAR(1),
	start_time      DECIMAL(30,2),
	end_time        DECIMAL(30,2),
	room            VARCHAR(15),
	PRIMARY KEY (year,section,semester,day),
	FOREIGN KEY (cid) references course(cid)

);

CREATE TABLE takes (
        cid            int,
        dept            varchar(32),
        year            CHAR(4),
        section         INT(2),
        semester        VARCHAR(10),
        uid            int,
        grade           CHAR(2),
        FOREIGN KEY (uid) references person(uid),
        FOREIGN KEY (year, section, semester) references schedule( year, section, semester),
        FOREIGN KEY (cid, dept) references course(cid, department)
);

CREATE TABLE teaches (

        cid            int,
        dept		varchar(32),
        year            CHAR(4),
        section         INT(2),
        semester       VARCHAR(10),
        uid            int,
        FOREIGN KEY (year, section, semester) references schedule(year, section, semester),
        FOREIGN KEY (cid, dept) references course(cid, department)

);
