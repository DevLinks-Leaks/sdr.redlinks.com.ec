	<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
			<!-- Sidebar user panel -->
			<div class="user-panel">
				<div class="pull-left image">
				  <img src="{ruta_imagenes}/user2-160x160.png" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
				  <p>{usua_nomb}</p>
				  <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
				</div>
		    </div>
			<ul class="sidebar-menu">
				<li class="header">MEN&Uacute; ADMINISTRATIVO</li>
				<li>
				  <a href="../general/">
					<i class="fa fa-home"></i> <span>Inicio</span>
				  </a>
				</li>
				<li class="{menuadminPeriodos}"><a href="../adminPeriodos/"><i class="fa fa-calendar"></i> <span>Administrar períodos</span></a></li>
				<li class="{menuEmpleados}"><a href="../interesado/"><i class="fa fa-briefcase"></i> <span>Empleados</span></a></li>
				<li class="{menuPremios}"><a href="../premio/"><i class="fa fa-gift"></i> <span>Premios</span></a></li>
				<!--<li><a href="../informe/"><i class="fa fa-pie-chart"></i><span>Reporte de puntaje</span></a></li>-->
				<li class="{openSoliConfigUsua} treeview">
					<a href="#">
						<i class="fa fa-user"></i>
						<span>Configuración de Usuario</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li class="{menuSoliConfigUsua01}"><a href="../usuario/"><i class="fa fa-group"></i>Usuarios</a></li>
						<li class="{menuSoliConfigUsua02}"><a href="../rol/"><i class="fa fa-check-square"></i>Roles de usuarios</a></li>
						<li class="{menuSoliConfigUsua03}"><a href="../cambiarPass/"><i class="fa fa-key"></i>Cambiar contraseña</a></li>
					</ul>
				</li>
				<li class="{openSoliConfigSist} treeview">
					<a href="#">
						<i class="fa fa-gears"></i>
						<span>Configuración de sistema</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li class="{menuSoliConfigSist01}"><a href="../periodo/"><i class="fa fa-calendar-plus-o"></i>Período anual</a></li>
					</ul>
				</li>
			</ul>
        </section>
        <!-- /.sidebar -->
    </aside>