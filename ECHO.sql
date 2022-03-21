--
-- PostgreSQL database dump
--

-- Dumped from database version 11.5
-- Dumped by pg_dump version 12.1

-- Started on 2020-05-14 15:47:09

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

--
-- TOC entry 244 (class 1255 OID 19762)
-- Name: add_attendee(); Type: FUNCTION; Schema: public; Owner: echoUser
--

CREATE FUNCTION public.add_attendee() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
Begin
    IF (select count(*) from attends a where a.id=New.id)=0  THEN
        INSERT INTO attendee(ID,full_name, health_center_name)
        SELECT DISTINCT c.ID, c.Full_name, c.health_center_name
        FROM Contact c, attends a
        WHERE a.id=c.id;
    END IF;
    
    Return New;
End;
$$;


ALTER FUNCTION public.add_attendee() OWNER TO "echoUser";

SET default_tablespace = '';

--
-- TOC entry 226 (class 1259 OID 18785)
-- Name: attendee; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.attendee (
    id integer NOT NULL,
    full_name text,
    health_center_name text
);


ALTER TABLE public.attendee OWNER TO "echoUser";

--
-- TOC entry 225 (class 1259 OID 18783)
-- Name: attendee_id_seq; Type: SEQUENCE; Schema: public; Owner: echoUser
--

CREATE SEQUENCE public.attendee_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.attendee_id_seq OWNER TO "echoUser";

--
-- TOC entry 4077 (class 0 OID 0)
-- Dependencies: 225
-- Name: attendee_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: echoUser
--

ALTER SEQUENCE public.attendee_id_seq OWNED BY public.attendee.id;


--
-- TOC entry 212 (class 1259 OID 17349)
-- Name: attendeessession_raw1; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.attendeessession_raw1 (
    date date,
    start_time character varying(100),
    end_time character varying(100),
    clinic_name text,
    total_session_anonymous_attendees character varying(50),
    clinic_status text,
    clinic_location text,
    clinic_type text,
    clinic_notes text,
    full_name text,
    first_name text,
    last_name text,
    attendee_type text,
    connection_type text,
    health_center_name text,
    health_center_street_address text,
    health_center_notes text
);


ALTER TABLE public.attendeessession_raw1 OWNER TO "echoUser";

--
-- TOC entry 242 (class 1259 OID 19960)
-- Name: attends; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.attends (
    id integer NOT NULL,
    echo_name text NOT NULL,
    date timestamp without time zone NOT NULL,
    connection_type text NOT NULL,
    attendee_type text NOT NULL
);


ALTER TABLE public.attends OWNER TO "echoUser";

--
-- TOC entry 241 (class 1259 OID 19958)
-- Name: attends_id_seq; Type: SEQUENCE; Schema: public; Owner: echoUser
--

CREATE SEQUENCE public.attends_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.attends_id_seq OWNER TO "echoUser";

--
-- TOC entry 4078 (class 0 OID 0)
-- Dependencies: 241
-- Name: attends_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: echoUser
--

ALTER SEQUENCE public.attends_id_seq OWNED BY public.attends.id;


--
-- TOC entry 196 (class 1259 OID 16523)
-- Name: brfss; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.brfss (
    brfss_id integer NOT NULL,
    regionname character varying(30)
);


ALTER TABLE public.brfss OWNER TO "echoUser";

--
-- TOC entry 216 (class 1259 OID 17498)
-- Name: case_present_raw; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.case_present_raw (
    date date,
    clinic_name text,
    full_name text,
    patient_id text,
    patient_type text,
    presentation_start_time text,
    presentation_end_time text,
    followup_date text,
    health_center_name text,
    health_center_street_address text,
    heath_notes text
);


ALTER TABLE public.case_present_raw OWNER TO "echoUser";

--
-- TOC entry 222 (class 1259 OID 17841)
-- Name: cases; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.cases (
    date date NOT NULL,
    echo_name text NOT NULL,
    full_name text NOT NULL,
    health_center_name text,
    patient_id text NOT NULL,
    patient_type text,
    presentation_start_time text NOT NULL,
    presentation_end_time text,
    followup_date text,
    contact_id integer
);


ALTER TABLE public.cases OWNER TO "echoUser";

--
-- TOC entry 224 (class 1259 OID 18756)
-- Name: contact; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.contact (
    id integer NOT NULL,
    full_name text,
    first_name text,
    last_name text,
    job_title text,
    specialty text,
    health_center_name text,
    street_address text,
    mobile text,
    fax text,
    other_phone text,
    email text,
    other_email text,
    notes text,
    website text
);


