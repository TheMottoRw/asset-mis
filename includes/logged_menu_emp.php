<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <img src="images/logo.png" style="height:60px;width:160px" alt="ASSET MANAGEMENT" />
        </a>
        <br><br><br>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li>
                    <a href="Reservation.php">
                        <i class="far fa-check-square"></i>Reservation</a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="fas fa-power-off"></i>Logout</a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->
<?php validateSession(["Teacher","Student"]); ?>