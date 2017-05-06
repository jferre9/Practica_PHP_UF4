<style type="text/Css">
    <!--
   
    img {
        max-height: 300px;
    }
    .producte {
        height: 300px;
        width: 100%;
    }
    .imatge {
        width: 120px;
        max-height: 300px;
    }
    
   .marge {
       width: 100px;
   }
   .descripcio td {
       height: 40px;
   }
   

    -->
</style>
<?php for ($i = 0; $i < count($productes);$i++): 
    $p = $productes[$i];
    if ($i%3 === 0) echo "<page>"; ?>
    <?php if ($i === 0) echo "<table style='width:800px;'><tr><td style='width: 100%; text-align: center; text-decoration: underline; font-weight: bold; font-size: 20pt;'>Carta de vins</td></tr></table><br>" ?>
    <table class="producte">
        <tr>
            <td class="marge"></td>
        <td class="imatge">
            <img src='<?php echo base_url("public/imatges/productes/" . $p["imatge"]); ?>'>
        </td>
        <td class="descripcio">
            <table>
                <tr>
                    <td><b>Nom:</b> <?php echo $p['nom']?></td>
                </tr>
                <tr>
                    <td><b>Productor:</b> <?php echo $p['productor']?></td>
                </tr>
                <tr>
                    <td><b>Denominació d'origen:</b> <?php echo $p['do']?></td>
                </tr>
                <tr>
                    <td><b>Preu:</b> <?php echo $p['preu']?> €</td>
                </tr>
                <tr>
                    <td><b>Preu distribució:</b> <?php echo $p['preu_final']?> €</td>
                </tr>
            </table>
        </td>
        </tr>
    </table>
        <?php if ($i%3 === 2 || $i === (count($productes) -1)) echo "</page>"; ?>
<?php endfor; ?>