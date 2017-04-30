<div class="container pagina-carro">
    <table id="cart" class="table table-hover table-condensed">
        <thead>
            <tr>
                <th style="width:50%">Producte</th>
                <th style="width:10%">Preu</th>
                <th style="width:8%">Quantitat</th>
                <th style="width:22%" class="text-center">Subtotal</th>
                <th style="width:10%"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carro as $p): ?>
            <tr>
                <td data-th="Product">
                    <div class="row">
                        <div class="col-sm-2 hidden-xs"><img src="<?php echo base_url('public/imatges/productes/'.$p['imatge']) ?>" alt="..." class="img-responsive"/></div>
                        <div class="col-sm-10">
                            <h4 class="nomargin"><?php echo $p['nom'] ?></h4>
                            <p><?php echo $p['descripcio'] ?></p>
                        </div>
                    </div>
                </td>
                <td data-th="Price"><?php echo $p['preu'] ?> €</td>
                <td data-th="Quantity">
                    <input type="number" class="form-control text-center" value="<?php echo $p['quantitat'] ?>">
                </td>
                <td data-th="Subtotal" class="text-center"><?php echo ($p['quantitat']*$p['preu']) ?> €</td>
                <td class="actions" data-th="">
                    <button class="btn btn-info btn-sm"><i class="fa fa-refresh"></i></button>
                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>								
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="visible-xs">
                <td class="text-center"><strong>Total <?php echo $total ?> €</strong></td>
            </tr>
            <tr>
                <td><a href="<?php echo site_url('comprar') ?>" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
                <td colspan="2" class="hidden-xs"></td>
                <td class="hidden-xs text-center"><strong>Total <?php echo $total ?> €</strong></td>
                <td><a href="<?php echo site_url('comprar/checkout') ?>" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a></td>
            </tr>
        </tfoot>
    </table>
</div>