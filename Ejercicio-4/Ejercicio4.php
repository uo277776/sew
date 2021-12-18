<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="author" content="Alvaro Rodriguez Gonzalez"/>
    <meta name="description" content="Precios internacionales del Petroleo usando Commodities API"/>
    <meta name="keyworks" content="Petrol, Petroleo, Gas, API"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ejercicio 4</title>
    <link href="Ejercicio4.css" rel="stylesheet"/>
</head>
<body>
    <h1>Precios internacionales del petroleo</h1>
    <p>Uso de Commodities API</p>   
    <?php

        class Petrol{
            public function calcularPrecio($litros, $precioLitro){
                return $litros * $precioLitro;
            }

            public function calcularLitros($euros, $precioLitro){
                return $euros / $precioLitro;
            }
        }
        $apikey = "zjq29or2uqdgjiobbyu5ec1x83nui6ft31pm015t3fmgsq640q8khtvev4c6";
        $endpoint = "latest";
        $base = "BRENTOIL";
        $symbols = "EUR";
        $url = "https://commodities-api.com/api/" . $endpoint . "?access_key=" . $apikey . "&base=" . $base . "&symbols=" . $symbols; 

        $datos = file_get_contents($url);

        $json = json_decode($datos);

        $precio = $json->data->rates->EUR;
        $fecha = $json->data->date;
        $precioLitro = $precio / 158.987304;

        $petrol = new Petrol();

        $resultadoPrecio = "";
        $resultadoLitros = "";

        if (count($_POST) > 0){
            
            if (isset($_POST['precio'])){
                $resultadoPrecio = "<h3>" . $_POST['nlitros'] . " litros cuestan " . $petrol->calcularPrecio($_POST['nlitros'], $precioLitro) . " euros</h3>";
            }
            if (isset($_POST['litros'])){
                $resultadoLitros = "<h3>Con " . $_POST['neuros'] . " euros puede comprar " . $petrol->calcularLitros($_POST['neuros'], $precioLitro) . " litros</h3>";
            }

        }
        echo "
            <p>Fecha: $fecha </p>
            <p>Precio del petroleo: $precio euros por barril</p>
            <p>Precio del petroleo: $precioLitro euros por litro</p>
        ";

        echo "
            <form action='#' method='post'>
                <section id = 'litros'>
                    <h2>¿Cuantos litros quiero comprar?</h2>
                    <p><label for='nlitros'>Numero de litros:</label>
                        <input type = 'text' name='nlitros' id='nlitros' value = '10'/> 
                        <input type='submit' name='precio' value='calcular'/>
                    </p>
                    $resultadoPrecio
                </section>

                <section id = 'euros'>
                    <h2>¿Cuantos litros puedo comprar?</h2>
                    <p> <label for='neuros'>Euros:</label>
                        <input type = 'text' name='neuros' id='neuros' value = '10'/> 
                        <input type='submit' name='litros' value='calcular'/>
                    </p>
                    $resultadoLitros
                </section>
            </form>
        ";
    ?>
    
    <footer>
        <img src="media/HTML5.png" alt=" HTML5 Válido!" />
        <img src="media/CSS3.png" alt="CSS3 Válido!"/>
    </footer>
</body>
</html>