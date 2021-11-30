class Meteo {
    constructor(){
        this.apikey = "6d67d0724246af98877ee910916ddd14";
        this.ciudades = ["Oviedo", "Gijón", "Llanes", "Topas", "Salamanca"];
        this.codigoPais = "ES";
        this.tipo = "&mode=xml";
        this.unidades = "&units=metric";
        this.idioma = "&lang=es";
        this.ciudad = "Oviedo";
        this.url = "https://api.openweathermap.org/data/2.5/weather?q=" + this.ciudad + this.tipo + this.unidades + this.idioma + "&APPID=" + this.apikey;
    }
    cargarDatos(ciudad){
        $.ajax({
            dataType: "xml",
            url: this.url,
            method: 'GET',
            success: function(datos){
                
                var ciudad                = $('city',datos).attr("name");
                var longitud              = $('coord',datos).attr("lon");
                var latitud               = $('coord',datos).attr("lat");
                var pais                  = $('country',datos).text();
                var amanecer              = $('sun',datos).attr("rise");
                var minutosZonaHoraria    = new Date().getTimezoneOffset();
                var amanecerMiliSeg1970   = Date.parse(amanecer);
                    amanecerMiliSeg1970  -= minutosZonaHoraria * 60 * 1000;
                var amanecerLocal         = (new Date(amanecerMiliSeg1970)).toLocaleTimeString("es-ES");
                var oscurecer             = $('sun',datos).attr("set");          
                var oscurecerMiliSeg1970  = Date.parse(oscurecer);
                    oscurecerMiliSeg1970  -= minutosZonaHoraria * 60 * 1000;
                var oscurecerLocal        = (new Date(oscurecerMiliSeg1970)).toLocaleTimeString("es-ES");
                var temperatura           = $('temperature',datos).attr("value");
                var temperaturaMin        = $('temperature',datos).attr("min");
                var temperaturaMax        = $('temperature',datos).attr("max");
                var humedad               = $('humidity',datos).attr("value");
                var presion               = $('pressure',datos).attr("value");
                var velocidadViento       = $('speed',datos).attr("value");
                var direccionViento       = $('direction',datos).attr("value");
                var nubosidad             = $('clouds',datos).attr("value");
                var visibilidad           = $('visibility',datos).attr("value");
                var icono                 = $('weather',datos).attr("icon");
                
                var stringDatos = "<tr><td>" + ciudad + "</td>";
                    stringDatos += "<td>" + pais + "</td>";
                    stringDatos += "<td>" + longitud + "</td>";
                    stringDatos += "<td>" + latitud + "</td>";
                    stringDatos += "<td>" + temperatura + "</td>";
                    stringDatos += "<td>" + temperaturaMax + "</td>";
                    stringDatos += "<td>" + temperaturaMin + "</td>";
                    stringDatos += "<td>" + presion +"</td>";
                    stringDatos += "<td>" + humedad + "%</td>";
                    stringDatos += "<td>" + amanecerLocal + "</td>";
                    stringDatos += "<td>" + oscurecerLocal + "</td>";
                    stringDatos += "<td>" + direccionViento + "</td>";
                    stringDatos += "<td>" + velocidadViento + "</td>";
                    stringDatos += "<td>" + visibilidad + " metros</td>";
                    stringDatos += "<td>" + nubosidad + "%</td>";
                    stringDatos += "<td><img src = 'https://openweathermap.org/img/w/" + icono + ".png'/></td></tr>"
                    
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
        $("footer").before(elemento);
    }
    
    verXML(){
        this.crearTabla();
        for(let i = 0; i < this.ciudades.length; i++){
            this.ciudad = this.ciudades[i];
            this.url = "https://api.openweathermap.org/data/2.5/weather?q=" + this.ciudad + this.tipo + this.unidades + this.idioma + "&APPID=" + this.apikey;
            this.cargarDatos(this.ciudad);
            $("button").attr("disabled","disabled");
        }
       
    }
}
var meteo = new Meteo();