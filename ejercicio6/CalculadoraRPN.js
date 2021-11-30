
class CalculadoraRPN{
    constructor(){
        this.pila = new Array();
        this.numero = new String();
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

class CalculadoraEspecializada extends CalculadoraRPN{
    constructor(){
        super();
        this.currentbase = 10;
    }

    base2(){
        if (this.currentbase == 10){
            var number = this.decimalToBinary(this.pila.pop());
            this.pila.push(number);
            this.mostrarPila();
            this.currentbase = 2;
        } else if (this.currentbase == 16){
            var number = this.decimalToBinary(this.hexadecimalToDecimal(this.pila.pop()));
            this.pila.push(number);
            this.mostrarPila();
            this.currentbase = 2;
        } else if (this.currentbase == 8){
            var number = this.decimalToBinary(this.octalToDecimal(this.pila.pop()));
            this.pila.push(number);
            this.mostrarPila();
            this.currentbase = 2;
        }
    }

    base10(){
        if (this.currentbase == 2){
            var number = this.binaryToDecimal(this.pila.pop());
            this.pila.push(number);
            this.mostrarPila();
            this.currentbase = 10;
        } else if (this.currentbase == 16){
            var number = this.hexadecimalToDecimal(this.pila.pop());
            this.pila.push(number);
            this.mostrarPila();
            this.currentbase = 10;
        } else if (this.currentbase == 8){
            var number = this.octalToDecimal(this.pila.pop());
            this.pila.push(number);
            this.mostrarPila();
            this.currentbase = 10;
        }
    }

    base8(){
        if (this.currentbase == 2){
            var number = this.decimalToOctal(this.binaryToDecimal(this.pila.pop()))
            this.pila.push(number);
            this.mostrarPila();
            this.currentbase = 8;
        } else if (this.currentbase == 10){
            var number = this.decimalToOctal(this.pila.pop());
            this.pila.push(number);
            this.mostrarPila();
            this.currentbase = 8;
        } else if (this.currentbase == 16){
            var number = this.decimalToOctal(this.hexadecimalToDecimal(this.pila.pop()))
            this.pila.push(number);
            this.mostrarPila();
            this.currentbase = 8;
        }
    }

    base16(){
        if (this.currentbase == 10){
            var number = this.decimalToHexadecimal(this.pila.pop());
            this.pila.push(number);
            this.mostrarPila();
            this.currentbase = 16;
        } else if (this.currentbase == 2){
            var number = this.decimalToHexadecimal(this.binaryToDecimal(this.pila.pop()));
            this.pila.push(number);
            this.mostrarPila();
            this.currentbase = 16;
        } else if (this.currentbase == 8){
            var number = this.decimalToHexadecimal(this.octalToDecimal(this.pila.pop()));
            this.pila.push(number);
            this.mostrarPila();
            this.currentbase = 16;
        }
    }

    decimalToBinary(number){
        return new Number(number.toString(2));
    }

    binaryToDecimal(number){
        return new Number(parseInt(number, 2));
    }

    decimalToHexadecimal(number){
        return number.toString(16);
    }

    hexadecimalToDecimal(number){
        return new Number(parseInt(number, 16));
    }

    decimalToOctal(number){
        return new Number(number.toString(8));
    }

    octalToDecimal(number){
        return new Number(parseInt(number, 8));
    }
}

var calculadora = new CalculadoraEspecializada();

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

