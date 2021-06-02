# drop database if exists contract_database;

create database contract_database CHARACTER SET utf8 COLLATE utf8_persian_ci;



USE contract_database;

DROP TABLE IF EXISTS php_session;
CREATE TABLE php_session (
  SessionID varchar(32) NOT NULL DEFAULT '',
  DateCreated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  SessionData TEXT,
  PRIMARY KEY  (SessionID)
);

DROP TABLE IF EXISTS user;
CREATE TABLE user(
	ID INT NOT NULL UNIQUE AUTO_INCREMENT,
	Name varchar(60) NOT NULL,
	Phone_Number varchar(11) NOT NULL,
	CitizenID varchar(10) NOT NULL,
	Password varchar(255),
	PhoneConfirmed char(1) NOT NULL DEFAULT 0,
	CitizenIDConfirmed char(1) NOT NULL DEFAULT 0,
    TimeCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (ID)
);

Drop TABLE IF EXISTS user_emails;
CREATE TABLE user_emails(
     ID INT NOT NULL UNIQUE AUTO_INCREMENT,
     UserID INT NOT NULL,
     Email varchar(30) NOT NULL UNIQUE,
     EmailConfirmed char(1) NOT NULL DEFAULT 0,
     TimeCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     ActiveStatus ENUM ('ACTIVE','INACTIVE'),
     PRIMARY KEY (ID),
     FOREIGN KEY (UserID) REFERENCES user(ID)
);

DROP TABLE IF EXISTS user_signature;
CREATE TABLE user_signature(
	ID INT NOT NULL UNIQUE AUTO_INCREMENT,
	UserID INT NOT NULL,
   FileAddress varchar(100) NOT NULL,
	HashSig  varchar(64) NOT NULL,
   ActiveStatus ENUM ('ACTIVE','INACTIVE'),
    TimeCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (ID),
	FOREIGN KEY (UserID) REFERENCES user(ID)
);

DROP TABLE IF EXISTS private_key;
CREATE TABLE private_key(
	ID INT NOT NULL UNIQUE AUTO_INCREMENT,
	UserID INT NOT NULL,
	ActiveStatus ENUM ('ACTIVE','INACTIVE'),
	PrKey LONGBLOB NOT NULL,
    TimeCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (ID),
	FOREIGN KEY (UserID) REFERENCES user(ID)
);

DROP TABLE IF EXISTS public_key;
CREATE TABLE public_key(
    ID INT NOT NULL UNIQUE AUTO_INCREMENT,
    UserID INT NOT NULL,
    ActiveStatus ENUM ('ACTIVE','INACTIVE'),
    PuKey LONGBLOB NOT NULL,
    TimeCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (ID),
    FOREIGN KEY (UserID) REFERENCES user(ID)
);

DROP TABLE IF EXISTS access_control_list;
CREATE TABLE access_control_list(
	ID INT NOT NULL UNIQUE AUTO_INCREMENT,
	UserID INT NOT NULL,
	CanCreateTemplate CHAR(1) NOT NULL,
   CanCreateContract CHAR(1) NOT NULL,
	CanDeleteContract CHAR(1) NOT NULL,
	CanEditContract CHAR(1) NOT NULL,
   CanEditTemplate CHAR(1) NOT NULL,
	CanDeleteUser CHAR(1) NOT NULL,
   CanEditUser CHAR(1) NOT NULL,
   CanAddUser CHAR(1) NOT NULL,
	CanReadAudit CHAR(1) NOT NULL,
	CanEditAccessControl CHAR(1) NOT NULL,
	PRIMARY KEY (ID),
	FOREIGN KEY (UserID) REFERENCES user(ID)
);

DROP TABLE IF EXISTS audit_actions;
CREATE TABLE audit_actions(
	ID INT NOT NULL UNIQUE AUTO_INCREMENT,
	UserID INT NOT NULL,
	IPAddress CHAR(32) NOT NULL,
    TimeCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	HadAccessToAction CHAR(1),
   ActionDetails ENUM ('CREATE_TEMPLATE','CREATE_Contract','EDIT_Contract',
   'DELETE_TEMPLATE','DELETE_Contract','EDIT_TEMPLATE',
   'ADD_USER','DELETE_USER','EDIT_USER','READ_AUDIT','EDIT_ACCESS_CONTROL'),
   ChangedTemplateID INT,
   ChangedContractID INT,
   ChangedUserID INT,
   ChangedAccessControlID INT,
	PRIMARY KEY (ID),
	FOREIGN KEY(UserID)REFERENCES user(ID)
);


DROP TABLE IF EXISTS colleague;
CREATE TABLE colleague(
	ID INT NOT NULL UNIQUE AUTO_INCREMENT,
	UserIDA INT NOT NULL,
	UserIDB INT NOT NULL,
	PRIMARY KEY (ID),
	FOREIGN KEY(UserIDA)REFERENCES user(ID),
	FOREIGN KEY(UserIDB)REFERENCES user(ID)
);
DROP TABLE IF EXISTS contract_template;
CREATE TABLE contract_template(
      ID INT NOT NULL UNIQUE AUTO_INCREMENT,
      TemplateID VARCHAR(50) NOT NULL,
      Version INT NOT NULL,
      Content VARCHAR(2000) COLLATE utf8_persian_ci NOT NULL,
      ContentNum INT NOT NULL,
      BandNo INT NOT NULL,
      TabsareNo INT NOT NULL,
      MaddeNo INT NOT NULL,
      Part ENUM ('M','T','B','M-TITLE'),
      FieldType ENUM('STRING','INT','DATE','EMAIL','ADDRESS'),
      FieldStatus ENUM('EMPTY','FULL'),
      PRIMARY KEY (ID)
);


