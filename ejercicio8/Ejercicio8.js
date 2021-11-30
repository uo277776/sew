class Meteo {
    constructor(){
        this.apikey = "6d67d0724246af98877ee910916ddd14";
        this.ciudades = ["Gijon", "Oviedo", "Llanes", "Topas", "Salamanca"];
        this.codigoPais = "ES";
        this.unidades = "&units=metric";
        this.idioma = "&lang=es";
        this.ciudad = "Gijon";
        this.url = "http://api.openweathermap.org/data/2.5/weather?q=" + this.ciudad + "," + this.codigoPais + this.unidades + this.idioma + "&APPID=" + this.apikey;
    }

    cargarDatos(ciudad){
        $.ajax({
            dataType: "json",
            url: this.url,
            method: 'GET',
            success: function(datos){
                    var stringDatos = "<tr><td>" + datos.name + "</td>";
                        stringDatos += "<td>" + datos.sys.country + "</td>";
                        stringDatos += "<td>" + datos.coord.lat + "</td>";
                        stringDatos += "<td>" + datos.coord.lon + "</td>";
                        stringDatos += "<td>" + datos.main.temp + "</td>";
                        stringDatos += "<td>" + datos.main.temp_max + "</td>";
                        stringDatos += "<td>" + datos.main.temp_min + "</td>";
                        stringDatos += "<td>" + datos.main.pressure + "</td>";
                        stringDatos += "<td>" + datos.main.humidity + " %</td>";
                        stringDatos += "<td>" + new Date(datos.sys.sunrise *1000).toLocaleTimeString() + "</td>";
                        stringDatos += "<td>" + new Date(datos.sys.sunset *1000).toLocaleTimeString() + "</td>";
                        stringDatos += "<td>" + datos.wind.deg + "</td>";
                        stringDatos += "<td>" + datos.wind.speed + "</td>";
                        stringDatos += "<td>" + datos.visibility + " metros</td>";
                        stringDatos += "<td>" + datos.clouds.all + "%</td>";
                        stringDatos += "<td><img src='https://openweathermap.org/img/w/" + datos.weather[0].icon + ".png'/></td></tr>";
                    
                    $("table").append(stringDatos);
                },
            error:function(){
                $("button").after("<p>Error con la obtencion de los datos</p>");
            }
        });
    }
    crearTabla(){
        var elemento = document.createElement("table");
        elemento.innerHTML="<tr><th>Ciudad</th><th>Pais</th><th>Latitud</th><th>Longitud</th><th>Temperatura</th><th>Maxima</th><th>Minima</th>" +
       "<th>Presion</th><th>Humedad</th><th>Amanecer</th><th>Anochecer</th><th>Direccion</th><th>Velocidad</th><th>Visibilidad</th><th>Nubosidad</th><th>Icono</th></tr>";
        $("button").after(elemento);
    }
    verJSON(){
        this.crearTabla();
        for(let i = 0; i < this.ciudades.length; i++){
            this.ciudad = this.ciudades[i];
            this.url = "http://api.openweathermap.org/data/2.5/weather?q=" + this.ciudad + "," + this.codigoPais + this.unidades + this.idioma + "&APPID=" + this.apikey;
            this.cargarDatos(this.ciudad);
        }
        $("button").attr("disabled","disabled");
    }
}
var meteo = new Meteo();