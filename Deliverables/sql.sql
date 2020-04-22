use funnygitpun;
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS student CASCADE;
DROP TABLE IF EXISTS form CASCADE;
DROP TABLE IF EXISTS staff CASCADE;
DROP TABLE IF EXISTS transcript CASCADE;
DROP TABLE IF EXISTS donotshowerror CASCADE;

CREATE TABLE form(
	`uid` int, 
	`department` VARCHAR(32),
  	`fid` int,
	`cid` int, 
	PRIMARY KEY(`uid`,`department`,`cid`),
	FOREIGN KEY (`cid`) REFERENCES donotshowerror(`cid`),
	FOREIGN KEY (`uid`) REFERENCES student(`uid`)
);

CREATE TABLE student (
  `uid` int,
  `username` VARCHAR(32),
  `password` VARCHAR(40),
  `fname` VARCHAR(32),
  `lname` VARCHAR(32),
  `program` VARCHAR(32),
  `advisoruid` int,
  `department` VARCHAR(32),
  `address` VARCHAR(32),
  `email` VARCHAR(32),
  `grad_status` varchar(32),
  `grad_year` int,
  `thesis` boolean,
  `audited` boolean,
  PRIMARY KEY (`uid`),
  FOREIGN KEY (`advisoruid`) REFERENCES staff(`uid`)
);

CREATE TABLE staff(
  `uid` int,
  `username` VARCHAR(32),
  `password` VARCHAR(40),
  `sfname` VARCHAR(32),
  `slname` VARCHAR(32),
  `title` VARCHAR(32),
  `department` VARCHAR(32),
  `email` VARCHAR(32),
  `address` VARCHAR(32),
  PRIMARY KEY (`uid`)
);

CREATE TABLE donotshowerror(
  `cid` int,
  `department` VARCHAR(32),
  `subject` VARCHAR(32),
  `credit` int,
  `pre1` VARCHAR(32),
  `pre2` VARCHAR(32),
  PRIMARY KEY (`cid`,`department`)
);

CREATE TABLE transcript(
  `tid` int,
  `uid` int,
  `department` VARCHAR(32),
  `cid` int,
  `grade` VARCHAR(2),
  `yeartaken` int,
  `program` VARCHAR(32), 
  PRIMARY KEY (`tid`),
  FOREIGN KEY (`cid`) REFERENCES donotshowerror(`cid`)
);


INSERT INTO student VALUES (1,'mike','pass','mike','ehnot','masters',10,'CS','addr','email','f1', null, true, 0);

insert into staff values (0, 'admin', 'admin', 'marshall', 'marshall', 'admin', 'admin', 'email@gwu.edu', 'address');
insert into staff values (3, 'gs', 'pass', 'tom', 'jones', 'gs', 'CSCI', 'email@gwu.edu', 'address');



insert into staff values (10, 'B', 'pass', 'B', 'Narahari', 'fa', 'CSCI', 'email@gwu.edu', 'address');
insert into staff values (20, 'G', 'pass', 'G', 'Parmer', 'fa', 'CSCI', 'email@gwu.edu', 'address');


INSERT INTO student VALUES (55555555 ,'paul','pass','Paul','McCartney','masters',10,'CS','addr','email',0, null, null, 0);
INSERT INTO student VALUES (66666666 ,'george','pass','George','Harrison','masters',20,'CS','addr','email',0, null, null, 0);
INSERT INTO student VALUES (77777777 ,'eric','pass','Eric','Clapton','masters',20,'CS','addr','email','alumni',2014, 1, 1);


INSERT INTO donotshowerror VALUES (6221,'CSCI','SW Paradigms',3,null,null);
INSERT INTO donotshowerror VALUES (6461,'CSCI','Computer Architecture',3,null,null);
INSERT INTO donotshowerror VALUES (6212,'CSCI','Algorithms',3,null,null);
INSERT INTO donotshowerror VALUES (6220,'CSCI','Machine Learning',3,null,null);
INSERT INTO donotshowerror VALUES (6232,'CSCI','Networks 1',3,null,null);
INSERT INTO donotshowerror VALUES (6233,'CSCI','Networks 2',3,'CSCI 6232',null);
INSERT INTO donotshowerror VALUES (6241,'CSCI','Database 1',3,null,null);
INSERT INTO donotshowerror VALUES (6242,'CSCI','Database 2',3,'CSCI 6241',null);
INSERT INTO donotshowerror VALUES (6246,'CSCI','Compilers',3,'CSCI 6461','CSCI 6212');
INSERT INTO donotshowerror VALUES (6260,'CSCI','Multimedia',3,null,null);
INSERT INTO donotshowerror VALUES (6251,'CSCI','Cloud Computing',3,'CSCI 6461',null);
INSERT INTO donotshowerror VALUES (6254,'CSCI','SW Engineering',3,'CSCI 6221',null);
INSERT INTO donotshowerror VALUES (6262,'CSCI','Graphics 1',3,null,null);
INSERT INTO donotshowerror VALUES (6283,'CSCI','Security 1',3,'CSCI 6212',null);
INSERT INTO donotshowerror VALUES (6284,'CSCI','Cryptography',3,'CSCI 6212',null);
INSERT INTO donotshowerror VALUES (6286,'CSCI','Network Security',3,'CSCI 6283','CSCI 6232');
INSERT INTO donotshowerror VALUES (6325,'CSCI','Algorithms 2',3,'CSCI 6212',null);
INSERT INTO donotshowerror VALUES (6339,'CSCI','Embedded Systems',3,'CSCI 6461','CSCI 6212');
INSERT INTO donotshowerror VALUES (6384,'CSCI','Cryptography 2',3,'CSCI 6284',null);
INSERT INTO donotshowerror VALUES (6241,'ECE','Communication Theory',3,null,null);
INSERT INTO donotshowerror VALUES (6242,'ECE','Information Theory',2,null,null);
INSERT INTO donotshowerror VALUES (6210,'MATH','Logic',2,null,null);


