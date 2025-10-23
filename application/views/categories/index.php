<h1 class="text-center">Categorias</h1>

<div class="mb-3">
    <a href="<?php echo site_url('categories/create'); ?>" class="btn btn-primary">Crear Categoria</a>
</div>
<div class="row">   
    <div class="col-md-12">
        <table class="table table-striped">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo $category->id; ?></td>
                    <td><?php echo $category->name; ?></td>
                    <td>
                    
                        <a href="<?php echo site_url('categories/edit/'.$category->id); ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="#" class="btn btn-danger btn-sm" onclick="deleteCategory('<?= $category->id?>')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>

    function deleteCategory(categoryId) {
        if (confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
            window.location.href = '<?= base_url() . 'categories/delete/'?>' + categoryId;
        }
    }

</script>