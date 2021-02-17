DROP TABLE IF EXISTS `messages`;

CREATE TABLE messages (
  `messageId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `messageString` text(255) NOT NULL,
  `senderID` int(10) NOT NULL,
  `receiverID` int(10) NOT NULL,
  `timeSent` datetime NOT NULL,
    PRIMARY KEY (`messageID`),
    FOREIGN KEY (`senderID`) REFERENCES users(`userId`),
    FOREIGN KEY (`receiverID`) REFERENCES friendz(`friendId`)
);
