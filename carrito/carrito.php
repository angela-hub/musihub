<?php

// Lo que necesitamos
require_once $_SERVER['DOCUMENT_ROOT']."/musihub/dirs.php";
require_once VIEW_PATH . "../cabecera.php";

// como esta página está restringida al usuario en cuestion
if ((!isset($_SESSION['nombre']))) {
    header("location: /musihub/error.php");
    exit();
}

// Borramos todos los items, vaciar carrito
if (isset($_POST['vaciar_carrito'])) {
    $carrito = ControladorCarrito::getControlador();
    $carrito->vaciarCarrito();
    $sesion = ControladorAcceso::getControlador();
    header("location: carrito.php");
}

// Borrar un item
if (isset($_POST['borrar_item'])) {
    $carrito = ControladorCarrito::getControlador();
    $carrito->borrarLineaCarrito($_POST['id'], $_POST['uds']);
    $sesion = ControladorAcceso::getControlador();
    header("location: carrito.php");
    $sesion->crearCookie();
    header("location: carrito.php");
}

// Actualizamos un item
if (isset($_POST['id']) && isset($_POST['uds'])) {
    $carrito = ControladorCarrito::getControlador();
    // solo devuelve el foco al carrito si se ha actualizado correctamente, sino
    // mostrará el mensaje de error
    if ($carrito->actualizarLineaCarrito($_POST['id'], $_POST['uds'])) {
        // Si se actuliza el carrito en sesiones lo actualizmos en cookie
        $sesion = ControladorAcceso::getControlador();
        header("location: carrito.php");
    }
}


?>
<main role="main">
    <section class="page-header clearfix text-center">
        <h1>Carrito de compra</h1>
    </section>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <?php
    //Si en la sesion hay mas de 0 unidades entraría en el if para imprimir los articulos del carrito
    if ($_SESSION['uds'] > 0) {
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-md-offset-1">

                    <table class="table">

                        <thead class="thead-light">
                        <tr>
                            <th class="table-image"></th>
                            <th class="text-left">Instrumento</th>
                            <th class="text-right">Precio</th>
                            <th>Cantidad</th>
                            <th class="text-right">Total</th>
                            <th class="text-center"></th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php
                        $total = 0;
                        foreach ($_SESSION['carrito'] as $key => $value) {
                            $id = $key;
                            if ($value[0] != null) {
                                $instrumento = $value[0];
                                $cantidad = $value[1];
                                $total += $instrumento->getprecio() * $cantidad;
                                ?>
                                <!-- Inicio de fila -->
                                <tr>
                                    <!-- Imagen -->
                                    <td class='col-sm-1 col-md-1'><img
                                                src='../imagenes/fotos/<?php echo $instrumento->getImagen(); ?>'
                                                class='avatar img-thumbnail' alt='imagen' width='60'>
                                        <!-- Nombre -->
                                    <td class='col-sm-8 col-md-6 text-left'>
                                        <h4><?php echo $instrumento->getnombre(); ?></h4>
                                        <h6><?php echo $instrumento->gettipo(); ?></h6>
                                    </td>
                                    <!-- precio -->
                                    <td class="col-sm-1 col-md-1 text-right">
                                        <h6><?php echo $instrumento->getprecio(); ?>
                                            €</h6></td>
                                    <!-- Cantidad -->
                                    <td class="col-sm-1 col-md-1 text-center">
                                        <!-- Para actualizar -->
                                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>"
                                              method="post">
                                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                            <input type="number" name="uds" value="<?php echo $cantidad; ?>"
                                                   step="1" min="1"
                                                   max="<?php echo $instrumento->getstockinicial(); ?>"
                                                   onchange="submit()">
                                        </form>
                                    </td>
                                    <!-- Total -->
                                    <td class="col-sm-1 col-md-1 text-right"><h6>
                                            <strong><?php echo $instrumento->getPrecio() * $cantidad; ?> €</strong>
                                        </h6>
                                    </td>
                                    <!-- Eliminar -->
                                    <td class="col-sm-1 col-md-1 text-right">
                                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>"
                                              method="post">
                                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                            <input type="hidden" id="uds" name="uds"
                                                   value="<?php echo $cantidad; ?>">
                                            <button class="btn btn-danger" type="submit" name="borrar_item"
                                                    title='Borar Instrumento' data-toggle='tooltip'
                                                    onclick="return confirm('¿Seguro que desea borrar a este instrumento?')">
                                                <span class='glyphicon glyphicon-trash'></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <!-- Fin de fila de fila -->
                                <?php
                                // lo guardo en un valor de sesión tb
                                $_SESSION['total'] = $total;
                            }
                        }
                        ?>

                        </tbody>
                        <!-- Pie de Tabla -->
                        <tfoot>
                        <tr>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td class="col-sm-1 col-md-1 text-right">
                                <h6><strong><span id='subTotal'>SubTotal: </span></strong></h6>
                                <h6><strong><span id='iva'>I.V.A.: </span></strong></h6>
                                <h4><strong><span id='iva'>TOTAL: </span></strong></h4>
                            <td class="col-sm-8 col-md-6 text-right">
                                <h6><strong><span
                                                id='subTotal'><?php echo round(($total / 1.21), 2); echo "€"?> </span></strong>
                                </h6>
                                <h6><strong><span id='iva'><?php echo round(($total - ($total / 1.21)), 2); echo "€"?> </span></strong>
                                </h6>
                                <h4><strong><span id='precioTotal'><?php echo round(($total), 2); echo "€"?></span></strong>
                                </h4>
                            </td>
                            <td>  </td>
                        </tr>

                        <tr>
                            <td>
                                <!-- Seguir comprando -->
                                <a href='../index.php' class='btn btn-default'><span
                                            class='glyphicon glyphicon-plus'></span> Seguir comprando </a>
                            </td>
                            <td>  </td>

                            <td>
                                <!-- Vaciar Carrito -->
                                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>"
                                      method="post">
                                    <button class="btn btn-danger" type="submit" name="vaciar_carrito"
                                            title='Vaciar Carrito'
                                            onclick="return confirm('¿Seguro que desea vaciar el carrito?')">
                                        <span class='glyphicon glyphicon-trash'></span> Vaciar carrito</span>
                                    </button>
                                </form>
                            </td>
                            </td>
                            <td>  </td>
                            <td>  </td>
                            <td>
                                <!-- Pagar Carrito -->
                                <a href='fincarrito.php' class='btn btn-success'><span
                                            class='glyphicon glyphicon-credit-card'></span> Pagar compra </a>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<p class='lead'><em>El carrito está vacio.</em></p>";
    }
    ?>
</main>


<br>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "../footer.php"; ?>