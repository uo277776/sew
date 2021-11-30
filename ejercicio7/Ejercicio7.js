class JQuery{
    constructor(){
        this.result = 0.0;
    }

    mostrar(){
        $("h3").show();
    }

    ocultar(){
        $("h3").hide();
    }

    cambiarTexto(){
        $("#modificar").text(document.getElementById("texto").value);
    }

    añadirElemento(){
        var elemento = document.createElement(document.getElementById("elemento").value);
        elemento.innerHTML = document.getElementById("contenido").value;
        elemento.setAttribute("id", document.getElementById("id").value);
        $("#añadir").after(elemento);
    }

    borrarElemento(){
        $("#" + document.getElementById("borrarId").value).remove();
    }

    recorrerHTML(){
        $("*", document.body).each(function() {
            var etiquetaPadre = $(this).parent().get(0).tagName;
            $(this).before(document.createTextNode( "Etiqueta padre : <"  + etiquetaPadre + "> elemento : <" + $(this).get(0).tagName +"> valor: "));
        });
    }

    sumarTabla(){
        this.result = 0;
        $("table tr td").each(function(){
            query.result += parseFloat($(this).text());
        });
        var elemento = document.querySelector("input[value = 'Sumar Valores']");
        $(elemento).before("<p>La suma de los valores es " + this.result + "</p>");
    }
}

var query = new JQuery();