<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Alvaro Rodriguez Gonzalez"/>
    <meta name="description" content="Base de datos MySQL y PHP"/>
    <meta name="keyworks" content="Base de datos, MySQL, PHP, Conexiones, SQL"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ejercicio 6</title>
    <link rel="stylesheet" type="text/css" href="Ejercicio6.css" />
</head>

<body>
    <h1>Base de datos</h1>
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

            public function crearBaseDatos(){
                $conn = new mysqli($this->servername, $this->user, $this->password); 
                $sql = "CREATE DATABASE " . $this->dbname;
                if ($conn->query($sql) == TRUE){
                    echo "Base de Datos Creada Correctamente";
                } else{
                    echo "Error al Crear la Base de Datos: " . $conn->error;
                }
                $conn->close();
            }

            public function crearTabla(){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname); 
                $sql = "CREATE TABLE PruebasUsabilidad (
                    Codigo VARCHAR(10) NOT NULL PRIMARY KEY, 
                    Nombre VARCHAR(255) NOT NULL, 
                    Apellidos VARCHAR(255) NOT NULL, 
                    Email VARCHAR(255) NOT NULL, 
                    Telefono INT(9) NOT NULL, 
                    Edad INT(3) NOT NULL, 
                    Sexo VARCHAR(255) NOT NULL, 
                    Nivel INT(2) NOT NULL, 
                    Tiempo INT(10) NOT NULL, 
                    Realizada VARCHAR(255) NOT NULL, 
                    Comentarios VARCHAR(255) NOT NULL, 
                    Propuestas VARCHAR(255) NOT NULL, 
                    Valoracion INT(2) NOT NULL,
                    CONSTRAINT CHK_SEXO CHECK(Sexo = 'Masculino' OR Sexo = 'Femenino'),
                    CONSTRAINT CHK_NIVEL CHECK(Nivel >= 0 AND Nivel <= 10),
                    CONSTRAINT CHK_VALORACION CHECK(Valoracion >= 0 AND Valoracion <= 10),
                    CONSTRAINT CHK_REALIZADA CHECK(Realizada = 'Si' OR Realizada = 'No')
                )";
                if ($conn->query($sql) == TRUE){
                    echo "Tabla Creada Correctamente";
                } else{
                    echo "Error al Crear la Tabla " . $conn->error;
                }
                $conn->close();
            }

            public function borrarTabla(){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname); 
                $sql = "DROP TABLE PruebasUsabilidad";
                if ($conn->query($sql) == TRUE){
                    echo "Tabla Borrada Correctamente";
                } else{
                    echo "Error al Crear la Tabla " . $conn->error;
                }
                $conn->close();
            }

            public function insertarDatos($codigo, $nombre, $apellidos, $email, $tfn, $edad, $sexo, $nivel, $tiempo, $realizada, $comentarios, $propuestas, $valoracion){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname); 
                if (!($sql = $conn->prepare("INSERT INTO PruebasUsabilidad VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))){
                    echo "Fallo la preparacion " . $conn->error;
                }
                $sql->bind_param("ssssiisiisssi", $codigo, $nombre, $apellidos, $email, $tfn, $edad, $sexo, $nivel, $tiempo, 
                $realizada, $comentarios, $propuestas, $valoracion);
                if ($sql->execute()){
                    echo "Datos insertados correctamente";
                } else{
                    echo "Error al insertar datos " . $conn->error;
                }
                $sql->close();
                $conn->close();
            }

            public function buscarDatos($codigo){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname); 
                if (!($sql = $conn->prepare("SELECT * FROM PruebasUsabilidad WHERE codigo = ?"))){
                    echo "Fallo la preparacion " . $conn->error;
                }
                $sql->bind_param("s", $codigo);
                if (!$sql->execute()){
                    echo "Error al buscar datos" . $conn->error;
                }
                $result = $sql->get_result();
               
                if ($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "Codigo: " . $row['Codigo'] . " - Nombre: " . $row['Nombre'] . " - Apellidos: " . $row['Apellidos'] . " - Email: " . $row['Email']
                        . " - Telefono: " . $row['Telefono'] . " - Edad: " . $row['Edad'] . " - Sexo: " . $row['Sexo'] . " - Nivel: " . $row['Nivel'] . " - Tiempo: "
                        . $row['Tiempo'] . " - Realizada: " . $row['Realizada'] . " - Comentarios: " . $row['Comentarios'] . " - Propuestas: " . $row['Propuestas']
                        . " - Valoracion: " . $row['Valoracion'];
                    }
                }
            }

            public function modificarNombre($codigo, $nombre){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname); 
                if (!($sql = $conn->prepare("UPDATE PruebasUsabilidad SET Nombre = ? WHERE Codigo = ?"))){
                    echo "Fallo la preparacion " . $conn->error;
                }
                $sql->bind_param("ss", $nombre, $codigo);
                if ($sql->execute()){
                    echo "Datos modificados correctamente";
                } else{
                    echo "Error al modificar datos " . $conn->error;
                }

            }

            public function modificarApellidos($codigo, $apellidos){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname); 
                if (!($sql = $conn->prepare("UPDATE PruebasUsabilidad SET Apellidos = ? WHERE Codigo = ?"))){
                    echo "Fallo la preparacion " . $conn->error;
                }
                $sql->bind_param("ss", $apellidos, $codigo);
                if ($sql->execute()){
                    echo "Datos modificados correctamente";
                } else{
                    echo "Error al modificar datos " . $conn->error;
                }

            }

            public function modificarEmail($codigo, $email){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname); 
                if (!($sql = $conn->prepare("UPDATE PruebasUsabilidad SET Email = ? WHERE Codigo = ?"))){
                    echo "Fallo la preparacion " . $conn->error;
                }
                $sql->bind_param("ss", $email, $codigo);
                if ($sql->execute()){
                    echo "Datos modificados correctamente";
                } else{
                    echo "Error al modificar datos " . $conn->error;
                }

            }

            public function borrarDatos($codigo){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname); 
                if (!($sql = $conn->prepare("DELETE FROM PruebasUsabilidad WHERE codigo = ?"))){
                    echo "Fallo la preparacion " . $conn->error;
                }
                $sql->bind_param("s", $codigo);
                if (!$sql->execute()){
                    echo "Error al eliminar datos" . $conn->error;
                } else{
                    echo "Datos eliminados correctamente";
                }
            }

            public function mostrarInforme(){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname); 
                $sqlNumero = "SELECT COUNT(*) as numberOfRows FROM PruebasUsabilidad";
                $rsNumero = $conn->query($sqlNumero);
                if ($rsNumero->num_rows > 0){
                    while($row = $rsNumero->fetch_assoc()){
                        $total = $row['numberOfRows'];
                    }
                }
                $sqlEdad = "SELECT SUM(Edad) as sumaEdad FROM PruebasUsabilidad";
                $rsEdad = $conn->query($sqlEdad);
                if ($rsEdad->num_rows > 0){
                    while($row = $rsEdad->fetch_assoc()){
                        $edadTotal = $row['sumaEdad'];
                    }
                }
                $sqlSexo = "SELECT COUNT(*) as sexoMasculino FROM PruebasUsabilidad WHERE Sexo = 'Masculino'";
                $rsSexo = $conn->query($sqlSexo);
                if ($rsSexo->num_rows > 0){
                    while($row = $rsSexo->fetch_assoc()){
                        $sexoMasculino = $row['sexoMasculino'];
                    }
                }

                $sqlNivel = "SELECT SUM(Nivel) as sumaNivel FROM PruebasUsabilidad";
                $rsNivel = $conn->query($sqlNivel);
                if ($rsNivel->num_rows > 0){
                    while($row = $rsNivel->fetch_assoc()){
                        $nivelTotal = $row['sumaNivel'];
                    }
                }

                $sqlTiempo = "SELECT SUM(Tiempo) as sumaTiempo FROM PruebasUsabilidad";
                $rsTiempo = $conn->query($sqlTiempo);
                if ($rsTiempo->num_rows > 0){
                    while($row = $rsTiempo->fetch_assoc()){
                        $tiempoTotal = $row['sumaTiempo'];
                    }
                }

                $sqlRealizado = "SELECT COUNT(*) as realizadas FROM PruebasUsabilidad WHERE Realizada = 'Si'";
                $rsRealizado = $conn->query($sqlRealizado);
                if ($rsRealizado->num_rows > 0){
                    while($row = $rsRealizado->fetch_assoc()){
                        $realizadas = $row['realizadas'];
                    }
                }

                $sqlValoracion = "SELECT SUM(Valoracion) as sumaValoracion FROM PruebasUsabilidad";
                $rsValoracion = $conn->query($sqlValoracion);
                if ($rsValoracion->num_rows > 0){
                    while($row = $rsValoracion->fetch_assoc()){
                        $valoracionTotal = $row['sumaValoracion'];
                    }
                }

                $mediaEdad = $edadTotal / $total;
                $porcentajeMasculino = ($sexoMasculino/$total) * 100;
                $porcentajeFemenino = 100 - $porcentajeMasculino;
                $mediaNivel = $nivelTotal / $total;
                $mediaTiempo = $tiempoTotal / $total;
                $porcentajeSi = ($realizadas/$total) *100;
                $porcentajeNo = 100 - $porcentajeSi;
                $mediaValoracion = $valoracionTotal / $total;

                echo "<p>Total de Pruebas: " . $total . "</p>";
                echo "<p>Edad Media: " . $mediaEdad . "</p>";
                echo "<p>Porcentaje: Masculino: " . $porcentajeMasculino . "% - Femenino: " . $porcentajeFemenino . "%</p>";
                echo "<p>Nivel Medio: " . $mediaNivel . "</p>";
                echo "<p>Tiempo Medio: " . $mediaTiempo . "</p>";
                echo "<p>Pruebas realizadas: Si: " . $porcentajeSi . "% - No: " . $porcentajeNo . "%</p>";
                echo "<p>Valoracion Media: " . $mediaValoracion . "</p>";
            }

            public function exportar(){
                $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname); 
                if (!($sql = $conn->prepare("SELECT * FROM PruebasUsabilidad"))){
                    echo "Fallo la preparacion " . $conn->error;
                }
                $sql->execute();
                $result = $sql->get_result();
                
                
                $csv_file = "pruebasUsabilidad". ".csv";
                header("Content-Encoding: UTF-8");
                header("Content-type: text/csv; charset=UTF-8");
                header("Content-Disposition: attachment; filename=$csv_file");

                ob_end_clean();
                $f = fopen( 'php://output', 'w' );
                $delimiter = ";";
                if ($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $lineData = array($row['Codigo'], $row['Nombre'], $row['Apellidos'], $row['Email'], $row['Telefono'], $row['Edad'], $row['Sexo'],
                        $row['Nivel'], $row['Tiempo'], $row['Realizada'], $row['Comentarios'], $row['Propuestas'], $row['Valoracion']);
                        fputcsv($f, $lineData, $delimiter);
                    }
                }
                
               
                fclose($f);
                
            }

            public function importar($filename){
                $info = new SplFileInfo($filename);
                $extension = pathinfo($info->getFilename(), PATHINFO_EXTENSION);
                
                if ($extension == 'csv'){
                    $conn = new mysqli($this->servername, $this->user, $this->password, $this->dbname); 
                    $filename = $_FILES['file']['tmp_name'];
                    $f = fopen($filename, 'r');

                    while(($data = fgetcsv($f, 1000, ';')) !== FALSE){
                        $codigo = $data[0];
                        $query = "INSERT INTO PruebasUsabilidad VALUES('$codigo', '$data[1]', '$data[2]', '$data[3]', $data[4], $data[5], '$data[6]', 
                        $data[7], $data[8], '$data[9]', '$data[10]', '$data[11]', $data[12])";

                        $conn->query($query);
                    }
                    echo "Datos importados correctamente";
                } else{
                    echo "¡Archivo no valido!";
                }
            }
            
        }

        echo "
            <form action='#' method='post'>
                <input type='submit' name='crearDB' value='Crear Base de Datos'/>
                <input type='submit' name='crearTabla' value='Crear Tabla Pruebas Usabilidad'/>
                <input type='submit' name='borrarTabla' value='Borrar Tabla'/>
                <input type='submit' name='abrir' value='Insertar Datos'/>
                <input type='submit' name='buscar' value='Buscar Datos'/>
                <input type='submit' name='modificar' value='Modificar Datos'/>
                <input type='submit' name='borrar' value='Borrar Datos'/>
                <input type='submit' name='informe' value='Mostrar Informe'/>
                <input type='submit' name='exportar' value='Exportar a CSV'/>
                <input type='submit' name='importar' value='Importar de CSV'/>
            </form>
        ";

        if (isset($_SESSION['basedatos'])){
            $basedatos = $_SESSION['basedatos'];
        } else{
            $basedatos = new BaseDatos("localhost", "DBUSER2021", "DBPSWD2021", "DB2021");
            $_SESSION['basedatos'] = $basedatos;
        }

        if (count($_POST) > 0){
            if (isset($_POST['crearDB'])) $basedatos->crearBaseDatos();
            if (isset($_POST['crearTabla'])) $basedatos -> crearTabla();
            if (isset($_POST['borrarTabla'])) $basedatos->borrarTabla();
            if (isset($_POST['abrir'])){
                echo "
                    <form action='#' method='post' name='menu'>
                        <label for='codigo'>Codigo (DNI): </label>
                        <input type='text' name='codigoi' id='codigo'/> <br>
                        <label for='nombre'>Nombre: </label>
                        <input type='text' name='nombre' id='nombre'/> <br>
                        <label for='apellidos'>Apellidos: </label>
                        <input type='text' name='apellidos' id='apellidos'/> <br>
                        <label for='email'>E-mail: </label>
                        <input type='text' name='email' id='email'/> <br>
                        <label for='tfn'>Telefono: </label>
                        <input type='text' name='tfn' id='tfn'/> <br>
                        <label for='edad'>Edad: </label>
                        <input type='text' name='edad' id='edad'/> <br>
                        <label for='sexo'>Sexo: </label>
                        <input type='text' name='sexo' id='sexo'/> <br>
                        <label for='nivel'>Nivel: </label>
                        <input type='text' name='nivel' id='nivel'/> <br>
                        <label for='tiempo'>Tiempo: </label>
                        <input type='text' name='tiempo' id='tiempo'/> <br>
                        <label for='realizada'>Prueba realizada: </label>
                        <input type='text' name='realizada' id='realizada'/> <br>
                        <label for='comentarios'/>Comentarios: </label>
                        <input type='text' name='comentarios' id='comentarios'/> <br>
                        <label for='propuestas'>Propuestas: </label>
                        <input type='text' name='propuestas' id='propuestas'/> <br>
                        <label for='valoracion'>Valoracion: </label>
                        <input type='text' name='valoracion' id='valoracion'/> <br>
                        <input type='submit' name='insertar' value='Insertar'/>
                    </form>
                ";
            }
            if (isset($_POST['buscar'])){
                echo "
                    <form action='#' method='post'>
                        <label for='codigo'>Codigo (DNI): </label>
                        <input type='text' id='codigo' name='codigob'/>
                        <input type='submit' name='buscarDatos' value='Buscar'/>
                    </form>
                ";
            }
            if (isset($_POST['modificar'])){
                echo "
                    <form action='#' method='post'>
                        <input type='submit' name='nombrec' value='Modificar Nombre'/>
                        <input type='submit' name='apellidosc' value='Modificar Apellidos'/>
                        <input type='submit' name='emailc' value='Modificar Email'/>
                    </form>
                ";
            }
            if (isset($_POST['borrar'])){
                echo "
                    <form action='#' method='post'>
                        <label for='codigo'>Codigo (DNI): </label>
                        <input type='text' id='codigo' name='codigor'/>
                        <input type='submit' name='borrarDatos' value='Borrar'/>
                    </form>
                ";
            }
            if (isset($_POST['informe'])) $basedatos->mostrarInforme();
            if (isset($_POST['exportar'])){
                $basedatos->exportar();
            } 
            if (isset($_POST['importar'])){
                echo "
                    <form action='#' method='post' enctype='multipart/form-data'>
                        <input type='file' name='file'/>
                        <input type='submit' name='importarDatos' value='Importar'/>
                    </form>
                ";
            }

            if (isset($_POST['importarDatos'])) $basedatos->importar($_FILES['file']['name']);

            if (isset($_POST['insertar'])){
                $basedatos->insertarDatos($_POST['codigoi'], $_POST['nombre'], $_POST['apellidos'], $_POST['email'], $_POST['tfn'], $_POST['edad'], $_POST['sexo'],
                $_POST['nivel'], $_POST['tiempo'], $_POST['realizada'], $_POST['comentarios'],$_POST['propuestas'], $_POST['valoracion']);
            }
            if (isset($_POST['buscarDatos'])){
                $basedatos->buscarDatos($_POST['codigob']);
            }
            if (isset($_POST['borrarDatos'])){
                $basedatos->borrarDatos($_POST['codigor']);
            }

            if (isset($_POST['nombrec'])){
                echo "
                    <form action = '#' method='post'>
                        <label for='codigo'>Codigo (DNI): </label>
                        <input type='text' id='codigo' name='codigoc'/>
                        <label for='nombre'>Nuevo nombre: </label>
                        <input type='text' id='nombre' name='nombrec'/>
                        <input type='submit' name='cambiarNombre' value='Modificar'/>  
                    </form>
                ";
            }
            if (isset($_POST['cambiarNombre'])) $basedatos->modificarNombre($_POST['codigoc'],$_POST['nombrec']);
            if (isset($_POST['apellidosc'])){
                echo "
                    <form action = '#' method='post'>
                        <label for='codigo'>Codigo (DNI): </label>
                        <input type='text' id='codigo' name='codigoc'/>
                        <label for='apellidos'>Nuevos apellidos: </label>
                        <input type='text' id='apellidos' name='apellidosc'/>
                        <input type='submit' name='cambiarApellidos' value='Modificar'/>  
                    </form>
                ";
            }
            if (isset($_POST['cambiarApellidos'])) $basedatos->modificarApellidos($_POST['codigoc'],$_POST['apellidosc']);
            if (isset($_POST['emailc'])){
                echo "
                    <form action = '#' method='post'>
                        <label for='codigo'>Codigo (DNI): </label>
                        <input type='text' id='codigo' name='codigoc'/>
                        <label for='email'>Nuevo email: </label>
                        <input type='text' id='email' name='emailc'/>
                        <input type='submit' name='cambiarEmail' value='Modificar'/>  
                    </form>
                ";
            }
            if (isset($_POST['cambiarEmail'])) $basedatos->modificarEmail($_POST['codigoc'],$_POST['emailc']);
        }
    ?>
</body>
</html>