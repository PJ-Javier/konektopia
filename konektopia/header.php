<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light"
        id="sidenavAccordion">
        <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="index.php">konektopia</a>
        <!-- Navbar Items-->
        <ul class="navbar-nav align-items-center ms-auto">
            <?php
            if(isset($_SESSION['loggedinuseremail'])){
            ?>
            <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                    href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><img class="img-fluid"
                        src="public/assets/img/illustrations/profiles/profile-1.png" /></a>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
                    aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img" src="public/assets/img/illustrations/profiles/profile-1.png" />
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name"><?php if (isset($_SESSION['loggedinuseremail'])) {
                                echo $_SESSION['loggedinusername'];
                                } 
                                ?>
                                </div>
                            <div class="dropdown-user-details-email"><?php if (isset($_SESSION['loggedinuseremail'])) {
                                echo $_SESSION['loggedinuseremail'];
                                } 
                                ?>
                            </div>
                        </div>
                    </h6>
        
                    <!-- show all sidebar menu options in small screens -->
                    <div class="top-menu-small-screen">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="createPost.php">
                        <div class="dropdown-item-icon"><i data-feather="plus"></i></div>
                        Create Post
                        <div class="sidenav-collapse-arrow"></div>
                    </a>
                  
                    <!-- all posts -->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="allPosts.php">
                        <div class="dropdown-item-icon"><i data-feather="list"></i></div>
                        All Posts
                        <div class="sidenav-collapse-arrow"></div>
                    </a>
                    <!-- profile -->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="userProfile.php">
                        <div class="dropdown-item-icon"><i data-feather="user"></i></div>
                        Profile
                        <div class="sidenav-collapse-arrow"></div>
                    </a>
                    </div>
                    <!-- Logout -->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                        Logout
                        <div class="sidenav-collapse-arrow"></div>
                    </a>
                </div>
            </li>
            <?php
            }else{
            ?>
            <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                    href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><img class="img-fluid"
                        src="public/assets/img/illustrations/profiles/profile-1.png" /></a>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
                    aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img" src="public/assets/img/illustrations/profiles/profile-1.png" />
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name">Guest</div>
                            <div class="dropdown-user-details-email">Guest</div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="index.php">
                        <div class="dropdown-item-icon"><i data-feather="user"></i></div>
                        Login
                    </a>
                    <a class="dropdown-item" href="register.php">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                        Register
                    </a>
                </div>
            </li>
            <?php
            }
            ?>
        </ul>
    </nav>
     <!-- top-menu-small-screen show if screen size greater than 993  -->
    <style>

    @media screen and (max-width: 993px) {
        .top-menu-small-screen {
            display: block !important
        }
    }
    </style>

  