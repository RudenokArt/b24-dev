create table if not exists b_live_signature (
   ID int(11) not null auto_increment,
   DATE int(16) not null,
   DOCUMENT_ID int(11) not null,
   FILE_ID int(11) not null,
   PASSWORD varchar(16),
   primary key (ID));