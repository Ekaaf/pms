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
-- Name: biiling_other_info; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.biiling_other_info (
    id integer NOT NULL,
    billing_id integer NOT NULL,
    identity character varying(20),
    dob date,
    nationality character varying(30),
    estimated_arrival_time character varying(20),
    created_by integer NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone,
    expire_date date,
    identity_number character varying(100)
);


ALTER TABLE public.biiling_other_info OWNER TO postgres;

--
-- Name: biiling_other_info_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.biiling_other_info_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.biiling_other_info_id_seq OWNER TO postgres;

--
-- Name: biiling_other_info_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.biiling_other_info_id_seq OWNED BY public.biiling_other_info.id;


--
-- Name: billing; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.billing (
    id integer NOT NULL,
    user_id integer NOT NULL,
    total_price numeric NOT NULL,
    total_discount numeric NOT NULL,
    paid_amount numeric NOT NULL,
    due_amount numeric NOT NULL,
    total_vat numeric NOT NULL,
    price_with_vat numeric NOT NULL,
    adjustment numeric DEFAULT 0 NOT NULL,
    final_price numeric NOT NULL,
    created_by integer NOT NULL,
    payment_completed numeric(1,0) DEFAULT 0 NOT NULL,
    payment_completion_time timestamp without time zone,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp with time zone,
    adjustment_reason text,
    booking_type character varying(20),
    checked_in numeric(1,0) DEFAULT 0 NOT NULL,
    checked_out numeric(1,0) DEFAULT 0 NOT NULL,
    checked_in_time timestamp without time zone,
    checked_out_time timestamp without time zone,
    status numeric(1,0) DEFAULT 1 NOT NULL
);


ALTER TABLE public.billing OWNER TO postgres;

--
-- Name: billing_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.billing_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.billing_id_seq OWNER TO postgres;

--
-- Name: billing_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.billing_id_seq OWNED BY public.billing.id;


