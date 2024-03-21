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

INSERT INTO "menu_methods" ("id", "menu_id", "type", "path", "method_name", "default", "created_by", "created_at", "updated_at") VALUES
(11,	12,	1,	'admin/dashboard',	'Dashboard',	0,	NULL,	'2024-02-24 14:05:55.429105',	NULL),
(12,	13,	1,	'',	'',	0,	NULL,	'2024-02-24 14:06:14.671075',	NULL),
(13,	14,	0,	'admin/menus/menu-add',	'Add Menu',	0,	NULL,	'2024-02-24 14:08:30.521415',	NULL),
(14,	14,	0,	'admin/menus/menu-edit/{id}',	'Edit Menu',	0,	NULL,	'2024-02-24 14:08:30.521415',	NULL),
(15,	14,	0,	'admin/menus/delete-menu',	'Delete Menu',	0,	NULL,	'2024-02-24 14:08:30.521415',	NULL),
(16,	14,	1,	'admin/menus',	'List Menus',	0,	NULL,	'2024-02-24 14:08:30.521415',	NULL),
(17,	15,	0,	'admin/roles/save-role',	'Add Role',	0,	NULL,	'2024-02-24 14:10:04.596817',	NULL),
(18,	15,	0,	'admin/roles/edit-role/{id}',	'Edit Role',	0,	NULL,	'2024-02-24 14:10:04.596817',	NULL),
(19,	15,	0,	'admin/roles/delete-role',	'Delete Role',	0,	NULL,	'2024-02-24 14:10:04.596817',	NULL),
(20,	15,	1,	'admin/roles',	'Roles List',	0,	NULL,	'2024-02-24 14:10:04.596817',	NULL),
(21,	16,	0,	'admin/users/add',	'Add User',	0,	NULL,	'2024-03-10 16:24:56.795686',	NULL),
(22,	16,	0,	'admin/users/edit/{id}',	'Edit User',	0,	NULL,	'2024-03-10 16:24:56.795686',	NULL),
(23,	16,	0,	'admin/users/delete/{id}',	'Delete User',	0,	NULL,	'2024-03-10 16:24:56.795686',	NULL),
(24,	16,	1,	'admin/users',	'List User',	0,	NULL,	'2024-03-10 16:24:56.795686',	NULL);

DROP TABLE IF EXISTS "menus";
DROP SEQUENCE IF EXISTS menus_id_seq;
CREATE SEQUENCE menus_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."menus" (
    "id" integer DEFAULT nextval('menus_id_seq') NOT NULL,
    "parent_id" smallint,
    "title" character varying(500) NOT NULL,
    "path" character varying(500),
    "icon" character varying(500),
    "serial" smallint,
    "active" smallint DEFAULT '1' NOT NULL,
    "default" smallint DEFAULT '0' NOT NULL,
    "created_by" integer NOT NULL,
    "created_at" timestamp,
    "updated_at" timestamp,
    CONSTRAINT "menus_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "menus" ("id", "parent_id", "title", "path", "icon", "serial", "active", "default", "created_by", "created_at", "updated_at") VALUES
(12,	NULL,	'Dashboard',	'admin/dashboard',	NULL,	NULL,	1,	0,	1,	'2024-02-24 08:05:55',	'2024-02-24 08:05:55'),
(13,	NULL,	'Settings',	NULL,	NULL,	NULL,	1,	0,	1,	'2024-02-24 08:06:14',	'2024-02-24 08:06:14'),
(14,	13,	'Menus',	'admin/menus',	NULL,	NULL,	1,	0,	1,	'2024-02-24 08:08:30',	'2024-02-24 08:08:30'),
(15,	13,	'Roles',	'admin/roles',	NULL,	NULL,	1,	0,	1,	'2024-02-24 08:10:04',	'2024-02-24 08:10:04'),
(16,	13,	'Users',	'admin/users',	NULL,	NULL,	1,	0,	1,	'2024-03-10 10:24:56',	'2024-03-10 10:24:56');

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

INSERT INTO "roles" ("id", "name", "created_by", "created_at", "updated_at") VALUES
(1,	'Super Admin',	1,	'2024-02-24 09:15:16',	'2024-02-24 09:15:16'),
(2,	'Admin',	1,	'2024-02-24 09:15:23',	'2024-02-24 09:15:23');

DROP TABLE IF EXISTS "room_categories";
DROP SEQUENCE IF EXISTS room_categories_id_seq;
CREATE SEQUENCE room_categories_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."room_categories" (
    "id" integer DEFAULT nextval('room_categories_id_seq') NOT NULL,
    "category" character varying NOT NULL,
    "size" character varying NOT NULL,
    "people_adult" numeric(2,0) NOT NULL,
    "people_child" numeric(2,0) DEFAULT '0' NOT NULL,
    "description" text NOT NULL,
    "package" text,
    "facilities" text NOT NULL,
    "created_by" smallint NOT NULL,
    "created_at" timestamp NOT NULL,
    "updated_at" timestamp,
    "bed" character varying NOT NULL,
    "check_in" character varying(50) NOT NULL,
    "check_out" character varying(50) NOT NULL,
    "check_in_instruction" text,
    "cancellation_policy" text,
    CONSTRAINT "room_categories_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "user_access";
DROP SEQUENCE IF EXISTS user_access_id_seq;
CREATE SEQUENCE user_access_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."user_access" (
    "id" integer DEFAULT nextval('user_access_id_seq') NOT NULL,
    "menu_method_id" smallint NOT NULL,
    "role_id" smallint NOT NULL,
    "created_at" timestamp,
    "updated_at" timestamp,
    CONSTRAINT "user_access_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "user_access" ("id", "menu_method_id", "role_id", "created_at", "updated_at") VALUES
(2,	11,	2,	'2024-02-24 09:53:39',	NULL);

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
(2,	'test1@gmail.com',	'$2y$12$JxO2tz6zOLkJjvGZDKVOBuX0x3idOhJDsQJEFnuPEdn6fGQSd7tSq',	'111111111',	2,	0,	NULL,	'2024-02-24 09:36:39',	'2024-02-24 09:36:39'),
(1,	'ishmam.ekaf@gmail.com',	'$2y$10$.8f.1XdZAJ9Wp/VRPMsuMOSKzUoA8uNSWiqNAR093g3nPfcIBb6o6',	'01766833859',	1,	1,	1,	'2024-02-01 12:52:49.971239',	'2024-03-10 09:44:55');

-- 2024-03-21 17:36:14.720906+06
