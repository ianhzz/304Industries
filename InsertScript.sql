Insert into Supplier
Values (‘123’, ‘Factory 1’, ‘Chicago’);
Insert into Supplier
Values (‘456’, ‘Factory 2’, ‘Edmonton’);
Insert into Retailer
Values (‘987’, ‘H & N’, ‘Vancouver’);
Insert into Retailer
Values (‘654’, ‘Zera’, ‘Richmond’) ;
Insert into Clothing
Values (‘111123’, ‘Cool shirt’, ‘button-down’, ‘blue’, ‘cotton’, ‘123’, 59.98’, ‘Brand 1’);
Insert into Top
Values (‘111123’, ‘L’);
Insert into Inventory
Values (‘111123’, ‘50’, ‘123’);
Insert into clothing values (306240, ‘Golf Shirt’, ‘polo’, ‘white’, ‘cotton’, 123, ‘70’, ‘Brand 2’);
Insert into top values (306240, ‘M’);
Insert into inventory values (306240, 50, 123);      
Insert into clothing values (123456, ‘Fast Shoes’, ‘sneakers’, ‘red’,’polyester’, 456, ‘69.99’, ‘Brand 2’);
Insert into shoes values (123456, 10);
Insert into inventory values (123456, 4, 456);
Insert into clothing values (999999, ‘Speedy Shoes’, ‘sneakers’, ‘black’,’rubber’, 456, ‘89.99’, ‘Brand 1’);
Insert into shoes values (999999, 12);
Insert into inventory values (999999, 9, 456);
Insert into clothing values (101010, ‘Nice Pants’, ‘jeans’, ‘blue’, ‘denim’, 123, ‘49.99’, ‘Brand 1’);
Insert into bottom values (101010, 30,32);
Insert into inventory values (101010, 15, 123);
Insert into clothing values (300010, ‘Work Pants’, ‘khakis’, ‘khaki’, ‘cotton twill fabric’, 456, ‘29.99’, ‘Brand 2’);
Insert into bottom values (300010, 34, 34);
Insert into inventory values (300010, 100, 456);
Insert into member (name, email, address)
Values (‘Adam’, ‘thefirst@gmail.com’, ‘123 Garden of Eden Road’);
Insert into member (name, email, address)
Values (‘Eve’, ‘thesecond@gmail.com’, ‘122 Garden of Eden Road’);

insert into promotion (startdate, enddate, discount)
values (to_date('2019-06-01', 'yyyy-mm-dd'), to_date('2019-06-30', 'yyyy-mm-dd'), 20);
insert into promotion (startdate, enddate, discount)
values (to_date('2019-01-01', 'yyyy-mm-dd'), to_date('2019-06-01', 'yyyy-mm-dd'), 10);
insert into promotion (startdate, enddate, discount)
values (to_date('2019-06-30', 'yyyy-mm-dd'), to_date('2019-07-31', 'yyyy-mm-dd'), 50);
insert into promotion (startdate, enddate, discount)
values (to_date('2019-06-15', 'yyyy-mm-dd'), to_date('2019-06-30', 'yyyy-mm-dd'), 5);

insert into memberorderonline (memberid, barcode, orderdate, amount, approved)
values (1, 111123, to_date('2019-06-01', 'yyyy-mm-dd'), 4, 1);
insert into memberorderonline (memberid, barcode, orderdate, amount, approved)
values (2, 101010, to_date('2019-06-19', 'yyyy-mm-dd'), 2, -1);
insert into memberorderonline (memberid, barcode, orderdate, amount, approved)
values (2, 300010, to_date('2019-01-01', 'yyyy-mm-dd'), 15, 1);
insert into memberorderonline (memberid, barcode, orderdate, amount, approved)
values (2, 306240, to_date('2019-06-30', 'yyyy-mm-dd'), 5, -1);
insert into memberorderonline (memberid, barcode, orderdate, amount, approved)
values (1, 101010, to_date('2019-06-19', 'yyyy-mm-dd'), 3, -1);
insert into memberorderonline (memberid, barcode, orderdate, amount, approved)
values (1, 306240, to_date('2019-06-30', 'yyyy-mm-dd'), 7, -1);

Insert into RetailerOrderFromInventory (RetailerID, Barcode, Amount, OrderDate)
Values (‘987’, ‘101010’, ‘10’, to_date(‘2019-05-21’, ‘yyyy-mm-dd’));
Insert into RetailerOrderFromInventory (RetailerID, Barcode, Amount, OrderDate)
Values (‘987’, ‘123456’, ‘5’, ‘to_date(‘2019-06-20’, ‘yyyy-mm-dd’));
Insert into RetailerOrderFromInventory (RetailerID, Barcode, Amount, OrderDate)
Values (‘654’, ‘101010’, ‘8’, ‘to_date(‘2019-09-12’, ‘yyyy-mm-dd’));
Insert into RetailerOrderFromInventory (RetailerID, Barcode, Amount, OrderDate)
Values (‘654’, ‘306240’, ‘12’, ‘to_date(‘2019-12-09’, ‘yyyy-mm-dd’));


Commit;
