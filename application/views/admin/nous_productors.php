<div class="container">
    
    <h2>Nous Productors</h2>
    <table class="table table-hover taula-productors">
        <thead>
            <tr>
                <th>Imatge</th>
                <th>Nom</th>
                <th>Denominació d'origen</th>
                <th>Aceptar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productors as $p): //var_dump($p);?>
            <tr>
                <td><img src="<?php echo base_url("/public/imatges/productors/".$p["imatge"]) ?>"></td>
                <td><?php echo $p["nom"] ?></td>
                <td><?php echo $p["do"] ?></td>
                <td><a class="btn btn-info" href="<?php echo site_url("admin/acceptar_productor/".$p["id"]."/".  url_title($p["nom"]));  ?>">Acceptar</a></td>
                <td><a class="btn btn-danger" href="<?php echo site_url("admin/eliminar_productor/".$p["id"]."/".  url_title($p["nom"]));  ?>">Eliminar</a></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>