-- Active: 1703775593046@@127.0.0.1@3306@pweb
-- tables.sql


-- Users table
CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    phonenumber VARCHAR(10),
    Email VARCHAR(100) UNIQUE,
    Role ENUM('driver', 'passenger','admin') NOT NULL,
    Password VARCHAR(255) -- Hashed password
);

-- Rides table
CREATE TABLE Rides (
    RideID INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    DriverID INT NOT NULL,
    DepartureLocation VARCHAR(100),
    Destination VARCHAR(100),
    DepartureTime DATETIME,
    AvailableSeats INT,
    price INT,
    destinationLatitude VARCHAR(255),
    destinationLongitude VARCHAR(255),
    positionLatitude VARCHAR(255),
    positionLongitude VARCHAR(255),
    FOREIGN KEY (DriverID) REFERENCES Users(UserID) 
);


CREATE TABLE reservations (
    ReservationID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT, 
    RideID INT,
    FOREIGN KEY (RideID) REFERENCES rides(RideID)
);
