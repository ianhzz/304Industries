drop table MemberOrderOnlineStock;
drop table MemberOrderOnline;
drop table RetailerOrderFromInventory;
drop table Inventory;
drop table Bottom;
drop table Top;
drop table Shoes;
drop table Clothing;
drop table Promotion;
drop table Member;
drop table Retailer;
drop table Supplier;

create table Supplier (
    ID int primary key,
    Name varchar2(30),
    Location varchar2(30)
);

create table Retailer (
    ID int primary key,
    Name varchar2(30),
    Location varchar2(30)
);
create table Member (
    id integer generated always as identity,
    name varchar2(20) not null,
    email varchar2(30),
    address varchar2(30),
    primary key (id));

create table Promotion (
id integer generated always as identity,
startdate date not null,
enddate date,
discount integer,
      primary key (id)
);

create table Clothing (
    Barcode int primary key,
    Name varchar2(20),
    Type varchar2(15) not null,
    Color varchar(10),
    Materials varchar2(20),
    SupplierID int,
    Price real not null,
    Brand varchar(20),
    foreign key (SupplierID) references Supplier(ID)
        on delete set null
);

create table Shoes (
    Barcode int primary key,
    ShoeSize real,
    foreign key (Barcode) references Clothing
        on delete cascade
);

create table Top (
    Barcode int primary key,
    Sizing varchar(3),
    foreign key (Barcode) references Clothing
        on delete cascade
);

create table Bottom (
    Barcode int primary key,
    WaistSize real,
    Length real,
    foreign key (Barcode) references clothing
        on delete cascade
);

create table Inventory (
    Barcode int primary key,
    Stock int,
    SupplierID int,
    foreign key (Barcode) references Clothing(Barcode)
        on delete cascade,
    foreign key (SupplierID) references Supplier(ID)
);

create table RetailerOrderFromInventory (
    OrderID int generated always as identity,
    RetailerID int not null,
    Barcode int not null,
    Amount int not null,
    OrderDate date not null,
    Approved smallint not null,
    primary key (OrderID),
    foreign key (RetailerID) references Retailer(ID) on delete cascade,
    foreign key (Barcode) references Clothing(Barcode)
);

create table MemberOrderOnline (
OrderID integer generated always as identity,
MemberID integer not null, 
Barcode integer not null,
Amount integer not null,
         OrderDate date not null,
Approved smallint not null,
      primary key(orderid),
      foreign key(barcode) references clothing(Barcode) on delete cascade,
      foreign key(memberid) references member(id) on delete cascade
);

commit;