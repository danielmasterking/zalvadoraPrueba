<h1 class="text-cente">Crear Categorias</h1>

<?php echo form_open('categories/' . $action); ?>

    <div class="form-group">
        <label for="name">Nombre</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($category->name) ? $category->name : ''   ?>" required>   
    </div>

    <button type="submit" class="btn btn-primary mt-3">Enviar</button>
    <a href="<?= base_url() . 'categories'?>" class="btn btn-danger mt-3">volver</a>
<?php echo form_close(); ?>

