<div class="container">
    <h2>Registre Facebook</h2>
    <p>Hola <?php echo $nom ?>, necessitem algunes dades adicionals:</p>
    <form class="form-horizontal" method="post">
        <div class="form-group">
            <label class="control-label col-sm-2" for="cif">Cif:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="cif" id="cif">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="municipi">Municipi:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="municipi" id="municipi">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Enviar</button>
            </div>
        </div>
    </form>
</div>