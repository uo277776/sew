<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Alvaro Rodriguez Gonzalez"/>
    <meta name="description" content="Resultados e Informacion sobre Formula 1"/>
    <meta name="keyworks" content="Formula 1, Carreras, F1, Resultados"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ejercicio 7</title>
    <link rel="stylesheet" type="text/css" href="Ejercicio7.css" />
</head>

<body>
    <h1>Resultados de Formula 1</h1>
    <?php
        session_start();
        class BaseDatos{
            protected $servername;
            protected $user;
            protected $password;
            protected $dbname;

            public function __construct($servername, $user, $password, $dbname){
                $this->servername = $servername;
                $this->user = $user;
                $this->password = $password;
                $this->dbname = $dbname;
                
            }

            public function verCarreras(){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname); 

                $carreras = "SELECT * FROM grandespremios ORDER BY Dia DESC";
                
                $rsCarreras = $conn->query($carreras);

                if ($rsCarreras->num_rows > 0){
                    while ($carrera = $rsCarreras->fetch_assoc()){
                        $carreraPrint = "<p>Temporada: " . $carrera['Temporada'] . " - Dia: " . $carrera['Dia'];
                        $circuito = $this->getCircuito($carrera['Circuito']);
                        $carreraPrint .= " - Circuito: " . $circuito['Nombre'] . " - Vueltas: " . $carrera['Vueltas'];
                        $ganador = $this->getGanador($carrera['ID']);
                        $carreraPrint .= " - Ganador: " . $ganador['Nombre'] . " " . $ganador['Apellidos'] . "</p>";
                        echo $carreraPrint;
                    }
                }
                $conn->close();
            }

            public function verCarrera($dia){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname);
                $carrera = $conn->prepare("SELECT * FROM grandespremios WHERE Dia = ?");
                $carrera->bind_param("s", $dia);
                $carrera->execute();
                $rsCarrera = $carrera->get_result();
                if ($rsCarrera->num_rows > 0){
                    while($row = $rsCarrera->fetch_assoc()){
                        $carreraPrint = "<p>Temporada: " . $row['Temporada'] . " - Dia: " . $row['Dia'] . " - Vueltas: " . $row['Vueltas'] . "</p>";
                        $circuito = $this->getCircuito($row['Circuito']);
                        $carreraPrint .= "<p>Circuito: " . $circuito['Nombre'] . " - Pais: " . $circuito['Pais'] . " - Longitud: "
                        . $circuito['Longitud'] . " metros - Curvas: " . $circuito['Curvas'] . " - Capacidad: " . $circuito['Capacidad'] . " espectadores</p>";
                        $carreraPrint .= $this->getResultados($row["ID"]);
                        echo $carreraPrint;
                    }
                } else{
                    echo "No se ha disputado ninguna carrera en ese día!";
                }
                $conn->close();
            }

            public function getResultados($ID_Carrera){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname);
                $resultados = $conn->prepare("SELECT * FROM resultados WHERE ID_GranPremio = ? ORDER BY Resultado");
                $resultados->bind_param("i", $ID_Carrera);
                $resultados->execute();
                $rsResultados = $resultados->get_result();
                $resultadosPrint = "<p>Clasificacion Final:</p><ol>";
                if ($rsResultados->num_rows > 0){
                    while($resultado = $rsResultados->fetch_assoc()){
                        $piloto = $this->getPiloto($resultado['ID_Piloto']);
                        $resultadosPrint .= "<li>" . $piloto['Nombre'] . " " . $piloto['Apellidos'] . " - Parrilla: " . $resultado['Parrilla'];
                        $balance = $resultado['Parrilla'] - $resultado['Resultado'];
                        $resultadosPrint .= " - Balance: " . $balance . "</li>";
                    }
                }
                $resultadosPrint .= "</ol>";
                return $resultadosPrint;
            }

            private function getCircuito($ID_Circuito){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname); 
                $circuito = $conn->prepare("SELECT * FROM circuitos WHERE ID = ?");
                $circuito->bind_param("i", $ID_Circuito);
                $circuito->execute();
                $rsCircuito = $circuito->get_result();
                if ($rsCircuito->num_rows > 0){
                    while($row = $rsCircuito->fetch_assoc()){
                        return $row;
                    }
                }
                $conn->close();
            }

            private function getGanador($ID_Carrera){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname); 
                $ganador = $conn->prepare("SELECT * FROM pilotos WHERE ID IN (SELECT ID_Piloto FROM resultados WHERE ID_GranPremio = ? AND Resultado = 1)");
                $ganador->bind_param('i', $ID_Carrera);
                $ganador->execute();
                $rsGanador = $ganador->get_result();
                if ($rsGanador->num_rows > 0){
                    while($row = $rsGanador->fetch_assoc()){
                        return $row;
                    }
                }
                $conn->close();
            }

            private function getPiloto($ID_Piloto){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname); 
                $piloto = $conn->prepare("SELECT * FROM pilotos WHERE ID = ?");
                $piloto->bind_param('i', $ID_Piloto);
                $piloto->execute();
                $rsPiloto = $piloto->get_result();
                if ($rsPiloto->num_rows > 0){
                    while($row = $rsPiloto->fetch_assoc()){
                        return $row;
                    }
                }
                $conn->close();
            }

            private function getEquipo($ID_Equipo){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname); 
                $equipo = $conn->prepare("SELECT * FROM equipos WHERE ID = ?");
                $equipo->bind_param('i', $ID_Equipo);
                $equipo->execute();
                $rsEquipo = $equipo->get_result();
                if ($rsEquipo->num_rows > 0){
                    while($row = $rsEquipo->fetch_assoc()){
                        return $row;
                    }
                }
                $conn->close();
            }

            public function verMundialPilotos(){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname);
                $clasificacion = "SELECT r.ID_Piloto AS piloto, SUM(p.Puntos) AS puntos FROM resultados r, puntuacion p 
                WHERE r.Resultado = p.Resultado GROUP BY  r.ID_Piloto ORDER BY SUM(p.Puntos) DESC, r.ID_Piloto";
                $rsClasi = $conn->query($clasificacion);
                $clasiPrint = "<p>Clasificacion Mundial de Pilotos:</p><ol>";
                if ($rsClasi->num_rows > 0){
                    while($row = $rsClasi->fetch_assoc()){
                        $piloto = $this->getPiloto($row['piloto']);
                        $clasiPrint .= "<li>" . $piloto['Nombre'] . " " . $piloto['Apellidos'] . " - Puntos: " . $row['puntos'];
                        $victorias = $this->getVictorias($row['piloto']);
                        $clasiPrint .= ' - Victorias: ' . $victorias . "</li>";
                    }
                }
                $clasiPrint .= "</ol>";
                echo $clasiPrint;
                $conn->close();
            }

            public function getVictorias($ID_Piloto){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname);
                $victorias = $conn->prepare("SELECT count(*) as victorias FROM resultados WHERE Resultado = 1 AND ID_Piloto = ?");
                $victorias->bind_param("i", $ID_Piloto);
                $victorias->execute();
                $rsVictorias = $victorias->get_result();
                if ($rsVictorias->num_rows > 0){
                    while($row = $rsVictorias->fetch_assoc()){
                        return $row['victorias'];
                    }
                }
                $conn->close();
            }

            public function verMundialEquipos(){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname);
                $clasificacion = "SELECT pi.ID_Equipo AS equipo, SUM(p.Puntos) AS puntos FROM resultados r, puntuacion p, pilotos pi 
                WHERE r.Resultado = p.Resultado AND pi.ID = r.ID_Piloto GROUP BY pi.ID_Equipo ORDER BY SUM(p.Puntos) DESC, pi.ID_Equipo";
                $rsClasi = $conn->query($clasificacion);
                $clasiPrint = "<p>Clasificacion Mundial de Equipos:</p><ol>";
                if ($rsClasi->num_rows > 0){
                    while($row = $rsClasi->fetch_assoc()){
                        $equipo = $this->getEquipo($row['equipo']);
                        $clasiPrint .= "<li>" . $equipo['Nombre'] . " - Puntos: " . $row['puntos'];
                    }
                }
                $clasiPrint .= "</ol>";
                echo $clasiPrint;
                $conn->close();
            }

            public function verPilotos(){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname);
                $pilotos = "SELECT * FROM pilotos ORDER BY Victorias DESC";
                $rsPilotos = $conn->query($pilotos);
                $pilotosPrint = "<p>Clasificacion Historica de Pilotos:</p><ol>";
                if ($rsPilotos->num_rows > 0){
                    while($piloto = $rsPilotos->fetch_assoc()){
                        $equipo = $this->getEquipo($piloto['ID_Equipo']);
                        $pilotosPrint .= "<li>" . $piloto['Dorsal'] . " - " . $piloto['Nombre'] . " " . $piloto['Apellidos'] . " - Nacionalidad: " 
                        . $piloto['Nacionalidad'] . " - Victorias: " . $piloto['Victorias'] . " - Equipo: " . $equipo['Nombre'] . "</li>";
                    }
                }
                $pilotosPrint .= "</ol>";
                echo $pilotosPrint;
                $conn->close();
            }

            public function verEquipos(){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname);
                $equipos = "SELECT * FROM equipos ORDER BY Titulos DESC";
                $rsEquipos = $conn->query($equipos);
                $equiposPrint = "<p>Clasificacion Historia de Equipos:</p><ol>";
                if ($rsEquipos->num_rows > 0){
                    while($equipo = $rsEquipos->fetch_assoc()){
                        $equiposPrint .= "<li>" . $equipo['Nombre'] . " - Nacionalidad: " . $equipo['Nacionalidad'] . " - Jefe: " . $equipo['Jefe']
                        . " - Titulos: " . $equipo['Titulos'] . "</li>";
                    }
                }
                $equiposPrint .= "</ol>";
                echo $equiposPrint;
                $conn->close();
            }
        }

        if (isset($_SESSION['basedatosf1'])){
            $basedatos = $_SESSION['basedatosf1'];
        } else{
            $basedatos = new BaseDatos("localhost", "DBUSER2021", "DBPSWD2021", "Formula1");
            $_SESSION['basedatosf1'] = $basedatos;
        }

        echo "
            <form action='#' method='post'>
                <input type='submit' name='carreras' value='Ver ultimos Grandes Premios'/>
                <input type='submit' name='resultado' value='Ver resultados de una carrera'/>
                <input type='submit' name='mundial' value='Ver Clasificacion de Pilotos Actual'/>
                <input type='submit' name='mundialEquipos' value='Ver Clasificacion de Equipos Actual'/>
                <input type='submit' name='pilotos' value='Ver Clasificacion Historica de Pilotos'/>
                <input type='submit' name='equipos' value='Ver Clasificacion Historica de Equipos'/>
            </form>
        ";

        if (count($_POST) > 0){
            if (isset($_POST['carreras'])) $basedatos->verCarreras(); 
            if (isset($_POST['resultado'])){
                echo "
                    <form action='#' method='post'>
                        <label for='dia'>Dia de la carrera: </label>
                        <input type='text' id='dia' name='dia'/>
                        <input type='submit' name='ver' value='Ver Resultado'/>
                    </form>
                ";
            }
            if (isset($_POST['ver'])) $basedatos->verCarrera($_POST['dia']);
            if (isset($_POST['mundial'])) $basedatos->verMundialPilotos();
            if (isset($_POST['mundialEquipos'])) $basedatos->verMundialEquipos();
            if (isset($_POST['pilotos'])) $basedatos->verPilotos();
            if (isset($_POST['equipos'])) $basedatos->verEquipos();
        }
    ?>
</body>
</html>