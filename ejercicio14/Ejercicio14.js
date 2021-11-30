class Dibujo{
    constructor(){
        this.img = new Image();
        this.canvas = document.getElementsByTagName("canvas")[0];
        this.contexto = this.canvas.getContext("2d");
        this.color = "WHITE";
        this.grosor = 2;
        this.xAnterior = 0;
        this.yAnterior = 0;
        this.xActual = 0;
        this.yActual = 0;
        this.haComenzadoDibujo = false;
    }

    screen(){
        if (this.canvas.requestFullscreen){
            this.canvas.requestFullscreen();
        }
    }
    mostrarImagen(){
        var canvas = document.getElementsByTagName("canvas")[0];
        var ctx = canvas.getContext('2d');
        var x = document.getElementById("x").value;
        var y = document.getElementById("y").value;
        ctx.drawImage(this.img, parseFloat(x), parseFloat(y));
        console.log("2");
        
    }
    getImage(){
        var imgAux = new Image();
        var file = document.querySelector('input[type=file]').files[0];
        var lector = new FileReader();
        lector.onload = function (evento) {
            console.log("1");
            imgAux.src = lector.result;
        }
        if (file) {
            lector.readAsDataURL(file);
        } else {
            
            img.src = "";
        }

        this.img = imgAux;
    }

    iniciarDibujo(evento){
        this.xAnterior = this.xActual;
        this.yAnterior = this.yActual;
        this.xActual = this.obtenerXReal(evento);
        this.yActual = this.obtenerYReal(evento);
        this.contexto.beginPath();
        this.contexto.fillStyle = this.color;
        this.contexto.fillRect(this.xActual, this.yActual, this.grosor, this.grosor);
        this.contexto.closePath();
        this.haComenzadoDibujo = true;
    }

    moverDibujo(evento){
        if (!this.haComenzadoDibujo) {
            return;
        }
        this.xAnterior = this.xActual;
        this.yAnterior = this.yActual;
        this.xActual = this.obtenerXReal(evento);
        this.yActual = this.obtenerYReal(evento);
        this.contexto.beginPath();
        this.contexto.moveTo(this.xAnterior, this.yAnterior);
        this.contexto.lineTo(this.xActual, this.yActual);
        this.contexto.strokeStyle = this.color;
        this.contexto.lineWidth = this.grosor;
        this.contexto.stroke();
        this.contexto.closePath();
    }

    finalizarDibujo(){
        this.haComenzadoDibujo = false;
    }

    obtenerXReal(evento){
        return evento.clientX - this.canvas.getBoundingClientRect().left
    }

    obtenerYReal(evento){
        return evento.clientY - this.canvas.getBoundingClientRect().top;
    }

    cambiarColor(){
        this.color = document.getElementById("color").value;
    }

    cambiarGrosor(){
        this.grosor = document.getElementById("grosor").value;
    }

}
var dibujo = new Dibujo();

document.addEventListener("mousedown", evento => {
    dibujo.iniciarDibujo(evento);
});

document.addEventListener("mousemove", (evento) => {
   dibujo.moverDibujo(evento);
});
["mouseup", "mouseout"].forEach(nombreDeEvento => {
    document.addEventListener(nombreDeEvento, () => {
        dibujo.finalizarDibujo();
    });
});
