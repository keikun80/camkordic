drop table tbl_invent_voucher;
create table tbl_invent_voucher (
    vocKey serial,
    cusName varchar(255) not null,
    cusEmail varchar(255) not null,
    cusMobile varchar(255) not null,
    torKey int not null,
    orgKey int not null,
    amount float not null,
    numofpeo int not null,
    vocSer varchar(255) not null,
    departDate datetime not null,
    returnDate datetime not null,
    paymentDate datetime not null,
    openDate datetime not null,
    bookingDate datetime not null,
    isPaid enum('y','n') default 'n',
    isOpen enum('y','n') default 'n',
    isDel enum ('y','n') default 'n'
);