ALTER TABLE public.contact OWNER TO "echoUser";

--
-- TOC entry 223 (class 1259 OID 18754)
-- Name: contact_id_seq; Type: SEQUENCE; Schema: public; Owner: echoUser
--

CREATE SEQUENCE public.contact_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.contact_id_seq OWNER TO "echoUser";

--
-- TOC entry 4079 (class 0 OID 0)
-- Dependencies: 223
-- Name: contact_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: echoUser
--

ALTER SEQUENCE public.contact_id_seq OWNED BY public.contact.id;


--
-- TOC entry 210 (class 1259 OID 17235)
-- Name: contact_raw; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.contact_raw (
    id integer NOT NULL,
    full_name text,
    first_name text,
    last_name text,
    job_title text,
    credentials text,
    specialty text,
    health_center_name text,
    street_address text,
    city text,
    state text,
    zip_code text,
    county text,
    country text,
    phone text,
    mobile text,
    fax text,
    other_phone text,
    email text,
    other_email text,
    website text,
    total_sessions_attended integer,
    notes text
);


ALTER TABLE public.contact_raw OWNER TO "echoUser";

--
-- TOC entry 209 (class 1259 OID 17233)
-- Name: contact_raw_id_seq; Type: SEQUENCE; Schema: public; Owner: echoUser
--

CREATE SEQUENCE public.contact_raw_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.contact_raw_id_seq OWNER TO "echoUser";

--
-- TOC entry 4080 (class 0 OID 0)
-- Dependencies: 209
-- Name: contact_raw_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: echoUser
--

ALTER SEQUENCE public.contact_raw_id_seq OWNED BY public.contact_raw.id;


--
-- TOC entry 208 (class 1259 OID 17205)
-- Name: contacts_raw; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.contacts_raw (
    id integer NOT NULL,
    full_name text,
    first_name text,
    last_name text,
    job_title text,
    credentials text,
    speciality text,
    health_center_name text,
    street_address text,
    city text,
    state text,
    zip_code text,
    county text,
    country text,
    phone text,
    mobile text,
    fax text,
    other_phone text,
    email text,
    other_email text,
    website text,
    total_sessions_attended integer,
    notes text
);


ALTER TABLE public.contacts_raw OWNER TO "echoUser";

--
-- TOC entry 207 (class 1259 OID 17203)
-- Name: contacts_raw_id_seq; Type: SEQUENCE; Schema: public; Owner: echoUser
--

CREATE SEQUENCE public.contacts_raw_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.contacts_raw_id_seq OWNER TO "echoUser";

--
-- TOC entry 4081 (class 0 OID 0)
-- Dependencies: 207
-- Name: contacts_raw_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: echoUser
--

ALTER SEQUENCE public.contacts_raw_id_seq OWNED BY public.contacts_raw.id;


--
-- TOC entry 197 (class 1259 OID 16538)
-- Name: countydata; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.countydata (
    fips character(5),
    state character varying(20),
    county character varying(30) NOT NULL,
    brfss_id integer,
    landsqmi real,
    areasqmi real,
    totalpop2010 integer,
    pctover62 real,
    pctmales real,
    pctfemales real,
    pctwhite1 real,
    pctblack1 real,
    pctindian1 real,
    pctasian1 real,
    pcthawnpi1 real,
    pctother1 real,
    avghhinc real,
    avghhsocsec real,
    pctpoort real,
    pctpublictrans real,
    pctbachelorsormore real,
    pctbroadbandint real,
    pctnointernet real,
    pctnovehicles real,
    sef_rank integer,
    ho_rank integer,
    hf_rank integer,
    pctuninsured real,
    numofpcp integer,
    pctfluvacc real,
    pctsomecollege real,
    pctunemployed real,
    lifeexpect real,
    pctnohealthyfood real,
    pctrural real
);


ALTER TABLE public.countydata OWNER TO "echoUser";

--
-- TOC entry 206 (class 1259 OID 17179)
-- Name: credentials; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.credentials (
    credential_name character varying(100) NOT NULL
);


ALTER TABLE public.credentials OWNER TO "echoUser";

--
-- TOC entry 213 (class 1259 OID 17376)
-- Name: didactic_present_raw; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.didactic_present_raw (
    date date,
    clinic_name text,
    full_name text,
    title text,
    didactic_start_time character varying(50),
    didactic_end_time character varying(50),
    notes text
);


