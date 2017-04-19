<div class="container">
    
    <h2>Productors</h2>
    <table class="table table-hover">
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
            <?php foreach ($productor as $p): ?>
            <tr>
                <td><img src="<?php echo site_url()."/imatges/productors/".$p->imatge ?>"></td>
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
            <label class="control-label col-sm-2" for="do">Denominació d'orígen:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="do" id="do">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="lat">Latitud:</label>
            <div class="col-sm-10">
                <input type="number" max="85" min="-85" step="any" class="form-control" name="lat" id="lat">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="lon">Longitud:</label>
            <div class="col-sm-10">
                <input type="number" max="180" min="-180" step="any" class="form-control" name="lon" id="lon">
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