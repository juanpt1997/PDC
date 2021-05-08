  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
  	<!-- Brand Logo -->
  	<a href="operations-index" class="brand-link">
  		<img src="views/dist/img/admin_logo.png" alt="PDC Operations Logo" width="128" height="128" border="0" class="brand-image img-circle elevation-3" style="opacity: .8">
  		<span class="brand-text font-weight-light">PDC Operations</span> </a>

  	<!-- Sidebar -->
  	<div class="sidebar">
  		<!-- Sidebar user panel (optional) -->
  		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
  			<div class="image">
  				<img src="views/img/plantilla/personal-id-card.png" class="img-circle elevation-2" alt="User Image">
  			</div>
  			<div class="info">
  				<a href="#" class="d-block"><?= $_SESSION['name'] ?></a>
  			</div>
  		</div>

  		<!-- Sidebar Menu -->
  		<nav class="mt-2">
  			<ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
  				
				<!-- ===================================================
					OPERATIONS
				=================================================== -->
				<?php if (array_search('OPERATIONS', $_SESSION['options'])) : ?>
					<li class="nav-item has-treeview">
						<a href="#" class="nav-link">
							<i class="nav-icon fas fas fa-users-cog"></i>
							<p>
								Operations Options
								<i class="fas fa-angle-left right"></i>

							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="operations-index" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>Dashboard</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="operations-companies" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>Companies</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="operations-products" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>Products</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="orders" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>Orders</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="bol" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>Bill of Lading</p>
								</a>
							</li>
						</ul>
					</li>
				<?php endif ?>

				<!-- ===================================================
					COMPANIES
				=================================================== -->
				<?php if (array_search('COMPANIES', $_SESSION['options'])) : ?>
					<li class="nav-item has-treeview">
						<a href="#" class="nav-link">
							<i class="nav-icon fas fa-user"></i>
							<p>
								Companies Options
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="c-neworder" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>New Order</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="c-orders" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>Order Status</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="c-shippedorders" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>Shipped</p>
								</a>
							</li>

						</ul>
					</li>
				<?php endif ?>

				<!-- ===================================================
					USERS
				=================================================== -->
				<?php if (array_search('USERS', $_SESSION['options'])) : ?>
					<li class="nav-item">
						<a href="users" class="nav-link">
							<i class="nav-icon fas fa-users"></i>
							<p>
								Users
							</p>
						</a>
					</li>
				<?php endif ?>


				<?php if (array_search('OPERATIONS', $_SESSION['options'])) : ?>
					<li class="nav-header">EXTERNAL LINKS</li>
					<li class="nav-item">
						<a href="tv" class="nav-link" target="_blank">
							<i class="nav-icon fas fa-tachometer-alt"></i>
							<p>
								Monitor
							</p>
						</a>
					</li>
				<?php endif ?>


  			</ul>
  		</nav>
  		<!-- /.sidebar-menu -->
  	</div>
  	<!-- /.sidebar -->
  </aside>