ALTER TABLE public.didactic_present_raw OWNER TO "echoUser";

--
-- TOC entry 217 (class 1259 OID 17538)
-- Name: didactics; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.didactics (
    date date NOT NULL,
    echo_name text NOT NULL,
    full_name text NOT NULL,
    title text NOT NULL,
    didactic_start_time character varying(50) NOT NULL,
    didactic_end_time character varying(50),
    notes text,
    id integer
);


ALTER TABLE public.didactics OWNER TO "echoUser";

--
-- TOC entry 199 (class 1259 OID 17054)
-- Name: echo_ideas; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.echo_ideas (
    idea_id integer NOT NULL,
    idea_name character varying(100),
    date_created date,
    description text
);


ALTER TABLE public.echo_ideas OWNER TO "echoUser";

--
-- TOC entry 198 (class 1259 OID 17052)
-- Name: echo_ideas_idea_id_seq; Type: SEQUENCE; Schema: public; Owner: echoUser
--

CREATE SEQUENCE public.echo_ideas_idea_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.echo_ideas_idea_id_seq OWNER TO "echoUser";

--
-- TOC entry 4082 (class 0 OID 0)
-- Dependencies: 198
-- Name: echo_ideas_idea_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: echoUser
--

ALTER SEQUENCE public.echo_ideas_idea_id_seq OWNED BY public.echo_ideas.idea_id;


--
-- TOC entry 215 (class 1259 OID 17435)
-- Name: echos; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.echos (
    echo_name text NOT NULL
);


ALTER TABLE public.echos OWNER TO "echoUser";

--
-- TOC entry 200 (class 1259 OID 17063)
-- Name: employees; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.employees (
    email character varying(40) NOT NULL,
    last_name character varying(20),
    first_name character varying(20),
    gender character(1),
    CONSTRAINT employees_gender_check CHECK (((gender = 'M'::bpchar) OR (gender = 'F'::bpchar) OR (gender = 'O'::bpchar)))
);


ALTER TABLE public.employees OWNER TO "echoUser";

--
-- TOC entry 229 (class 1259 OID 19579)
-- Name: groups; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.groups (
    groupname character varying(200),
    name character varying(100) NOT NULL,
    streetaddress character varying(200) NOT NULL
);


ALTER TABLE public.groups OWNER TO "echoUser";

--
-- TOC entry 221 (class 1259 OID 17728)
-- Name: has_credential; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.has_credential (
    credential_name character varying(100) NOT NULL,
    id integer NOT NULL
);


ALTER TABLE public.has_credential OWNER TO "echoUser";

--
-- TOC entry 220 (class 1259 OID 17726)
-- Name: has_credential1_id_seq; Type: SEQUENCE; Schema: public; Owner: echoUser
--

CREATE SEQUENCE public.has_credential1_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.has_credential1_id_seq OWNER TO "echoUser";

--
-- TOC entry 4083 (class 0 OID 0)
-- Dependencies: 220
-- Name: has_credential1_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: echoUser
--

ALTER SEQUENCE public.has_credential1_id_seq OWNED BY public.has_credential.id;


--
-- TOC entry 219 (class 1259 OID 17707)
-- Name: has_type; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.has_type (
    type text NOT NULL,
    id integer NOT NULL
);


ALTER TABLE public.has_type OWNER TO "echoUser";

--
-- TOC entry 218 (class 1259 OID 17705)
-- Name: has_type_id_seq; Type: SEQUENCE; Schema: public; Owner: echoUser
--

CREATE SEQUENCE public.has_type_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.has_type_id_seq OWNER TO "echoUser";

--
-- TOC entry 4084 (class 0 OID 0)
-- Dependencies: 218
-- Name: has_type_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: echoUser
--

ALTER SEQUENCE public.has_type_id_seq OWNED BY public.has_type.id;


--
-- TOC entry 243 (class 1259 OID 19985)
-- Name: justnames; Type: VIEW; Schema: public; Owner: echoUser
--

CREATE VIEW public.justnames AS
 SELECT contact.id,
    contact.job_title,
    contact.health_center_name
   FROM public.contact;


ALTER TABLE public.justnames OWNER TO "echoUser";

--
-- TOC entry 240 (class 1259 OID 19932)
-- Name: login_credentials; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.login_credentials (
    username character varying(20) NOT NULL,
    password character varying(255)
);


ALTER TABLE public.login_credentials OWNER TO "echoUser";

