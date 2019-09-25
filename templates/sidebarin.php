<?php
?>
                <!-- Dynamic auth sidebar start -->
                <aside id="custom_html-3" class="widget_text widget callout secondary widget_custom_html">
                    <div class="entry-content">
                        <style>
                            ul.sidebar-sl li { margin-bottom: 0.5rem }
                            a.sidebar-slink { font-size: 1.05rem; padding: 0.5rem 1rem; color: #fff; background: #2e3192; display: block; border-radius: 3px }
                            a.sidebar-slink:hover { background: #4145c7; color: #fff !important }
                        </style>
                        <ul style="list-style: none; margin: 0" class="sidebar-sl">
                        <li class="sidebar-sl"><a href="agencycert_summary.php" class="sidebar-slink">Certification Summary Report</a></li>
                        </ul>
                    </div>
                </aside>
                <!-- Dynamic auth sidebar end -->
                <aside id="custom_html-3" class="widget_text widget callout secondary widget_custom_html">
                    <div class="entry-content">
                        <div class="textwidget custom-html-widget"><style>
                                ul.sidebar-sl li { margin-bottom: 0.5rem }
                                a.sidebar-slink { font-size: 1.05rem; padding: 0.5rem 1rem; color: #fff; background: #2e3192; display: block; border-radius: 3px }
                                a.sidebar-slink:hover { background: #4145c7; color: #fff !important }
                            </style>
                            <h3>Add/Edit</h3>
                            <ul style="list-style: none; margin: 0" class="sidebar-sl">
                            
                                <li class="sidebar-sl"><a href="agencycertification.php" class="sidebar-slink">Certification Details</a></li>
                                
<?php
if(isset($loggedInAccessLevel) && ($loggedInAccessLevel >= 2))
{
?>                              
                                <li class="sidebar-sl"><a href="certifyingbodymanager.php" class="sidebar-slink">Certifying Body Details</a></li>
                                <li class="sidebar-sl"><a href="govtagencyclassmanager.php" class="sidebar-slink">Government Agency Category</a></li>
                                <li class="sidebar-sl"><a href="govtagencymanager.php" class="sidebar-slink">List of Government Agencies</a></li>
                                
                                <li class="sidebar-sl"><a href="certificationmanager.php" class="sidebar-slink">Certification Details</a></li>
                                <li class="sidebar-sl"><a href="regionlistmanager.php" class="sidebar-slink">List of Regions</a></li>
                                <li class="sidebar-sl"><a href="provincelistmanager.php" class="sidebar-slink">List of Provinces</a></li>                                
<?php
}
?> 

                                <li class="sidebar-sl"><a href="citymunicipalitylistmanager.php" class="sidebar-slink">List of Cities/Municipalities</a></li>
                                <li class="sidebar-sl"><a href="barangaylistmanager.php" class="sidebar-slink">List of Barangays</a></li>
<?php
if(isset($loggedInAccessLevel) && ($loggedInAccessLevel >= 2))
{
?>
                                <li class="sidebar-sl"><a href="updateuserdetail.php" class="sidebar-slink">List of User Accounts</a></li>

<?php
}
?>                                
                            </ul>
                    </div>
                </aside>
                <!-- Dynamic auth sidebar start -->
                <aside id="custom_html-3" class="widget_text widget callout secondary widget_custom_html">
                    <div class="entry-content">
                        <style>
                            ul.sidebar-sl li { margin-bottom: 0.5rem }
                            a.sidebar-slink { font-size: 1.05rem; padding: 0.5rem 1rem; color: #fff; background: #2e3192; display: block; border-radius: 3px }
                            a.sidebar-slink:hover { background: #4145c7; color: #fff !important }
                        </style>
                        <ul style="list-style: none; margin: 0" class="sidebar-sl">
                            <li><a href="logout.php" class="sidebar-slink">Logout</a></li>
                        </ul>
                    </div>
                </aside>                