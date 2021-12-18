<!DOCTYPE HTML>
<html lang="es">
<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <meta name="author" content="Alvaro Rodriguez Gonzalez"/>
    <meta name="description" content="Calculadora Cientifica"/>
    <meta name="keyworks" content="Calculadora, cientifica, operacion, resta, suma"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora Cientifica</title>
    <link rel="stylesheet" type="text/css" href="CalculadoraCientifica.css" />
</head>

<body>
    <h1>Calculadora Cientifica</h1>
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
                if (isset($this->memoria)){
                    $this->memoria -= $this->expresion;
                }
            }

            public function recuperarMemoria(){
                if (isset($this->memoria)){
                    $this->expresion = $this->memoria;
                }
            }
        }

        class CalculadoraCientifica extends CalculadoraBasica{
            protected $signo;

            public function __construct(){
                parent::__construct();
                $this->signo = FALSE;
                $this->parentesisAbiertos = 0;
            }

            public function sin(){
                $this->calcular();
                $this->expresion = sin($this->expresion);
            }

            public function cos(){
                $this->calcular();
                $this->expresion = cos($this->expresion);
            }

            public function tan(){
                $this->calcular();
                $this->expresion = tan($this->expresion);
            }

            public function potencia2(){
                $this->calcular();
                $this->expresion = pow($this->expresion, 2);
            }

            public function potencia10(){
                $this->calcular();
                $this->expresion = pow(10, $this->expresion);
            }

            public function log(){
                $this->calcular();
                $this->expresion = log($this->expresion);
            }

            public function exp(){
                $this->calcular();
                $this->expresion = exp($this->expresion);
            }

            public function pi(){
                $this->expresion = pi();
            }

            public function raiz(){
                $this->calcular();
                $this->expresion = sqrt($this->expresion);
            }

            public function factorial(){
                $this->calcular();
                $factorial = 1; 
                for ($i = 1; $i <= $this->expresion; $i++){ 
                    $factorial = $factorial * $i; 
                } 
                $this->expresion = $factorial;
            }

            public function guardarMemoria(){
               $this->memoria = $this->expresion;
            }

            public function borrarMemoria(){
                $this->memoria = "";
            }

            public function borrarUltimo(){
                $this->expresion = substr($this->expresion, 0, -1);
            }

            public function signo(){
                if ($this->signo == FALSE){
                    $this->expresion = "-(" . $this->expresion . ")";
                    $this->signo = TRUE;
                } else{
                    $this->expresion = substr($this->expresion, 1);
                    $this->signo = FALSE;
                }
                
            }

            public function parentesisIzquierdo(){
                $this->expresion .= "(";
                $this->parentesisAbiertos += 1;
            }

            public function parentesisDerecho(){
                if ($this->parentesisAbiertos > 0){
                    $this->expresion .= ")";
                    $this->parentesisAbiertos -= 1;
                }
            }
        }

        $pantalla = "";

        if (isset($_SESSION['cientifica'])){
            $calculadora = $_SESSION['cientifica'];
        } else{
            $calculadora = new CalculadoraCientifica();
            $_SESSION['cientifica'] = $calculadora;
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
            if (isset($_POST['CE'])) $calculadora->borrarTodo();
            if (isset($_POST['C'])) $calculadora->borrarTodo();
            if (isset($_POST['B'])) $calculadora->borrarUltimo();
            if (isset($_POST["xy"])) $calculadora->escribir("**");
            if (isset($_POST['MC'])) $calculadora->borrarMemoria();
            if (isset($_POST['MR'])) $calculadora->recuperarMemoria();
            if (isset($_POST['M+'])) $calculadora->sumarMemoria();
            if (isset($_POST['M-'])) $calculadora->restarMemoria();
            if (isset($_POST['MS'])) $calculadora->guardarMemoria();
            if (isset($_POST['sin'])) $calculadora->sin();
            if (isset($_POST['cos'])) $calculadora->con();
            if (isset($_POST['tan'])) $calculadora->tan();
            if (isset($_POST['x2'])) $calculadora->potencia2();
            if (isset($_POST['10x'])) $calculadora->potencia10();
            if (isset($_POST['Log'])) $calculadora->log();
            if (isset($_POST['Exp'])) $calculadora->exp();
            if (isset($_POST['pi'])) $calculadora->pi();
            if (isset($_POST['raiz'])) $calculadora->raiz();
            if (isset($_POST['factorial'])) $calculadora->factorial();
            if (isset($_POST['Mod'])) $calculadora->escribir("%");
            if (isset($_POST['signo'])) $calculadora->signo();
            if (isset($_POST['izquierdo'])) $calculadora->parentesisIzquierdo();
            if (isset($_POST['derecho'])) $calculadora->parentesisDerecho();

            $pantalla = $calculadora->getExpresion();
        }

        echo "
            <form action='#' method='post' name='calculadora'>
                <label for='pantalla'>Calculadora</label>
                <input type='text' id='pantalla' name='operacion' value='$pantalla' disabled/>

                <input type='submit' name='MC' value='MC'/>
                <input type='submit' name='MR' value='MR'/>
                <input type='submit' name='M+' value='M+'/>
                <input type='submit' name='M-' value='M-'/>
                <input type='submit' name='MS' value='MS'/>

                <input type='submit' name='x2' value='x2'/>
                <input type='submit' name='xy' value='xy'/>
                <input type='submit' name='sin' value='sin'/>
                <input type='submit' name='cos' value='cos'/>
                <input type='submit' name='tan' value='tan'/>

                <input type='submit' name='raiz' value='√'/>
                <input type='submit' name='10x' value='10x'/>
                <input type='submit' name='Log' value='Log'/>
                <input type='submit' name='Exp' value='Exp'/>
                <input type='submit' name='Mod' value='Mod'/>

                <input type='submit' name='flecha' value='↑'/>
                <input type='submit' name='CE' value='CE'/>
                <input type='submit' name='C' value='C'/>
                <input type='submit' name='B' value='B'/>
                <input type='submit' name='/' value='/'/>

                <input type='submit' name='pi' value='π'/>
                <input type='submit' name='7' value='7'/>
                <input type='submit' name='8' value='8'/>
                <input type='submit' name='9' value='9'/>
                <input type='submit' name='*' value='*'/>

                <input type='submit' name='factorial' value='n!'/>
                <input type='submit' name='4' value='4'/>
                <input type='submit' name='5' value='5'/>
                <input type='submit' name='6' value='6'/>
                <input type='submit' name='-' value='-'/>

                <input type='submit' name='signo' value='±'/>
                <input type='submit' name='1' value='1'/>
                <input type='submit' name='2' value='2'/>
                <input type='submit' name='3' value='3'/>
                <input type='submit' name='+' value='+'/>
                
                <input type='submit' name='izquierdo' value='('/>
                <input type='submit' name='derecho' value=')'/>
                <input type='submit' name='0' value='0'/>
                <input type='submit' name='punto' value='.'/>
                <input type='submit' name='=' value='='/>
            </form>";
    ?>
    <footer>
        <img src="media/HTML5.png" alt="HTML5 Válido!" />
        <img src="media/CSS3.png" alt="CSS3 Válido!"/>
    </footer>
</body>
</html>