/*
--------------------------------------------------------
OMT © 2022
Thomas GOILLOT
-------------------------------------------------------- 
*/
CREATE TABLE OMT_USER(
   id_user INT AUTO_INCREMENT,
   firstname VARCHAR(50)  NOT NULL,
   surname VARCHAR(50)  NOT NULL,
   mail VARCHAR(250)  NOT NULL,
   password VARCHAR(250)  NOT NULL,
   phone_number CHAR(10) ,
   permissions_level INT NOT NULL,
   date_of_birth VARCHAR(50)  NOT NULL,
   gender CHAR(1) ,
   height DOUBLE,
   weight DOUBLE,
   descritption VARCHAR(255) ,
   PRIMARY KEY(id_user)
);

CREATE TABLE EXERCISE(
   id_exercise INT AUTO_INCREMENT,
   exercise_name VARCHAR(50) ,
   exercise_picture VARCHAR(50) ,
   exercise_info VARCHAR(255) ,
   PRIMARY KEY(id_exercise)
);

CREATE TABLE TRAINING(
   id_training INT AUTO_INCREMENT,
   name_training VARCHAR(50) ,
   privacy_training INT,
   creation_date DATETIME,
   id_user INT NOT NULL,
   PRIMARY KEY(id_training),
   FOREIGN KEY(id_user) REFERENCES OMT_USER(id_user)
);

CREATE TABLE OBJECTIVE(
   id_objective INT AUTO_INCREMENT,
   name VARCHAR(35)  NOT NULL,
   description VARCHAR(255) ,
   id_user INT NOT NULL,
   PRIMARY KEY(id_objective),
   FOREIGN KEY(id_user) REFERENCES OMT_USER(id_user)
);

CREATE TABLE EVENT(
   id_event INT AUTO_INCREMENT,
   name VARCHAR(50)  NOT NULL,
   date_start DATETIME,
   date_end DATETIME,
   description VARCHAR(255) ,
   link VARCHAR(255) ,
   id_user INT NOT NULL,
   PRIMARY KEY(id_event),
   FOREIGN KEY(id_user) REFERENCES OMT_USER(id_user)
);

CREATE TABLE BADGE(
   id_badge INT AUTO_INCREMENT,
   name_badge VARCHAR(50)  NOT NULL,
   img_badge VARCHAR(50) ,
   description_badge VARCHAR(250) ,
   nb_seance_user_required INT,
   PRIMARY KEY(id_badge)
);

CREATE TABLE TCHAT(
   id_message INT AUTO_INCREMENT,
   content VARCHAR(255)  NOT NULL,
   PRIMARY KEY(id_message)
);

CREATE TABLE USER_GROUP(
   id_group INT AUTO_INCREMENT,
   group_name VARCHAR(50) ,
   group_description VARCHAR(255) ,
   PRIMARY KEY(id_group)
);

CREATE TABLE PRODUCT(
   id_product INT AUTO_INCREMENT,
   name VARCHAR(50)  NOT NULL,
   price DOUBLE NOT NULL,
   desccription VARCHAR(255) ,
   img VARCHAR(50) ,
   quantity INT,
   PRIMARY KEY(id_product)
);

CREATE TABLE AVATAR(
   id_avatar INT AUTO_INCREMENT,
   head VARCHAR(50)  NOT NULL,
   eyes VARCHAR(50)  NOT NULL,
   mouth VARCHAR(50)  NOT NULL,
   noze VARCHAR(50)  NOT NULL,
   hairs VARCHAR(50) ,
   id_user INT NOT NULL,
   PRIMARY KEY(id_avatar),
   FOREIGN KEY(id_user) REFERENCES OMT_USER(id_user)
);

CREATE TABLE USER_LOG(
   id_log VARCHAR(50) ,
   activity VARCHAR(50)  NOT NULL,
   date_of_activity DATE NOT NULL,
   id_user INT NOT NULL,
   PRIMARY KEY(id_log),
   FOREIGN KEY(id_user) REFERENCES OMT_USER(id_user)
);

CREATE TABLE USER_VISIT(
   id_connexion INT AUTO_INCREMENT,
   date_connection DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
   id_user INT NOT NULL,
   PRIMARY KEY(id_connexion),
   FOREIGN KEY(id_user) REFERENCES OMT_USER(id_user)
);

