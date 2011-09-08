CREATE TABLE IF NOT EXISTS "eagb_badwords" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL  UNIQUE ,
    "word" TEXT NOT NULL ,
    "created" DATETIME NOT NULL ,
    "modified" DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS "eagb_entries" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL UNIQUE,
    "name" TEXT NOT NULL ,
    "email" TEXT NOT NULL ,
    "homepage" TEXT NOT NULL ,
    "body" TEXT NOT NULL ,
    "hide_email" INTEGER,
    "created" DATETIME NOT NULL ,
    "modified" DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS "eagb_settings" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL UNIQUE,
    "name" TEXT NOT NULL ,
    "setting" INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS "eagb_smileys" ("id" INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL UNIQUE,
    "smiley" TEXT NOT NULL ,
    "url" TEXT NOT NULL ,
    "modified" DATETIME NOT NULL ,
    "created" DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS "eagb_users" (
    "id" INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL  UNIQUE ,
    "name" TEXT NOT NULL ,
    "email" TEXT NOT NULL ,
    "password" TEXT NOT NULL ,
    "salt" TEXT NOT NULL ,
    "created" DATETIME,
    "modified" DATETIME
);