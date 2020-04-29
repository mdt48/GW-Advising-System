
INSERT INTO course VALUES (6221, "CSCI",  "SW Paradigms", 3);
INSERT INTO course VALUES (6461, "CSCI", "Computer Architecture", 3);
INSERT INTO course VALUES (6212, "CSCI", "Algorithms", 3);
INSERT INTO course VALUES (6220, "CSCI", "Machiene Learning", 3);
INSERT INTO course VALUES (6232, "CSCI", "Networks 1", 3);
INSERT INTO course VALUES (6233, "CSCI", "Networks 2", 3);
INSERT INTO course VALUES (6241, "CSCI", "Database 1", 3);
INSERT INTO course VALUES (6242, "CSCI", "Database 2", 3);
INSERT INTO course VALUES (6246, "CSCI", "Compilers", 3);
INSERT INTO course VALUES (6260, "CSCI", "Multimedia", 3);
INSERT INTO course VALUES (6251, "CSCI", "Cloud Computing", 3);
INSERT INTO course VALUES (6254, "CSCI", "SW Engineering", 3);
INSERT INTO course VALUES (6262, "CSCI", "Graphics 1", 3);
INSERT INTO course VALUES (6283, "CSCI", "Security 1", 3);
INSERT INTO course VALUES (6284, "CSCI", "Cryptography", 3);
INSERT INTO course VALUES (6286, "CSCI", "Network Security", 3);
INSERT INTO course VALUES (6325, "CSCI", "Algorithms 2", 3);
INSERT INTO course VALUES (6339, "CSCI", "Embedded Systems", 3);
INSERT INTO course VALUES (6384, "CSCI", "Cryptography 2", 3);
INSERT INTO course VALUES (6241, "ECE", "Communication Theory", 3);
INSERT INTO course VALUES (6242, "ECE", "Information Theory", 2);
INSERT INTO course VALUES (6210, "MATH", "Logic", 2);


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



INSERT INTO person VALUES
(88888888, "bholiday", "password", "Billie", "Holiday", "12 Main St Washington, DC", "mbuckley22@gwu.edu");
INSERT INTO student VALUES
(88888888, "Masters");
INSERT INTO takes VALUES
(6461, "CSCI", 2020, 1, "Spring", 88888888, "IP");
INSERT INTO takes VALUES
(6212, "CSCI", 2020, 1, "Spring", 88888888, "IP");
INSERT INTO person VALUES
(99999999, "dkrall", "password", "Diana", "Krall", "2350 H St NW Washington, DC", "mbuckley22@gwu.edu");
INSERT INTO student VALUES
(99999999, "Masters");
INSERT INTO person VALUES
(12345678, "bnarahari", "password", "Bhagi", "Narahari", "SEH", "mbuckley22@gwu.edu");
INSERT INTO faculty VALUES
(12345678);
INSERT INTO teaches VALUES
(6461, "CSCI", 2020, 1, "Spring", 12345678);
INSERT INTO person VALUES
(87654321, "hchoi", "password", "Hyeong", "Choi", "SEH", "mbuckley22@gwu.edu");
INSERT INTO faculty VALUES
(87654321);
INSERT INTO teaches VALUES
(6212, "CSCI", 2020, 1, "Spring", 87654321);
INSERT INTO person VALUES
(12121212, "mbuckley", "password", "Molly", "Buckley", "2350 H St NW Washington, DC", "mbuckley22@gwu.edu");
INSERT INTO admin VALUES
(12121212, true);


INSERT INTO person VALUES
(22223333, "sgassman", "password", "Sam", "Gassman", "2350 H St NW Washington, DC", "mbuckley22@gwu.edu");
INSERT INTO admin VALUES
(22223333, false);
