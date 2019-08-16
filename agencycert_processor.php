<?php
include 'templates/magic.php';
include 'lib/secProc.php';
include 'dbconn.php';

//phpinfo();

//get govt agency
$govtagencyid = $_REQUEST['govtagencyid'];
$regionid = $_REQUEST['regionid'];
$provinceid = $_REQUEST['provinceid'];
$citymunicipalityid = $_REQUEST['citymunicipalityid'];
$barangayid = $_REQUEST['barangayid'];
$certificationid = $_REQUEST['certificationid'];
$certifyingbodyid = $_REQUEST['certifyingbodyid'];
$certvalidstartdate = $_REQUEST['certvalidstartdate'];
$certvalidenddate = $_REQUEST['certvalidenddate'];
$certificationregnumber = $_REQUEST['certificationregnumber'];
$certificationscope = $_REQUEST['certificationscope'];
$headofagency = $_REQUEST['headofagency'];
$scope_ispartial = $_REQUEST['scope_ispartial'];


//for troubleshooting purposes only
echo "the submitted values are $govtagencyid, $regionid, $provinceid, $citymunicipalityid, $barangayid, $certificationid, $certifyingbodyid, $certificationregnumber, $certificationscope, $headofagency, $scope_ispartial, $certvalidstartdate and $certvalidenddate";
die();

/*
govtagencyid integer references govtagency(id) on delete restrict,
certifyingbodyid integer references certifyingbody(id) on delete restrict,
certificationid integer references certifications(id) on delete restrict,
certificationregnumber varchar(16) not null,
certificationscope text not null,
scope_ispartial boolean default null,
certpdfurl text not null,
headofagency varchar(128) default null,
provinceid integer default null references provinces(id) on delete restrict,
citymunicipalityid integer default null references citymunicipality(id) on delete restrict,
barangayid integer default null references barangays(id) on delete restrict,
certvalidstartdate date not null,
certvalidenddate

govtagencyid integer references govtagency(id) on delete restrict,
certifyingbodyid integer references certifyingbody(id) on delete restrict,
certificationid integer references certifications(id) on delete restrict,
certificationregnumber varchar(16) not null,
certificationscope text not null,
scope_ispartial boolean default null,
certpdfurl text not null,
headofagency varchar(128) default null,
provinceid integer default null references provinces(id) on delete restrict,
citymunicipalityid integer default null references citymunicipality(id) on delete restrict,
barangayid integer default null references barangays(id) on delete restrict,
certvalidstartdate date not null,
certvalidenddate