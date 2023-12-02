ALTER TABLE post ADD COLUMN post_mail_notification ENUM('N','Y') DEFAULT 'N';

UPDATE post SET post_mail_notification = 'Y' WHERE post_mail_notification = 'N';