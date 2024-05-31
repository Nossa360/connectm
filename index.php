<!DOCTYPE html>
<html lang="es">
<head>
    <title>Inicio</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <?php include './inc/link.php'; ?>
</head>

<body id="container-page-index">
    <?php include './inc/navbar.php'; ?>
    
    <section id="slider-store" class="carousel slide" data-ride="carousel" style="padding: 0;">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#slider-store" data-slide-to="0" class="active"></li>
            <li data-target="#slider-store" data-slide-to="1"></li>
            <li data-target="#slider-store" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <?php
            $slides = [
                ['src' => './assets/img/slider1.jpg', 'caption' => 'Emerick', 'active' => true],
                ['src' => './assets/img/slider2.jpg', 'caption' => 'CoreGaming', 'active' => false],
                ['src' => './assets/img/slider3.jpg', 'caption' => 'TEC', 'active' => false],
            ];

            foreach ($slides as $index => $slide) {
                $activeClass = $slide['active'] ? 'active' : '';
                echo "<div class='item $activeClass'>
                        <img src='{$slide['src']}' alt='slider$index'>
                        <div class='carousel-caption'>{$slide['caption']}</div>
                      </div>";
            }
            ?>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#slider-store" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="right carousel-control" href="#slider-store" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Siguiente</span>
        </a>
    </section>

    <section id="new-prod-index">    
        <div class="container">
            <div class="page-header">
                <h1>Últimos <small>locales agregados</small></h1>
            </div>
            <div class="row">
                <?php
                include 'library/configServer.php';
                include 'library/consulSQL.php';

                $consulta = ejecutarSQL::consultar("SELECT * FROM producto WHERE Stock > 0 AND Estado='Activo' ORDER BY id DESC LIMIT 7");
                $totalproductos = mysqli_num_rows($consulta);

                if ($totalproductos > 0) {
                    while ($fila = mysqli_fetch_array($consulta, MYSQLI_ASSOC)) {
                        $imagen = !empty($fila['Imagen']) && is_file("./assets/img-products/" . $fila['Imagen']) ? $fila['Imagen'] : "default.png";
                        $precioFinal = $fila['Descuento'] > 0 ? number_format($fila['Precio'] - ($fila['Precio'] * ($fila['Descuento'] / 100)), 2, '.', '') : $fila['Precio'];

                        echo "<div class='col-xs-12 col-sm-6 col-md-4'>
                                <div class='thumbnail'>
                                    <img class='img-product' src='assets/img-products/$imagen'>
                                    <div class='caption'>
                                        <h3>{$fila['Marca']}</h3>
                                        <p>{$fila['NombreProd']}</p>";
                        
                        if ($fila['Descuento'] > 0) {
                            echo "<p>{$fila['Descuento']}% descuento: \${$precioFinal}</p>";
                        }

                        echo "<p class='text-center'>
                                <a href='infoProd.php?CodigoProd={$fila['CodigoProd']}' class='btn btn-primary btn-sm btn-raised btn-block'>
                                    <i class='fa fa-plus'></i>&nbsp; Detalles
                                </a>
                              </p>
                          </div>
                        </div>
                      </div>";
                    }
                } else {
                    echo '<h2>No hay locales registrados en la tienda</h2>';
                }
                ?>  
            </div>
        </div>
    </section>

    <section id="reg-info-index">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 text-center">
                    <article style="margin-top:5%;">
                        <p><i class="fa fa-users fa-4x"></i></p>
                        <h3>Registrate</h3>
                        <p>Registrate como cliente de <span class="tittles-pages-logo">CONNECT M</span> en un sencillo formulario para poder ingresar tu local</p>
                        <p><a href="registration.php" class="btn btn-info btn-raised btn-block">Registrarse</a></p>   
                    </article>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <img src="assets/img/tv.png" alt="Smart-TV" class="img-responsive" style="width: 70%; display: block; margin: 0 auto;">
                </div>
            </div>
        </div>
    </section>

    <?php include './inc/footer.php'; ?>
</body>
</html>
