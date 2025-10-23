<header>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">zalvadora</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?php echo $method == "users" ? 'active' : ''  ?>" aria-current="page" href="<?= base_url() . 'users'?>">Usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $method == "products" ? 'active' : ''  ?>" href="<?= base_url() . 'products'?>">Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $method == "categories" ? 'active' : ''  ?>" href="<?= base_url() . 'categories'?>">Categorias</a>
        </li>
     
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="<?= base_url() . 'auth/logout'?>">Cerrar session</a></li>
      </ul>

      
    </div>
  </div>
</nav>
</header>