<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sidenav shadow-right sidenav-light">
            <div class="sidenav-menu">
                <div class="nav accordion" id="accordionSidenav">
                    <div class="sidenav-menu-heading">Menu</div>
                    <?php
                    if (isset($_SESSION['loggedinusername'])) {
                    ?>
                    <a class="nav-link collapsed" href="createPost.php">
                        <div class="nav-link-icon"><i data-feather="plus"></i></div>
                        Create Post
                        <div class="sidenav-collapse-arrow"></div>
                    </a>
                    <!-- all posts -->
                    <a class="nav-link collapsed" href="allPosts.php">
                        <div class="nav-link-icon"><i data-feather="list"></i></div>
                        All Posts
                        <div class="sidenav-collapse-arrow"></div>
                    </a>
                    <!-- profile -->
                    <a class="nav-link collapsed" href="userProfile.php">
                        <div class="nav-link-icon"><i data-feather="user"></i></div>
                        Profile
                        <div class="sidenav-collapse-arrow"></div>
                    </a>
                    <!-- Logout -->
                    <a class="nav-link collapsed" href="logout.php">
                        <div class="nav-link-icon"><i data-feather="log-out"></i></div>
                        Logout
                        <div class="sidenav-collapse-arrow"></div>
                    </a>
                    <?php
                    } 
                    ?>
                </div>
            </div>
            <div class="sidenav-footer">
                <div class="sidenav-footer-content">
                    <div class="sidenav-footer-subtitle">Logged in as:</div>
                    <div class="sidenav-footer-title">
                        <?php if (isset($_SESSION['loggedinuseremail'])) {
                            echo $_SESSION['loggedinusername'];
                          } 
                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>