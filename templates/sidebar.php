<?php
//if not logged in and authenticated
?>
                <!-- Dynamic unauth sidebar start -->
                <aside id="custom_html-3" class="widget_text widget callout secondary widget_custom_html">
                    <div class="entry-content">
                        <style>
                            ul.sidebar-sl li { margin-bottom: 0.5rem }
                            a.sidebar-slink { font-size: 1.05rem; padding: 0.5rem 1rem; color: #fff; background: #2e3192; display: block; border-radius: 3px }
                            a.sidebar-slink:hover { background: #4145c7; color: #fff !important }
                        </style>
                        <ul style="list-style: none; margin: 0" class="sidebar-sl">
                            <li class="sidebar-sl"><a href="login.php" class="sidebar-slink">Login</a></li>
                            <li class="sidebar-sl"><a href="signup.php" class="sidebar-slink">Signup</a></li>
                        </ul>
                    </div>
                </aside>
                <!-- Dynamic unauth sidebar end -->
<?php
//if logged in and authenticated

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
                            <li><a href="logout.php" class="sidebar-slink">Signout</a></li>
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
                            <ul style="list-style: none; margin: 0" class="sidebar-sl">
                                    <li class="sidebar-sl"><a href="updateuserdetail.php" class="sidebar-slink">Approve/Deny User Signup</a></li>
                                    <li class="sidebar-sl"><a href="https://www.dap.edu.ph/invitation-to-bid" class="sidebar-slink">Add/Update Region List</a></li>
                                    <li class="sidebar-sl"><a href="https://www.dap.edu.ph/invitation-to-bid" class="sidebar-slink">Add/Update Province List</a></li>
                                    <li class="sidebar-sl"><a href="https://www.dap.edu.ph/invitation-to-bid" class="sidebar-slink">Add/Update District/Division List</a></li>
                                    <li class="sidebar-sl"><a href="https://www.dap.edu.ph/invitation-to-bid" class="sidebar-slink">Add/Update City/Municipality List</a></li>
                                    <li class="sidebar-sl"><a href="https://www.dap.edu.ph/invitation-to-bid" class="sidebar-slink">Add/Update Barangay List</a></li>
                                    <li class="sidebar-sl"><a href="https://www.dap.edu.ph/invitation-to-bid" class="sidebar-slink">Add/Update Government Agency Category</a></li>
                                    <li><a href="https://www.dap.edu.ph/career-opportunities" class="sidebar-slink">Add/Update Government Agency</a></li>
                                    <li><a href="https://www.dap.edu.ph/performance-based-incentive-system" class="sidebar-slink"><div style="float: left; display:inline-block; width: 10%"></div><div style="float: left; display:inline-block; width: 80%">Add/Update Certifying Body</div>
                                <div style="clear:both"></div>
                            </a></li>
                                    <li><a href="https://www.dap.edu.ph/service-charter" class="sidebar-slink">Add/Update Certification</a></li>
                                    <li><a href="agencycertification.html" class="sidebar-slink">Add/Update Agency Certification</a></li>
                            </ul>
                    </div>
                </aside>
<?php
//end of conditionals for the sidebar
?>