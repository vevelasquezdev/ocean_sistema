
var maquinge = function () {
    return {
        validacionGeneral: function (id_form) {
            
            'use strict';
            window.addEventListener('load', function() {                    
                var forms = document.getElementsByClassName('needs-validation');
                
                var validation = Array.prototype.filter.call(forms, function(form)
                {
                    form.addEventListener.on('click', function(event)
                    {
                        if (form.checkValidity() === false)
                        {
                            event.preventDefault();
                            event.stopPropagation();
                            initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
                        }
                        form.classList.add('was-validated');                        
                    },false);
                });                
            }, false);              
           
        },
        notificaciones: function (mensaje, titulo, tipo) {            
            initApp.playSound(asset+'smartadmin/dist/media/sound', 'smallbox');    
            var shortCutFunction = tipo;
            var msg = mensaje;
            var title = titulo;
    
            toastr.options = {
                closeButton: true,
                newestOnTop: true,
                progressBar: true,
                preventDuplicates: true,
                onclick: null
            };
    
            toastr[shortCutFunction](msg, title);
        },
    }
}();

function llenarComboCurso(input, modalidad){    
    MsgDlgLoadAjaxInput(input);     
    modalidad = modalidad || "PERSONALIZADO";
    $('#' + input).prop('options').length = 1;
    $.ajax({
        url: 'get_curso_modalidad?modalidad=' + modalidad,
        type: 'GET',
        success: function (data) {
            for (i = 0; i <= data.length - 1; i++) {
                $('#' + input).append('<option value=' + data[i].id + '>' + data[i].curso+ ' --- S/. '+data[i].ct_venta+'.00' + '</option>');
            }           
        },
        error: function (error) {
            var errors = error.responseJSON;                        
            if (error.status === 500) {
                maquinge.notificaciones(errors.msg, 'Maquingenieros', 'error');
            }
        }           
    }).done(function(){        
        MsgDlgLoadAjaxFinish(input);
    });
}



function MsgDlgLoadAjaxInput(Dialogo){
    $('#'+Dialogo).parent().block({
        message:"<div class='d-flex justify-content-center'>"
        +    "<strong>.: Cargando :. ...</strong>" 
        +    "<div class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></div>"
        +"</div>",       
        css: { background: 'white', width: '62%', opacity:'0.6', 'margin-top':'2.7%'}  
    });
    
    $(".blockUI").css("background-color", "#d2d2d2");
    $(".blockUI").css("border", "0px");
}

function MsgDlgLoadAjaxForm(Dialogo){
    $('#'+Dialogo).parent().block({
        message:"<div class='d-flex justify-content-center'>"
        +    "<div class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></div>"
        +    "<strong>.: Cargando :. </strong>"
        +"</div>",       
        css: { background: 'white', width: '33%', opacity:'0.5', 'margin-top':'48%', 'margin-left':'35%'}  
    });
    $(".blockUI").css("border", "2px");
}


function MsgDlgLoadAjaxFinish(Dialogo){
    $('#'+Dialogo).parent().unblock();
}


function calculateEdad(input, birthday) {
    var birthday_arr = birthday.split("/");
    var birthday_date = new Date(birthday_arr[2], birthday_arr[1] - 1, birthday_arr[0]);
    var ageDifMs = Date.now() - birthday_date.getTime();
    var ageDate = new Date(ageDifMs);
    var edad = Math.abs(ageDate.getUTCFullYear() - 1970);
    $("#"+input).val(edad);
}


function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 45 && charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
    return true;
}


var dom_buttons_table = "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
"<'row'<'col-sm-12'tr>>" +
"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";

var espanol = {
    "processing": "Procesando...",
    "lengthMenu": "Mostrar _MENU_ &nbsp;&nbsp;&nbsp;",
    "zeroRecords": "No se encontraron resultados",
    "emptyTable": "Ningún dato disponible en esta tabla",
    "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "infoFiltered": "(filtrado de un total de _MAX_ registros)",               
    "infoThousands": ",",
    "loadingRecords": "Cargando...",
    "paginate": {
        "first": "Primero",
        "last": "Último",
        "next": "Siguiente",
        "previous": "Anterior"
    }
};
var exportbuttons = [                       
{
    extend: 'pdfHtml5',
    text: 'PDF',
    titleAttr: 'Generate PDF',
    className: 'btn-outline-danger btn-sm mr-1'
},
{
    extend: 'excelHtml5',
    text: 'Excel',
    titleAttr: 'Generate Excel',
    className: 'btn-outline-success btn-sm mr-1'
},
/*{
    extend: 'copyHtml5',
    text: 'Copy',
    titleAttr: 'Copy to clipboard',
    className: 'btn-outline-primary btn-sm mr-1'
},
 {
    extend: 'print',
    text: 'Print',
    titleAttr: 'Print Table',
    className: 'btn-outline-primary btn-sm'
} */
];