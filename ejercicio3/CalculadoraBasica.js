class CalculadoraBasica{
    constructor(){
        this.operador = "";
        this.n1 = new Number(0);
        this.n2 = new Number(0);
    }

    setOperador(operador){
        this.operador = operador;
        this.n1 = new Number(document.getElementById("pantalla").value);
        document.getElementById("pantalla").value = "";
    }

    escribir(numero){
        document.getElementById("pantalla").value += numero;
    }

    calcular(){
        this.n2 = new Number(document.getElementById("pantalla").value);
        var expresion = this.n1 + this.operador + this.n2;
        try{
            document.getElementById("pantalla").value = eval(expresion);
        }
        catch(e){
            document.getElementById("pantalla").value = "ERROR";
        }
    }

    borrarTodo(){
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

var calculadora = new CalculadoraBasica();

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

