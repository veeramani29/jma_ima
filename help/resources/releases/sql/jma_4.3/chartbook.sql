CREATE TABLE `chartbook_user_folders` LIKE `mychart_user_folders`;

ALTER TABLE chartbook_user_folders ADD COLUMN folder_desc TEXT;


ALTER TABLE user_accounts ADD COLUMN `isAuthor` ENUM('N','Y') DEFAULT 'N';

ALTER TABLE chartbook_user_folders CHANGE  `status` `status` ENUM('ACTIVE','INACTIVE','DELETED') DEFAULT 'INACTIVE';