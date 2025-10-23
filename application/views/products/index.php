<h1 class="text-center">Productos</h1>

<div class="mb-3">
    <a href="<?php echo site_url('products/create'); ?>" class="btn btn-primary">Crear Producto</a>
</div>

<div class="mb-3">
    <form method="get" action="<?= base_url() . 'index.php/products'?>">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Buscar producto por nombre o SKU" name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </div>
    </form>
</div>


<div class="row">
    <div class="col-md-12">
        <table class="table table-striped">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Sku</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $product): ?>
                <tr>
                    <td><?php echo $product->id; ?></td>
                    <td><?php echo $product->name; ?></td>
                    <td><?php echo $product->sku; ?></td>
                    <td><?php echo $product->price; ?></td>
                    <td><?php echo $product->category_name; ?></td>
                    <td>
                       
                        <a href="<?php echo site_url('products/edit/'.$product->id); ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="#" class="btn btn-danger btn-sm" onclick="deleteProduct('<?= $product->id ?>')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div><?= $pagination ?></div>

    </div>

    <script>

        function deleteProduct(ProductId) {
            if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                window.location.href = '<?= base_url() . 'products/delete/'?>' + ProductId;
            }
        }
    </script>