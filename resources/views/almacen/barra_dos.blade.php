@extends('layouts.app')
@section('titulo') Inventario - Barra Dos @endsection


@section('contenido')

<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300"><i>Inventario</i></span>&nbsp;&nbsp;Barra Dos 
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>                    
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="form-row">
                        <div class="col-md-2 mb-4">                           
                            <div class="form-group row">
                                <label class="col-form-label col-12 col-lg-2 form-label text-lg-right mr-2">Fecha:</label>
                                <div class="col-12 col-lg-9">
                                    <input style="width: 100px" type="text" id="fch" class="form-control form-control-sm" value="@php echo date('d-m-Y'); @endphp"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">                           
                            <button onclick="actualizar_tabla();" type="button" class="btn btn-primary btn-sm btn-block waves-effect waves-themed">ACTUALIZAR</button> 
                        </div>                                             
                    </div>
                                  
                    <div class="table-responsive">
                        <table id="tablaInvBarraDos" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>ID</th>
                                    <th>Inicial</th>
                                    <th>Unidad</th>                         
                                    <th>Descripcion prod.</th>
                                    <th>Entradas</th>  
                                    <th>Salidas</th> 
                                    <th>Stock</th>                                   
                                </tr>
                            </thead>                    
                        </table>                                             
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>
<script>  

$(function () { 
    $("#menu_alm_invent_barra").addClass("active open");
    $("#submenu_barra_2").addClass("active");  
    $('#fch').datepicker({
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: controls,
                    format: 'dd-mm-yyyy'
                });  

    var table = $('#tablaInvBarraDos').DataTable({
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "almacen-barra-dos?fch="+$("#fch").val(),        
        columns: [
            {data: 'id',visible: false, searchable: false},
            {data: 'inicial',className: 'text-center'},
            {data: 'unidad'},
            {data: 'des_pro'},
            {data: 'entradas',className: 'text-center'},   
            {data: 'salidas',className: 'text-center'},       
            {data: 'stock',className: 'text-center'},
        ],       
        dom: dom_buttons_table,
        buttons: [{
            extend: 'pdfHtml5',
            text: 'PDF',
            titleAttr: 'Generate PDF',
            className: 'btn-outline-danger btn-sm mr-1',
            exportOptions: {
                columns: [0,1,2,3,4,5,6]
            }
        },{
            extend: 'excelHtml5',
            text: 'Excel',
            titleAttr: 'Generate Excel',
            className: 'btn-outline-success btn-sm mr-1',
            exportOptions: {
                columns: [0,1,2,3,4,5,6]
            }
        }],
        lengthMenu: [ [50, 100, -1], [50, 100, "All"] ],
        language: espanol,
        ordering: false,
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            if ( aData.stock <= "5" ) {              
                $(nRow).find('td:eq(5)').css('color', 'red');
                $(nRow).find('td:eq(5)').css('font-weight', 'bold');
            }else{
                $(nRow).find('td:eq(5)').css('color', '#0082E8');
                $(nRow).find('td:eq(5)').css('font-weight', 'bold');
            }
        }
    });
    setTimeout(function(){
        if (table.rows().count()==0) {
            maquinge.notificaciones('Es necesario realizar Recarga de Inventarios.<br>* Ir a Menu Productos.', 'Sistema', 'error');
        }
    }, 500);
});

function actualizar_tabla(){

    $('#tablaInvBarraDos').DataTable().ajax.url("almacen-barra-dos?fch="+$("#fch").val()).load();

}



</script>
@endpush
