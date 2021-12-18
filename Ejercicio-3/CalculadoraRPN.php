<!DOCTYPE HTML>
<html lang="es">
<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <meta name="author" content="Alvaro Rodriguez Gonzalez"/>
    <meta name="description" content="Calculadora RPN"/>
    <meta name="keyworks" content="Calculadora, RPN, operacion, resta, suma"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora RPN</title>
    <link rel="stylesheet" type="text/css" href="CalculadoraRPN.css" />
</head>

<body>
    <h1>Calculadora RPN</h1>
    <?php
        session_start();
        class CalculadoraRPN{
            protected $numero;
            protected $pila;

            public function __construct(){
                $this->numero = "";
                $this->pila = array();
            }

            public function escribir($caracter){
                $this->numero .= $caracter;
            }

            public function apilar(){
                array_unshift($this->pila, $this->numero);
                $this->numero = "";
            }

            public function desapilar(){
                return array_shift($this->pila);
            }

            public function mostrarPila(){
                $contador = 1;
                $contenido = "";
                foreach($this->pila as $valor){
                    $contenido .=  $contador . ": " . $valor . "\n";
                    $contador += 1;
                }
                return $contenido;
            }

            public function borrarTodo(){
                $this->numero = "";
                $this->pila = array();
            }

            public function getNumero(){
                return $this->numero;
            }

            public function getPila(){
                return $this->pila;
            }

            public function sumar(){
                $suma = $this->desapilar() + $this->desapilar();
                array_unshift($this->pila, $suma);
            }

            public function restar(){
                $segundoOperando = $this->desapilar();
                $resta = $this->desapilar() - $segundoOperando;
                array_unshift($this->pila, $resta);
            }
        
            public function mult(){
                $mult = $this->desapilar() * $this->desapilar();
                array_unshift($this->pila, $mult);
            }
        
            public function div(){
                $segundoOperando = $this->desapilar();
                $div = $this->desapilar() / $segundoOperando;
                array_unshift($this->pila, $div);
            }

            public function sin(){
                array_unshift($this->pila, sin($this->desapilar()));
            }

            public function cos(){
                array_unshift($this->pila, cos($this->desapilar()));
            }

            public function tan(){
                array_unshift($this->pila, tan($this->desapilar()));
            }

            public function asin(){
                array_unshift($this->pila, asin($this->desapilar()));
            }

            public function acos(){
                array_unshift($this->pila, acos($this->desapilar()));
            }

            public function atan(){
                array_unshift($this->pila, atan($this->desapilar()));
            }
        
        }

        $pantalla = "";

        if (isset($_SESSION['RPN'])){
            $calculadora = $_SESSION['RPN'];
        } else{
            $calculadora = new CalculadoraRPN();
            $_SESSION['RPN'] = $calculadora;
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
            if (isset($_POST['punto'])) $calculadora->escribir('.');
            if (isset($_POST['Enter'])) $calculadora->apilar();
            if (isset($_POST['+'])) $calculadora->sumar();
            if (isset($_POST['-'])) $calculadora->restar();
            if (isset($_POST['*'])) $calculadora->mult();
            if (isset($_POST['/'])) $calculadora->div();
            if (isset($_POST['sin'])) $calculadora->sin();
            if (isset($_POST['cos'])) $calculadora->cos();
            if (isset($_POST['tan'])) $calculadora->tan();
            if (isset($_POST['asin'])) $calculadora->asin();
            if (isset($_POST['acos'])) $calculadora->acos();
            if (isset($_POST['atan'])) $calculadora->atan();

            if (isset($_POST['C'])){
                $calculadora->borrarTodo();
            }
            
            $pantalla = $calculadora->mostrarPila();

        }

        echo "
            <form action='#' method='post'> 
                <label for='pantalla'>Calculadora</label>
                <textarea id='pantalla' rows='10' disabled>$pantalla</textarea>
                <input type='submit' name='asin' value='ArcSin'/>
                <input type='submit' name='acos' value='ArcCos'/>
                <input type='submit' name='atan' value='ArcTan'/>
                <input type='submit' name='C' value='C'/>

                <input type='submit' name='sin' value='sin'/>
                <input type='submit' name='cos' value='cos'/>
                <input type='submit' name='tan' value='tan'/>
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

                <input type ='submit' name='0' value='0' >
                <input type ='submit' name='punto' value='.'/>
                <input type ='submit' name='Enter' value='Enter'/>
            </form>
        ";
    ?>
    
    <footer>
        <img src="media/HTML5.png" alt=" HTML5 Válido!" />
        <img src="media/CSS3.png" alt="CSS3 Válido!"/>
    </footer>
</body>
</html>