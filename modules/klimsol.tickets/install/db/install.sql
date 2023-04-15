create table if not exists b_klimsol_faq (
   ID int(11) not null auto_increment,
   DATE int(16) not null,
   QUESTION varchar(500) not null,
   ANSWER varchar(500) not null,
   SORT int(8),
   primary key (ID));