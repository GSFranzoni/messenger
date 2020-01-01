drop database if exists messenger;
create database messenger;
use messenger;
create table if not exists User (
    id INT AUTO_INCREMENT,
    email VARCHAR(200) NOT NULL,
    password VARCHAR(50) NOT NULL,
    name VARCHAR(300) NOT NULL,
    avatar VARCHAR(200) NOT NULL,
    constraint pk_user PRIMARY KEY (id)
);

create table if not exists Message (
    id INT AUTO_INCREMENT,
    _to INT  NOT NULL,
    _from INT  NOT NULL,
    text VARCHAR(200) NOT NULL,
    moment DATE NOT NULL,
    constraint pk_category PRIMARY KEY (id),
    constraint fk_to_user FOREIGN KEY (_to) references User(id),
    constraint fk_from_user FOREIGN KEY (_from) references User(id)
);
