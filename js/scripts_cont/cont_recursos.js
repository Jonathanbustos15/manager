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

$("#btn_nuevocontrato").click(function() {
        $("#lbl_form_contrato").html("Nueva Hoja de Vida");
        $("#lbl_btn_actionHvida").html("Guardar <span class='glyphicon glyphicon-save'></span>");
        //$("#selectPosgrado").attr('hidden','');
        $("#btn_actionHvida").attr("data-action", "crear");
        $("#btn_actionHvida").attr('disabled', 'disabled');
        $("#frm_contrato_hvida").html("");
        $("#archivos_res").html("");
        $("#res_form").html("");
        arrEstudios.length = 0;
        validaBtnGuardar();
        $("#form_hvida")[0].reset();
        $("#form_contrato_estudios")[0].reset();
        $("form_archivo")[0].reset();
        $("form1")[0].reset();
    });


$(document).ready(function(){
        $("#fkID_cedula").change(function(){
                var op = $("#fkID_cedula option:selected").val();
                console.log(op);
                console.log("aqui toy");
        });
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



