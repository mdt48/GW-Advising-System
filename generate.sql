-- mysql tables for regs 

DROP TABLE IF EXISTS takes;
DROP TABLE IF EXISTS student;
DROP TABLE IF EXISTS faculty;
DROP TABLE IF EXISTS teaches;
DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS prereqs;
DROP TABLE IF EXISTS schedule;
DROP TABLE IF EXISTS course;
DROP TABLE IF EXISTS person;

CREATE TABLE person (

        u_id            CHAR(8),
        username        VARCHAR(15),
        password        VARCHAR(15),
        fname           VARCHAR(15),
        lname           VARCHAR(15),
        address         VARCHAR(30),
        email           VARCHAR(25),
        PRIMARY KEY (u_id)

);

CREATE TABLE student (

        u_id            CHAR(8),
        program         VARCHAR(15),
        PRIMARY KEY (u_id),
        FOREIGN KEY (u_id) references person(u_id)

);

CREATE TABLE faculty (

        u_id            CHAR(8),
        PRIMARY KEY (u_id),
        FOREIGN KEY (u_id) references person(u_id)

);

CREATE TABLE admin (

        u_id            CHAR(8),
        isGS            BOOLEAN,
        PRIMARY KEY (u_id),
        FOREIGN KEY (u_id) references person(u_id)

);

CREATE TABLE course (

        c_id            CHAR(4),
        dept            CHAR(4),
        name            VARCHAR(25),
        credits         INT(1),
        PRIMARY KEY (c_id, dept)

);

CREATE TABLE schedule (

        c_id            CHAR(4),
        dept            CHAR(4),
        year            CHAR(4),
        section         INT(2),
        semester        VARCHAR(10),
        day             CHAR(1),
        start_time      DECIMAL(30,2),
        end_time        DECIMAL(30,2),
        room            VARCHAR(15),
        PRIMARY KEY (c_id, dept, year, section, semester),
        FOREIGN KEY (c_id, dept) references course(c_id, dept)

);

CREATE TABLE takes (

        c_id            CHAR(4),
        dept            CHAR(4),
        year            CHAR(4),
        section         INT(2),
        semester        VARCHAR(10),
        u_id            CHAR(8),
        grade           CHAR(2),
        PRIMARY KEY (u_id, c_id, dept, year, section, semester),
        FOREIGN KEY (u_id) references student(u_id),
        FOREIGN KEY (c_id, dept, year, section, semester) references schedule(c_id, dept, year, section, semester)

);

CREATE TABLE prereqs (

        c_id            CHAR(4),
        req_cid         CHAR(4),
        ismain          BOOLEAN,
        dept            CHAR(4),
        req_dept        CHAR(4),
        PRIMARY KEY (c_id, req_cid, dept),
        FOREIGN KEY (c_id, dept) references course(c_id, dept),
        FOREIGN KEY (req_cid, req_dept) references course(c_id, dept)

);

CREATE TABLE teaches (

        c_id            CHAR(4),
        dept		CHAR(4),
        year            CHAR(4),
        section         INT(2),
        semester       VARCHAR(10),
        u_id            CHAR(8),
        PRIMARY KEY (c_id, dept, year, section, semester),
        FOREIGN KEY (c_id, dept, year, section, semester) references schedule(c_id, dept, year, section, semester)

);

