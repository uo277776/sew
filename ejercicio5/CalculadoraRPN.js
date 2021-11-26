
class CalculadoraRPN{
    constructor(){
        this.pila = new Array();
        this.numero = new String();
        this.puntoMarcado = false;
    }

    añadirNumero(valor){
        this.numero += valor;
    }

    punto(){
        if (!this.puntoMarcado){
            this.puntoMarcado = true;
            this.numero += ".";
            conselog
        }
        
    }

    apilar(){
        var numeroPush = new Number(this.numero);
        this.pila.push(numeroPush);
        this.mostrarPila();
        this.numero = new String();
        this.puntoMarcado = false;
    }

    sumar(){
        var suma = this.pila.pop() + this.pila.pop();
        this.pila.push(suma);
        this.mostrarPila();
    }

    restar(){
        var segundoOperando = this.pila.pop();
        var resta = this.pila.pop() - segundoOperando;
        this.pila.push(resta)
        this.mostrarPila();
    }

    mult(){
        var mult = this.pila.pop() * this.pila.pop();
        this.pila.push(mult);
        this.mostrarPila();
    }

    div(){
        var segundoOperando = this.pila.pop();
        var div = this.pila.pop() / segundoOperando;
        this.pila.push(div);
        this.mostrarPila();
    }

    sin(){
        this.pila.push(Math.sin(this.pila.pop()));
        this.mostrarPila();
    }

    cos(){
        this.pila.push(Math.cos(this.pila.pop()));
        this.mostrarPila();
    }

    tan(){
        this.pila.push(Math.cos(this.pila.pop()));
        this.mostrarPila();
    }

    arcsin(){
        this.pila.push(Math.asin(this.pila.pop()));
        this.mostrarPila();
    }

    arccos(){
        this.pila.push(Math.acos(this.pila.pop()));
        this.mostrarPila();
    }

    arctan(){
        this.pila.push(Math.atan(this.pila.pop()));
        this.mostrarPila();
    }

    borrar(){
        this.pila = new Array();
        this.numero = new String();
        this.mostrarPila();
        this.puntoMarcado = false;
    }
    mostrarPila(){
        var contador = 1;
        document.getElementsByTagName("textarea")[0].textContent = "";
        for(let i = this.pila.length - 1; i >= 0; i--){
            document.getElementsByTagName("textarea")[0].textContent += contador + ": " + this.pila[i] + "\n";
            contador++;
        }
    }
   

}

var calculadora = new CalculadoraRPN();

document.addEventListener('keydown', (event) =>{
    var keyName = event.key;
    if ((keyName >= 0 && keyName <= 9)){
        calculadora.añadirNumero(keyName);
    }
    if (keyName == '.'){
        calculadora.punto();
    }
    if (keyName == '+'){
        calculadora.sumar();
    }
    if (keyName == '-'){
        calculadora.restar();
    }
    if (keyName == '/'){
        calculadora.div();
    }
    if (keyName == '*'){
        calculadora.mult();
    }
    if (keyName == "Enter"){
        calculadora.apilar();
    }
    if (keyName == "Backspace"){
        calculadora.borrar();
    }
});