--
-- Name: booking; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking (
    id integer NOT NULL,
    user_id integer NOT NULL,
    room_id integer NOT NULL,
    from_date timestamp(0) without time zone NOT NULL,
    to_date timestamp(0) without time zone NOT NULL,
    people_adult numeric(1,0),
    people_child numeric(1,0),
    unit_price numeric(10,0),
    discount numeric(10,0),
    total_price numeric(10,0),
    vat numeric(10,0),
    created_by numeric(10,0),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    billing_id integer,
    booking_type character varying(20),
    room_category_id integer,
    status numeric(1,0) DEFAULT 1 NOT NULL,
    no_of_nights integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.booking OWNER TO postgres;

--
-- Name: booking_days; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_days (
    id integer NOT NULL,
    billing_id integer NOT NULL,
    room_id integer NOT NULL,
    date date NOT NULL,
    unit_price numeric(10,0) NOT NULL,
    discount numeric(10,0) NOT NULL,
    total_price numeric(10,0) NOT NULL,
    vat numeric(10,0) NOT NULL,
    created_by integer NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone
);


ALTER TABLE public.booking_days OWNER TO postgres;

--
-- Name: booking_days_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_days_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.booking_days_id_seq OWNER TO postgres;

--
-- Name: booking_days_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_days_id_seq OWNED BY public.booking_days.id;


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
-- Name: payment_records; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.payment_records (
    id integer NOT NULL,
    billing_id integer NOT NULL,
    payment_medium character varying(30) NOT NULL,
    amount numeric NOT NULL,
    deduction numeric NOT NULL,
    paid_by integer NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone
);


ALTER TABLE public.payment_records OWNER TO postgres;

--
-- Name: payment_records_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.payment_records_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.payment_records_id_seq OWNER TO postgres;

--
-- Name: payment_records_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.payment_records_id_seq OWNED BY public.payment_records.id;


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
-- Name: room_categories_rent; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.room_categories_rent (
    id integer NOT NULL,
    room_category_id integer NOT NULL,
    rent_date date NOT NULL,
    price numeric NOT NULL,
    discount numeric DEFAULT 0 NOT NULL,
    net_price numeric NOT NULL,
    created_by integer NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.room_categories_rent OWNER TO postgres;

--
-- Name: room_categories_rent_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.room_categories_rent_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.room_categories_rent_id_seq OWNER TO postgres;

--
-- Name: room_categories_rent_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.room_categories_rent_id_seq OWNED BY public.room_categories_rent.id;


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
-- Name: user_info; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_info (
    id integer NOT NULL,
    user_id integer NOT NULL,
    title character varying(10) NOT NULL,
    first_name character varying(100) NOT NULL,
    last_name character varying NOT NULL,
    address text,
    postal_code character varying(30),
    city character varying(50),
    country character varying(100),
    created_by integer NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone,
    gender character varying(10)
);


ALTER TABLE public.user_info OWNER TO postgres;

--
-- Name: user_info_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_info_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.user_info_id_seq OWNER TO postgres;

--
-- Name: user_info_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_info_id_seq OWNED BY public.user_info.id;


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
    updated_at timestamp(0) without time zone,
    created_by integer
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
-- Name: biiling_other_info id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.biiling_other_info ALTER COLUMN id SET DEFAULT nextval('public.biiling_other_info_id_seq'::regclass);


--
-- Name: billing id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.billing ALTER COLUMN id SET DEFAULT nextval('public.billing_id_seq'::regclass);


--
-- Name: booking id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking ALTER COLUMN id SET DEFAULT nextval('public.booking_id_seq'::regclass);


--
-- Name: booking_days id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_days ALTER COLUMN id SET DEFAULT nextval('public.booking_days_id_seq'::regclass);


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
-- Name: payment_records id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payment_records ALTER COLUMN id SET DEFAULT nextval('public.payment_records_id_seq'::regclass);


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
-- Name: room_categories_rent id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_categories_rent ALTER COLUMN id SET DEFAULT nextval('public.room_categories_rent_id_seq'::regclass);


--
-- Name: rooms id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rooms ALTER COLUMN id SET DEFAULT nextval('public.rooms_id_seq'::regclass);


--
-- Name: user_access id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_access ALTER COLUMN id SET DEFAULT nextval('public.user_access_id_seq'::regclass);


--
-- Name: user_info id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_info ALTER COLUMN id SET DEFAULT nextval('public.user_info_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: biiling_other_info; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.biiling_other_info (id, billing_id, identity, dob, nationality, estimated_arrival_time, created_by, created_at, updated_at, expire_date, identity_number) FROM stdin;
45	46	passport	2024-06-27	Bangladesh	\N	1	2024-06-27 09:09:46	2024-06-27 09:09:46	2024-06-27	passport
53	57	passport	2024-06-27	Bangladesh	\N	1	2024-06-27 09:47:33	2024-06-27 09:47:33	2024-06-27	passport
77	81	passport	2024-07-16	Bangladesh	\N	1	2024-07-04 12:35:39	2024-07-04 12:35:39	2024-07-24	passport
\.


--
-- Data for Name: billing; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.billing (id, user_id, total_price, total_discount, paid_amount, due_amount, total_vat, price_with_vat, adjustment, final_price, created_by, payment_completed, payment_completion_time, created_at, updated_at, adjustment_reason, booking_type, checked_in, checked_out, checked_in_time, checked_out_time, status) FROM stdin;
46	3	36000	0	0	36000	0	0	0	36000	1	0	\N	2024-06-27 09:09:46	2024-06-27 09:09:46+06	\N	\N	0	0	\N	\N	1
57	37	32000	0	0	32000	0	0	0	32000	1	0	\N	2024-06-27 09:47:33	2024-06-30 06:06:49+06	\N	\N	1	1	2024-06-27 14:00:03	2024-06-30 06:06:49	1
81	37	32000	0	0	32000	0	0	0	32000	1	0	\N	2024-07-04 12:35:39	2024-07-04 12:35:39+06	\N	\N	0	0	\N	\N	1
\.


--
-- Data for Name: booking; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking (id, user_id, room_id, from_date, to_date, people_adult, people_child, unit_price, discount, total_price, vat, created_by, created_at, updated_at, billing_id, booking_type, room_category_id, status, no_of_nights) FROM stdin;
23	3	6	2024-06-28 00:00:00	2024-07-01 00:00:00	1	1	3	0	0	0	1	2024-06-27 09:09:46	\N	46	\N	41	1	0
24	3	1	2024-06-28 00:00:00	2024-07-01 00:00:00	1	1	3	0	0	0	1	2024-06-27 09:09:46	\N	46	\N	40	1	0
26	37	6	2024-07-01 00:00:00	2024-07-02 00:00:00	1	1	8000	0	16000	0	1	2024-06-27 09:47:33	\N	57	\N	41	1	2
27	37	7	2024-07-01 00:00:00	2024-07-02 00:00:00	1	1	8000	0	16000	0	1	2024-06-27 09:47:33	\N	57	\N	41	1	2
44	37	6	2024-07-04 00:00:00	2024-07-06 00:00:00	1	1	8000	0	16000	0	1	2024-07-04 12:35:39	\N	81	\N	41	1	2
45	37	7	2024-07-04 00:00:00	2024-07-06 00:00:00	1	1	8000	0	16000	0	1	2024-07-04 12:35:39	\N	81	\N	41	1	2
\.


--
-- Data for Name: booking_days; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_days (id, billing_id, room_id, date, unit_price, discount, total_price, vat, created_by, created_at, updated_at) FROM stdin;
1	81	6	2024-07-04	8000	0	8000	0	1	2024-07-04 12:35:39	\N
2	81	6	2024-07-05	8000	0	8000	0	1	2024-07-04 12:35:39	\N
3	81	7	2024-07-04	8000	0	8000	0	1	2024-07-04 12:35:39	\N
4	81	7	2024-07-05	8000	0	8000	0	1	2024-07-04 12:35:39	\N
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
33	room-category-thumb	images/room-category/Panorama Ocean Suite/	2024-04-22 10:59:43	2024-04-22 10:59:43	40	1	Panorama Ocean Suite_thumb.webp
37	room-category-other-image	images/room-category/Panorama Ocean Suite/	2024-04-22 10:59:43	\N	40	1	Panorama Ocean Suite_other_image_1.webp
38	room-category-thumb	images/room-category/Sea View/	2024-04-30 05:42:22	\N	41	1	Sea View_thumb.webp
40	room-category-other-image	images/room-category/Sea View/	2024-05-08 09:03:02	\N	41	1	Sea View_other_image_1.webp
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
28	9	1	admin/check-in	Check In View	0	\N	2024-06-30 12:09:27	\N
29	9	0	admin/check-in-complete/{id}	Check In Complete	0	\N	2024-06-30 12:09:27	\N
30	10	1	admin/check-out	Check Out View	0	\N	2024-06-30 12:14:15	\N
31	10	0	admin/check-out-complete/{id}	Check Out	0	\N	2024-06-30 12:14:15	\N
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
9	\N	Check In	admin/check-in	\N	\N	1	0	1	2024-06-30 06:09:26	2024-06-30 06:09:26
10	\N	Check Out	admin/check-out	\N	\N	1	0	1	2024-06-30 06:14:15	2024-06-30 06:14:15
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
24	2024_04_25_051830_create_biiling_other_info_table	0
25	2024_04_25_051830_create_billing_table	0
26	2024_04_25_051830_create_booking_table	0
27	2024_04_25_051830_create_failed_jobs_table	0
28	2024_04_25_051830_create_files_table	0
29	2024_04_25_051830_create_menu_methods_table	0
30	2024_04_25_051830_create_menus_table	0
31	2024_04_25_051830_create_password_reset_tokens_table	0
32	2024_04_25_051830_create_payment_records_table	0
33	2024_04_25_051830_create_personal_access_tokens_table	0
34	2024_04_25_051830_create_roles_table	0
35	2024_04_25_051830_create_room_categories_table	0
36	2024_04_25_051830_create_rooms_table	0
37	2024_04_25_051830_create_user_access_table	0
38	2024_04_25_051830_create_users_table	0
39	2024_04_25_064949_create_biiling_other_info_table	0
40	2024_04_25_064949_create_billing_table	0
41	2024_04_25_064949_create_booking_table	0
42	2024_04_25_064949_create_failed_jobs_table	0
43	2024_04_25_064949_create_files_table	0
44	2024_04_25_064949_create_menu_methods_table	0
45	2024_04_25_064949_create_menus_table	0
46	2024_04_25_064949_create_password_reset_tokens_table	0
47	2024_04_25_064949_create_payment_records_table	0
48	2024_04_25_064949_create_personal_access_tokens_table	0
49	2024_04_25_064949_create_roles_table	0
50	2024_04_25_064949_create_room_categories_table	0
51	2024_04_25_064949_create_rooms_table	0
52	2024_04_25_064949_create_user_access_table	0
53	2024_04_25_064949_create_users_table	0
54	2024_05_05_111001_create_biiling_other_info_table	0
55	2024_05_05_111001_create_billing_table	0
56	2024_05_05_111001_create_booking_table	0
57	2024_05_05_111001_create_failed_jobs_table	0
58	2024_05_05_111001_create_files_table	0
59	2024_05_05_111001_create_menu_methods_table	0
60	2024_05_05_111001_create_menus_table	0
61	2024_05_05_111001_create_password_reset_tokens_table	0
62	2024_05_05_111001_create_payment_records_table	0
63	2024_05_05_111001_create_personal_access_tokens_table	0
64	2024_05_05_111001_create_roles_table	0
65	2024_05_05_111001_create_room_categories_table	0
66	2024_05_05_111001_create_rooms_table	0
67	2024_05_05_111001_create_user_access_table	0
68	2024_05_05_111001_create_user_info_table	0
69	2024_05_05_111001_create_users_table	0
70	2024_05_07_112339_create_biiling_other_info_table	0
71	2024_05_07_112339_create_billing_table	0
72	2024_05_07_112339_create_booking_table	0
73	2024_05_07_112339_create_failed_jobs_table	0
74	2024_05_07_112339_create_files_table	0
75	2024_05_07_112339_create_menu_methods_table	0
76	2024_05_07_112339_create_menus_table	0
77	2024_05_07_112339_create_password_reset_tokens_table	0
78	2024_05_07_112339_create_payment_records_table	0
79	2024_05_07_112339_create_personal_access_tokens_table	0
80	2024_05_07_112339_create_roles_table	0
81	2024_05_07_112339_create_room_categories_table	0
82	2024_05_07_112339_create_rooms_table	0
83	2024_05_07_112339_create_user_access_table	0
84	2024_05_07_112339_create_user_info_table	0
85	2024_05_07_112339_create_users_table	0
86	2024_05_13_065251_create_biiling_other_info_table	0
87	2024_05_13_065251_create_billing_table	0
88	2024_05_13_065251_create_booking_table	0
89	2024_05_13_065251_create_failed_jobs_table	0
90	2024_05_13_065251_create_files_table	0
91	2024_05_13_065251_create_menu_methods_table	0
92	2024_05_13_065251_create_menus_table	0
93	2024_05_13_065251_create_password_reset_tokens_table	0
94	2024_05_13_065251_create_payment_records_table	0
95	2024_05_13_065251_create_personal_access_tokens_table	0
96	2024_05_13_065251_create_roles_table	0
97	2024_05_13_065251_create_room_categories_table	0
98	2024_05_13_065251_create_room_categories_rent_table	0
99	2024_05_13_065251_create_rooms_table	0
100	2024_05_13_065251_create_user_access_table	0
101	2024_05_13_065251_create_user_info_table	0
102	2024_05_13_065251_create_users_table	0
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: payment_records; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.payment_records (id, billing_id, payment_medium, amount, deduction, paid_by, created_at, updated_at) FROM stdin;
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
1	Super Admin	1	2024-05-06 10:08:03	2024-05-06 10:08:03
2	Customer	1	2024-05-06 10:08:22	2024-05-06 10:08:22
3	Guest	1	2024-05-06 10:08:29	2024-05-06 10:08:29
\.


--
-- Data for Name: room_categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.room_categories (id, category, size, people_adult, people_child, description, package, facilities, created_by, created_at, updated_at, bed, check_in, check_out, check_in_instruction, cancellation_policy, price, discount) FROM stdin;
40	Panorama Ocean Suite	500	2	1	<p><span style="background-color:rgb(246,245,251);color:rgb(0,0,0);font-family:&quot;Open Sans&quot;, &quot;Open Sans&quot;;font-size:17px;"><span style="-webkit-text-stroke-width:0px;display:inline !important;float:none;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;orphans:2;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;">A luxurious 2 bedroom suit perfect for family &amp; friends with the 180 degree view of world’s longest unbroken beach. The ceiling height window from the living room gives you an excellent opportunity to indulge with Sun, Sand &amp; Sea.</span></span></p>	<p><span style="background-color:rgb(246,245,251);color:rgb(0,0,0);font-family:&quot;Open Sans&quot;, &quot;Open Sans&quot;;font-size:17px;"><span style="-webkit-text-stroke-width:0px;display:inline !important;float:none;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;orphans:2;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;">A luxurious 2 bedroom suit perfect for family &amp; friends with the 180 degree view of world’s longest unbroken beach. The ceiling height window from the living room gives you an excellent opportunity to indulge with Sun, Sand &amp; Sea.</span></span></p>	<p><span style="background-color:rgb(246,245,251);color:rgb(0,0,0);font-family:&quot;Open Sans&quot;, &quot;Open Sans&quot;;font-size:17px;"><span style="-webkit-text-stroke-width:0px;display:inline !important;float:none;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;orphans:2;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;">A luxurious 2 bedroom suit perfect for family &amp; friends with the 180 degree view of world’s longest unbroken beach. The ceiling height window from the living room gives you an excellent opportunity to indulge with Sun, Sand &amp; Sea.</span></span></p>	1	2024-04-22 10:55:25	2024-04-22 10:55:25	2	11	12	<p><span style="background-color:rgb(246,245,251);color:rgb(0,0,0);font-family:&quot;Open Sans&quot;, &quot;Open Sans&quot;;font-size:17px;"><span style="-webkit-text-stroke-width:0px;display:inline !important;float:none;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;orphans:2;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;">A luxurious 2 bedroom suit perfect for family &amp; friends with the 180 degree view of world’s longest unbroken beach. The ceiling height window from the living room gives you an excellent opportunity to indulge with Sun, Sand &amp; Sea.</span></span></p>	<p><span style="background-color:rgb(246,245,251);color:rgb(0,0,0);font-family:&quot;Open Sans&quot;, &quot;Open Sans&quot;;font-size:17px;"><span style="-webkit-text-stroke-width:0px;display:inline !important;float:none;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;orphans:2;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;">A luxurious 2 bedroom suit perfect for family &amp; friends with the 180 degree view of world’s longest unbroken beach. The ceiling height window from the living room gives you an excellent opportunity to indulge with Sun, Sand &amp; Sea.</span></span></p>	5000	10
41	Sea View	1000	2	2	<p>test</p>	<p>test</p>	<p>test</p>	1	2024-04-30 05:42:19	2024-05-08 09:03:00	1	14:00	12:00	<p>tes</p>	<p>test</p>	8000	10
33	test	1	1	1	<p>test</p>	<p>test</p>	<p>test</p>	1	2024-04-18 11:03:19	2024-04-18 11:03:19	1	11	22	<p>test</p>	<p>test</p>	1	1
\.


--
-- Data for Name: room_categories_rent; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.room_categories_rent (id, room_category_id, rent_date, price, discount, net_price, created_by, created_at, updated_at) FROM stdin;
1	40	2024-05-09	7000	500	6500	1	2024-05-08 09:20:55	\N
2	40	2024-05-10	7000	500	6500	1	2024-05-08 09:20:55	\N
3	40	2024-05-11	7000	500	6500	1	2024-05-08 09:20:55	\N
4	40	2024-05-12	7000	500	6500	1	2024-05-08 09:20:55	\N
5	40	2024-05-13	7000	500	6500	1	2024-05-08 09:20:55	\N
6	40	2024-05-14	7000	500	6500	1	2024-05-08 09:20:55	\N
7	40	2024-05-15	7000	500	6500	1	2024-05-08 09:20:55	\N
8	40	2024-05-24	6500	500	6000	1	2024-05-23 05:39:01	\N
9	40	2024-05-25	6500	500	6000	1	2024-05-23 05:39:01	\N
10	40	2024-05-26	6500	500	6000	1	2024-05-23 05:39:01	\N
11	40	2024-05-27	6500	500	6000	1	2024-05-23 05:39:01	\N
\.


--
-- Data for Name: rooms; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.rooms (id, room_category_id, room_number, room_status, status, housekeeping, created_by, created_at, updated_at) FROM stdin;
1	40	101	1	1	1	1	2024-04-30 05:41:09	\N
2	40	102	1	1	1	1	2024-04-30 05:41:09	\N
3	40	103	1	1	1	1	2024-04-30 05:41:09	\N
4	40	104	1	1	1	1	2024-04-30 05:41:09	\N
5	40	105	1	1	1	1	2024-04-30 05:41:09	\N
6	41	201	1	1	1	1	2024-04-30 05:42:40	\N
7	41	202	1	1	1	1	2024-04-30 05:42:40	\N
8	41	203	1	1	1	1	2024-04-30 05:42:40	\N
\.


--
-- Data for Name: user_access; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_access (id, menu_method_id, role_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: user_info; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_info (id, user_id, title, first_name, last_name, address, postal_code, city, country, created_by, created_at, updated_at, gender) FROM stdin;
2	3	Mr.	John	Ekaf	dhaka	1	dhaka	Bangladesh	1	2024-05-06 10:10:50	2024-05-06 10:10:50	\N
33	37	Mr.	John	Ekaf	dhaka	1	dhaka	Bangladesh	1	2024-05-07 11:15:35	2024-05-07 11:15:35	Male.
35	39	Mr.	John	Ekaf	dhaka	1	dhaka	Bangladesh	1	2024-05-07 11:18:25	2024-05-07 11:18:25	Female
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, email, password, mobile, role_id, verified, status, created_at, updated_at, created_by) FROM stdin;
1	ishmam.ekaf@gmail.com	$2y$10$.8f.1XdZAJ9Wp/VRPMsuMOSKzUoA8uNSWiqNAR093g3nPfcIBb6o6	01766833859	1	1	1	2024-04-16 11:59:32	\N	\N
37	newuser@gmail.com	$2y$12$Vi02inJz9b.Wzy/DORnlS.B.pPh.Yc9r8ZRBp58D6ytZ/5bZN2GD6	\N	2	0	1	2024-05-07 11:15:35	2024-05-07 11:15:35	1
39	guest@gmail.com	$2y$12$9dkRBH8SkpLR1jHidVD8xObWd3bIwbx.srORXwu2DlrgDw8H5OnoC	\N	3	0	1	2024-05-07 11:18:25	2024-05-07 11:18:25	1
3	ishmam.ekaf@gmail.com	$2y$12$2taA2Tk2Lomvp7NiO.ib4ewVbh1PKC765Pttp/OEagf7w4jdOn/Om	01766833859	2	0	1	2024-05-06 10:10:50	2024-05-06 10:10:50	1
\.


--
-- Name: biiling_other_info_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.biiling_other_info_id_seq', 77, true);


--
-- Name: billing_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.billing_id_seq', 81, true);


--
-- Name: booking_days_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_days_id_seq', 4, true);


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
-- Name: payment_records_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.payment_records_id_seq', 1, false);


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
-- Name: room_categories_rent_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.room_categories_rent_id_seq', 11, true);


--
-- Name: rooms_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.rooms_id_seq', 1, false);


--
-- Name: user_access_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_access_id_seq', 1, false);


--
-- Name: user_info_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_info_id_seq', 35, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 1, true);


--
-- Name: biiling_other_info biiling_other_info_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.biiling_other_info
    ADD CONSTRAINT biiling_other_info_pkey PRIMARY KEY (id);


--
-- Name: billing billing_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.billing
    ADD CONSTRAINT billing_pkey PRIMARY KEY (id);


--
-- Name: booking_days booking_days_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_days
    ADD CONSTRAINT booking_days_pkey PRIMARY KEY (id);


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
-- Name: payment_records payment_records_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payment_records
    ADD CONSTRAINT payment_records_pkey PRIMARY KEY (id);


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
-- Name: room_categories_rent room_categories_rent_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_categories_rent
    ADD CONSTRAINT room_categories_rent_pkey PRIMARY KEY (id);


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
-- Name: user_info user_info_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_info
    ADD CONSTRAINT user_info_pkey PRIMARY KEY (id);


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

