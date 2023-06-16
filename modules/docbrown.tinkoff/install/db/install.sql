create table if not exists b_docbrown_tinkoff (
   ID int(11) not null auto_increment,
   DATE int(16) not null,
   OPERATION_ID varchar(55) not null unique,
   ACCOUNT varchar(55) not null,
   AMOUNT int(11) not null,
   CURRENCY varchar(3) not null,
   PURPOSE varchar(255) not null,
   PAYER varchar(255) not null,
   CRM_ID varchar(22),
   primary key (ID)
);