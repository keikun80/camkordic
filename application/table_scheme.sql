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

create table tbl_invent_user (
  usrKey serial,
  usrName varchar(255) not null,
  usrEmail varchar(255) not null,
  usrPass varchar(255) not null,
  isDel enum('y','n') default 'n'
);

create table tbl_code_tour (
  torKey serial,
  orgKey int not null,
  torName varchar(255) not null,
  torDesc text not null,
  isDel enum('y', 'n') default 'n'
);

create table tbl_code_org (
    orgKey serial,
    orgName varchar(255) not null,
    orgPerson varchar(255) not null,
    orgTaxCode varchar(255),
    orgMobile varchar(255),
    isDel enum('y','n') default 'n'
);
