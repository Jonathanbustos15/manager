//------------------------------------------------------------------------------------------------------------
        //paginación

        //tomar el nombre o el id de la tabla
        //pasarlo como parámetro

        var nombre_tabla = $('table').attr('id');

        console.log("El id de la tabla es: "+nombre_tabla);


        switch(nombre_tabla) {

                case 'tbl_proceso':
                    //----------------------------------------------
                    var table = $('#'+nombre_tabla).DataTable(

                        {
                            //"order": [[ 1, "asc" ]], //ordenando por nombre asc
                            "pagingType": "full_numbers",
                            "lengthMenu": [[-1, 50], ["Todo", 50]],

                            "language": {
                                "lengthMenu":     "Mostrando _MENU_ registros",
                                "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                                "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                                "search":         "Buscar:",
                                "loadingRecords": "Cargando...",
                                "processing":     "Procesando...",
                                "zeroRecords": "No hay registros que coincidan.",
                                "infoEmpty": "No se encuentran registros.",
                                "infoFiltered":   "(Filtrando _MAX_ registros en total)",
                                //------------------------------------------------------------------
                                //paginador
                                "paginate": {
                                    "first":      "<--",
                                    "last":       "-->",
                                    "next":       ">",
                                    "previous":   "<"
                                },
                                "aria": {
                                    "sortAscending":  ": activate to sort column ascending",
                                    "sortDescending": ": activate to sort column descending"
                                },
                                //------------------------------------------------------------------
                                // 

                            },
                            //"ordering": false
                            "order": [[1, 'asc'],[2, 'desc']]
                        }

                    );
                    break;                             
                    //----------------------------------------------
                case 'tbl_gastos_gral':
                    //----------------------------------------------
                    var table = $('#'+nombre_tabla).DataTable(

                        {
                            //"order": [[ 1, "asc" ]], //ordenando por nombre asc
                            "pagingType": "full_numbers",
                            "lengthMenu": [[-1, 50], ["Todo", 50]],

                            "language": {
                                "lengthMenu":     "Mostrando _MENU_ registros",
                                "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                                "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                                "search":         "Buscar:",
                                "loadingRecords": "Cargando...",
                                "processing":     "Procesando...",
                                "zeroRecords": "No hay registros que coincidan.",
                                "infoEmpty": "No se encuentran registros.",
                                "infoFiltered":   "(Filtrando _MAX_ registros en total)",
                                //------------------------------------------------------------------
                                //paginador
                                "paginate": {
                                    "first":      "<--",
                                    "last":       "-->",
                                    "next":       ">",
                                    "previous":   "<"
                                },
                                "aria": {
                                    "sortAscending":  ": activate to sort column ascending",
                                    "sortDescending": ": activate to sort column descending"
                                },
                                //------------------------------------------------------------------
                                // 

                            },
                            //"ordering": false
                            "order": []
                        }

                    );
                    break;

                    case 'tbl_repositorio':
                        //----------------------------------------------
                        var table = $('#'+nombre_tabla).DataTable(

                            {
                                //"order": [[ 1, "asc" ]], //ordenando por nombre asc
                                "pagingType": "full_numbers",
                                "lengthMenu": [[-1, 50], ["Todo", 50]],

                                "language": {
                                    "lengthMenu":     "Mostrando _MENU_ registros",
                                    "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                                    "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                                    "search":         "Buscar:",
                                    "loadingRecords": "Cargando...",
                                    "processing":     "Procesando...",
                                    "zeroRecords": "No hay registros que coincidan.",
                                    "infoEmpty": "No se encuentran registros.",
                                    "infoFiltered":   "(Filtrando _MAX_ registros en total)",
                                    //------------------------------------------------------------------
                                    //paginador
                                    "paginate": {
                                        "first":      "<--",
                                        "last":       "-->",
                                        "next":       ">",
                                        "previous":   "<"
                                    },
                                    "aria": {
                                        "sortAscending":  ": activate to sort column ascending",
                                        "sortDescending": ": activate to sort column descending"
                                    },
                                    //------------------------------------------------------------------
                                    // 

                                },
                                //"ordering": false
                                "order": []
                            }

                        );
                    break;
                    case 'tbl_detail_repositorio':
                        //----------------------------------------------
                        var table = $('#'+nombre_tabla).DataTable(

                            {
                                //"order": [[ 1, "asc" ]], //ordenando por nombre asc
                                "pagingType": "full_numbers",
                                "lengthMenu": [[-1, 50], ["Todo", 50]],

                                "language": {
                                    "lengthMenu":     "Mostrando _MENU_ registros",
                                    "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                                    "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                                    "search":         "Buscar:",
                                    "loadingRecords": "Cargando...",
                                    "processing":     "Procesando...",
                                    "zeroRecords": "No hay registros que coincidan.",
                                    "infoEmpty": "No se encuentran registros.",
                                    "infoFiltered":   "(Filtrando _MAX_ registros en total)",
                                    //------------------------------------------------------------------
                                    //paginador
                                    "paginate": {
                                        "first":      "<--",
                                        "last":       "-->",
                                        "next":       ">",
                                        "previous":   "<"
                                    },
                                    "aria": {
                                        "sortAscending":  ": activate to sort column ascending",
                                        "sortDescending": ": activate to sort column descending"
                                    },
                                    //------------------------------------------------------------------
                                    // 

                                },
                                //"ordering": false
                                "order": []
                            }

                        );
                    break;                             
                    //----------------------------------------------              
                default:
                    //----------------------------------------------
                    var table = $('.table').DataTable(

                        {
                            //"order": [[ 1, "asc" ]], //ordenando por nombre asc
                            "pagingType": "full_numbers",
                            "lengthMenu": [[-1, 50], ["Todo", 50]],

                            "language": {
                                "lengthMenu":     "Mostrando _MENU_ registros",
                                "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                                "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                                "search":         "Buscar:",
                                "loadingRecords": "Cargando...",
                                "processing":     "Procesando...",
                                "zeroRecords": "No hay registros que coincidan.",
                                "infoEmpty": "No se encuentran registros.",
                                "infoFiltered":   "(Filtrando _MAX_ registros en total)",
                                //------------------------------------------------------------------
                                //paginador
                                "paginate": {
                                    "first":      "<--",
                                    "last":       "-->",
                                    "next":       ">",
                                    "previous":   "<"
                                },
                                "aria": {
                                    "sortAscending":  ": activate to sort column ascending",
                                    "sortDescending": ": activate to sort column descending"
                                },
                                //------------------------------------------------------------------
                                // "order": [[0, 'desc']]

                            },                            
                            //"ordering": false
                            "order": []
                        }

                    );
                    //----------------------------------------------
            }

        

        setTimeout(function(){

            //------------------------------------------------------
            //switch para ordenamiento tbl_proceso

            switch(nombre_tabla) {

                case 'tbl_hvida':
                    //----------------------------------------------
                    table.order( [ 1, 'asc' ] ).draw();
                    break;
                    //----------------------------------------------
                case 'tbl_conte':
                    //----------------------------------------------
                    table.order( [ 2, 'asc' ] ).draw();
                    break;
                    //----------------------------------------------    
                case 'tbl_formatos':
                    //----------------------------------------------
                    table.page.len( 10 ).draw();
                    //table.order( [ 0, 'asc' ] ).draw();
                    break;
                    //----------------------------------------------
                case 'tbl_proyectos':
                    //----------------------------------------------
                    table.page.len( 10 ).draw();
                    table.order( [ 1, 'desc' ] ).draw();
                    break;
                    //----------------------------------------------
                case 'tbl_proceso':
                    //----------------------------------------------                                                    

                    table.page.len( 10 ).draw();
                    //table.order( [ , '' ] ).draw();
                    break;
                    //----------------------------------------------
                case 'tbl_gastos_gral':
                    //table.column( 0 ).visible( false );
                    table.page.len( 50 ).draw();
                    //table.order( [ 0, 'desc' ] ).draw();
                    break;
                case 'tbl_repositorio':
                    //table.column( 0 ).visible( false );
                    table.page.len( 10 ).draw();
                    //table.order( [ 0, 'desc' ] ).draw();
                    break;
                case 'tbl_detail_repositorio':
                    //table.column( 0 ).visible( false );
                    table.page.len( 10 ).draw();
                    //table.order( [ 0, 'desc' ] ).draw();
                    break;

                default:
                    //----------------------------------------------
                    
                    table.page.len( 50 ).draw();
                    //table.order( [ 0, 'desc' ] ).draw();
                    //table.column( 0 ).visible( false ); 
                    //----------------------------------------------
            }
            //------------------------------------------------------

        }, 1000);

        //tbl_proyectos
        if (nombre_tabla == 'tbl_proyectos') {
            table
            .column( '8:visible' )
            .order( 'asc' )
            .draw();

            //--------------------------------
            table.column( 4 ).visible( false );
            table.column( 5 ).visible( false );
            table.column( 7 ).visible( false );
            table.column( 8 ).visible( false );
        };

        //tbl_gastos_gral https://datatables.net/reference/api/column().visible()
        //Funciones especiales tabla gastos general

        if (nombre_tabla == 'tbl_gastos_gral'){
            
            function detallesGastoGral(ver){

                //console.log('Ejecutando como '+ver)
                
                table.column( 4 ).visible( ver );
                table.column( 6 ).visible( ver );
                table.column( 7 ).visible( ver );
                table.column( 8 ).visible( ver );
                table.column( 9 ).visible( ver );
                table.column( 10 ).visible( ver ); 
            }

            detallesGastoGral(false);

            $("#tbl_gastos_gral_length").append('&nbsp&nbsp&nbsp&nbsp&nbsp<button id="btn_detallesIngGral" data-ver="true" class="btn"><span id="span_detallesIngGral" class="glyphicon glyphicon-plus"></span> Detalles</button>')        
            //$("#tbl_ingresos_gral_filter").insertBefore('selector')

            //var verButtonData = '';

            

            $("#btn_detallesIngGral").click(function(event) {
                

                verButtonData = $(this).data('ver');

                //console.log(verButtonData)
                
                //$(this).data('ver','false');

                if (verButtonData == true) {
                    
                    
                    $("#span_detallesIngGral").attr('class', 'glyphicon glyphicon-minus');
                    //$(this).attr('data-ver','false');
                    $(this).data('ver',false);
                    detallesGastoGral(verButtonData);

                } else {
                    
                    
                    $("#span_detallesIngGral").attr('class', 'glyphicon glyphicon-plus');
                    //$(this).attr('data-ver','true');
                    $(this).data('ver',true);
                    detallesGastoGral(verButtonData);

                };

            });   

            //----------------------------------------------------------------------------
            //           
            //----------------------------------------------------------------------------
            
        };

                 //---------------------------------------------------------------------------
            //opciones especiales tabla hoja de vida

        if (nombre_tabla == 'tbl_hvida'){

            function detallesHvida(ver){

                //console.log('Ejecutando como '+ver)

                table.column( 3 ).visible( ver );
                table.column( 4 ).visible( ver );
                table.column( 5 ).visible( ver ); 
                table.column( 6 ).visible( ver );
                table.column( 7 ).visible( ver );               
            }

            detallesHvida(false);


            $("#tbl_hvida_length").append('&nbsp&nbsp&nbsp&nbsp&nbsp<button id="btn_detallesHvida" data-ver="true" class="btn"><span id="span_detallesHvida" class="glyphicon glyphicon-plus"></span> Detalles</button>')        
            //$("#tbl_ingresos_gral_filter").insertBefore('selector')

            //var verButtonData = '';

            $("#btn_detallesHvida").click(function(event) {
                /* Act on the event */

                verButtonData = $(this).data('ver');

                //console.log(verButtonData)
                
                //$(this).data('ver','false');

                if (verButtonData == true) {
                    
                    
                    $("#span_detallesHvida").attr('class', 'glyphicon glyphicon-minus');
                    //$(this).attr('data-ver','false');
                    $(this).data('ver',false);
                    detallesHvida(verButtonData);

                } else {
                                        
                    $("#span_detallesHvida").attr('class', 'glyphicon glyphicon-plus');
                    //$(this).attr('data-ver','true');
                    $(this).data('ver',true);
                    detallesHvida(verButtonData);

                };

            });
        };        
        
        if (nombre_tabla == 'tbl_conte'){

            function detallescontrato(ver){

                //console.log('Ejecutando como '+ver)

                table.column( 3 ).visible( ver );
                table.column( 4 ).visible( ver );
                table.column( 5 ).visible( ver ); 
                table.column( 6 ).visible( ver );
                table.column( 7 ).visible( ver );               
            }

            detallescontrato(false);


            $("#tbl_contrato_length").append('&nbsp&nbsp&nbsp&nbsp&nbsp<button id="btn_detallescontrato" data-ver="true" class="btn"><span id="span_detallescontrato" class="glyphicon glyphicon-plus"></span> Detalles</button>')        
            //$("#tbl_ingresos_gral_filter").insertBefore('selector')

            //var verButtonData = '';

            $("#btn_detallescontrato").click(function(event) {
                /* Act on the event */

                verButtonData = $(this).data('ver');

                //console.log(verButtonData)
                
                //$(this).data('ver','false');

                if (verButtonData == true) {
                    
                    
                    $("#span_detallescontrato").attr('class', 'glyphicon glyphicon-minus');
                    //$(this).attr('data-ver','false');
                    $(this).data('ver',false);
                    detallescontrato(verButtonData);

                } else {
                                        
                    $("#span_detallescontrato").attr('class', 'glyphicon glyphicon-plus');
                    //$(this).attr('data-ver','true');
                    $(this).data('ver',true);
                    detallescontrato(verButtonData);

                };

            });
        };
