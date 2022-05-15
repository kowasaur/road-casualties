CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password CHAR(60) NOT NULL,
    phone_number CHAR(10),
    is_admin BOOLEAN NOT NULL
    -- TODO: address and name
);

CREATE TABLE road_casualties (
    id INT PRIMARY KEY AUTO_INCREMENT,
    year INT NOT NULL,
    region ENUM('Unknown', 'Brisbane', 'Central', 'South Eastern', 'Southern', 'Northern') NOT NULL,
    severity ENUM('Fatality', 'Hospitalised', 'Medically treated', 'Minor injury') NOT NULL,
    age_group ENUM('Unknown', '0 to 16', '17 to 24', '25 to 29', '30 to 39', '40 to 49', '50 to 59', '60 to 74', '75 and over') NOT NULL,
    gender ENUM('Unknown', 'Male', 'Female') NOT NULL,
    road_user_type ENUM('Bicyclist', 'Driver', 'Motorcyclist', 'Passenger', 'Pedestrian', 'Other') NOT NULL,
    amount INT NOT NULL
);
