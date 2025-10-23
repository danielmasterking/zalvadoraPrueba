<h1>Nuevo usuario</h1>


<?php echo form_open('users/' . $action); ?>

    <div class="form-group">
        <label for="name">Nombre</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($user->name) ? $user->name : ''   ?>" required>
    </div>

    <div class="form-group">
        <label for="email">Correo Electrónico</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($user->email) ? $user->email : ''   ?>" required>
    </div>
   
    <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password"  <?= $method == 'edit' ? "disabled" : '' ?>>
    </div>

    <div class="form-group">
        <label for="role">Rol</label>
        <select class="form-control" id="role" name="role" required>
            <option value="admin" <?php echo isset($user->role) ? $user->role =='admin' ? 'selected' :'' : ''   ?> >Administrador</option>
            <option value="user" <?php echo isset($user->role) ? $user->role =='user' ? 'selected' :'' : ''   ?>>Usuario</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Enviar</button>
    <a href="<?= base_url() . 'users'?>" class="btn btn-danger mt-3">volver</a>
<?php echo form_close(); ?>