<h1 class="text-center">Usuarios</h1>
<div class="mb-3">
    <a href="<?php echo site_url('users/create'); ?>" class="btn btn-primary">Crear Usuario</a>

</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Rol</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td>
                       
                        <a href="<?php echo site_url('users/edit/'.$user['id']); ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="#" class="btn btn-danger btn-sm" onclick="deleteUser('<?= $user['id']?>')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
</div>

<script>

    function deleteUser(userId) {
        if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
            window.location.href = '<?= base_url() . 'users/delete/'?>' + userId;
        }
    }
</script>