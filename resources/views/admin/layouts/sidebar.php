<?php
// Shared dashboard sidebar.
?>
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="<?= $GLOBALS['basePath'] ?>/admin">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
           <a class="nav-link collapsed" href="<?= $GLOBALS['basePath'] ?>/users/index">
          <i class="bi bi-card-list"></i>
          <span>Users</span>
        </a>
      </li><!-- End Register Page Nav -->

      <li class="nav-item">
           <a class="nav-link collapsed" href="<?= $GLOBALS['basePath'] ?>/categories/index">
          <i class="bi bi-card-list"></i>
          <span>categories</span>
        </a>
      </li><!-- End Register Page Nav -->

    
    </ul>

  </aside><!-- End Sidebar-->
