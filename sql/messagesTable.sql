CREATE TABLE messages (
	id INT AUTO_INCREMENT,
	user_id INT NOT NULL,
	weeklyreport_id INT NOT NULL,
	content VARCHAR(1000),
	date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	date_modified DATETIME DEFAULT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES users(id),
	FOREIGN KEY (weeklyreport_id) REFERENCES weeklyreports(id)
);