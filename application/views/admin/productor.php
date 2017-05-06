<div class="container productor">
    <h2>Productor</h2>
    <div class="detalls">
        <p><b>Nom:</b> <?php echo $productor["nom"]; ?><br>
            <b>Denominació d'orígen:</b> <?php echo $productor["do"] ?><br>
            <b>Direcció:</b> <?php echo $productor["direccio"] ?><br>
            <b>Imatge:</b> <img src='<?php echo base_url("public/imatges/productors/" . $productor["imatge"]) ?>'></p>
    </div>



    <h2>Productes</h2>
    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse1">Afegir producte</a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="nom">Nom:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nom" id="nom" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="descripcio">Descripcio:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="descripcio" id="descripcio" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="preu">Preu de distribució:</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.01" class="form-control" name="preu" id="preu" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="preu_final">Preu final:</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.01"  class="form-control" name="preu_final" id="preu_final" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="imatge">Imatge:</label>
                            <div class="col-sm-10">
                                <input type="file" accept="image/x-png,image/gif,image/jpeg" name="imatge" id="imatge" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <input type="submit" name="enviar" value="Enviar" class="btn btn-info">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-hover taula-productes">
        <thead>
            <tr>
                <th>Imatge</th>
                <th>Nom</th>
                <th>Preu distribuidor</th>
                <th>Preu final</th>
                <th>Modificar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productes as $p): ?>
                <tr>
                    <td><img src='<?php echo base_url("public/imatges/productes/" . $p["imatge"]) ?>'></td>
                    <td><?php echo $p["nom"] ?></td>
                    <td><?php echo $p["preu"] ?> €</td>
                    <td><?php echo $p["preu_final"] ?> €</td>
                    <td><a class="btn btn-info" href="<?php echo site_url('admin/modificar_producte/'.$p["id"]."/".  url_title($p['nom'])) ?>">Modificar</a></td>
                    <td><a class="btn btn-danger" href="<?php echo site_url('admin/eliminar_producte/'.$p["id"]) ?>">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>




</div>