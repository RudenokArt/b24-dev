create table if not exists b_docbrown_tinkoff (
   ID int(11) not null auto_increment,
   DATE int(16) not null,
   OPERATION_ID varchar(11) not null,
   CRM_ID varchar(11) not null,
   primary key (ID)
);