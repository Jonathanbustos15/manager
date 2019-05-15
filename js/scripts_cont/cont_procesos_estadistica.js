$(function(){

	console.log("Hola desde estadistica procesos...");	

	//-------------------------------------------------------
	//rango de fecha

	//calendario para la fecha de cierre
	var dateFormat = "yy-mm-dd",
      from = $("#fecha_ini_est")
        .datepicker({
          defaultDate: "+1w",
          dateFormat: "yy-mm-dd",
          //changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
           
          to.datepicker( "option", "minDate", getDate( this ) );

        }),
      to = $( "#fecha_fin_est" ).datepicker({
        defaultDate: "+1w",
        dateFormat: "yy-mm-dd",
        //changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date_range;
      try {
        date_range = $.datepicker.parseDate( dateFormat, element.value );
        
      } catch( error ) {
      	
        date_range = null;
      }
 
      return date_range;
    }
	//-------------------------------------------------------

	//-------------------------------------------------------
	//funcion que retorne todos los procesos
	
	$("#btn_cons_est").click(function(){
		
		/**/
		var objt_estadistica = {

			"arr_filtros" :[

			{
				"nombre":"Para presentar",
				"filtro":"procesos.fkID_estado = 2 AND procesos.fkID_paso_actual = 6"
			},
			{
				"nombre":"Borrador",
				"filtro":"procesos.fkID_estado = 1"
			},
			{
				"nombre":"Entregados",
				"filtro":"procesos.fkID_paso_actual = 9"
			},
			{
				"nombre":"No Entregados",
				"filtro":"procesos.fkID_paso_actual = 10"
			},
			{
				"nombre":"Perdidos",
				"filtro":"procesos.fkID_paso_actual = 11"
			},
			{
				"nombre":"Ganados",
				"filtro":"procesos.fkID_paso_actual = 12"
			},
			{
				"nombre":"Descartados",
				"filtro":"procesos.fkID_paso_actual = 7"
			},
			/**/
			{
				"nombre":"Creado/Abierto",
				"filtro":"procesos.fkID_paso_actual = 1 AND procesos.fkID_estado != 1"
			},
			{
				"nombre":"Revisión/Abierto",
				"filtro":"procesos.fkID_estado = 2 AND procesos.fkID_paso_actual = 5"
			},

			],
			"rango_fechas" : ["fecha_cierre BETWEEN '"+$("#fecha_ini_est").val()+"' AND '"+$("#fecha_fin_est").val()+"' "]
		};

		//limpia el div
		$("#div-estadistica-procesos").html("");

		
		if ($("#fecha_ini_est").val() == "" || $("#fecha_fin_est").val() == "") {

			alert("Debe seleccionar un rango de fechas válido.");

		} else {

			var ciclo_estd = $.each(objt_estadistica.arr_filtros, function( index, value ) {

			  	estadistica.filtro = value.filtro;
				estadistica.rango_fechas = objt_estadistica.rango_fechas[0];
				estadistica.nombre = value.nombre;

				estadistica.set_estadistica();

			});

			$.when(ciclo_estd).then(estd_ok);

			function estd_ok () {
				// body...
				console.log("Terminó de pintar las estadísticas!");
				estadistica.calcular_100();
			}

		};

		return false;
	});
	//-------------------------------------------------------

});