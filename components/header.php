<!--[if lt IE 9
    ]><script type="text/javascript">
        jQuery && jQuery.transformer({ addClasses: true });
    </script><!
[endif]-->
<div id="access">
    <h2>Skip links and keyboard navigation</h2>
    <ul>
        <li><a href="#content">Skip to content</a></li>
        <li><a href="#nav-site">Skip to navigation</a></li>
        <li><a href="#footer">Skip to footer</a></li>
        <li>
            <a
                href="http://www.qld.gov.au/help/accessibility/keyboard.html#section-aria-keyboard-navigation"
                >Use tab and cursor keys to move around the page (more information)</a
            >
        </li>
    </ul>
</div>

<div id="header">
    <div class="box-sizing">
        <div class="max-width">
            <h2>Site header</h2>

            <a id="qg-coa" href="http://www.qld.gov.au/">
                <!--[if gte IE 7
                ]><!--><img
                    src="theme/qg-coa.png"
                    width="287"
                    height="50"
                    alt="Queensland Government"
                /><!--<![endif]-->
                <!--[if lte IE 6
                    ]><img
                        src="theme/qg-coa-ie6.png"
                        width="287"
                        height="50"
                        alt="Queensland Government"
                /><![endif]-->
                <img src="cue/images/qg-coa-print.png" class="print-version" alt="" />
            </a>

            <ul id="tools">
                <li><a accesskey="3" href="http://www.qld.gov.au/#sitemap">Site map</a></li>
                <li>
                    <a accesskey="4" href="http://www.qld.gov.au/contact/">Contact us</a>
                </li>
                <li><a href="http://www.qld.gov.au/help/">Help</a></li>
                <li class="last-child">
                    <form action="http://pan.search.qld.gov.au/search/search.cgi" id="search-form">
                        <div class="search-wrapper">
                            <label for="search-query">Search Queensland Government</label>
                            <input
                                accesskey="5"
                                type="text"
                                name="query"
                                id="search-query"
                                size="27"
                                value=""
                            />
                            <input type="submit" class="submit" value="Search" />
                            <input type="hidden" name="num_ranks" value="10" />
                            <input type="hidden" name="tiers" value="off" />
                            <input type="hidden" name="collection" value="qld-gov" />
                            <input type="hidden" name="profile" value="qld" />
                        </div>
                    </form>
                </li>
            </ul>

            <h2 id="site-name">
                <a href="." accesskey="2">
                    <!--[if gte IE 7
                    ]><!--><img
                        src="theme/site-name.png"
                        height="28"
                        alt="Site name"
                    /><!--<![endif]-->
                    <!--[if lte IE 6
                        ]><img src="theme/site-name-ie6.png" height="28" alt="Site name"
                    /><![endif]-->
                    <img src="theme/site-name-print.png" height="28" class="print-version" alt="" />
                </a>
            </h2>
        </div>
    </div>
</div>

<div id="nav-site">
    <div class="max-width">
        <h2>Site navigation</h2>
        <ul>
            <li><a href=".">Home</a></li>
            <?php 
                if ($_SESSION["loggedin"]) { ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php } else { ?>
                    <li><a href="404.html">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php }
            ?>
        </ul>
    </div>
</div>
