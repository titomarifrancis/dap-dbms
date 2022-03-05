<?php
//find agency processor
include 'templates/magic.php';
include 'templates/headerin.php';
include 'dbconn.php';
?>
<h3>Agency Search Result</h3>
<?php
if(isset($_REQUEST['partfullagencyname']))
{
  $inputString= ucwords($_REQUEST['partfullagencyname']);
  //echo "Input string is $inputString<br/>";

  $tableHeaderOn = 0;

  $query = "select agencycertifications.id as agencycertificationid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, regions.regionname, provinces.provincename, citymunicipality.towncitymunicipalityname from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, regions, provinces, citymunicipality where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=false and agencycertifications.regionid=regions.id and agencycertifications.provinceid=provinces.id and agencycertifications.citymunicipalityid=citymunicipality.id and govtagency.agencyname like '%$inputString%' order by agencyname";
  //echo "$query<br/>";
  $queryCount= $dbh->query($query)->rowCount();
  if($queryCount > 0)
  {
    //
    echo "There are $queryCount records of agency with certification having the input in its name";
    if($tableHeaderOn == 0)
    {
        $tableHeaderOn = 1;
        include 'templates/tableheader.php';
    }
    
    $queryStmt= $dbh->query($query);
    foreach($queryStmt as $row)
    {
        //
        $isPartial="Not Full Scope";
        if($row['ispartial'] == 1)
        {
            $isPartial="Full Scope";
        }
?>
                        <tr> 
                        <td><a href="agencycert_detail.php?id=<?php echo $row['agencycertificationid'];?>"><?php echo $row['agencyname'];?></a></td>
						<td><p>Taguig</p></td>
						<td><p>Main Office</p></td>						
                        <td><?php echo $row['certifyingbody'];?></td>
                        <td><?php echo $row['certificationdesc'];?></td>
                        <td><?php echo $row['certstartdate'];?></td>
                        <td><?php echo $row['certenddate'];?></td>
                        <td><?php echo $isPartial;?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>          
<?php
    }
    if($tableHeaderOn == 1)
    {
        include 'templates/tablefooter.php';
    }       
  }
  else
  {
    //Display notice that no records were found with that search string
    echo "There may be no agency and/or there may be no certification yet recorded for such agency name with the input you entered";
  }
}
include 'templates/footer.php';