class CalculadoraBasica{
    constructor(){
    }

    setOperador(operador){
        this.operador = operador;
        document.getElementById("pantalla").value = "";
    }

    escribir(numero){
        document.getElementById("pantalla").value += numero;
    }

    calcular(){
        var numeroNuevo = new Number(document.getElementById("pantalla").value);
        var expresion = this.numeroGuardado + this.operador + numeroNuevo
        if (this.operador == ""){
            expresion = numeroNuevo;
        }
        try{
            document.getElementById("pantalla").value = eval(expresion);
        }
        catch(e){
            document.getElementById("pantalla").value = "ERROR";
        }
        
    }

    borrarTodo(){
        this.parentesisAbiertos = 0;
        this.operador = "";
        this.numeroGuardado = 0;
        document.getElementById("pantalla").value = "";
    }

    guardarMemoria(){
        this.memoria = new Number(document.getElementById("pantalla").value);
    }

    sumarMemoria(){
        this.memoria += new Number(document.getElementById("pantalla").value);
    }

    restarMemoria(){
        this.memoria -= new Number(document.getElementById("pantalla").value);
    }
}

class CalculadoraCientifica extends CalculadoraBasica{
    constructor(){
        super();
        this.parentesisAbiertos = 0;
        this.shift = false;
    }

    borrarMemoria(){
        this.memoria = new Number(0);
    }

    recuperarMemoria(){
        document.getElementById("pantalla").value = this.memoria;
    }
    borrar(){
        document.getElementById("pantalla").value = "";
    }

    borrarUltimo(){
        var contenido = document.getElementById("pantalla").value;
        document.getElementById("pantalla").value = contenido.substring(0, contenido.length - 1);
    }

    coseno(){
        var numero = new Number(document.getElementById("pantalla").value);
        if (this.shift){
            document.getElementById("pantalla").value = Math.acos(numero);
        } else{
            document.getElementById("pantalla").value = Math.cos(numero);
        }
        
    }

    seno(){
        var numero = new Number(document.getElementById("pantalla").value);
        if (this.shift){
            document.getElementById("pantalla").value = Math.asin(numero);
        } else{
            document.getElementById("pantalla").value = Math.sin(numero);
        }
    }

    tangente(){
        var numero = new Number(document.getElementById("pantalla").value);
        if (this.shift){
            document.getElementById("pantalla").value = Math.atan(numero);
        } else{
            document.getElementById("pantalla").value = Math.tan(numero);
        }
    }

    potencia2(){
        var numero = new Number(document.getElementById("pantalla").value);
        if (this.shift){
            document.getElementById("pantalla").value = Math.pow(numero,3);
        } else{
            document.getElementById("pantalla").value = Math.pow(numero,2);
        }
    }

    potencia10(){
        var numero = new Number(document.getElementById("pantalla").value);
        document.getElementById("pantalla").value = Math.pow(10, numero);
    }

    log(){
        var numero = new Number(document.getElementById("pantalla").value);
        document.getElementById("pantalla").value = Math.log(numero);
    }

    exp(){
        var numero = new Number(document.getElementById("pantalla").value);
        document.getElementById("pantalla").value = Math.exp(numero);
    }

    parentesisIzquierdo(){
        this.parentesisAbiertos++;
        document.getElementById("pantalla").value += "(";
    }

    parentesisDerecho(){
        if (this.parentesisAbiertos > 0){;
            this.parentesisAbiertos--;
            document.getElementById("pantalla").value += ")";
        }
    }

    setOperador(operador){
        if (this.parentesisAbiertos > 0){
            document.getElementById("pantalla").value += operador;
        } else{
            this.numeroGuardado = new Number(eval(document.getElementById("pantalla").value));
            super.setOperador(operador);
        }
    }

    pi(){
        document.getElementById("pantalla").value = Math.PI;
    }

    raiz(){
        var numero = new Number(document.getElementById("pantalla").value);
        document.getElementById("pantalla").value = Math.sqrt(numero);
    }

    factorial(){
        var numero = new Number(document.getElementById("pantalla").value);
        let fact = 1;
        for(let i = numero; i>0; i--){
            fact *= i;
        }
        document.getElementById("pantalla").value = fact;
    }

    negativo(){
        var contenido = document.getElementById("pantalla").value;
        if (contenido.charAt(0) != '-'){
            document.getElementById("pantalla").value = "-" + contenido;
        } else{
            document.getElementById("pantalla").value = contenido.substring(1, contenido.length);
        }
    }

    activarShift(){
        if (!this.shift){
            document.getElementById("bpotencia").value = "x3";
            document.getElementById("bsin").value = "ArcSin";
            document.getElementById("bcos").value = "ArcCos";
            document.getElementById("btan").value = "ArcTan";
            this.shift = true;
        } else{
            document.getElementById("bpotencia").value = "x2";
            document.getElementById("bsin").value = "Sin";
            document.getElementById("bcos").value = "Cos";
            document.getElementById("btan").value = "Tan";
            this.shift = false;
        }
    }
}

var calculadora = new CalculadoraCientifica();

document.addEventListener('keydown', (event) =>{
    var keyName = event.key;
    if ((keyName >= 0 && keyName <= 9) || keyName == '.' ){
        calculadora.escribir(keyName);
    }
    if (keyName == '+' || keyName == '-' || keyName == '/' || keyName == '*'){
        calculadora.setOperador(keyName);
    }
    if (keyName == '=' || keyName == "Enter"){
        calculadora.calcular();
    }
    if (keyName == "Backspace"){
        calculadora.borrarTodo();
    }
    
});