create table if not exists b_lisenkov_award (
	ID int primary key auto_increment,
	USER_ID int,
	DATE timestamp default current_timestamp,
	TASK int,
	AWARD varchar(255)
);