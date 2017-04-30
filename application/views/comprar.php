<div class="container pagina-comprar">
    <div class="container">
        <?php foreach ($productes as $p): ?>
        <div class="col-md-3 producte">
            <img src="<?php echo base_url('public/imatges/productes/'.$p['imatge']); ?>">
            <div class="descripcio">
                <h2><?php echo $p['nom'] ?></h2>
                <p><span class="preu">Preu: <?php echo $p['preu'] ?> €</span><br>
                    <?php echo $p['descripcio'] ?></p>
            </div>
            <div class="formulari-producte">
                <form method="post" action="<?php echo site_url('comprar/carro'); ?>">
                    <input type="hidden" name="id" value="<?php echo $p['id'] ?>">
                    <input type="number" value="0" name="quantitat" min="0"><br>
                    <input type="submit" class="btn btn-info" value="Afegir al carro">
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

