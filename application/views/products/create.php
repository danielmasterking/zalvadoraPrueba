<h1 class="text-center">Crear producto</h1>

<?php echo form_open('products/' . $action); ?>

    <div class="form-group">
        <label for="name">Nombre</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($product->name) ? $product->name : ''   ?>" required>
    </div>

    <div class="form-group">
        <label for="sku">SKU</label>
        <input type="text" class="form-control" id="sku" name="sku" value="<?php echo isset($product->sku) ? $product->sku : ''   ?>" <?php echo $method == 'edit' ? 'disabled' :'' ;?>>
    </div>
   
    <div class="form-group">
        <label for="price">Precio</label>
        <input type="text" class="form-control" id="price" name="price" value="<?php echo isset($product->price) ? $product->price : ''   ?>" required>
    </div>

    <div class="form-group">
        <label for="category_id">Categoría</label>
        <select class="form-control" id="category_id" name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category->id; ?>" <?php echo isset($product->category_id) && $product->category_id == $category->id ? 'selected' : '' ; ?>>
                    <?php echo $category->name; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Enviar</button>
    <a href="<?= base_url() . 'products'?>" class="btn btn-danger mt-3">volver</a>
<?php echo form_close(); ?>