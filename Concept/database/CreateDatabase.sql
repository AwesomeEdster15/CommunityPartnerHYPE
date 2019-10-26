CREATE TABLE Patron (
    userName VARCHAR(100) NOT NULL,
    firstName VARCHAR(100),
    lastInitial CHAR(1),
    passWord VARCHAR(120),
    email VARCHAR(100),
    phoneNumber VARCHAR(10),
    isAdmin BOOLEAN,
    PRIMARY KEY (userName)
);

-- To add firstName and lastInital to an already existing Patron
-- table, run this:
-- ALTER TABLE Patron
--     ADD firstName VARCHAR(100),
--     ADD lastInitial CHAR(1);

-- To change rewritable to reusable in an already existing ProductType table:
-- ALTER TABLE ProductType Change rewritable reusable BOOLEAN 

-- To change requestPeriod to an integer (number of days):
-- ALTER TABLE ProductType Change requestPeriod requestPeriod INTEGER 
-- ALTER TABLE ProductType Change productLine productLink VARCHAR(100)

-- To add auto-increment to the id fields, run this:
-- ALTER TABLE ProductKeywords CHANGE keywordID keywordID INT(10) NOT NULL AUTO_INCREMENT;
-- ALTER TABLE Item CHANGE itemID itemID INT(10) NOT NULL AUTO_INCREMENT;
-- ALTER TABLE Reservation CHANGE reservationID reservationID INT(10) NOT NULL AUTO_INCREMENT;

-- To add the itemName field to the Item table:
-- ALTER TABLE Item ADD itemName VARCHAR(100);

CREATE TABLE ProductType (
    imageLink VARCHAR(1000),
    productName VARCHAR(100),
    productLink VARCHAR(100),
    stockCount INTEGER(10),
    reusable BOOLEAN,
    requestPeriod INTEGER,
    PRIMARY KEY (productName)
);

CREATE TABLE ProductKeywords (
    keywordID INTEGER(10) NOT NULL AUTO_INCREMENT,
    productLine VARCHAR(100),
    keyword VARCHAR(100),
    productName VARCHAR(100),
    PRIMARY KEY (keywordID),
    FOREIGN KEY (productName) REFERENCES ProductType(productName)
);

CREATE TABLE Item (
    itemID INTEGER(10) NOT NULL AUTO_INCREMENT,
    itemName VARCHAR(100),
    comments VARCHAR(1000),
    productName VARCHAR(100),
    inStock BOOLEAN,
    PRIMARY KEY (itemID),
    FOREIGN KEY (productName) REFERENCES ProductType(productName)
);

CREATE TABLE Reservation (
    reservationID INTEGER(10) NOT NULL AUTO_INCREMENT,
    userName VARCHAR(100),
    dateIn DATE,
    dateOut DATE,
    itemID INTEGER(10),
    expectedReturnDate DATE,
    PRIMARY KEY (reservationID),
    FOREIGN KEY (userName) REFERENCES Patron(userName),
    FOREIGN KEY (itemID) REFERENCES Item(itemID)
);