INSERT INTO transcript VALUES (1,1,'CSCI',6221,'A',2019,'MS');
INSERT INTO transcript VALUES (2,1,'CSCI',6461,'A',2019,'MS');
INSERT INTO transcript VALUES (3,1,'CSCI',6212,'A',2019,'MS');
INSERT INTO transcript VALUES (4,1,'CSCI',6220,'A',2019,'MS');
INSERT INTO transcript VALUES (5,1,'CSCI',6232,'A',2019,'MS');
INSERT INTO transcript VALUES (6,1,'CSCI',6233,'A',2019,'MS');
INSERT INTO transcript VALUES (7,1,'CSCI',6241,'A',2020,'MS');
INSERT INTO transcript VALUES (8,1,'CSCI',6242,'A',2020,'MS');
INSERT INTO transcript VALUES (9,1,'CSCI',6246,'A',2020,'MS');
INSERT INTO transcript VALUES (10,1,'CSCI',6260,'A',2020,'MS');
INSERT INTO transcript VALUES (11,1,'CSCI',6251,'B',2020,'MS');
INSERT INTO transcript VALUES (12,1,'CSCI',6254,'B',2020,'MS');
INSERT INTO transcript VALUES (13,1,'CSCI',6262,'C',2020,'MS');


INSERT INTO transcript VALUES (14,55555555,'CSCI',6221,'A',2019,'MS');
INSERT INTO transcript VALUES (15,55555555,'CSCI',6212,'A',2019,'MS');
INSERT INTO transcript VALUES (16,55555555,'CSCI',6461,'A',2019,'MS');
INSERT INTO transcript VALUES (17,55555555,'CSCI',6232,'A',2019,'MS');
INSERT INTO transcript VALUES (18,55555555,'CSCI',6233,'A',2019,'MS');
INSERT INTO transcript VALUES (19,55555555,'CSCI',6241,'B',2019,'MS');
INSERT INTO transcript VALUES (20,55555555,'CSCI',6246,'B',2019,'MS');
INSERT INTO transcript VALUES (21,55555555,'CSCI',6262,'B',2019,'MS');
INSERT INTO transcript VALUES (22,55555555,'CSCI',6283,'B',2019,'MS');
INSERT INTO transcript VALUES (23,55555555,'CSCI',6242,'B',2019,'MS');


INSERT INTO transcript VALUES (24,66666666 ,'ECE',6242,'C',2019,'MS');

INSERT INTO transcript VALUES (25,66666666 ,'CSCI',6221,'B',2019,'MS');
INSERT INTO transcript VALUES (26,66666666 ,'CSCI',6461,'B',2019,'MS');
INSERT INTO transcript VALUES (27,66666666 ,'CSCI',6212,'B',2019,'MS');
INSERT INTO transcript VALUES (28,66666666 ,'CSCI',6232,'B',2019,'MS');
INSERT INTO transcript VALUES (29,66666666 ,'CSCI',6233,'B',2019,'MS');
INSERT INTO transcript VALUES (30,66666666 ,'CSCI',6241,'B',2019,'MS');
INSERT INTO transcript VALUES (31,66666666 ,'CSCI',6242,'B',2019,'MS');
INSERT INTO transcript VALUES (32,66666666 ,'CSCI',6283,'B',2019,'MS');
INSERT INTO transcript VALUES (33,66666666 ,'CSCI',6284,'B',2019,'MS');


INSERT INTO transcript VALUES (34,77777777 ,'CSCI',6221,'B',2019,'MS');
INSERT INTO transcript VALUES (35,77777777 ,'CSCI',6212,'B',2019,'MS');
INSERT INTO transcript VALUES (36,77777777 ,'CSCI',6461,'B',2019,'MS');
INSERT INTO transcript VALUES (37,77777777 ,'CSCI',6232,'B',2019,'MS');
INSERT INTO transcript VALUES (38,77777777 ,'CSCI',6233,'B',2019,'MS');
INSERT INTO transcript VALUES (39,77777777 ,'CSCI',6241,'B',2019,'MS');
INSERT INTO transcript VALUES (40,77777777 ,'CSCI',6242,'B',2019,'MS');
INSERT INTO transcript VALUES (41,77777777 ,'CSCI',6283,'A',2019,'MS');
INSERT INTO transcript VALUES (42,77777777 ,'CSCI',6284,'A',2019,'MS');

INSERT INTO transcript VALUES (43,77777777 ,'CSCI',6286,'A',2019,'MS');

