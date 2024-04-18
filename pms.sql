--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1
-- Dumped by pg_dump version 16.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: booking; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking (
    id integer NOT NULL,
    user_id numeric(10,0) NOT NULL,
    room_id numeric(10,0) NOT NULL,
    from_date timestamp(0) without time zone NOT NULL,
    to_date timestamp(0) without time zone NOT NULL,
    people_adult numeric(1,0),
    people_children numeric(1,0),
    checked_in_time timestamp(0) without time zone,
    checked_out_time timestamp(0) without time zone,
    unit_price numeric(10,0),
    discount numeric(10,0),
    total_price numeric(10,0),
    paid_amount numeric(10,0),
    due_amount numeric(10,0),
    vat numeric(10,0),
    created_by numeric(10,0),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.booking OWNER TO postgres;

--
-- Name: booking_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.booking_id_seq OWNER TO postgres;

--
-- Name: booking_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_id_seq OWNED BY public.booking.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: files; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.files (
    id integer NOT NULL,
    type character varying(100) NOT NULL,
    path character varying(500) NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone,
    element_id integer NOT NULL,
    last_modified_by integer NOT NULL,
    filename character varying(100) NOT NULL
);


ALTER TABLE public.files OWNER TO postgres;

--
-- Name: files_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.files_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.files_id_seq OWNER TO postgres;

--
-- Name: files_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.files_id_seq OWNED BY public.files.id;


--
-- Name: menu_methods; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menu_methods (
    id integer NOT NULL,
    menu_id smallint NOT NULL,
    type smallint,
    path character varying(500),
    method_name character varying(500),
    "default" smallint DEFAULT '0'::smallint NOT NULL,
    created_by integer,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.menu_methods OWNER TO postgres;

--
-- Name: menu_methods_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.menu_methods_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.menu_methods_id_seq OWNER TO postgres;

--
-- Name: menu_methods_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.menu_methods_id_seq OWNED BY public.menu_methods.id;


--
-- Name: menus; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menus (
    id integer NOT NULL,
    parent_id smallint,
    title character varying(500) NOT NULL,
    path character varying(500),
    icon character varying(500),
    serial smallint,
    active smallint DEFAULT '1'::smallint NOT NULL,
    "default" smallint DEFAULT '0'::smallint NOT NULL,
    created_by integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.menus OWNER TO postgres;

--
-- Name: menus_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.menus_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.menus_id_seq OWNER TO postgres;

--
-- Name: menus_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.menus_id_seq OWNED BY public.menus.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    created_by integer NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.roles_id_seq OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- Name: room_categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.room_categories (
    id integer NOT NULL,
    category character varying(255) NOT NULL,
    size character varying(255) NOT NULL,
    people_adult numeric(2,0) NOT NULL,
    people_child numeric(2,0) DEFAULT '0'::numeric NOT NULL,
    description text NOT NULL,
    package text,
    facilities text NOT NULL,
    created_by smallint NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone,
    bed character varying(255) NOT NULL,
    check_in character varying(50) NOT NULL,
    check_out character varying(50) NOT NULL,
    check_in_instruction text,
    cancellation_policy text,
    price numeric(10,0) NOT NULL,
    discount numeric NOT NULL
);


ALTER TABLE public.room_categories OWNER TO postgres;

--
-- Name: room_categories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.room_categories_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.room_categories_id_seq OWNER TO postgres;

--
-- Name: room_categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.room_categories_id_seq OWNED BY public.room_categories.id;


--
-- Name: rooms; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.rooms (
    id integer NOT NULL,
    room_category_id numeric(10,0) NOT NULL,
    room_number character varying(10) NOT NULL,
    room_status character varying(15) NOT NULL,
    status numeric(1,0) DEFAULT '1'::numeric NOT NULL,
    housekeeping numeric(1,0) DEFAULT '1'::numeric NOT NULL,
    created_by numeric(10,0),
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.rooms OWNER TO postgres;

--
-- Name: rooms_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.rooms_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.rooms_id_seq OWNER TO postgres;

--
-- Name: rooms_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.rooms_id_seq OWNED BY public.rooms.id;


--
-- Name: user_access; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_access (
    id integer NOT NULL,
    menu_method_id smallint NOT NULL,
    role_id smallint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.user_access OWNER TO postgres;

--
-- Name: user_access_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_access_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.user_access_id_seq OWNER TO postgres;

--
-- Name: user_access_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_access_id_seq OWNED BY public.user_access.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    email character varying(100) NOT NULL,
    password character varying(100) NOT NULL,
    mobile character varying(25),
    role_id smallint,
    verified smallint DEFAULT '0'::smallint,
    status smallint,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: booking id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking ALTER COLUMN id SET DEFAULT nextval('public.booking_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: files id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.files ALTER COLUMN id SET DEFAULT nextval('public.files_id_seq'::regclass);


--
-- Name: menu_methods id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_methods ALTER COLUMN id SET DEFAULT nextval('public.menu_methods_id_seq'::regclass);


--
-- Name: menus id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus ALTER COLUMN id SET DEFAULT nextval('public.menus_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: room_categories id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_categories ALTER COLUMN id SET DEFAULT nextval('public.room_categories_id_seq'::regclass);


--
-- Name: rooms id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rooms ALTER COLUMN id SET DEFAULT nextval('public.rooms_id_seq'::regclass);


--
-- Name: user_access id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_access ALTER COLUMN id SET DEFAULT nextval('public.user_access_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: booking; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking (id, user_id, room_id, from_date, to_date, people_adult, people_children, checked_in_time, checked_out_time, unit_price, discount, total_price, paid_amount, due_amount, vat, created_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: files; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.files (id, type, path, created_at, updated_at, element_id, last_modified_by, filename) FROM stdin;
2	room-category-thumb	images/room-category/test/	2024-04-18 11:03:19	\N	33	1	test_thumb
3	room-category-other-image	images/room-category/test/	2024-04-18 11:03:20	\N	33	1	test_other_image_1
4	room-category-other-image	images/room-category/test/	2024-04-18 11:03:20	\N	33	1	test_other_image_2
5	room-category-other-image	images/room-category/test/	2024-04-18 11:03:21	\N	33	1	test_other_image_3
\.


--
-- Data for Name: menu_methods; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.menu_methods (id, menu_id, type, path, method_name, "default", created_by, created_at, updated_at) FROM stdin;
1	1	1			0	\N	2024-04-16 12:02:11	\N
2	2	1	admin/users	User List	0	\N	2024-04-16 12:03:52	\N
3	2	0	admin/users/add	User Add	0	\N	2024-04-16 12:03:52	\N
4	2	0	admin/users/edit/{id}	User Edit	0	\N	2024-04-16 12:03:52	\N
5	2	0	admin/users/delete/{id}	User Delete	0	\N	2024-04-16 12:03:52	\N
6	2	0	admin/user-access/{id}	User Access	0	\N	2024-04-16 12:03:52	\N
7	3	1	admin/roles	Role List	0	\N	2024-04-16 12:04:34	\N
8	3	0	admin/roles/save-role	Role Add	0	\N	2024-04-16 12:04:34	\N
9	3	0	admin/roles/edit-role/{id}	Role Edit	0	\N	2024-04-16 12:04:34	\N
10	3	0	admin/roles/delete-role	Role Delete	0	\N	2024-04-16 12:04:34	\N
11	4	1	admin/users/change-password	Change Password	0	\N	2024-04-16 12:05:36	\N
12	5	1	admin/menus	Menu List	0	\N	2024-04-16 12:08:33	\N
13	5	0	admin/menus/menu-add	Menu Add	0	\N	2024-04-16 12:08:33	\N
14	5	0	admin/menus/menu-edit/{id}	Menu Edit	0	\N	2024-04-16 12:08:33	\N
15	5	0	admin/menus/delete-menu	Menu Delete	0	\N	2024-04-16 12:08:33	\N
16	2	0	admin/users/change-password/{id}	Change User Password	0	\N	2024-04-16 06:10:06	2024-04-16 06:10:06
17	6	1	admin/room-category	Room Category List	0	\N	2024-04-16 12:12:38	\N
18	6	0	admin/room-category/add	Room Category Add	0	\N	2024-04-16 12:12:38	\N
19	6	0	admin/room-category/edit/{id}	Room Category Edit	0	\N	2024-04-16 12:12:38	\N
20	6	0	admin/room-category/delete/{id}	Room Category Delete	0	\N	2024-04-16 12:12:38	\N
21	6	0	admin/room-category/view/{id}	Room Category View	0	\N	2024-04-16 12:12:38	\N
22	7	1	admin/rooms	Room List	0	\N	2024-04-16 12:13:57	\N
23	7	0	admin/rooms/add	Room Add	0	\N	2024-04-16 12:13:57	\N
24	8	1	admin/room-category-rent	Room Rent List	0	\N	2024-04-16 12:15:25	\N
25	8	0	admin/room-category-rent/add	Room Rent Add	0	\N	2024-04-16 12:15:25	\N
26	8	0	admin/room-category-rent/edit/{id}	Room Rent Edit	0	\N	2024-04-16 12:15:25	\N
27	8	0	admin/room-category-rent/delete/{id}	Room Rent Delete	0	\N	2024-04-16 12:15:25	\N
\.


--
-- Data for Name: menus; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.menus (id, parent_id, title, path, icon, serial, active, "default", created_by, created_at, updated_at) FROM stdin;
1	\N	Settings	\N	\N	\N	1	0	1	2024-04-16 06:02:11	2024-04-16 06:02:11
2	1	Users	admin/users	\N	\N	1	0	1	2024-04-16 06:03:52	2024-04-16 06:03:52
3	1	Roles	admin/roles	\N	\N	1	0	1	2024-04-16 06:04:33	2024-04-16 06:04:33
4	\N	Change Password	admin/users/change-password	\N	\N	1	0	1	2024-04-16 06:05:36	2024-04-16 06:05:36
5	1	Menus	admin/menus	\N	\N	1	0	1	2024-04-16 06:08:33	2024-04-16 06:08:33
6	\N	Room Category	admin/room-category	\N	\N	1	0	1	2024-04-16 06:12:38	2024-04-16 06:12:38
7	\N	Rooms	admin/rooms	\N	\N	1	0	1	2024-04-16 06:13:56	2024-04-16 06:13:56
8	\N	Room Rent	admin/room-category-rent	\N	\N	1	0	1	2024-04-16 06:15:24	2024-04-16 06:15:24
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2014_10_12_100000_create_password_reset_tokens_table	1
2	2019_08_19_000000_create_failed_jobs_table	1
3	2019_12_14_000001_create_personal_access_tokens_table	1
4	2024_04_04_105250_create_menu_methods_table	1
5	2024_04_04_105250_create_menus_table	1
6	2024_04_04_105250_create_roles_table	1
7	2024_04_04_105250_create_room_categories_table	1
8	2024_04_04_105250_create_rooms_table	1
9	2024_04_04_105250_create_user_access_table	1
10	2024_04_04_105250_create_users_table	1
11	2024_04_08_081738_create_booking_table	1
12	2024_04_18_110403_create_booking_table	0
13	2024_04_18_110403_create_failed_jobs_table	0
14	2024_04_18_110403_create_files_table	0
15	2024_04_18_110403_create_menu_methods_table	0
16	2024_04_18_110403_create_menus_table	0
17	2024_04_18_110403_create_password_reset_tokens_table	0
18	2024_04_18_110403_create_personal_access_tokens_table	0
19	2024_04_18_110403_create_roles_table	0
20	2024_04_18_110403_create_room_categories_table	0
21	2024_04_18_110403_create_rooms_table	0
22	2024_04_18_110403_create_user_access_table	0
23	2024_04_18_110403_create_users_table	0
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.roles (id, name, created_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: room_categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.room_categories (id, category, size, people_adult, people_child, description, package, facilities, created_by, created_at, updated_at, bed, check_in, check_out, check_in_instruction, cancellation_policy, price, discount) FROM stdin;
33	test	1	1	1	<p>test</p>	<p>test</p>	<p>test</p>	1	2024-04-18 11:03:19	2024-04-18 11:03:19	1	11	22	<p>test</p>	<p>test</p>	1	1
\.


--
-- Data for Name: rooms; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.rooms (id, room_category_id, room_number, room_status, status, housekeeping, created_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: user_access; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_access (id, menu_method_id, role_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, email, password, mobile, role_id, verified, status, created_at, updated_at) FROM stdin;
1	ishmam.ekaf@gmail.com	$2y$10$.8f.1XdZAJ9Wp/VRPMsuMOSKzUoA8uNSWiqNAR093g3nPfcIBb6o6	01766833859	1	1	1	2024-04-16 11:59:32	\N
\.


--
-- Name: booking_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_id_seq', 1, false);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: files_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.files_id_seq', 5, true);


--
-- Name: menu_methods_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.menu_methods_id_seq', 27, true);


--
-- Name: menus_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.menus_id_seq', 8, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 23, true);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_id_seq', 1, false);


--
-- Name: room_categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.room_categories_id_seq', 33, true);


--
-- Name: rooms_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.rooms_id_seq', 1, false);


--
-- Name: user_access_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_access_id_seq', 1, false);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 1, true);


--
-- Name: booking booking_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking
    ADD CONSTRAINT booking_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: files files_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.files
    ADD CONSTRAINT files_pkey PRIMARY KEY (id);


--
-- Name: menu_methods menu_methods_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_methods
    ADD CONSTRAINT menu_methods_pkey PRIMARY KEY (id);


--
-- Name: menus menus_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus
    ADD CONSTRAINT menus_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: room_categories room_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_categories
    ADD CONSTRAINT room_categories_pkey PRIMARY KEY (id);


--
-- Name: rooms rooms_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rooms
    ADD CONSTRAINT rooms_pkey PRIMARY KEY (id);


--
-- Name: user_access user_access_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_access
    ADD CONSTRAINT user_access_pkey PRIMARY KEY (id);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- PostgreSQL database dump complete
--

