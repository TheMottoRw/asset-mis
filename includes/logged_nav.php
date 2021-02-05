<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap">
                <h4 class="text-center">ASSET MANAGEMENT INFORMATION SYSTEM</h4>
                <form class="form-header" action="" method="POST" STYLE="display: none">
                    <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for datas &amp; reports..." />
                    <button class="au-btn--submit" type="submit">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                </form>
                <div class="header-button">
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="image">
                                <img  src="images/user-icon.jpeg" />
                            </div>
                            <div class="content">
                                <a class="js-acc-btn" href="#"><?= $_SESSION['user_info']['firstname']." ".$_SESSION['user_info']['lastname']; ?></a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <a href="#">
                                            <img src="images/user-icon.jpeg" alt="John Doe" />
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="name">
                                            <a href="#"><?= $_SESSION['user_info']['firstname']." ".$_SESSION['user_info']['lastname']; ?></a>
                                        </h5>
                                        <span class="email"><?= $_SESSION['user_info']['email']; ?></span>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-account"></i>Home</a>
                                    </div>
                                <div class="account-dropdown__footer">
                                    <a href="#">
                                        <i class="zmdi zmdi-power"></i>Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
