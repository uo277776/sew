class CalculadoraBasica{
    constructor(){
        this.operador = "";
        this.n1 = new Number(0);
        this.n2 = new Number(0);
    }

    setOperador(operador){
        this.operador = operador;
        this.n1 = new Number(document.getElementsByTagName("textarea")[0].textContent);
        document.getElementsByTagName("textarea")[0].textContent = "";
    }

    escribir(numero){
        document.getElementsByTagName("textarea")[0].textContent += numero;
    }

    calcular(){
        this.n2 = new Number(document.getElementsByTagName("textarea")[0].textContent);
        var expresion = this.n1 + this.operador + this.n2;
        try{
            document.getElementsByTagName("textarea")[0].textContent = eval(expresion);
        }
        catch(e){
            document.getElementsByTagName("textarea")[0].textContent = "ERROR";
        }
    }

    borrarTodo(){
        this.operador = "";
        this.numeroGuardado = 0;
        document.getElementsByTagName("textarea")[0].textContent = "";
    }

    guardarMemoria(){
        this.memoria = new Number(document.getElementsByTagName("textarea")[0].textContent);
    }

    sumarMemoria(){
        this.memoria += new Number(document.getElementsByTagName("textarea")[0].textContent);
    }

    restarMemoria(){
        this.memoria -= new Number(document.getElementsByTagName("textarea")[0].textContent);
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

