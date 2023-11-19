--
-- PostgreSQL database dump
--

-- Dumped from database version 15.5 (Debian 15.5-1.pgdg120+1)
-- Dumped by pg_dump version 15.0

-- Started on 2023-11-19 20:59:43 CET

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
-- TOC entry 236 (class 1259 OID 16513)
-- Name: criteria; Type: TABLE; Schema: public; Owner: myuser
--

CREATE TABLE IF NOT EXISTS public.criteria (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    type character varying(255) NOT NULL,
    dataset_id bigint NOT NULL
);


ALTER TABLE public.criteria OWNER TO myuser;

--
-- TOC entry 235 (class 1259 OID 16512)
-- Name: criteria_id_seq; Type: SEQUENCE; Schema: public; Owner: myuser
--

CREATE SEQUENCE public.criteria_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.criteria_id_seq OWNER TO myuser;

--
-- TOC entry 3490 (class 0 OID 0)
-- Dependencies: 235
-- Name: criteria_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: myuser
--

ALTER SEQUENCE public.criteria_id_seq OWNED BY public.criteria.id;


--
-- TOC entry 244 (class 1259 OID 16573)
-- Name: dataset_user; Type: TABLE; Schema: public; Owner: myuser
--

CREATE TABLE IF NOT EXISTS public.dataset_user (
    id bigint NOT NULL,
    dataset_id bigint NOT NULL,
    user_id bigint NOT NULL
);


ALTER TABLE public.dataset_user OWNER TO myuser;

--
-- TOC entry 243 (class 1259 OID 16572)
-- Name: dataset_user_id_seq; Type: SEQUENCE; Schema: public; Owner: myuser
--

CREATE SEQUENCE public.dataset_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dataset_user_id_seq OWNER TO myuser;

--
-- TOC entry 3491 (class 0 OID 0)
-- Dependencies: 243
-- Name: dataset_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: myuser
--

ALTER SEQUENCE public.dataset_user_id_seq OWNED BY public.dataset_user.id;


--
-- TOC entry 224 (class 1259 OID 16436)
-- Name: datasets; Type: TABLE; Schema: public; Owner: myuser
--