CREATE TABLE TRAINING_ORDER(
   id_training INT,
   id_exercise INT,
   id_training_order INT AUTO_INCREMENT PRIMARY KEY,
   training_exercise_order INT NOT NULL,
   duration VARCHAR(20)  NOT NULL,
   FOREIGN KEY(id_training) REFERENCES TRAINING(id_training),
   FOREIGN KEY(id_exercise) REFERENCES EXERCISE(id_exercise)
);

CREATE TABLE TRAINING_HISTORICAL(
    id_training_historical INT AUTO_INCREMENT PRIMARY KEY,
   id_user INT,
   id_training INT,
   training_duration TIME NOT NULL,
   training_date DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
   FOREIGN KEY(id_user) REFERENCES OMT_USER(id_user),
   FOREIGN KEY(id_training) REFERENCES TRAINING(id_training)
);


CREATE TABLE SEND_MESSAGE(
   id_user INT,
   id_message INT,
   publication_date DATETIME NOT NULL,
   PRIMARY KEY(id_user, id_message),
   FOREIGN KEY(id_user) REFERENCES OMT_USER(id_user),
   FOREIGN KEY(id_message) REFERENCES TCHAT(id_message)
);

CREATE TABLE PARTICIPATE_EVENT(
   id_user INT,
   id_event INT,
   PRIMARY KEY(id_user, id_event),
   FOREIGN KEY(id_user) REFERENCES OMT_USER(id_user),
   FOREIGN KEY(id_event) REFERENCES EVENT(id_event)
);

CREATE TABLE GROUP_EVENT_OWNED(
   id_event INT,
   id_group INT,
   PRIMARY KEY(id_event, id_group),
   FOREIGN KEY(id_event) REFERENCES EVENT(id_event),
   FOREIGN KEY(id_group) REFERENCES USER_GROUP(id_group)
);

CREATE TABLE COLLECTED_BADGE(
   id_user INT,
   id_badge INT,
   date_of_delivery DATETIME NOT NULL,
   PRIMARY KEY(id_user, id_badge),
   FOREIGN KEY(id_user) REFERENCES OMT_USER(id_user),
   FOREIGN KEY(id_badge) REFERENCES BADGE(id_badge)
);

CREATE TABLE RELATIONSHIP(
   id_user INT,
   id_user_1 INT,
   friendship_status INT,
   id_blocker INT,
   PRIMARY KEY(id_user, id_user_1),
   FOREIGN KEY(id_user) REFERENCES OMT_USER(id_user),
   FOREIGN KEY(id_user_1) REFERENCES OMT_USER(id_user)
);

CREATE TABLE GROUP_RELATIONSHIP(
   id_user INT,
   id_group INT,
   group_status INT NOT NULL,
   PRIMARY KEY(id_user, id_group),
   FOREIGN KEY(id_user) REFERENCES OMT_USER(id_user),
   FOREIGN KEY(id_group) REFERENCES USER_GROUP(id_group)
);

CREATE TABLE APPRECIATION(
   id_appreciation INT AUTO_INCREMENT PRIMARY KEY,
   id_user INT,
   id_training INT,
   stars VARCHAR(50)  NOT NULL,
   comment VARCHAR(255) ,
   date_of_add DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
   FOREIGN KEY(id_user) REFERENCES OMT_USER(id_user),
   FOREIGN KEY(id_training) REFERENCES TRAINING(id_training)
);

CREATE TABLE SUBSCRIBE(
   id_subscribe INT AUTO_INCREMENT,
   subscribe_name VARCHAR(50),
   subscribe_price DOUBLE,
   subscribe_description VARCHAR(255) ,
   id_subscribe_inheritance INT,
   PRIMARY KEY(id_subscribe),
   FOREIGN KEY(id_subscribe_inheritance) REFERENCES SUBSCRIBE(id_subscribe)
);

CREATE TABLE GIVE_TOOL(
   id_user INT,
   id_subscribe INT,
   date_of_delivery DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(id_user, id_subscribe),
   FOREIGN KEY(id_user) REFERENCES OMT_USER(id_user),
   FOREIGN KEY(id_subscribe) REFERENCES SUBSCRIBE(id_subscribe)
);

CREATE TABLE ORDER_PRODUCT(
   id_user INT,
   id_product INT,
   date_of_purchase DATETIME NOT NULL,
   total_price DOUBLE,
   PRIMARY KEY(id_user, id_product),
   FOREIGN KEY(id_user) REFERENCES OMT_USER(id_user),
   FOREIGN KEY(id_product) REFERENCES PRODUCT(id_product)
);



