@extends('layouts.app')
@section('titulo') Mesas @endsection


@section('contenido')

<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300"><i>Mesas</i></span>&nbsp;&nbsp;OceanClub
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10"
                        data-original-title="Minimizar"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                        data-offset="0,10" data-original-title="Maximizar"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="col-md-8 mb-3">
                        <label class="form-label" for="des_pro">Descripcion productos:<span
                                class="text-danger">*</span></label>
                        <input type="text" id="des_pro" name="des_pro" placeholder="Search" class="form-control text-uppercase" />
                        <input id="hidden_des_pro" id="hidden_des_pro" type="text" class="form-control text-uppercase" >

                    </div>
                    <div class="col-xl-12">
                        <!-- datatable start -->
                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                            <tfoot class="bg-primary-600">
                                <tr>
                                  <td></td>
                                  <td style="text-align: right">TOTAL: S/.</td>
                                  <td><input id="ttotal" value="000.00" type="text" class="form-control pl-1 pr-1" style="font-weight: bold;font-size: 20px; height: 25px;border: 0px; background: ghostwhite;color: #0960a5" readonly></td>
                                  <td></td>                                 
                                </tr>
                            </tfoot> 
                        </table>
                         
                        <!-- datatable end -->
                    </div>
                    <div class="col-xl-12">
                        <hr class="mt-5 mb-5">
                        <h5>Event <i>logs (AJAX Calls)</i></h5>
                        <div id="app-eventlog" class="alert alert-primary p-1 h-auto my-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@push('scripts')
<script src="https://cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script>

    $('#des_pro').typeahead({
        source: function(query, process) {
            objects = [];
            map = {};
            $.getJSON('productos/'+query, null,function ( jsonData ){
                $.each(jsonData, function(i, object) {
                    map[object.label] = object;
                    objects.push(object.label);
                });
                process(objects);
            });
        
            // var data = [{"id":1,"label":"machin"},{"id":2,"label":"truc"}]
        },
        updater: function(item) {
            $('#hidden_des_pro').val(map[item].id);
            return item;
        }
    }); 

    var events = $("#app-eventlog");

// Column Definitions
var columnSet = [
{
    title: "Cantidad",
    id: "it_cant",
    data: "cant",
    type: "text",    
    errorMsg: "*Cantidad inválida.",
    defaultValue: "1"    
},{
    title: "Descripcion",
    id: "des_pro",
    data: "des_pro",
    type: "text",    
    errorMsg: "*Descripcion es requerida." 
    
},{
    title: "Precio",
    id: "pre_pro",
    data: "pre_pro",
    type: "number",
    placeholderMsg: "0.00",
},{
    title: "Estado",
    id: "estado",
    data: "estado",
    type: "text",
    defaultValue: "ESPERA"     
}    
];

/* start data table */
var myTable = $('#dt-basic-example').dataTable({
   
    dom: "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'B>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    ajax: "productos",
    columns: columnSet,   
    select: 'single',    
    altEditor: true,
    responsive: true,  
    buttons: [
    {
        extend: 'selected',
        text: '<i class="fal fa-times mr-1"></i> Delete',
        name: 'delete',
        className: 'btn-primary btn-sm mr-1'
    },
    {
        extend: 'selected',
        text: '<i class="fal fa-edit mr-1"></i> Edit',
        name: 'edit',
        className: 'btn-primary btn-sm mr-1'
    },
    {
        text: '<i class="fal fa-plus mr-1"></i> Add',
        name: 'add',
        className: 'btn-success btn-sm mr-1'
    }],
    columnDefs: [
    {
        // targets: 2,
        // type: 'currency',
        // render: function(data, type, full, meta){            
        //     if (data >= 0){
        //         return '<span class="text-success fw-500">$' + data + '</span>';
        //     }else{
        //         return '<span class="text-danger fw-500">$' + data + '</span>';
        //     }
        // },
    }    
    ],
    drawCallback: function () {
        var sum = $('#dt-basic-example').DataTable().column(2).data().sum();
        $('#ttotal').html(sum);
      }	,

    /* default callback for insertion: mock webservice, always success */
    onAddRow: function(dt, rowdata, success, error){
        console.log("Missing AJAX configuration for INSERT");
        success(rowdata);
        events.prepend('<p class="text-success fw-500">' + JSON.stringify(rowdata, null, 4) + '</p>');
    },
    onEditRow: function(dt, rowdata, success, error){
        console.log("Missing AJAX configuration for UPDATE");
        success(rowdata);
        events.prepend('<p class="text-info fw-500">' + JSON.stringify(rowdata, null, 4) + '</p>');
    },
    onDeleteRow: function(dt, rowdata, success, error){
        console.log("Missing AJAX configuration for DELETE");
        success(rowdata);
        events.prepend('<p class="text-danger fw-500">' + JSON.stringify(rowdata, null, 4) + '</p>');
    }
});
 


    
</script>

@endpush