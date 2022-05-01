CREATE DATABASE wimc
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE wimc;

CREATE TABLE customs (
    ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    CODE INT UNSIGNED NOT NULL,
    NAMT VARCHAR(128) NOT NULL,
    OKPO INT UNSIGNED NOT NULL,
    OGRN INT UNSIGNED NOT NULL,
    INN INT UNSIGNED NOT NULL,
    NAME_ALL VARCHAR(128) NOT NULL,
    ADRTAM VARCHAR(128) NOT NULL,
    PROSF INT UNSIGNED NOT NULL,
    TELEFON VARCHAR(128) NOT NULL,
    FAX VARCHAR(128) NOT NULL,
    EMAIL VARCHAR(128) NOT NULL,
    COORDS_LATITUDE VARCHAR(128) NOT NULL,
    COORDS_LONGITUDE VARCHAR(128) NOT NULL
);

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    EMAIL VARCHAR(128) NOT NULL,
    NAME VARCHAR(128) NOT NULL,
    ROLE INT UNSIGNED NOT NULL,
    password CHAR(64) NOT NULL,
    UNIQUE INDEX EMAIL(EMAIL)
);

