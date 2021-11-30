class Lector{
    constructor(){

    }
    leerArchivoTexto(files) 
    { 
        var archivo = files[0];
        this.crearSection(archivo.name);
        this.añadirDatos(archivo);
            
        var tipoTexto = /text.*/;
        var tipoJson = /json.*/;
        if (archivo.type.match(tipoTexto) || archivo.type.match(tipoJson)) {
            var lector = new FileReader();
            $("#" + CSS.escape(archivo.name)).append("<p>Contenido del archivo: </p>");
            this.crearContenido(archivo.name);
            lector.readAsText(archivo);
            lector.onload = function (evento) {
                document.getElementById("contenido" + archivo.name).innerText = lector.result;
            }      
        } 
        else {
            $("#" + CSS.escape(archivo.name)).append("</p>Error : ¡¡¡ Archivo no válido !!!</p>");
        }
    }
    

    crearContenido(id){
        var p = "<p id = contenido" + id + "></p>";
        $("#" + CSS.escape(id)).append(p);
    }

    crearSection(nombre){
        var section = "<section id = " + nombre + "></section>"
        $("#selector").after(section);
    }

    añadirDatos(archivo){
        var nombre = "<h3>Nombre: " + archivo.name +"</h3>";
        $("#" + CSS.escape(archivo.name)).append(nombre);

        var tamaño = "<p> Tamaño: " + archivo.size + " bytes</p>";
        $("#" + CSS.escape(archivo.name)).append(tamaño);

        var tipo = "<p> Tipo: " + archivo.type + "</p>";
        $("#" + CSS.escape(archivo.name)).append(tipo);

        var fecha = "<p> Ultima modificacion: " + archivo.lastModifiedDate + "</p>";
        $("#" + CSS.escape(archivo.name)).append(fecha);
    }
}

var lector = new Lector();