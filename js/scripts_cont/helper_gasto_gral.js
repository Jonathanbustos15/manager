(function() {
    //helper para ingresos general
    self.id_empresa = 0;
    self.fechaaprobacion = '';
    self.selector_filtro = '';
    self.options_format = {
        symbol: "$",
        decimal: ",",
        thousand: ".",
        precision: 0,
        format: "%s%v"
    };
    self.remplazar = function(texto, buscar, nuevo) {
        var temp = '';
        var long = texto.length;
        for (j = 0; j < long; j++) {
            if (texto[j] == buscar) {
                temp += nuevo;
            } else temp += texto[j];
        }
        return temp;
    }
    //---------------------------------------------------------------------------------------------------
    self.cons_fecha_aprobacion_empresa = function() {
        var consulta_fecha = "select DISTINCT gasto_gral.fecha_aprobacion FROM gasto_gral WHERE fkID_empresa = " + id_empresa + " AND gasto_gral.fecha_aprobacion IS NOT NULL AND gasto_gral.fecha_aprobacion <> '0000-00-00' ORDER BY fecha_aprobacion DESC LIMIT 10";
        return $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + consulta_fecha + "&tipo=consulta_gen",
        }).done(function(data) {
            //------------------------------------------
            //this.paso_reciente = data.mensaje[0].idPaso2;		        
        }).fail(function() {
            console.log("error");
            //quita todo? o pone todo?
            //location.reload();
        }).always(function() {
            console.log("complete");
        });
        /*---------------------------------------------------*/
    }
    self.cons_fecha_aprobacion_funtecso = function() {
        var consulta_fecha = "select DISTINCT gasto_gral.fecha_aprobacion FROM gasto_gral WHERE fkID_empresa = 2 AND gasto_gral.fecha_aprobacion IS NOT NULL AND gasto_gral.fecha_aprobacion <> '0000-00-00' ORDER BY fecha_aprobacion DESC LIMIT 10";
        return $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + consulta_fecha + "&tipo=consulta_gen",
        }).done(function(data) {
            //------------------------------------------
            //this.paso_reciente = data.mensaje[0].idPaso2;		        
        }).fail(function() {
            console.log("error");
            //quita todo? o pone todo?
            //location.reload();
        }).always(function() {
            console.log("complete");
        });
        /*---------------------------------------------------*/
    }
    self.cons_fecha_aprobacion_empresa_todo = function() {
        var consulta_fecha = "select gasto_gral.* FROM gasto_gral WHERE gasto_gral.fecha_aprobacion IS NOT NULL";
        return $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + consulta_fecha + "&tipo=consulta_gen",
        }).done(function(data) {
            //------------------------------------------
            //this.paso_reciente = data.mensaje[0].idPaso2;		        
        }).fail(function() {
            console.log("error");
            //quita todo? o pone todo?
            //location.reload();
        }).always(function() {
            console.log("complete");
        });
        /*---------------------------------------------------*/
    }
    self.fill_fecha = function() {
        switch (id_empresa) {
            case (0):
                var data_fecha = cons_fecha_aprobacion_funtecso();
                data_fecha.success(function(data) {
                    console.log(data);
                    itera_fecha(data);
                });
                break;
            case ('Todo'):
                var fecha_todo = cons_fecha_aprobacion_empresa_todo();
                fecha_todo.success(function(data) {
                    console.log(data);
                    itera_fecha(data);
                });
                break;
            case (''):
                var fecha_todo = cons_fecha_aprobacion_empresa_todo();
                fecha_todo.success(function(data) {
                    console.log(data);
                    itera_fecha(data);
                });
                break;
            default:
                var data_fecha = cons_fecha_aprobacion_empresa();
                data_fecha.success(function(data) {
                    console.log(data);
                    itera_fecha(data);
                });
                break;
        }
    }
    self.itera_fecha = function(data) {
        $("#" + selector_filtro).html('');
        $("#" + selector_filtro).append('<option></option>');
        if (data.estado == "ok") {
            $("#" + selector_filtro).removeAttr('disabled');
            $.each(data.mensaje, function(index, val) {
                $("#" + selector_filtro).append('<option value="\'' + val.fecha_aprobacion + '\'">' + val.fecha_aprobacion + '</option>');
            });
        } else {
            $("#" + selector_filtro).html('');
            $("#" + selector_filtro).attr('disabled', 'true');
        };
    }
    //---------------------------------------------------------------------------------------------------
})();