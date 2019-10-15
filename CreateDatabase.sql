CREATE TABLE Patron (
    userName VARCHAR(100),
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

CREATE TABLE ProductType (
    productLine VARCHAR(100),
    stockCount INTEGER(10),
    reusable BOOLEAN,
    imageLink VARCHAR(1000),
    productName VARCHAR(100),
    requestPeriod DATE,
    PRIMARY KEY (productName)
);

CREATE TABLE ProductKeywords (
    keywordID INTEGER(10),
    productLine VARCHAR(100),
    keyword VARCHAR(100),
    productID VARCHAR(100),
    PRIMARY KEY (keywordID),
    FOREIGN KEY (productID) REFERENCES ProductType(productName)
);

CREATE TABLE Item (
    itemID INTEGER(10),
    comments VARCHAR(1000),
    productName VARCHAR(100),
    inStock BOOLEAN,
    PRIMARY KEY (itemID),
    FOREIGN KEY (productName) REFERENCES ProductType(productName)
);

CREATE TABLE Reservation (
    reservationID INTEGER(10),
    userName VARCHAR(100),
    dateIn DATE,
    dateOut DATE,
    itemID INTEGER(10),
    expectedReturnDate DATE,
    PRIMARY KEY (reservationID),
    FOREIGN KEY (userName) REFERENCES Patron(userName),
    FOREIGN KEY (itemID) REFERENCES Item(itemID)
);


