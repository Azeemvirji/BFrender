DROP TABLE IF EXISTS `friends`;

CREATE TABLE `friends` (
  `friendId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL,
  `FriendsID` int(10) NOT NULL,
  PRIMARY KEY (`friendId`),
  FOREIGN KEY (`userID`) REFERENCES users(`userId`)

);

insert  into `friends`(`friendID`,`userId`,`FriendsID`) values (1,1,2);
insert  into `friends`(`friendID`,`userId`,`FriendsID`) values (2,1,3);
insert  into `friends`(`friendID`,`userId`,`FriendsID`) values (3,2,3);
