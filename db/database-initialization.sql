create table userlevels (
	id serial primary key,
	userlevel integer unique check (userlevel < 4),
	leveldesc varchar(64) not null,
	creationdate timestamptz not null
);

create index idx_userlevel on userlevels(id, userlevel);

create table regions (
	id serial primary key,
	regionname varchar(64) not null,
	creationdate timestamptz not null	
);

create index idx_region on regions(id, regionname);

create table provinces (
	id serial primary key,
	provincename varchar(64) not null,
	regionid integer references regions(id) on delete restrict,
	creationdate timestamptz not null	
);

create index idx_province on provinces(id, provincename);

create table citymunicipality (
	id serial primary key,
	towncitymunicipalityname varchar(64) not null,
	iscity boolean default false not null,
	provinceid integer default null references provinces(id) on delete restrict,
	creationdate timestamptz not null
);

create index idx_citymunicipality on citymunicipality(id, towncitymunicipalityname);

create table barangays (
	id serial primary key,
	barangayname varchar(64) not null,
	citymunicipalityid integer references citymunicipality(id) on delete restrict,
	creationdate timestamptz not null
);

create index idx_barangay on barangays(id, barangayname);

create table governancelevel (
	id serial primary key,
	govlevel varchar(64) not null,
	creationdate timestamptz not null
);

create index idx_governancelevel on governancelevel(id, govlevel);

create table govtagencyclass (
	id serial primary key,
	agencyclassdesc varchar(64) not null,
	creationdate timestamptz not null
);

create index idx_govtagencyclass on govtagencyclass(id, agencyclassdesc);

create table govtagency (
	id serial primary key,
	agencyname varchar(128) not null,
	govtagencyclassid integer references govtagencyclass(id) on delete restrict,
	parentgovagencyid integer default null references govtagency(id) on delete restrict,
	hideorigcertdate boolean default false,
	creationdate timestamptz not null
);

create index idx_govtagency on govtagency(id, agencyname);

create table systemusers (
	id serial primary key,
	lastname varchar(64) not null,
	firstname varchar(64) not null,
	midname varchar(5) default null,
	extname varchar(5) default null,
	position varchar(64) default null,
	contactlandline varchar(128) default null,
	contactmobile varchar(128) default null,
	contactemail varchar(128) default null,
	govtagencyid integer default null references govtagency(id) on delete restrict,
	regionid integer default null references regions(id) on delete restrict,
	provinceid integer default null references provinces(id) on delete restrict,
	citymunicipalityid integer default null references citymunicipality(id) on delete restrict,
	barangayid integer default null references barangays(id) on delete restrict,
	usrname varchar(128) unique not null,
	usrpassword varchar(128) not null,
    usrpasswdsalt varchar(128) not null,
	userlevelid integer default 1 references userlevels(userlevel) on delete restrict check(userlevelid < 4),
	isapproved boolean default false,
	approvedby integer default null references systemusers(id) on delete restrict,
	approveddate timestamptz default null,
	createdby integer default null references systemusers(id) on delete restrict,
	creationdate timestamptz default null
);

create index idx_systemuser on systemusers(id, lastname, firstname, midname, extname, usrname, usrpassword);

alter table userlevels add column createdby integer default null references systemusers(id) on delete restrict;
alter table regions add column createdby integer default null references systemusers(id) on delete restrict;
alter table provinces add column createdby integer default null references systemusers(id) on delete restrict;
alter table citymunicipality add column createdby integer default null references systemusers(id) on delete restrict;
alter table barangays add column createdby integer default null references systemusers(id) on delete restrict;
alter table govtagencyclass add column createdby integer default null references systemusers(id) on delete restrict;
alter table govtagency add column createdby integer default null references systemusers(id) on delete restrict;

create table certifications (
	id serial primary key,
	certificationstandard varchar(32) unique not null,
	createdby integer default null references systemusers(id) on delete restrict,
	creationdate timestamptz not null
);

create index idx_certification on certifications(id, certificationstandard);

create table certifyingbody (
	id serial primary key,
	ispabaccredited boolean default false,
	providerorg varchar(128) unique not null,
	isapproved boolean default false,
	approvedby integer default null references systemusers(id) on delete restrict, 	
	createdby integer default null references systemusers(id) on delete restrict,
	creationdate timestamptz not null
);

create index idx_certifyingbody on certifyingbody(id, providerorg);

create table agencycertifications (
	id serial primary key,
	govtagencyid integer references govtagency(id) on delete restrict,
	certifyingbodyid integer references certifyingbody(id) on delete restrict,
	certificationid integer references certifications(id) on delete restrict,
	certificationregnumber varchar(64) not null,
	governancelevel integer default null references governancelevel(id) on delete restrict,
	certificationscope text not null,
	certificationsite varchar(64) default null,
	scope_ispartial boolean default null,
	certpdfurl text not null,
	headofagency varchar(128) default null,
	regionid integer default null references regions(id) on delete restrict,
	provinceid integer default null references provinces(id) on delete restrict,
	citymunicipalityid integer default null references citymunicipality(id) on delete restrict,
	barangayid integer default null references barangays(id) on delete restrict,
	certvalidstartdate date not null,
	certvalidenddate date not null check (certvalidenddate > certvalidstartdate),
	isapproved boolean default false,
	approvedby integer default null references systemusers(id) on delete restrict,	
	approveddate timestamptz default null,
	isexpired boolean default false,
	createdby integer default null references systemusers(id) on delete restrict,
	creationdate timestamptz not null   
);

create index idx_agencycertification on agencycertifications(id, certificationregnumber, certificationscope, certvalidstartdate, certvalidenddate);
