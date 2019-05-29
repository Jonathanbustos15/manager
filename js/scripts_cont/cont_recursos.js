$(function() {
    //console.log('hola hojas');
    uppercaseForm("form_contrato");
    //---------------------------------------------------------
    //variable para el objeto del formulario
    var objt_f_hvida = {};
    //variable de accion del boton del formulario
    var action = "";
    //variable para el id del registro
    var id_hvida = "";
    var idEstudio = 0;
    var nomEstudio = "";
    var tipoEstudio = "";
    var arrEstudios = [];
    var arrEstudiosBusqueda = [];
    var arrHojaEstudios = [];
    //console.log('saludando desde las funciones hvida');
    var valoresArchivos = [];
    var arregloDeArchivos = [];
    var contDetailName = 0;
    var archCoincide = "";

$(document).ready(function(){
    $("#btn_nuevocontrato").click(function() {
        console.log("miremeee")
    });
    });


$(document).ready(function(){
        $("#fkID_cedula").change(function(){
                var op = $("#fkID_cedula option:selected").val();
                console.log(op);
                console.log("aqui toy");
        });
});

$("#btn_nuevocontrato").click(function() {
        console.log("miremeee")
    });


$(document).ready(function(){
        $("#fkID_cedula").change(function(){
            console.log("aqui toy");
        var url= '../controller/actualizar.php';
        console.log("aqui toy 2");
        $.getJSON(url, { _num1 : $("#fkID_cedula option:selected").val() }, function(clientes) {
        console.log("aqui toy");
        $.each(clientes, function(i,cliente){
        $("#nombrec").val(cliente.nombre);
        $("#apellidoc").val(cliente.apellido);
        $("#telefonoc").val(cliente.telefono);
        $("#emailc").val(cliente.email);
        $("#fkID_estadoc").val(cliente.empresa);
        console.log("aqui toy");
        });
        });
        });
        });



