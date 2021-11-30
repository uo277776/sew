class Petrol {
    constructor(){
        this.cargado = false;
        this.precio = 0.0;
        this.precioLitro = 0.0;

        this.apikey = "caww4hi6o14pye0ymn22ux3lj49rqdup63w28il20t89t3ck59m0aiigvwur";
        this.endpoint = "latest";
        this.base = 'BRENTOIL';
        this.symbols = "EUR";
        this.url = "https://commodities-api.com/api/" + this.endpoint + "?access_key=" + this.apikey + "&base=" + this.base + "&symbols=" + this.symbols; 
    }
    
    cargarDatos(){
        $.ajax({
            url: this.url,
            dataType: "json",
            success: function(datos){
                    petrol.cargarJSON(datos);
                },
            error:function(){
                $("#divisa").after("<p>Error al cargar los precios</p>");
                }
        });
        
    }

    cargarJSON(datos){
        console
        if (this.symbols == "EUR"){
            this.precio = datos.data.rates.EUR;
        } else{
            this.precio = datos.data.rates.USD;
        }
        this.precioLitro = this.precio / 158.987304;
        var stringDatos = "<h2>Precios: </h2>";
        stringDatos += "<p>Dia de la medicion: " +  datos.data.date + "</p>";
        stringDatos += "<p>Precio del petroleo (" + this.symbols + "): " + this.precio + " por barril</p>";
        stringDatos += "<p>Precio del petroleo (" + this.symbols + "): " + this.precioLitro + " por litro</p>";
        $("#precios").html(stringDatos);
    }
    crearSection(){
        var elemento = document.createElement("section");
        elemento.id = "precios";
        $("#divisa").after(elemento);
    }

    verPrecios(){
        if (!this.cargado){
            this.crearSection();
            this.cargado = true;
        }
        this.cargarDatos(); 
    }

    cambiarDivisa(){
        if (this.symbols == "EUR"){
            this.symbols = "USD";
            this.url = "https://commodities-api.com/api/" + this.endpoint + "?access_key=" + this.apikey + "&base=" + this.base + "&symbols=" + this.symbols; 
            document.getElementById("divisa").value = "Cambiar a Euros";
        } else{
            this.symbols = "EUR"
            this.url = "https://commodities-api.com/api/" + this.endpoint + "?access_key=" + this.apikey + "&base=" + this.base + "&symbols=" + this.symbols; 
            document.getElementById("divisa").value = "Cambiar a Dolares";
        }
    }

    calcularEuros(){
        var litros = document.getElementById("nlitros").value;
        var total = this.precioLitro * litros;
        $("#litros").append("<h3>" + litros + " litros cuestan " + total.toFixed(2) + " " + this.getDivisa() +"</h3>");
    }

    calcularLitros(){
        var euros = document.getElementById("neuros").value;
        var total = euros / this.precioLitro;
        $("#euros").append("<h3>Con " + euros + " " + this.getDivisa() + " puede comprar " + total + " litros</h3>");
    }

    getDivisa(){
        if (this.symbols == "EUR"){
            return "euros";
        }
        return "dolares";
    }
}

var petrol = new Petrol();