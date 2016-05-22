CREATE TABLE notifications
(
	comment_id INT,
	member_id INT,
	is_read BOOLEAN DEFAULT FALSE,
	
	PRIMARY KEY (comment_id, member_id),
	FOREIGN KEY (comment_id) REFERENCES comments(id),
	FOREIGN KEY (member_id) REFERENCES members(id)
);