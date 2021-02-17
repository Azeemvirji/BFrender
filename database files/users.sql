DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `userId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `gender` char(1) NOT NULL,
  `accessLevel` varchar(10) NOT NULL,
  `securityQuestion` varchar(255) NOT NULL,
  `securityAnswer` varchar(255) NOT NULL,
  `postalCode` char(7) NOT NULL,
  `imageLocation` varchar(255),
  `dateJoined` datetime NOT NULL,
  `status` varchar(10) NOT NULL,
  `lastLogin` datetime NOT NULL,
  `frozen` char(1) NOT NULL,
  PRIMARY KEY (`userId`)
);

insert  into `users`(`userId`,`fname`,`lname`,`uname`,`email`,`password`,`dateOfBirth`, `gender`, `accessLevel`,`securityQuestion`,`securityAnswer`,`postalCode`,`imageLocation`,`dateJoined`,`status`,`lastLogin`,`frozen`) values
(1,'Tester','Testee','a','Testew','a','1/2/1990', 'f','admin','Weird Question','Weird Answer', 'M2K 5H7', '/users/pics','2/2/2021 23:59:59','offline','2/2/2021 23:59:59','N');

insert  into `users`(`userId`,`fname`,`lname`,`uname`,`email`,`password`,`dateOfBirth`, `gender`, `accessLevel`,`securityQuestion`,`securityAnswer`,`postalCode`,`imageLocation`,`dateJoined`,`status`,`lastLogin`,`frozen`) values
(2,'Tester1','Testee1','a1','Testew1','a1','1/2/1990', 'f','admin','Weird Question1','Weird Answer1', 'M2K 5H7', '/users/pics','2/2/2021 23:59:59','offline','2/2/2021 23:59:59','N');

insert  into `users`(`userId`,`fname`,`lname`,`uname`,`email`,`password`,`dateOfBirth`, `gender`, `accessLevel`,`securityQuestion`,`securityAnswer`,`postalCode`,`imageLocation`,`dateJoined`,`status`,`lastLogin`,`frozen`) values
(3,'Tester2','Testee2','a2','Testew2','a2','1/2/1990', 'f','admin','Weird Question2','Weird Answer2', 'M2K 5H7', '/users/pics','2/2/2021 23:59:59','offline','2/2/2021 23:59:59','N');

insert  into `users`(`userId`,`fname`,`lname`,`uname`,`email`,`password`,`dateOfBirth`, `gender`, `accessLevel`,`securityQuestion`,`securityAnswer`,`postalCode`,`imageLocation`,`dateJoined`,`status`,`lastLogin`,`frozen`) values
(4,'Tester3','Testee3','a3','Testew3','a3','1/2/1990', 'f','admin','Weird Question3','Weird Answer3', 'M2K 5H7', '/users/pics','2/2/2021 23:59:59','offline','2/2/2021 23:59:59','N');
