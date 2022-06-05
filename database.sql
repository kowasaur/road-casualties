CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password CHAR(60) NOT NULL,
    phone_number CHAR(10),
    is_admin BOOLEAN NOT NULL,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    address VARCHAR(255)
);

CREATE TABLE alerts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    -- These two would be from Road crash locations
    location VARCHAR(255) NOT NULL, -- Loc_Local_Government_Area
    severity VARCHAR(255) NOT NULL, -- Crash_Severity
    via_email BOOLEAN NOT NULL, -- email or phone number
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE road_casualties (
    year INT,
    region ENUM('Unknown', 'Brisbane', 'Central', 'South Eastern', 'Southern', 'North Coast', 'Northern', 'Far Northern'),
    severity ENUM('Fatality', 'Hospitalised', 'Medically treated', 'Minor injury'),
    age_group ENUM('Unknown', '0 to 16', '17 to 24', '25 to 29', '30 to 39', '40 to 49', '50 to 59', '60 to 74', '75 and over'),
    gender ENUM('Unknown', 'Male', 'Female'),
    road_user_type ENUM('Bicyclist', 'Driver', 'Motorcyclist', 'Passenger', 'Pedestrian', 'Other'),
    amount INT NOT NULL,
    CONSTRAINT id PRIMARY KEY (year, region, severity, age_group, gender, road_user_type)
);
