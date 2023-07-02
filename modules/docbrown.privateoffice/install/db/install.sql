create table if not exists b_docbrown_privateoffice_chat (
   ID int(11) not null auto_increment,
   DEAL int(11) not null,
   CONTACT int(11) not null,
   CHAT int(11) not null,
   USER int(11) not null,
   primary key (ID)
);