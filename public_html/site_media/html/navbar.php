<form name="frm_menu" id="frm_menu" action="../general/" enctype="multipart/form-data" method="post">
	<input type="hidden" name="event" id="event" value="" />
	<header class="main-header">
        <!-- Logo -->
        <a href="../general/" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><i><b>SDR</b>L</i></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><i><b>SDR</b>Links</i></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a class="dropdown-toggle" data-toggle="dropdown" style="margin:0;padding:0 5px;">
								{cmb_periodos}
							</a>
						</li>
						<form action="salir.php">
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								  <img src="{ruta_imagenes}/user2-160x160.png" class="user-image" alt="User Image">
								  <span class="hidden-xs">{usua_nomb} {usua_apel}</span>
								</a>
								<ul class="dropdown-menu">
								  <!-- User image -->
								  <li class="user-header">
									<img src="{ruta_imagenes}/user2-160x160.png" class="img-circle" alt="User Image">
									<p>
									{usua_nomb} {usua_apel} - {usua_correo}
									  <small>{rol_descripcion}</small>
									</p>
								  </li>
								  <!-- Menu Footer-->
								  <li class="user-footer">
									<div class="pull-right">
									  <input type="submit" class="btn btn-default btn-flat" value="Cerrar sesión" />
									</div>
								  </li>
								</ul>
							</li>
						</form>
					</ul>
			</div>
        </nav>
    </header>
</form>