--
-- TOC entry 227 (class 1259 OID 19556)
-- Name: organizations; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.organizations (
    name character varying(100) NOT NULL,
    streetaddress character varying(200) NOT NULL,
    city character varying(100),
    state character varying(50),
    zipcode character varying(20),
    county character varying(200),
    country character varying(20),
    phone character varying(50)
);


ALTER TABLE public.organizations OWNER TO "echoUser";

--
-- TOC entry 228 (class 1259 OID 19564)
-- Name: orgsmo; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.orgsmo (
    name character varying(100) NOT NULL,
    streetaddress character varying(200) NOT NULL,
    city character varying(100),
    zipcode character varying(20),
    county character varying(30),
    fqhc boolean
);


ALTER TABLE public.orgsmo OWNER TO "echoUser";

--
-- TOC entry 203 (class 1259 OID 17089)
-- Name: other_employee; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.other_employee (
    email character varying(40) NOT NULL
);


ALTER TABLE public.other_employee OWNER TO "echoUser";

--
-- TOC entry 202 (class 1259 OID 17079)
-- Name: outreach_coordinator; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.outreach_coordinator (
    email character varying(40) NOT NULL
);


ALTER TABLE public.outreach_coordinator OWNER TO "echoUser";

--
-- TOC entry 205 (class 1259 OID 17132)
-- Name: outreach_event_registrants; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.outreach_event_registrants (
    email character varying(40) NOT NULL,
    outreach_event_id integer NOT NULL,
    last_name character varying(20),
    first_name character varying(20)
);


ALTER TABLE public.outreach_event_registrants OWNER TO "echoUser";

--
-- TOC entry 204 (class 1259 OID 17130)
-- Name: outreach_event_registrants_outreach_event_id_seq; Type: SEQUENCE; Schema: public; Owner: echoUser
--

CREATE SEQUENCE public.outreach_event_registrants_outreach_event_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.outreach_event_registrants_outreach_event_id_seq OWNER TO "echoUser";

--
-- TOC entry 4085 (class 0 OID 0)
-- Dependencies: 204
-- Name: outreach_event_registrants_outreach_event_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: echoUser
--

ALTER SEQUENCE public.outreach_event_registrants_outreach_event_id_seq OWNED BY public.outreach_event_registrants.outreach_event_id;


--
-- TOC entry 239 (class 1259 OID 19910)
-- Name: outreach_events; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.outreach_events (
    event_id integer NOT NULL,
    event_name character varying(300),
    date character varying(30),
    location character varying(200),
    who_exhibiting character varying(50),
    fee integer,
    notes text,
    go_again character varying(10),
    touches integer,
    attendees integer,
    comments text
);


ALTER TABLE public.outreach_events OWNER TO "echoUser";

--
-- TOC entry 238 (class 1259 OID 19908)
-- Name: outreach_events_event_id_seq; Type: SEQUENCE; Schema: public; Owner: echoUser
--

CREATE SEQUENCE public.outreach_events_event_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.outreach_events_event_id_seq OWNER TO "echoUser";

--
-- TOC entry 4086 (class 0 OID 0)
-- Dependencies: 238
-- Name: outreach_events_event_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: echoUser
--

ALTER SEQUENCE public.outreach_events_event_id_seq OWNED BY public.outreach_events.event_id;


--
-- TOC entry 237 (class 1259 OID 19867)
-- Name: outreach_events_raw; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.outreach_events_raw (
    event_name character varying(300),
    date character varying(30),
    location character varying(200),
    who_exhibiting character varying(50),
    fee integer,
    notes text,
    go_again character varying(10),
    touches integer,
    attendees integer,
    comments text
);


ALTER TABLE public.outreach_events_raw OWNER TO "echoUser";

--
-- TOC entry 201 (class 1259 OID 17069)
-- Name: session_coordinator; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.session_coordinator (
    email character varying(40) NOT NULL
);


ALTER TABLE public.session_coordinator OWNER TO "echoUser";

--
-- TOC entry 214 (class 1259 OID 17427)
-- Name: sessions; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.sessions (
    date date NOT NULL,
    echo_name text NOT NULL,
    start_time character varying(100),
    end_time character varying(100),
    total_session_anonymous_attendees character varying(50),
    clinic_status text,
    clinic_location text,
    clinic_type text
);


ALTER TABLE public.sessions OWNER TO "echoUser";

--
-- TOC entry 231 (class 1259 OID 19682)
-- Name: survey; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.survey (
    surveyid integer NOT NULL,
    start_date timestamp without time zone,
    end_date timestamp without time zone,
    type text,
    echo_name text
);