CREATE TABLE IF NOT EXISTS public.datasets (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    user_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.datasets OWNER TO myuser;

--
-- TOC entry 223 (class 1259 OID 16435)
-- Name: datasets_id_seq; Type: SEQUENCE; Schema: public; Owner: myuser
--

CREATE SEQUENCE public.datasets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.datasets_id_seq OWNER TO myuser;

--
-- TOC entry 3492 (class 0 OID 0)
-- Dependencies: 223
-- Name: datasets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: myuser
--

ALTER SEQUENCE public.datasets_id_seq OWNED BY public.datasets.id;


--
-- TOC entry 240 (class 1259 OID 16539)
-- Name: electre_criteria_settings; Type: TABLE; Schema: public; Owner: myuser
--

CREATE TABLE IF NOT EXISTS public.electre_criteria_settings (
    id bigint NOT NULL,
    electre_one_id bigint NOT NULL,
    criterion_id bigint NOT NULL,
    weight double precision,
    q double precision,
    p double precision,
    v double precision,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.electre_criteria_settings OWNER TO myuser;

--
-- TOC entry 239 (class 1259 OID 16538)
-- Name: electre_criteria_settings_id_seq; Type: SEQUENCE; Schema: public; Owner: myuser
--

CREATE SEQUENCE public.electre_criteria_settings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.electre_criteria_settings_id_seq OWNER TO myuser;

--
-- TOC entry 3493 (class 0 OID 0)
-- Dependencies: 239
-- Name: electre_criteria_settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: myuser
--

ALTER SEQUENCE public.electre_criteria_settings_id_seq OWNED BY public.electre_criteria_settings.id;


--
-- TOC entry 228 (class 1259 OID 16465)
-- Name: electre_ones; Type: TABLE; Schema: public; Owner: myuser
--

CREATE TABLE IF NOT EXISTS public.electre_ones (
    id bigint NOT NULL,
    lambda double precision NOT NULL,
    project_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.electre_ones OWNER TO myuser;

--
-- TOC entry 227 (class 1259 OID 16464)
-- Name: electre_ones_id_seq; Type: SEQUENCE; Schema: public; Owner: myuser
--

CREATE SEQUENCE public.electre_ones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.electre_ones_id_seq OWNER TO myuser;

--
-- TOC entry 3494 (class 0 OID 0)
-- Dependencies: 227
-- Name: electre_ones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: myuser
--

ALTER SEQUENCE public.electre_ones_id_seq OWNED BY public.electre_ones.id;


--
-- TOC entry 230 (class 1259 OID 16477)
-- Name: electre_tris; Type: TABLE; Schema: public; Owner: myuser
--

CREATE TABLE IF NOT EXISTS public.electre_tris (
    id bigint NOT NULL,
    lambda double precision NOT NULL,
    project_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.electre_tris OWNER TO myuser;

--
-- TOC entry 229 (class 1259 OID 16476)
-- Name: electre_tris_id_seq; Type: SEQUENCE; Schema: public; Owner: myuser
--

CREATE SEQUENCE public.electre_tris_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.electre_tris_id_seq OWNER TO myuser;

--
-- TOC entry 3495 (class 0 OID 0)
-- Dependencies: 229
-- Name: electre_tris_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: myuser
--

ALTER SEQUENCE public.electre_tris_id_seq OWNED BY public.electre_tris.id;


--
-- TOC entry 220 (class 1259 OID 16412)
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: myuser
--

CREATE TABLE IF NOT EXISTS public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO myuser;

--
-- TOC entry 219 (class 1259 OID 16411)
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: myuser
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO myuser;

--
-- TOC entry 3496 (class 0 OID 0)
-- Dependencies: 219
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: myuser
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- TOC entry 215 (class 1259 OID 16387)
-- Name: migrations; Type: TABLE; Schema: public; Owner: myuser
--

CREATE TABLE IF NOT EXISTS public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO myuser;

--
-- TOC entry 214 (class 1259 OID 16386)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: myuser
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO myuser;

--
-- TOC entry 3497 (class 0 OID 0)
-- Dependencies: 214
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: myuser
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 218 (class 1259 OID 16404)
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: myuser
--

CREATE TABLE IF NOT EXISTS public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO myuser;

--
-- TOC entry 222 (class 1259 OID 16424)
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: myuser
--

CREATE TABLE IF NOT EXISTS public.personal_access_tokens (
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


ALTER TABLE public.personal_access_tokens OWNER TO myuser;

--
-- TOC entry 221 (class 1259 OID 16423)
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: myuser
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personal_access_tokens_id_seq OWNER TO myuser;

--
-- TOC entry 3498 (class 0 OID 0)
-- Dependencies: 221
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: myuser
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- TOC entry 242 (class 1259 OID 16556)
-- Name: project_user; Type: TABLE; Schema: public; Owner: myuser
--

CREATE TABLE IF NOT EXISTS public.project_user (
    id bigint NOT NULL,
    project_id bigint NOT NULL,
    user_id bigint NOT NULL
);


ALTER TABLE public.project_user OWNER TO myuser;

--
-- TOC entry 241 (class 1259 OID 16555)
-- Name: project_user_id_seq; Type: SEQUENCE; Schema: public; Owner: myuser
--

CREATE SEQUENCE public.project_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.project_user_id_seq OWNER TO myuser;

--
-- TOC entry 3499 (class 0 OID 0)
-- Dependencies: 241
-- Name: project_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: myuser
--

ALTER SEQUENCE public.project_user_id_seq OWNED BY public.project_user.id;


--
-- TOC entry 226 (class 1259 OID 16448)
-- Name: projects; Type: TABLE; Schema: public; Owner: myuser
--

CREATE TABLE IF NOT EXISTS public.projects (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    user_id bigint NOT NULL,
    dataset_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.projects OWNER TO myuser;

--
-- TOC entry 225 (class 1259 OID 16447)
-- Name: projects_id_seq; Type: SEQUENCE; Schema: public; Owner: myuser
--

CREATE SEQUENCE public.projects_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.projects_id_seq OWNER TO myuser;

--
-- TOC entry 3500 (class 0 OID 0)
-- Dependencies: 225
-- Name: projects_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: myuser
--

ALTER SEQUENCE public.projects_id_seq OWNED BY public.projects.id;


--
-- TOC entry 217 (class 1259 OID 16394)
-- Name: users; Type: TABLE; Schema: public; Owner: myuser
--

CREATE TABLE IF NOT EXISTS public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO myuser;

--
-- TOC entry 216 (class 1259 OID 16393)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: myuser
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO myuser;

--
-- TOC entry 3501 (class 0 OID 0)
-- Dependencies: 216
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: myuser
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 232 (class 1259 OID 16489)
-- Name: utas; Type: TABLE; Schema: public; Owner: myuser
--

CREATE TABLE IF NOT EXISTS public.utas (
    id bigint NOT NULL,
    project_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.utas OWNER TO myuser;

--
-- TOC entry 231 (class 1259 OID 16488)
-- Name: utas_id_seq; Type: SEQUENCE; Schema: public; Owner: myuser
--

CREATE SEQUENCE public.utas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.utas_id_seq OWNER TO myuser;

--
-- TOC entry 3502 (class 0 OID 0)
-- Dependencies: 231
-- Name: utas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: myuser
--

ALTER SEQUENCE public.utas_id_seq OWNED BY public.utas.id;


--
-- TOC entry 238 (class 1259 OID 16522)
-- Name: values; Type: TABLE; Schema: public; Owner: myuser
--

CREATE TABLE IF NOT EXISTS public."values" (
    id bigint NOT NULL,
    value double precision NOT NULL,
    criterion_id bigint NOT NULL,
    variant_id bigint NOT NULL
);


ALTER TABLE public."values" OWNER TO myuser;

--
-- TOC entry 237 (class 1259 OID 16521)
-- Name: values_id_seq; Type: SEQUENCE; Schema: public; Owner: myuser
--

CREATE SEQUENCE public.values_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.values_id_seq OWNER TO myuser;

--
-- TOC entry 3503 (class 0 OID 0)
-- Dependencies: 237
-- Name: values_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: myuser
--

ALTER SEQUENCE public.values_id_seq OWNED BY public."values".id;


--
-- TOC entry 234 (class 1259 OID 16501)
-- Name: variants; Type: TABLE; Schema: public; Owner: myuser
--

CREATE TABLE IF NOT EXISTS public.variants (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    dataset_id bigint NOT NULL
);


ALTER TABLE public.variants OWNER TO myuser;

--
-- TOC entry 233 (class 1259 OID 16500)
-- Name: variants_id_seq; Type: SEQUENCE; Schema: public; Owner: myuser
--

CREATE SEQUENCE public.variants_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.variants_id_seq OWNER TO myuser;

--
-- TOC entry 3504 (class 0 OID 0)
-- Dependencies: 233
-- Name: variants_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: myuser
--

ALTER SEQUENCE public.variants_id_seq OWNED BY public.variants.id;


--
-- TOC entry 3284 (class 2604 OID 16516)
-- Name: criteria id; Type: DEFAULT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.criteria ALTER COLUMN id SET DEFAULT nextval('public.criteria_id_seq'::regclass);


--
-- TOC entry 3288 (class 2604 OID 16576)
-- Name: dataset_user id; Type: DEFAULT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.dataset_user ALTER COLUMN id SET DEFAULT nextval('public.dataset_user_id_seq'::regclass);


--
-- TOC entry 3278 (class 2604 OID 16439)
-- Name: datasets id; Type: DEFAULT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.datasets ALTER COLUMN id SET DEFAULT nextval('public.datasets_id_seq'::regclass);


--
-- TOC entry 3286 (class 2604 OID 16542)
-- Name: electre_criteria_settings id; Type: DEFAULT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.electre_criteria_settings ALTER COLUMN id SET DEFAULT nextval('public.electre_criteria_settings_id_seq'::regclass);


--
-- TOC entry 3280 (class 2604 OID 16468)
-- Name: electre_ones id; Type: DEFAULT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.electre_ones ALTER COLUMN id SET DEFAULT nextval('public.electre_ones_id_seq'::regclass);


--
-- TOC entry 3281 (class 2604 OID 16480)
-- Name: electre_tris id; Type: DEFAULT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.electre_tris ALTER COLUMN id SET DEFAULT nextval('public.electre_tris_id_seq'::regclass);


--
-- TOC entry 3275 (class 2604 OID 16415)
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- TOC entry 3273 (class 2604 OID 16390)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 3277 (class 2604 OID 16427)
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- TOC entry 3287 (class 2604 OID 16559)
-- Name: project_user id; Type: DEFAULT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.project_user ALTER COLUMN id SET DEFAULT nextval('public.project_user_id_seq'::regclass);


--
-- TOC entry 3279 (class 2604 OID 16451)
-- Name: projects id; Type: DEFAULT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.projects ALTER COLUMN id SET DEFAULT nextval('public.projects_id_seq'::regclass);


--
-- TOC entry 3274 (class 2604 OID 16397)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 3282 (class 2604 OID 16492)
-- Name: utas id; Type: DEFAULT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.utas ALTER COLUMN id SET DEFAULT nextval('public.utas_id_seq'::regclass);


--
-- TOC entry 3285 (class 2604 OID 16525)
-- Name: values id; Type: DEFAULT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public."values" ALTER COLUMN id SET DEFAULT nextval('public.values_id_seq'::regclass);


--
-- TOC entry 3283 (class 2604 OID 16504)
-- Name: variants id; Type: DEFAULT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.variants ALTER COLUMN id SET DEFAULT nextval('public.variants_id_seq'::regclass);


--
-- TOC entry 3319 (class 2606 OID 16520)
-- Name: criteria criteria_pkey; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.criteria
    ADD CONSTRAINT criteria_pkey PRIMARY KEY (id);


--
-- TOC entry 3327 (class 2606 OID 16578)
-- Name: dataset_user dataset_user_pkey; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.dataset_user
    ADD CONSTRAINT dataset_user_pkey PRIMARY KEY (id);


--
-- TOC entry 3307 (class 2606 OID 16441)
-- Name: datasets datasets_pkey; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.datasets
    ADD CONSTRAINT datasets_pkey PRIMARY KEY (id);


--
-- TOC entry 3323 (class 2606 OID 16544)
-- Name: electre_criteria_settings electre_criteria_settings_pkey; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.electre_criteria_settings
    ADD CONSTRAINT electre_criteria_settings_pkey PRIMARY KEY (id);


--
-- TOC entry 3311 (class 2606 OID 16470)
-- Name: electre_ones electre_ones_pkey; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.electre_ones
    ADD CONSTRAINT electre_ones_pkey PRIMARY KEY (id);


--
-- TOC entry 3313 (class 2606 OID 16482)
-- Name: electre_tris electre_tris_pkey; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.electre_tris
    ADD CONSTRAINT electre_tris_pkey PRIMARY KEY (id);


--
-- TOC entry 3298 (class 2606 OID 16420)
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 3300 (class 2606 OID 16422)
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- TOC entry 3290 (class 2606 OID 16392)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 3296 (class 2606 OID 16410)
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- TOC entry 3302 (class 2606 OID 16431)
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- TOC entry 3304 (class 2606 OID 16434)
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- TOC entry 3325 (class 2606 OID 16561)
-- Name: project_user project_user_pkey; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.project_user
    ADD CONSTRAINT project_user_pkey PRIMARY KEY (id);


--
-- TOC entry 3309 (class 2606 OID 16453)
-- Name: projects projects_pkey; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.projects
    ADD CONSTRAINT projects_pkey PRIMARY KEY (id);


--
-- TOC entry 3292 (class 2606 OID 16403)
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- TOC entry 3294 (class 2606 OID 16401)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 3315 (class 2606 OID 16494)
-- Name: utas utas_pkey; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.utas
    ADD CONSTRAINT utas_pkey PRIMARY KEY (id);


--
-- TOC entry 3321 (class 2606 OID 16527)
-- Name: values values_pkey; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public."values"
    ADD CONSTRAINT values_pkey PRIMARY KEY (id);


--
-- TOC entry 3317 (class 2606 OID 16506)
-- Name: variants variants_pkey; Type: CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.variants
    ADD CONSTRAINT variants_pkey PRIMARY KEY (id);


--
-- TOC entry 3305 (class 1259 OID 16432)
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: myuser
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- TOC entry 3341 (class 2606 OID 16579)
-- Name: dataset_user dataset_user_dataset_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.dataset_user
    ADD CONSTRAINT dataset_user_dataset_id_foreign FOREIGN KEY (dataset_id) REFERENCES public.datasets(id);


--
-- TOC entry 3342 (class 2606 OID 16584)
-- Name: dataset_user dataset_user_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.dataset_user
    ADD CONSTRAINT dataset_user_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- TOC entry 3328 (class 2606 OID 16442)
-- Name: datasets datasets_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.datasets
    ADD CONSTRAINT datasets_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- TOC entry 3337 (class 2606 OID 16550)
-- Name: electre_criteria_settings electre_criteria_settings_criterion_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.electre_criteria_settings
    ADD CONSTRAINT electre_criteria_settings_criterion_id_foreign FOREIGN KEY (criterion_id) REFERENCES public.criteria(id) ON DELETE CASCADE;


--
-- TOC entry 3338 (class 2606 OID 16545)
-- Name: electre_criteria_settings electre_criteria_settings_electre_one_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.electre_criteria_settings
    ADD CONSTRAINT electre_criteria_settings_electre_one_id_foreign FOREIGN KEY (electre_one_id) REFERENCES public.electre_ones(id) ON DELETE CASCADE;


--
-- TOC entry 3331 (class 2606 OID 16471)
-- Name: electre_ones electre_ones_project_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.electre_ones
    ADD CONSTRAINT electre_ones_project_id_foreign FOREIGN KEY (project_id) REFERENCES public.projects(id);


--
-- TOC entry 3332 (class 2606 OID 16483)
-- Name: electre_tris electre_tris_project_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.electre_tris
    ADD CONSTRAINT electre_tris_project_id_foreign FOREIGN KEY (project_id) REFERENCES public.projects(id);


--
-- TOC entry 3339 (class 2606 OID 16562)
-- Name: project_user project_user_project_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.project_user
    ADD CONSTRAINT project_user_project_id_foreign FOREIGN KEY (project_id) REFERENCES public.projects(id);


--
-- TOC entry 3340 (class 2606 OID 16567)
-- Name: project_user project_user_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.project_user
    ADD CONSTRAINT project_user_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- TOC entry 3329 (class 2606 OID 16459)
-- Name: projects projects_dataset_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.projects
    ADD CONSTRAINT projects_dataset_id_foreign FOREIGN KEY (dataset_id) REFERENCES public.datasets(id);


--
-- TOC entry 3330 (class 2606 OID 16454)
-- Name: projects projects_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.projects
    ADD CONSTRAINT projects_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- TOC entry 3333 (class 2606 OID 16495)
-- Name: utas utas_project_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.utas
    ADD CONSTRAINT utas_project_id_foreign FOREIGN KEY (project_id) REFERENCES public.projects(id);


--
-- TOC entry 3335 (class 2606 OID 16528)
-- Name: values values_criterion_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public."values"
    ADD CONSTRAINT values_criterion_id_foreign FOREIGN KEY (criterion_id) REFERENCES public.criteria(id);


--
-- TOC entry 3336 (class 2606 OID 16533)
-- Name: values values_variant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public."values"
    ADD CONSTRAINT values_variant_id_foreign FOREIGN KEY (variant_id) REFERENCES public.variants(id);


--
-- TOC entry 3334 (class 2606 OID 16507)
-- Name: variants variants_dataset_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: myuser
--

ALTER TABLE ONLY public.variants
    ADD CONSTRAINT variants_dataset_id_foreign FOREIGN KEY (dataset_id) REFERENCES public.datasets(id);


-- Completed on 2023-11-19 20:59:43 CET

--
-- PostgreSQL database dump complete
--

