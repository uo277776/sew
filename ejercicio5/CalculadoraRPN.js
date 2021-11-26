
class CalculadoraRPN{
    constructor(){
        this.pila = new Array();
        this.numero = new String();
    }

    añadirNumero(valor){
        this.numero += valor;
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

    arccos(){
        this.pila.push(Math.acos(this.pila.pop()));
        this.mostrarPila();
    }

    arctan(){
        this.pila.push(Math.atan(this.pila.pop()));
        this.mostrarPila();
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