ALTER TABLE public.survey OWNER TO "echoUser";

--
-- TOC entry 233 (class 1259 OID 19710)
-- Name: survey_new_raw; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.survey_new_raw (
    surveyid integer NOT NULL,
    start_date timestamp without time zone,
    end_date timestamp without time zone,
    type text,
    echo_name text
);


ALTER TABLE public.survey_new_raw OWNER TO "echoUser";

--
-- TOC entry 232 (class 1259 OID 19708)
-- Name: survey_new_raw_surveyid_seq; Type: SEQUENCE; Schema: public; Owner: echoUser
--

CREATE SEQUENCE public.survey_new_raw_surveyid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.survey_new_raw_surveyid_seq OWNER TO "echoUser";

--
-- TOC entry 4087 (class 0 OID 0)
-- Dependencies: 232
-- Name: survey_new_raw_surveyid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: echoUser
--

ALTER SEQUENCE public.survey_new_raw_surveyid_seq OWNED BY public.survey_new_raw.surveyid;


--
-- TOC entry 230 (class 1259 OID 19680)
-- Name: survey_surveyid_seq; Type: SEQUENCE; Schema: public; Owner: echoUser
--

CREATE SEQUENCE public.survey_surveyid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.survey_surveyid_seq OWNER TO "echoUser";

--
-- TOC entry 4088 (class 0 OID 0)
-- Dependencies: 230
-- Name: survey_surveyid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: echoUser
--

ALTER SEQUENCE public.survey_surveyid_seq OWNED BY public.survey.surveyid;


--
-- TOC entry 236 (class 1259 OID 19744)
-- Name: taken_survey; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.taken_survey (
    surveyid integer NOT NULL,
    id integer NOT NULL,
    responded boolean
);


ALTER TABLE public.taken_survey OWNER TO "echoUser";

--
-- TOC entry 235 (class 1259 OID 19742)
-- Name: taken_survey_id_seq; Type: SEQUENCE; Schema: public; Owner: echoUser
--

CREATE SEQUENCE public.taken_survey_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.taken_survey_id_seq OWNER TO "echoUser";

--
-- TOC entry 4089 (class 0 OID 0)
-- Dependencies: 235
-- Name: taken_survey_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: echoUser
--

ALTER SEQUENCE public.taken_survey_id_seq OWNED BY public.taken_survey.id;


--
-- TOC entry 234 (class 1259 OID 19740)
-- Name: taken_survey_surveyid_seq; Type: SEQUENCE; Schema: public; Owner: echoUser
--

CREATE SEQUENCE public.taken_survey_surveyid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.taken_survey_surveyid_seq OWNER TO "echoUser";

--
-- TOC entry 4090 (class 0 OID 0)
-- Dependencies: 234
-- Name: taken_survey_surveyid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: echoUser
--

ALTER SEQUENCE public.taken_survey_surveyid_seq OWNED BY public.taken_survey.surveyid;


--
-- TOC entry 211 (class 1259 OID 17263)
-- Name: type; Type: TABLE; Schema: public; Owner: echoUser
--

CREATE TABLE public.type (
    type text NOT NULL
);


ALTER TABLE public.type OWNER TO "echoUser";

--
-- TOC entry 3868 (class 2604 OID 18788)
-- Name: attendee id; Type: DEFAULT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.attendee ALTER COLUMN id SET DEFAULT nextval('public.attendee_id_seq'::regclass);


--
-- TOC entry 3874 (class 2604 OID 19963)
-- Name: attends id; Type: DEFAULT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.attends ALTER COLUMN id SET DEFAULT nextval('public.attends_id_seq'::regclass);


--
-- TOC entry 3867 (class 2604 OID 18759)
-- Name: contact id; Type: DEFAULT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.contact ALTER COLUMN id SET DEFAULT nextval('public.contact_id_seq'::regclass);


--
-- TOC entry 3864 (class 2604 OID 17238)
-- Name: contact_raw id; Type: DEFAULT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.contact_raw ALTER COLUMN id SET DEFAULT nextval('public.contact_raw_id_seq'::regclass);


--
-- TOC entry 3863 (class 2604 OID 17208)
-- Name: contacts_raw id; Type: DEFAULT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.contacts_raw ALTER COLUMN id SET DEFAULT nextval('public.contacts_raw_id_seq'::regclass);


