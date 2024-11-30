<?php include_once 'views/template/header-principal.php';
include_once 'views/template/portada.php'; ?>

<section class="our-rooms-area ptb-100">
    <div class="container">
        <div class="section-title">
            <span>Habitaciones</span>
            <h2>Fascinantes habitaciones & suites</h2>
        </div>
        <div class="row">
            <?php foreach ($data['habitaciones'] as $habitacion) { ?>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-rooms-three-wrap">
                        <div class="single-rooms-three">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/habitaciones/' . $habitacion['foto']; ?>" alt="Image">
                            <div class="single-rooms-three-content">
                                <h3><?= $habitacion['estilo']; ?></h3>
                                <ul class="rating">
                                    <li>
                                        <i class="bx bxs-star <?= ($habitacion['calificacion'] >= 1) ? 'text-warning' : 'text-secondary'; ?>"></i>
                                    </li>
                                    <li>
                                        <i class="bx bxs-star <?= ($habitacion['calificacion'] >= 2) ? 'text-warning' : 'text-secondary'; ?>"></i>
                                    </li>
                                    <li>
                                        <i class="bx bxs-star <?= ($habitacion['calificacion'] >= 3) ? 'text-warning' : 'text-secondary'; ?>"></i>
                                    </li>
                                    <li>
                                        <i class="bx bxs-star <?= ($habitacion['calificacion'] >= 4) ? 'text-warning' : 'text-secondary'; ?>"></i>
                                    </li>
                                    <li>
                                        <i class="bx bxs-star <?= ($habitacion['calificacion'] >= 5) ? 'text-warning' : 'text-secondary'; ?>"></i>
                                    </li>
                                </ul>
                                <span class="price"><?= $habitacion['precio'] . '/Noche'; ?></span>
                                <center>
                                <p class="price"><?= $habitacion['descripcion']; ?></p>
                                </center>
                                </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php include_once 'views/template/footer-principal.php'; ?>

</body>

</html>