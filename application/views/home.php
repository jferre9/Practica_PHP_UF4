<div class="container">
    <h1>Home</h1>
    
    <?php mapa_punts($posicions) ?>
    
    
    <h2>Vols treballar amb nosaltres?</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
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