DROP TABLE IF EXISTS contract;
CREATE TABLE contract(
	ID VARCHAR(50) NOT NULL,
    ContractSubject VARCHAR(200) NOT NULL,
    Budget INT NOT NULL,
    PageNums INT NOT NULL,
    CopyNums INT NOT NULL,
    StartDate DATE,
    EndDate DATE,
    MaddeNums INT NOT NULL,
	CreatorID INT NOT NULL,
	KeyUsedToSign VARCHAR(1000) NOT NULL,
	State ENUM ('SIGNED','PAYMENT_PENDING', 'SIGN_PENDING', 'REJECTED'),
	QR_Intc VARCHAR(20),
    TemplateID VARCHAR(50) NOT NULL,
	PRIMARY KEY (ID),
	FOREIGN KEY(CreatorID)REFERENCES user(ID)
);


DROP TABLE IF EXISTS contract_madde;
CREATE TABLE contract_madde(
   ID VARCHAR(50) NOT NULL,
   ContractID VARCHAR(50) NOT NULL,
   MaddeTitle VARCHAR(500) NOT NULL,
   MaddeNum INT NOT NULL,
   ActiveStatus ENUM ('ACTIVE','INACTIVE'),
   TimeCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (ContractID,ID),
   FOREIGN KEY(ContractID) REFERENCES contract(ID)
);

DROP TABLE IF EXISTS contract_band;
CREATE TABLE contract_band(
   ID VARCHAR(50) NOT NULL,
   MaddeID VARCHAR(50) NOT NULL,
   ContractID VARCHAR(50) NOT NULL,
   BandNum INT NOT NULL,
   Content VARCHAR(2000) COLLATE utf8_persian_ci NOT NULL,
   ActiveStatus ENUM ('ACTIVE','INACTIVE'),
   TimeCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   FOREIGN KEY (ContractID, MaddeID) REFERENCES contract_madde(ContractID,ID),
   PRIMARY KEY (ContractID,MaddeID,ID)
);


DROP TABLE IF EXISTS contract_tabsare;
CREATE TABLE contract_tabsare(
   ID VARCHAR(50) NOT NULL,
   MaddeID VARCHAR(50) NOT NULL,
   BandID VARCHAR(50) NOT NULL,
   ContractID VARCHAR(50) NOT NULL,
   Title VARCHAR(200) NOT NULL,
   TabsareNum INT NOT NULL,
   Content VARCHAR(2000) COLLATE utf8_persian_ci NOT NULL,
   ActiveStatus ENUM ('ACTIVE','INACTIVE'),
   Status ENUM ('FOR_MADDE','FOR_BAND'),
   TimeCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   FOREIGN KEY (ContractID,MaddeID,BandID) REFERENCES contract_band(ContractID,MaddeID,ID),
   PRIMARY KEY (ContractID,MaddeID,BandID,ID)
);


DROP TABLE IF EXISTS template_contract_items;
CREATE TABLE template_contract_items(
    ID BIGINT UNIQUE AUTO_INCREMENT,
    ItemID VARCHAR(50) NOT NULL ,
    ContractID VARCHAR(50) NOT NULL,
    Content VARCHAR(500) COLLATE utf8_persian_ci NOT NULL,
    ActiveStatus ENUM ('ACTIVE','INACTIVE'),
    TimeCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ContractID) REFERENCES contract(ID),
    PRIMARY KEY (ID)
);
-- what for templateDocs
DROP TABLE IF EXISTS messaging;
CREATE TABLE messaging(
   ID INT NOT NULL UNIQUE AUTO_INCREMENT,
   SenderID INT NOT NULL,
   ContractID VARCHAR(50) NOT NULL,
   MaddeID VARCHAR(50) NOT NULL,
   PrevMessageID INT NOT NULL,
   Content VARCHAR(2000) COLLATE utf8_persian_ci NOT NULL,
   TimeCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   FOREIGN KEY (SenderID) REFERENCES user(ID),
   FOREIGN KEY (ContractID,MaddeID) REFERENCES contract_madde(ContractID,ID),
   FOREIGN KEY (PrevMessageID) REFERENCES messaging(ID)
);

DROP TABLE IF EXISTS contract_parties;
CREATE TABLE contract_parties(
   ID INT NOT NULL UNIQUE AUTO_INCREMENT,
   ContractID VARCHAR(50) NOT NULL,
   PartyID INT NOT NULL,
   ContractKey BLOB NOT NULL ,
   PRIMARY KEY(ID),
   FOREIGN KEY (ContractID) REFERENCES contract(ID),
   FOREIGN KEY (PartyID) REFERENCES user (ID)
);


DROP TABLE IF EXISTS sign_request;
CREATE TABLE sign_request(
   ID INT NOT NULL UNIQUE AUTO_INCREMENT,
   SenderID INT NOT NULL,
   ReciverID INT NOT NULL,
   ContractID VARCHAR(50) NOT NULL,
   SignStatus ENUM ('ACCEPTED','REJECTED','SUSPENDED'),
   SignatureID INT NOT NULL,
   TimeCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(ID),
   FOREIGN KEY (SenderID) REFERENCES user(ID),
   FOREIGN KEY (ReciverID) REFERENCES user(ID),
   FOREIGN KEY (SignatureID) REFERENCES user_signature(ID),
   FOREIGN KEY (ContractID) REFERENCES contract(ID)
   -- FOREIGN KEY () REFERENCES
);

