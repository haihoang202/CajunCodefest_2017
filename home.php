/**

@Author: Hoang Pham

*/


<?php
include ('header.php');
?>


<div class="wrapper">
    <div class="sidebar" data-color="blue" data-image="assets/img/sidebar-5.jpg">

        <!--

            Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
            Tip 2: you can also add an image using data-image tag

        -->

        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="home.php" class="simple-text">
                    CitiDex
                </a>
            </div>

            <ul class="nav" >
                <li class="active">
                    <a href="home.php">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="home.php?what=rec">
                        <i class="pe-7s-note2"></i>
                        <p>Recreation</p>
                    </a>
                    <ul class="">
                        <li>
                            <a href="home.php?what=parks">Park</a>
                        </li>
                        <li>
                            <a href="home.php?what=publicArt3">Art</a>
                        </li>
                        <li>
                            <a href="home.php?what=preserveSite2">Preservation Site</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="home.php?what=dayBuses">
                        <i class="pe-7s-news-paper"></i>
                        <p>Transit</p>
                    </a>
                    <ul class="">
                        <li>
                            <a href="home.php?what=dayBuses">Day Buses</a>
                        </li>
                        <li>
                            <a href="home.php?what=nightBus">Night Bus</a>
                        </li>
                        <li>
                            <a href="home.php?what=satBus">Weekend Bus</a>
                        </li>
                    </ul>
                </li>
                <?php
                    if( strpos( $what, 'Bus' ) !== false ) {
                ?>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Bus Route
                        </a>
                        <ul class="dropdown-menu" id="busroute">

                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Map Type
                        </a>
                        <ul class="dropdown-menu" id="maptype">

                        </ul>
                    </li>
                <?php } ?>

            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Dashboard</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-dashboard"></i>
                            </a>
                        </li>
                        <li class="dropdown">
<!--                                <i class="fa fa-globe"></i>-->
<!--                                <b class="caret"></b>-->
                            </a>
<!--                            <ul class="dropdown-menu">-->
<!---->
<!--                            </ul>-->
                        </li>
<!--                        <li>-->
<!--                            <form action="home.php" method="post">-->
<!--                                <input class="fa fa-search"/>-->
<!--                                <input type="text" name="search"/>-->
<!--                            </form>-->
<!--                        </li>-->
                    </ul>

                    <ul class="nav navbar-nav navbar-right">

                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div id="map"></div>
            <div id="fullSize"></div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="home.php?what=parks">
                                Recreation
                            </a>
                        </li>
                        <li>
                            <a href="home.php?what=dayBuses">
                                Transit
                            </a>
                        </li>
                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; 2017 <a href="home.php">Citix</a>, by the Squanchers
                </p>
            </div>
        </footer>

    </div>
</div>


/**

@Author: Hoang Pham

*/


<?php
include ('footer.php');
?>
