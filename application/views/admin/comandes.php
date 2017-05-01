<div class="container">
    <h2>Comandes pendents</h2>
    <form method="post" action="<?php echo site_url("admin/ruta") ?>">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Client</th>
                <th>Preu</th>
                <th>Data</th>
                <th>Entregar</th>
                <th>Mostrar ruta</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comandesPendents as $c): ?>
            <tr>
                <td><?php echo $c['client'] ?></td>
                <td><?php echo $c['preu_total'] ?> €</td>
                <td><?php echo $c['data'] ?></td>
                <td><a class="btn btn-info" href="<?php echo site_url("admin/finalitzar/".$c['id']) ?>">Finalitzar</a></td>
                <td><input type="checkbox" name="ruta[<?php echo $c['client_id'] ?>]" ></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
        <input type="submit" class="btn btn-info" value="Veure ruta">
    </form>
    <h2>Comandes finalitzades</h2>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Client</th>
                <th>Preu</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comandesFinalitzades as $c): ?>
            <tr>
                <td><?php echo $c['client'] ?></td>
                <td><?php echo $c['preu_total'] ?> €</td>
                <td><?php echo $c['data'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>