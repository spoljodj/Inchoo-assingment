drop database if exists picdatabase;
create database picdatabase default character set utf8;
# c:\xampp\mysql\bin\mysql.exe -uspoljar -pmatija --default_character_set=utf8 < D:\PP20\zadatak.hr\database.sql



# BACKUP
# c:\xampp\mysql\bin\mysqldump.exe -uspoljar -pmatija edunovapp20 > f:\backupdatabase.sql
use picdatabase;

create table user(
    user_id         int not null primary key auto_increment,
    email           varchar(50) not null,
    user_password   char(60) not null,
    user_name        varchar(50) not null,
    sessionid       varchar(100)
);

create table album(
    picture_id      int not null primary key auto_increment,
    posting_user    int not null,
    picture_name    varchar(100)
);

alter table album add foreign key(posting_user) references user(user_id);

insert into user(user_id,email,user_password,user_name,sessionid) values
(null,'spoljo1122@gmail.com','$2y$10$34K.VGo7JO/rdwHWyxS12uED7axurDUnrwNUBSGYakjotkhxxupC6','spoljo',null);