create table if not exists b_live_signature (
   ID int(11) not null auto_increment,
   DATE int(16) not null,
   FILE_ID varchar(11) not null,
   PASSWORD varchar(11) not null,
   SIGNATURE varchar(8)  DEFAULT "N",
   primary key (ID)
   );