--
-- TOC entry 3860 (class 2604 OID 17057)
-- Name: echo_ideas idea_id; Type: DEFAULT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.echo_ideas ALTER COLUMN idea_id SET DEFAULT nextval('public.echo_ideas_idea_id_seq'::regclass);


--
-- TOC entry 3866 (class 2604 OID 17731)
-- Name: has_credential id; Type: DEFAULT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.has_credential ALTER COLUMN id SET DEFAULT nextval('public.has_credential1_id_seq'::regclass);


--
-- TOC entry 3865 (class 2604 OID 17710)
-- Name: has_type id; Type: DEFAULT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.has_type ALTER COLUMN id SET DEFAULT nextval('public.has_type_id_seq'::regclass);


--
-- TOC entry 3862 (class 2604 OID 17135)
-- Name: outreach_event_registrants outreach_event_id; Type: DEFAULT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.outreach_event_registrants ALTER COLUMN outreach_event_id SET DEFAULT nextval('public.outreach_event_registrants_outreach_event_id_seq'::regclass);


--
-- TOC entry 3873 (class 2604 OID 19913)
-- Name: outreach_events event_id; Type: DEFAULT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.outreach_events ALTER COLUMN event_id SET DEFAULT nextval('public.outreach_events_event_id_seq'::regclass);


--
-- TOC entry 3869 (class 2604 OID 19685)
-- Name: survey surveyid; Type: DEFAULT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.survey ALTER COLUMN surveyid SET DEFAULT nextval('public.survey_surveyid_seq'::regclass);


--
-- TOC entry 3870 (class 2604 OID 19713)
-- Name: survey_new_raw surveyid; Type: DEFAULT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.survey_new_raw ALTER COLUMN surveyid SET DEFAULT nextval('public.survey_new_raw_surveyid_seq'::regclass);


--
-- TOC entry 3871 (class 2604 OID 19747)
-- Name: taken_survey surveyid; Type: DEFAULT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.taken_survey ALTER COLUMN surveyid SET DEFAULT nextval('public.taken_survey_surveyid_seq'::regclass);


--
-- TOC entry 3872 (class 2604 OID 19748)
-- Name: taken_survey id; Type: DEFAULT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.taken_survey ALTER COLUMN id SET DEFAULT nextval('public.taken_survey_id_seq'::regclass);


--
-- TOC entry 3912 (class 2606 OID 18793)
-- Name: attendee attendee_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.attendee
    ADD CONSTRAINT attendee_pkey PRIMARY KEY (id);


--
-- TOC entry 3931 (class 2606 OID 19968)
-- Name: attends attends_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.attends
    ADD CONSTRAINT attends_pkey PRIMARY KEY (id, echo_name, date, connection_type, attendee_type);


--
-- TOC entry 3876 (class 2606 OID 16527)
-- Name: brfss brfss_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.brfss
    ADD CONSTRAINT brfss_pkey PRIMARY KEY (brfss_id);


--
-- TOC entry 3907 (class 2606 OID 17848)
-- Name: cases cases_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.cases
    ADD CONSTRAINT cases_pkey PRIMARY KEY (date, echo_name, full_name, patient_id, presentation_start_time);


--
-- TOC entry 3909 (class 2606 OID 18764)
-- Name: contact contact_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.contact
    ADD CONSTRAINT contact_pkey PRIMARY KEY (id);


--
-- TOC entry 3878 (class 2606 OID 16542)
-- Name: countydata countydata_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.countydata
    ADD CONSTRAINT countydata_pkey PRIMARY KEY (county);


--
-- TOC entry 3892 (class 2606 OID 17183)
-- Name: credentials credentials_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.credentials
    ADD CONSTRAINT credentials_pkey PRIMARY KEY (credential_name);


--
-- TOC entry 3901 (class 2606 OID 17545)
-- Name: didactics didactics_presents_1_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.didactics
    ADD CONSTRAINT didactics_presents_1_pkey PRIMARY KEY (date, echo_name, full_name, title, didactic_start_time);


--
-- TOC entry 3899 (class 2606 OID 17442)
-- Name: echos echo_1_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.echos
    ADD CONSTRAINT echo_1_pkey PRIMARY KEY (echo_name);


--
-- TOC entry 3880 (class 2606 OID 17062)
-- Name: echo_ideas echo_ideas_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.echo_ideas
    ADD CONSTRAINT echo_ideas_pkey PRIMARY KEY (idea_id);


--
-- TOC entry 3882 (class 2606 OID 17068)
-- Name: employees employees_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_pkey PRIMARY KEY (email);


