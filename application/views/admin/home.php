<div class="container">
    
    <h2>Productors</h2>
    <table class="table table-hover taula-productors">
        <thead>
            <tr>
                <th>Imatge</th>
                <th>Nom</th>
                <th>Denominació d'origen</th>
                <th>Modificar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productors as $p): //var_dump($p);?>
            <tr>
                <td><img src="<?php echo base_url("/public/imatges/productors/".$p["imatge"]) ?>"></td>
                <td><?php echo $p["nom"] ?></td>
                <td><?php echo $p["do"] ?></td>
                <td><a class="btn btn-info" href="<?php echo site_url("admin/productor/".$p["id"]."/".  url_title($p["nom"]));  ?>">Modificar</a></td>
                <td><a class="btn btn-danger" href="<?php echo site_url("admin/eliminar_productor/".$p["id"]."/".  url_title($p["nom"]));  ?>">Eliminar</a></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <h2>Afegir productor</h2>
    <?php if (isset($error)): ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <form class="form-horizontal" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label class="control-label col-sm-2" for="nom">Nom:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="nom" id="nom">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="email">Email:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="email" id="email">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="do">Denominació d'orígen:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="do" id="do">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="direccio">Direccio:</label>
            <div class="col-sm-10">
                <input type="text"  class="form-control" name="direccio" id="direccio">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="imatge">Imatge:</label>
            <div class="col-sm-10">
                <input type="file" accept="image/x-png,image/gif,image/jpeg" name="imatge" id="imatge">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <input type="submit" name="enviar" value="Enviar" class="btn btn-info">
            </div>
        </div>
    </form>
</div>