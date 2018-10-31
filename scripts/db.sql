CREATE DATABASE web_task_two;
USE web_task_two;

CREATE TABLE tblUsers (
    `userId` int not null AUTO_INCREMENT,
    `firstname` varchar(50) not null,
    `lastname` varchar(50) not null,
    `email` varchar(100) not null,
    `passwordHash` text not null,
    primary key (`userId`)
);

CREATE TABLE tblItems (
    `itemId` varchar(50) not null,
    `description` text not null,
    `costPrice` numeric(15,2) not null,
    `quantity` numeric not null,
    `sellPrice` numeric(15,2) not null,
    primary key (`itemId`)
);

CREATE TABLE tblCustomers (
    `customerId` int not null AUTO_INCREMENT,
    `userId` int not null,
    `billingAddress` text not null,
    foreign key (`userId`) references tblUsers(`userId`),
    primary key (`customerId`)
);

CREATE TABLE tblOrders (
    `orderId` int not null AUTO_INCREMENT,
    `customerId` int not null,
    `orderDate` datetime not null,
    `shippingAddress` text not null,
    foreign key (`customerId`) references tblCustomers(`customerId`),
    primary key (`orderId`)
);

CREATE TABLE tblOrderItems (
    `orderItemId` int not null AUTO_INCREMENT,
    `orderId` int not null,
    `itemId` varchar(50) not null,
    `quantity` numeric not null,
    foreign key (`orderId`) references tblOrders(`orderId`),
    foreign key (`itemId`) references tblItems(`itemID`),
    primary key (`orderItemId`)
);