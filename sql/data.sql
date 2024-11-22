CREATE TABLE applicants (
    applicant_id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(255),
    lname VARCHAR(255),
    assigned_sub VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE accounts (
   user_id INT AUTO_INCREMENT PRIMARY KEY,
   username VARCHAR(255),
   password VARCHAR(255),
   date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    activity VARCHAR(255),
    fname VARCHAR(255),
    lname VARCHAR(255),
    assigned_sub VARCHAR(255),
    username VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
