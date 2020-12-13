<?php
if(!isset($isLoggedIn))
{
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
                            <li class="sidebar-sl"><a href="signup.php" class="sidebar-slink">Create Account</a></li>
                        </ul>
                    </div>
                </aside>
                <!-- Dynamic unauth sidebar end -->
<?php
}