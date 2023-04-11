create table if not exists b_klimsol_faq (
   ID int(11) not null auto_increment,
   DATE timestamp default current_timestamp,
   QUESTION varchar(500) not null,
   ANSWER varchar(500) not null,
   primary key (ID));