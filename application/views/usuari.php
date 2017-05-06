<div class="container pagina-carro">
    <h1>Dades personals</h1>
    <p><b>Nom:</b> <?php echo $usuari['nom'] ?><br>
    <b>Email:</b> <?php echo $usuari['email'] ?><br>
    <b>Cif:</b> <?php echo $usuari['cif'] ?><br>
    <b>Municipi:</b> <?php echo $usuari['municipi'] ?><br>
    <b>Tipus login:</b> <?php echo $usuari['facebook_id']?"Facebook":"Normal" ?><br>
    <b>Clau webservice:</b> <?php echo $usuari['clau'] ?><br></p>
</div>