--
-- TOC entry 3919 (class 2606 OID 19586)
-- Name: groups groups_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.groups
    ADD CONSTRAINT groups_pkey PRIMARY KEY (name, streetaddress);


--
-- TOC entry 3905 (class 2606 OID 17733)
-- Name: has_credential has_credential1_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.has_credential
    ADD CONSTRAINT has_credential1_pkey PRIMARY KEY (credential_name, id);


--
-- TOC entry 3903 (class 2606 OID 17715)
-- Name: has_type has_type_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.has_type
    ADD CONSTRAINT has_type_pkey PRIMARY KEY (type, id);


--
-- TOC entry 3929 (class 2606 OID 19936)
-- Name: login_credentials login_credentials_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.login_credentials
    ADD CONSTRAINT login_credentials_pkey PRIMARY KEY (username);


--
-- TOC entry 3915 (class 2606 OID 19563)
-- Name: organizations organizations_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.organizations
    ADD CONSTRAINT organizations_pkey PRIMARY KEY (name, streetaddress);


--
-- TOC entry 3917 (class 2606 OID 19568)
-- Name: orgsmo orgsmo_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.orgsmo
    ADD CONSTRAINT orgsmo_pkey PRIMARY KEY (name, streetaddress);


--
-- TOC entry 3888 (class 2606 OID 17093)
-- Name: other_employee other_employee_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.other_employee
    ADD CONSTRAINT other_employee_pkey PRIMARY KEY (email);


--
-- TOC entry 3886 (class 2606 OID 17083)
-- Name: outreach_coordinator outreach_coordinator_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.outreach_coordinator
    ADD CONSTRAINT outreach_coordinator_pkey PRIMARY KEY (email);


--
-- TOC entry 3890 (class 2606 OID 17137)
-- Name: outreach_event_registrants outreach_event_registrants_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.outreach_event_registrants
    ADD CONSTRAINT outreach_event_registrants_pkey PRIMARY KEY (email);


--
-- TOC entry 3927 (class 2606 OID 19918)
-- Name: outreach_events outreach_events_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.outreach_events
    ADD CONSTRAINT outreach_events_pkey PRIMARY KEY (event_id);


--
-- TOC entry 3897 (class 2606 OID 17434)
-- Name: sessions session_1_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT session_1_pkey PRIMARY KEY (date, echo_name);


--
-- TOC entry 3884 (class 2606 OID 17073)
-- Name: session_coordinator session_coordinator_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.session_coordinator
    ADD CONSTRAINT session_coordinator_pkey PRIMARY KEY (email);


--
-- TOC entry 3923 (class 2606 OID 19718)
-- Name: survey_new_raw survey_new_raw_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.survey_new_raw
    ADD CONSTRAINT survey_new_raw_pkey PRIMARY KEY (surveyid);


--
-- TOC entry 3921 (class 2606 OID 19690)
-- Name: survey survey_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.survey
    ADD CONSTRAINT survey_pkey PRIMARY KEY (surveyid);


--
-- TOC entry 3925 (class 2606 OID 19750)
-- Name: taken_survey taken_survey_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.taken_survey
    ADD CONSTRAINT taken_survey_pkey PRIMARY KEY (surveyid, id);


--
-- TOC entry 3894 (class 2606 OID 17270)
-- Name: type type_pkey; Type: CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.type
    ADD CONSTRAINT type_pkey PRIMARY KEY (type);


--
-- TOC entry 3895 (class 1259 OID 19981)
-- Name: index_date; Type: INDEX; Schema: public; Owner: echoUser
--

CREATE INDEX index_date ON public.sessions USING btree (date);


--
-- TOC entry 3910 (class 1259 OID 19983)
-- Name: index_name; Type: INDEX; Schema: public; Owner: echoUser
--

CREATE INDEX index_name ON public.contact USING btree (last_name, first_name);


--
-- TOC entry 3913 (class 1259 OID 19984)
-- Name: index_org_county; Type: INDEX; Schema: public; Owner: echoUser
--

CREATE INDEX index_org_county ON public.organizations USING btree (county);


--
-- TOC entry 3940 (class 2606 OID 18794)
-- Name: attendee attendee_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.attendee
    ADD CONSTRAINT attendee_id_fkey FOREIGN KEY (id) REFERENCES public.contact(id);


