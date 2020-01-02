drop database if exists messenger;
create database messenger;
use messenger;
create table if not exists User (
    id INT AUTO_INCREMENT,
    email VARCHAR(200) NOT NULL,
    password VARCHAR(50) NOT NULL,
    name VARCHAR(300) NOT NULL,
    constraint pk_user PRIMARY KEY (id)
);

create table if not exists Message (
    id INT AUTO_INCREMENT,
    text VARCHAR(200) NOT NULL,
    moment DATE NOT NULL,
    _to INT  NOT NULL,
    _from INT  NOT NULL,
    chat INT NOT NULL,
    constraint pk_category PRIMARY KEY (id),
    constraint fk_to_user FOREIGN KEY (_to) references User(id),
    constraint fk_from_user FOREIGN KEY (_from) references User(id),
    constraint fk_chat FOREIGN KEY (chat) references Chat(id)
);

create table if not exists Chat (
    id INT AUTO_INCREMENT,
    user1 INT  NOT NULL,
    user2 INT  NOT NULL,
    constraint pk_chat PRIMARY KEY (id),
    constraint fk_user1_user FOREIGN KEY (user1) references User(id),
    constraint fk_user2_user FOREIGN KEY (user2) references User(id)
);

DROP TRIGGER IF EXISTS check_duplicate;
delimiter //
CREATE TRIGGER check_duplicate BEFORE INSERT ON Chat
FOR EACH ROW
BEGIN 
	DECLARE result int;
    SELECT COUNT(*) 
		INTO result
		FROM Chat
        WHERE (user1 = NEW.user1 AND user2 = NEW.user2) OR 
			  (user1 = NEW.user2 AND user2 = NEW.user1);
	if(result>0) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Estes usuários já possuem um Chat criado!';
    END IF;
END
// delimiter ;