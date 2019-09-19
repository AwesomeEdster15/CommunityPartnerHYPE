CREATE TABLE Patron (
    userName VARCHAR(100),
    passWord VARCHAR(120),
    email VARCHAR(100),
    phoneNumber INT(10),
    isAdmin BOOLEAN,
    PRIMARY KEY (userName)
);

CREATE TABLE ProductType (
    productLine VARCHAR(100),
    stockCount INT(10),
    rewritable BOOLEAN,
    imageLink VARCHAR(1000),
    productName VARCHAR(100),
    requestPeriod DATE,
    PRIMARY KEY (productName)
);

CREATE TABLE ProductKeywords (
    keywordID INT(10),
    productLine VARCHAR(100),
    keyword VARCHAR(100),
    PRIMARY KEY (keywordID),
    FOREIGN KEY productID REFERENCES ProductType(productID)
)

CREATE TABLE Reservation (
    userName VARCHAR(100),
    dateIn DATE,
    dateOut DATE,
    itemID INT(10),
    expectedReturnDate DATE,
    PRIMARY KEY (itemID),
    FOREIGN KEY (userName) REFERENCES Patron(userName)
);

CREATE TABLE Item (
    itemID INT(10),
    comments VARCHAR(1000),
    productName VARCHAR(100),
    inStock BOOLEAN,
    PRIMARY KEY (productName),
    FOREIGN KEY itemID REFERENCES Reservation(itemID),
    FOREIGN KEY productName REFERENCES ProductType(productName)
);
