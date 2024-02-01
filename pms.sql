-- Adminer 4.8.1 PostgreSQL 16.1 dump

DROP TABLE IF EXISTS "menu_methods";
DROP SEQUENCE IF EXISTS menu_methods_id_seq;
CREATE SEQUENCE menu_methods_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."menu_methods" (
    "id" integer DEFAULT nextval('menu_methods_id_seq') NOT NULL,
    "menu_id" smallint NOT NULL,
    "type" smallint,
    "path" character varying(500),
    "method_name" character varying(500),
    "default" smallint DEFAULT '0' NOT NULL,
    "created_by" integer,
    "created_at" timestamp DEFAULT now() NOT NULL,
    "updated_at" timestamp,
    CONSTRAINT "menu_methods_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "menu_test";
CREATE TABLE "public"."menu_test" (
    "id" integer,
    "parent_id" smallint,
    "title" character varying(200),
    "path" character varying(500),
    "icon" character varying(500),
    "active" smallint,
    "default" smallint,
    "created_by" integer,
    "created_at" timestamp,
    "updated_at" timestamp
) WITH (oids = false);

INSERT INTO "menu_test" ("id", "parent_id", "title", "path", "icon", "active", "default", "created_by", "created_at", "updated_at") VALUES
(1,	NULL,	'home',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(2,	1,	'h1',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(3,	1,	'h2',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(4,	2,	'h1sub1',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(5,	2,	'h1sub2',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(6,	NULL,	'dashboard',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(7,	NULL,	'settings',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(8,	7,	'set1',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(9,	7,	'set2',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS "menus";
DROP SEQUENCE IF EXISTS menus_id_seq;
CREATE SEQUENCE menus_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."menus" (
    "id" integer DEFAULT nextval('menus_id_seq') NOT NULL,
    "parent_id" smallint,
    "title" character varying(200) NOT NULL,
    "path" character varying(500),
    "icon" character varying(500),
    "active" smallint DEFAULT '1' NOT NULL,
    "default" smallint DEFAULT '0' NOT NULL,
    "created_by" integer,
    "created_at" timestamp DEFAULT now() NOT NULL,
    "updated_at" timestamp,
    CONSTRAINT "menus_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "roles";
DROP SEQUENCE IF EXISTS roles_id_seq;
CREATE SEQUENCE roles_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."roles" (
    "id" integer DEFAULT nextval('roles_id_seq') NOT NULL,
    "name" character varying(100) NOT NULL,
    "created_by" integer NOT NULL,
    "created_at" timestamp DEFAULT now() NOT NULL,
    "updated_at" timestamp,
    CONSTRAINT "roles_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "users";
DROP SEQUENCE IF EXISTS users_id_seq;
CREATE SEQUENCE users_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."users" (
    "id" integer DEFAULT nextval('users_id_seq') NOT NULL,
    "email" character varying(100) NOT NULL,
    "password" character varying(100) NOT NULL,
    "mobile" character varying(25),
    "role_id" smallint,
    "verified" smallint DEFAULT '0',
    "status" smallint,
    "created_at" timestamp DEFAULT now() NOT NULL,
    "updated_at" timestamp,
    CONSTRAINT "users_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "users" ("id", "email", "password", "mobile", "role_id", "verified", "status", "created_at", "updated_at") VALUES
(1,	'ishmam.ekaf@gmail.com',	'$2y$10$.8f.1XdZAJ9Wp/VRPMsuMOSKzUoA8uNSWiqNAR093g3nPfcIBb6o6',	'01766833859',	1,	1,	1,	'2024-02-01 12:52:49.971239',	NULL);

-- 2024-02-01 17:59:02.318079+06
