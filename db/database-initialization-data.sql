--Government Agency
--DAP GQMPO
--Super Administrator
insert into userlevels(userlevel, leveldesc, creationdate) values(1, 'Government Agency', NOW());
insert into userlevels(userlevel, leveldesc, creationdate) values(2, 'DAP GQMPO', NOW());
insert into userlevels(userlevel, leveldesc, creationdate) values(3, 'Super Administrator', NOW());

--initialization user
--lastname - Escano
--firstname - Tito Mari Francis
--usrname - titomarifrancis
--usrpassword - password
--usrpasswordsalt - autogenerated
--userlevelid - 3
--isapproved - true
--approveddate - NOW()
--creationdate - NOW()
insert into systemusers(lastname, firstname, usrname, usrpassword, usrpasswdsalt, userlevelid, isapproved, approveddate, creationdate) values('Escano', 'Tito Mari Francis', 'titomarifrancis@edgekit.com', 'Gc/FN5izPSUzA', 'GcjeEJ6.BddW.V.8rSfGS', '3', true, 'NOW()', 'NOW()');
--insert into systemusers(lastname, firstname, midname, position, contactlandline, contactmobile, contactemail, usrname, usrpassword, usrpasswdsalt, userlevelid, isapproved, approveddate, creationdate) values('Olimpiada', 'Philip Jourdan', 'E', 'Project Assistant', '026312137', '09471774923', 'olimpiadap@dap.edu.ph', 'olimpiadap@dap.edu.ph', 'kAl1LstTGqhQ2', 'kAUesNWr2p4SVTG3pDafO', '2', true, 'NOW()', 'NOW()');

--National Capital Region
--Region 1 - Ilocos Region
--Region 2 - Cagayan Valley
--Region 3 - Central Luzon
--Region 4A - CALABARZON
--Region 4B - MIMAROPA
--Region 5 - Bicol Region
--Region 6 - Western Visayas
--Region 7 - Central Visayas
--Region 8 - Eastern Visayas
--Region 9 - Zamboanga Peninsula
--Region 10 - Northern Mindanao
--Region 11 - Davao Region
--Region 12 - SOCCSKSARGEN
--Region CARAGA
--Cordillera Administrative Region
--Autonomous Region of Muslim Mindanao
insert into regions(regionname, creationdate) values('National Capital Region (NCR)', NOW());
insert into regions(regionname, creationdate) values('Region 1 - Ilocos Region', NOW());
insert into regions(regionname, creationdate) values('Region 2 - Cagayan Valley', NOW());
insert into regions(regionname, creationdate) values('Region 3 - Central Luzon', NOW());
insert into regions(regionname, creationdate) values('Region 4A - CALABARZON', NOW());
insert into regions(regionname, creationdate) values('Region 4B - MIMAROPA', NOW());
insert into regions(regionname, creationdate) values('Region 5 - Bicol Region', NOW());
insert into regions(regionname, creationdate) values('Region 6 - Western Visayas', NOW());
insert into regions(regionname, creationdate) values('Region 7 - Central Visayas', NOW());
insert into regions(regionname, creationdate) values('Region 8 - Eastern Visayas', NOW());
insert into regions(regionname, creationdate) values('Region 9 - Zamboanga Peninsula', NOW());
insert into regions(regionname, creationdate) values('Region 10 - Northern Mindanao', NOW());
insert into regions(regionname, creationdate) values('Region 11 - Davao Region', NOW());
insert into regions(regionname, creationdate) values('Region 12 - SOCCSKSARGEN', NOW());
insert into regions(regionname, creationdate) values('Region 13 - CARAGA Administrative Region', NOW());
insert into regions(regionname, creationdate) values('Cordillera Administrative Region', NOW());
insert into regions(regionname, creationdate) values('Autonomous Region in Muslim Mindanao', NOW());

--Main Office
--Regional Office
--Division/District Office
--Field Office
insert into governancelevel(govlevel, creationdate) values ('Main Office', NOW());
insert into governancelevel(govlevel, creationdate) values ('Regional Office', NOW());
insert into governancelevel(govlevel, creationdate) values ('Division/District Office', NOW());
insert into governancelevel(govlevel, creationdate) values ('Field Office', NOW());

--Constitutional Offices
--Government-Owned and/or Controlled Corporations
--Local Government Units
--Local Water Districts
--National Government Agencies (NGA)
--NGA-Attached Offices and Bureaus
--Other Executive Offices
--State Universities and Colleges
insert into govtagencyclass(agencyclassdesc, creationdate) values('Constitutional Offices', NOW());
insert into govtagencyclass(agencyclassdesc, creationdate) values('Government-Owned and Controlled Corporations', NOW());
insert into govtagencyclass(agencyclassdesc, creationdate) values('Local Government Units', NOW());
insert into govtagencyclass(agencyclassdesc, creationdate) values('Local Water Districts', NOW());
insert into govtagencyclass(agencyclassdesc, creationdate) values('National Government Agencies (NGA)', NOW());
insert into govtagencyclass(agencyclassdesc, creationdate) values('NGA-Attached Offices and Bureaus', NOW());
insert into govtagencyclass(agencyclassdesc, creationdate) values('Other Executive Offices', NOW());
insert into govtagencyclass(agencyclassdesc, creationdate) values('State Universities and Colleges', NOW());

insert into certifications(certificationstandard, creationdate) values('ISO 9001:1987', NOW());
insert into certifications(certificationstandard, creationdate) values('ISO 9001:1994', NOW());
insert into certifications(certificationstandard, creationdate) values('ISO 9001:2000', NOW());
insert into certifications(certificationstandard, creationdate) values('ISO 9001:2008', NOW());
insert into certifications(certificationstandard, creationdate) values('ISO 9001:2015', NOW());