--
-- TOC entry 3948 (class 2606 OID 19974)
-- Name: attends attends_echo_name_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.attends
    ADD CONSTRAINT attends_echo_name_fkey FOREIGN KEY (echo_name, date) REFERENCES public.sessions(echo_name, date);


--
-- TOC entry 3947 (class 2606 OID 19969)
-- Name: attends attends_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.attends
    ADD CONSTRAINT attends_id_fkey FOREIGN KEY (id) REFERENCES public.attendee(id);


--
-- TOC entry 3939 (class 2606 OID 17853)
-- Name: cases cases_date_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.cases
    ADD CONSTRAINT cases_date_fkey FOREIGN KEY (date, echo_name) REFERENCES public.sessions(date, echo_name);


--
-- TOC entry 3932 (class 2606 OID 16543)
-- Name: countydata countydata_brfss_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.countydata
    ADD CONSTRAINT countydata_brfss_id_fkey FOREIGN KEY (brfss_id) REFERENCES public.brfss(brfss_id);


--
-- TOC entry 3943 (class 2606 OID 19587)
-- Name: groups groups_name_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.groups
    ADD CONSTRAINT groups_name_fkey FOREIGN KEY (name, streetaddress) REFERENCES public.orgsmo(name, streetaddress);


--
-- TOC entry 3938 (class 2606 OID 17739)
-- Name: has_credential has_credential1_credential_name_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.has_credential
    ADD CONSTRAINT has_credential1_credential_name_fkey FOREIGN KEY (credential_name) REFERENCES public.credentials(credential_name);


--
-- TOC entry 3937 (class 2606 OID 17716)
-- Name: has_type has_type_type_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.has_type
    ADD CONSTRAINT has_type_type_fkey FOREIGN KEY (type) REFERENCES public.type(type);


--
-- TOC entry 3942 (class 2606 OID 19574)
-- Name: orgsmo orgsmo_county_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.orgsmo
    ADD CONSTRAINT orgsmo_county_fkey FOREIGN KEY (county) REFERENCES public.countydata(county);


--
-- TOC entry 3941 (class 2606 OID 19569)
-- Name: orgsmo orgsmo_name_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.orgsmo
    ADD CONSTRAINT orgsmo_name_fkey FOREIGN KEY (name, streetaddress) REFERENCES public.organizations(name, streetaddress);


--
-- TOC entry 3935 (class 2606 OID 17094)
-- Name: other_employee other_employee_email_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.other_employee
    ADD CONSTRAINT other_employee_email_fkey FOREIGN KEY (email) REFERENCES public.employees(email);


--
-- TOC entry 3934 (class 2606 OID 17084)
-- Name: outreach_coordinator outreach_coordinator_email_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.outreach_coordinator
    ADD CONSTRAINT outreach_coordinator_email_fkey FOREIGN KEY (email) REFERENCES public.employees(email);


--
-- TOC entry 3936 (class 2606 OID 17472)
-- Name: sessions session_1_echo_name_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT session_1_echo_name_fkey FOREIGN KEY (echo_name) REFERENCES public.echos(echo_name);


--
-- TOC entry 3933 (class 2606 OID 17074)
-- Name: session_coordinator session_coordinator_email_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.session_coordinator
    ADD CONSTRAINT session_coordinator_email_fkey FOREIGN KEY (email) REFERENCES public.employees(email);


--
-- TOC entry 3944 (class 2606 OID 19691)
-- Name: survey survey_echo_name_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.survey
    ADD CONSTRAINT survey_echo_name_fkey FOREIGN KEY (echo_name) REFERENCES public.echos(echo_name);


--
-- TOC entry 3945 (class 2606 OID 19751)
-- Name: taken_survey taken_survey_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.taken_survey
    ADD CONSTRAINT taken_survey_id_fkey FOREIGN KEY (id) REFERENCES public.attendee(id);


--
-- TOC entry 3946 (class 2606 OID 19756)
-- Name: taken_survey taken_survey_surveyid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: echoUser
--

ALTER TABLE ONLY public.taken_survey
    ADD CONSTRAINT taken_survey_surveyid_fkey FOREIGN KEY (surveyid) REFERENCES public.survey(surveyid);


--
-- TOC entry 4076 (class 0 OID 0)
-- Dependencies: 3
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: echoUser
--

REVOKE ALL ON SCHEMA public FROM rdsadmin;
REVOKE ALL ON SCHEMA public FROM PUBLIC;
GRANT ALL ON SCHEMA public TO "echoUser";
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2020-05-14 15:47:21

--
-- PostgreSQL database dump complete
--

