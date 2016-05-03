CREATE TABLE messages (
	id INT AUTO_INCREMENT,
	user_id INT NOT NULL,
	weeklyreport_id INT NOT NULL,
	content VARCHAR(1000),
	date_created DATE NOT NULL,
	date_modified DATE,
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES users(id),
	FOREIGN KEY (weeklyreport_id) REFERENCES weeklyreports(id)
);