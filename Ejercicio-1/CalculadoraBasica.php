<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Alvaro Rodriguez Gonzalez"/>
    <meta name="description" content="Calculadora Basica"/>
    <meta name="keyworks" content="Calculadora, operacion, resta, suma"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Calculadora Basica</title>
    <link rel="stylesheet" type="text/css" href="CalculadoraBasica.css" />
</head>

<body>
    <h1>Calculadora Basica</h1>
    <?php
        session_start();
        class CalculadoraBasica{
            protected $expresion;
            protected $memoria;

            public function __construct(){
                $this->expresion = "";
                $this->memoria = "";
            }

            public function escribir($numero){
                $this->expresion .= $numero;
            }

            public function calcular(){
                $this->expresion = eval("return $this->expresion;");
            }

            public function borrarTodo(){
                $this->expresion = "";
            }

            public function getExpresion(){
                return $this->expresion;
            }

            public function getMemoria(){
                return $this->memoria;
            }

            public function sumarMemoria(){
                if (empty($this->memoria)){
                    $this->memoria = $this->expresion;
                } else{
                    $this->memoria += $this->expresion;
                }
            }

            public function restarMemoria(){
                if (empty($this->memoria)){
                    
                } else{
                    $this->memoria -= $this->expresion;
                }
            }

            public function recuperarMemoria(){
                if (empty($this->memoria)){
                    
                } else{
                    $this->expresion = $this->memoria;
                }
            }
        }

        $pantalla = "";

        if (isset($_SESSION['calculadora'])){
            $calculadora = $_SESSION['calculadora'];
        } else{
            $calculadora = new CalculadoraBasica();
            $_SESSION['calculadora'] = $calculadora;
        }

        if (count($_POST) > 0){

            if (isset($_POST['0'])) $calculadora->escribir("0");
            if (isset($_POST['1'])) $calculadora->escribir("1");
            if (isset($_POST['2'])) $calculadora->escribir("2");
            if (isset($_POST['3'])) $calculadora->escribir("3");
            if (isset($_POST['4'])) $calculadora->escribir("4");
            if (isset($_POST['5'])) $calculadora->escribir("5");
            if (isset($_POST['6'])) $calculadora->escribir("6");
            if (isset($_POST['7'])) $calculadora->escribir("7");
            if (isset($_POST['8'])) $calculadora->escribir("8");
            if (isset($_POST['9'])) $calculadora->escribir("9");
            if (isset($_POST['+'])) $calculadora->escribir("+");
            if (isset($_POST['-'])) $calculadora->escribir("-");
            if (isset($_POST['/'])) $calculadora->escribir("/");
            if (isset($_POST['*'])) $calculadora->escribir("*");
            if (isset($_POST['punto'])) $calculadora->escribir('.');
            if (isset($_POST['='])) $calculadora->calcular();
            if (isset($_POST['C']))$calculadora->borrarTodo();
            if (isset($_POST['mrc'])) $calculadora->recuperarMemoria();
            if (isset($_POST['m+'])) $calculadora->sumarMemoria();
            if (isset($_POST['m-'])) $calculadora->restarMemoria();

            $pantalla = $calculadora->getExpresion();
        }

        echo "
            <form action='#' method='post' name='calculadora'>
                <label for='pantalla'>Calculadora</label>
                <input type='text' id='pantalla' name='operacion' value='$pantalla' disabled/>

                <input type='submit' name='mrc' value='mrc'/>
                <input type='submit' name='m-' value='m-'/>
                <input type='submit' name='m+' value='m+'/>
                <input type='submit' name='/' value='/'/>

                <input type='submit' name='7' value='7'/>
                <input type='submit' name='8' value='8'/>
                <input type='submit' name='9' value='9'/>
                <input type='submit' name='*' value='*'/>

                <input type='submit' name='4' value='4'/>
                <input type='submit' name='5' value='5'/>
                <input type='submit' name='6' value='6'/>
                <input type='submit' name='-' value='-'/>

                <input type='submit' name='1' value='1'/>
                <input type='submit' name='2' value='2'/>
                <input type='submit' name='3' value='3'/>
                <input type='submit' name='+' value='+'/>
                
                <input type='submit' name='0' value='0'/>
                <input type='submit' name='punto' value='.'/>
                <input type='submit' name='C' value='C'/>
                <input type='submit' name='=' value='='/>
            </form>";
    ?>
</body>
</html>