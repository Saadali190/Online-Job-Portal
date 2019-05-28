create database db_project;
use db_project;

create table admin(
	ad_username varchar(20) not null primary key,
    password 	varchar(100) not null,
    email		varchar(20)	not null);


create table jobseeker(
	js_username    varchar(20)		not null primary key,
    password    varchar(100) 		not null,
    js_ssn		varchar(20)			not null unique,
	fname 		varchar(20)     	not null,
    lname 		varchar(20)     	not null,
    age   		int 		  		null,
    Address		varchar(100)		null,
    Country     varchar(50)			null,
    skills		varchar(1000)		null,
    qlf			varchar(50)			null,
    exp			varchar(100)		null,
    proj		varchar(1000)		null,
    email		varchar(100)		null,
    phno		varchar(20)			null,
    ad			varchar(20),
    foreign key (ad) references admin(ad_username)
    on delete cascade on update cascade);
    
    
create table jobprovider(
	jp_username varchar(20)		 	not null primary key,
    password varchar(100) 		not null,
    company		varchar(50)			not null,
    address		varchar(1000)	    null,
    companyd    varchar(1000),
    email		varchar(50),
    pno			varchar(20),
    country		varchar(20),
    ad			varchar(20),
    foreign key (ad) references admin(ad_username)
    on delete cascade on update cascade);
    
create table job(
	job_title	varchar(100)		not null primary key,
    req_qlf	    varchar(500),
    req_exp		varchar(500),
    company		varchar(50),
    ad			varchar(20),
    jp			varchar(20),
    foreign key (ad) references admin(ad_username)
    on delete cascade on update cascade ,
    foreign key (jp) references jobprovider(jp_username)
    on delete cascade on update cascade);
    	
    
create table applied_for(
	js 			varchar(20)		primary key,
    jp			varchar(20),
    jt			varchar(100),
    application varchar(1000),
    foreign key (js) references jobseeker(js_username),
    foreign key (jp) references jobprovider(jp_username),
    foreign key (jt) references job(job_title));
	
create table response(
	js 			varchar(20),
    jp			varchar(20) 	primary key,
    jt			varchar(100),
    response    varchar(1000),
    foreign key (js) references jobseeker(js_username)
    on delete cascade on update cascade,
    foreign key (jp) references jobprovider(jp_username)
    on delete cascade on update cascade,
    foreign key (jt) references job(job_title)
    on delete cascade on update cascade);
    