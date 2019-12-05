<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version">
        <span>
            Bienvenido
        </span>
    </div>
    <nav role="navigation">
        <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
        <div class="small-logo">
            <span class="text-primary">Gestor Farmacia</span>
        </div>
        <form class="navbar-form-custom" method="post" action="#">
            <div class="form-group">
                <input type="text" class="form-control" name="usuario" readonly="true" value="<?php echo $_SESSION['nombre_comercial'] . " | " . $_SESSION['nombre_usuario']?>">
            </div>
        </form>
        
        <div class="mobile-menu">
            <button type="button" class="navbar-toggle mobile-menu-toggle" data-toggle="collapse" data-target="#mobile-collapse">
                <i class="fa fa-chevron-down"></i>
            </button>
            <div class="collapse mobile-navbar" id="mobile-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="" href="login.html">Login</a>
                    </li>
                    <li>
                        <a class="" href="login.html">Logout</a>
                    </li>
                    <li>
                        <a class="" href="profile.html">Profile</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">

                <li class="dropdown">
                    <a href="reg_venta.php">
                        <i class="pe-7s-cart"></i>
                    </a>
                </li>


                <li class="dropdown">
                    <a href="procesos/logout.php">
                        <i class="pe-7s-upload pe-rotate-90"></i>
                    </a>
                </li>

            </ul>
        </div>
    </nav>
</div>