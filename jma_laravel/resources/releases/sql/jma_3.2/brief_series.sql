CREATE TABLE briefseries(
briefseries_id INT(11) AUTO_INCREMENT,
briefseries_type VARCHAR(10),
briefseries_title TEXT,
briefseries_description TEXT,
briefseries_title_img VARCHAR(100),
briefseries_summary_path VARCHAR(130),
briefseries_ppt_path VARCHAR(130),
briefseries_date DATE,
is_premium ENUM('Y','N'),
PRIMARY KEY(briefseries_id)
);