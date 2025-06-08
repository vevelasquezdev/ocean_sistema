<?php

use App\Http\Controllers\admin\CartaController;
use App\Http\Controllers\admin\CategoriasController;
use App\Http\Controllers\admin\ClienteController;
use App\Http\Controllers\admin\EgCategoriaController;
use App\Http\Controllers\admin\HomeMesasController;
use App\Http\Controllers\admin\InCategoriaController;
use App\Http\Controllers\admin\MesasController;
use App\Http\Controllers\admin\PedidosController;
use App\Http\Controllers\admin\TemporalPedidosController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\almacen\EntradasController;
use App\Http\Controllers\almacen\InventarioBarraController;
use App\Http\Controllers\almacen\ProductosController;
use App\Http\Controllers\almacen\ReportesAlmacenController;
use App\Http\Controllers\almacen\SalidasController;
use App\Http\Controllers\caja\AperturaCierreController;
use App\Http\Controllers\caja\CajaMesasController;
use App\Http\Controllers\caja\EgresosController;
use App\Http\Controllers\caja\IngresosController;
use App\Http\Controllers\caja\MovimientosController;
use App\Http\Controllers\pedidos\BarraController;
use App\Http\Controllers\pedidos\CocinaController;
use App\Http\Controllers\pedidos\EliminadosController;
use App\Http\Controllers\reportes\ReportePedidosController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {return view('auth.login');});
});

/* Route::get('user-list-excel', [UserController::class, 'exportExcelUsers'])->name('usuarios.excel');
Route::post('user-import-excel', [UserController::class, 'importExcelUsers'])->name('usuario.import.excel'); */
Route::group(['middleware'=>['auth','PreventBackHistory']], function(){

    Route::get('dashboard', function () { return view('dashboard'); })->name('dashboard');
    
    /*USUARIOS*/ 
    Route::get('view_users', [UserController::class, 'index'])->name('vwuser');
    Route::resource('users', UserController::class)->names('users');


    /*CARTA*/ 
    Route::get('view_carta', [CartaController::class, 'index'])->name('vwcarta');
    Route::resource('carta', CartaController::class)->names('carta');


    /**ADMINISTRACION DE MESAS */
    Route::resource('admin-mesas', MesasController::class)->names('admin-mesas');
    Route::get('vw-admin-mesas', [MesasController::class, 'index'])->name('vwadminmesas');


    /*MESAS */
    Route::get('view_mesas', [HomeMesasController::class, 'index'])->name('vwmesas');
    Route::resource('mesas', HomeMesasController::class)->names('mesas');    
    Route::get('productos/{query}', [HomeMesasController::class, 'store']);// buscardor de carta
    Route::get('print_ticket/{id_pedido_temp}', [HomeMesasController::class, 'print_ticket']);


    /*temporal mesas get_items */
    Route::get('/table_pedido_detalle_temp/{id_pedido_temp?}{id_mesa?}', [TemporalPedidosController::class, 'get_ittems_table_temp'])->name('table_pedido_detalle_temp');
    Route::resource('temp-pedidos', TemporalPedidosController::class)->names('temp-pedidos');
    Route::get('add_coment', [TemporalPedidosController::class, 'add_coment']);
    Route::get('check_orden/{id_detalle_temp}', [TemporalPedidosController::class, 'check_orden']);// eliminar sin pedir razon tabla pedido_detalle_tem

    
    /**llenar pedidos tabla fija */
    Route::resource('pedidos', PedidosController::class)->names('pedidos');
    Route::get('table_pedido_detalle', [PedidosController::class, 'get_ittems_table']);


    /**Clientes */
    Route::resource('clientes', ClienteController::class)->names('clientes');

  
    /**Cocina */
    Route::get('get_cocina_1/{fch?}', [CocinaController::class, 'get_cocina_1'])->name('get_cocina_1');
    Route::get('get_cocina_1_2/{fch?}', [CocinaController::class, 'get_cocina_1_2'])->name('get_cocina_1_2');
    Route::get('get_cocina_2/{fch?}', [CocinaController::class, 'get_cocina_2'])->name('get_cocina_2');
    Route::get('get_cocina_2_2/{fch?}', [CocinaController::class, 'get_cocina_2_2'])->name('get_cocina_2_2');
    Route::get('agrupar_cocina_1/{fch?}', [CocinaController::class, 'agrupar_cocina_1'])->name('aprupar_cocina_1');
    Route::get('agrupar_cocina_2/{fch?}', [CocinaController::class, 'agrupar_cocina_2'])->name('aprupar_cocina_2');
    Route::resource('cocina', CocinaController::class)->names('cocina');


    /**Barra */
    Route::resource('barra', BarraController::class)->names('barra');
    Route::get('get_barra_1/{fch?}{barra?}', [BarraController::class, 'get_barra_1'])->name('get_barra_1');
    Route::get('get_barra_1_2/{fch?}{barra?}', [BarraController::class, 'get_barra_1_2'])->name('get_barra_1_2');
    Route::get('agrupar_barra_1/{fch?}{barra?}', [BarraController::class, 'agrupar_barra_1'])->name('agrupar_barra_1');


    /**Eliminados */
    Route::resource('eliminados', EliminadosController::class)->names('eliminados');
    Route::get('tabla-eliminados/{fch?}', [EliminadosController::class,'tabla_eliminados']);

    /**CAJA MESAS */
    // Route::resource('vwcaja-mesas', CajaMesasController::class)->names('caja-mesas');


    /**CATEGORIAS */
    Route::resource('vwcategorias', CategoriasController::class)->names('categorias');
    Route::get('incat_list', [InCategoriaController::class, 'getInCategoria'])->name('InCategoria.list');
    Route::get('egcat_list', [EgCategoriaController::class, 'getEgCategoria'])->name('EgCategoria.list');
    Route::resource('ingresoscategorias', InCategoriaController::class)->names('ingresoscategorias');
    Route::resource('egresoscategorias', EgCategoriaController::class)->names('egresoscategorias');


    /**Caja apertura y cierre */
    Route::resource('apecierrecaja', AperturaCierreController::class)->names('apecierrecaja');
    Route::resource('movimientosctrl', MovimientosController::class)->names('movimientosctrl');
    Route::get('movimientos_list', [MovimientosController::class, 'getMovimientos'])->name('movimientos.list');
    Route::get('check-apertura-caja', [MovimientosController::class, 'check_apertura_caja']);
    Route::post('insert-movimiento', [MovimientosController::class, 'insert_movimiento']);


    /** REPORTES */
    Route::get('vwreportcocina', [ReportePedidosController::class, 'vw_reporte_cocina']);
    Route::get('reporte-cocina/{fch?}{cocina?}', [ReportePedidosController::class, 'reporte_cocina']);
    Route::get('vwreportbarra', [ReportePedidosController::class, 'vw_reporte_barra']);
    Route::get('reporte-barra/{fch?}{barra?}', [ReportePedidosController::class, 'reporte_barra']);
    Route::get('vwreportmovimientos', [ReportePedidosController::class, 'vw_reporte_movimientos']);
    Route::get('reporte-movimientos/{fch?}{caja?}{tipo?}', [ReportePedidosController::class, 'reporte_movimientos']);
    Route::get('reporte-movimientos-pdf/{fch?}{caja?}', [ReportePedidosController::class, 'reporte_movimientos_pdf']);


    /**ALMACEN */
    Route::get('tabla-alm-entradas/{fch?}', [EntradasController::class,'get_tabla_alm_entradas']);
    Route::resource('alm-entradas', EntradasController::class)->names('alm-entradas');
    Route::get('tabla-alm-salidas/{fch?}', [SalidasController::class,'get_tabla_alm_salidas']);
    Route::resource('alm-salidas', SalidasController::class)->names('alm-salidas');
    
    /** INVENTARIO */
    Route::get('check_recarga_inventarios',[InventarioBarraController::class,'check_recarga_inventarios']);
    Route::get('vw_principal_barra',[InventarioBarraController::class,'vw_principal_barra']);
    Route::get('almacen-principal-barra/{fch?}',[InventarioBarraController::class,'principal_barra']);
    Route::get('vw_barra_uno',[InventarioBarraController::class,'vw_barra_uno']);
    Route::get('almacen-barra-uno/{fch?}',[InventarioBarraController::class,'barra_uno']);
    Route::get('vw_barra_dos',[InventarioBarraController::class,'vw_barra_dos']);
    Route::get('almacen-barra-dos/{fch?}',[InventarioBarraController::class,'barra_dos']);
    Route::get('vw_barra_tres',[InventarioBarraController::class,'vw_barra_tres']);
    Route::get('almacen-barra-tres/{fch?}',[InventarioBarraController::class,'barra_tres']);
    Route::get('vw_barra_cuatro',[InventarioBarraController::class,'vw_barra_cuatro']);
    Route::get('almacen-barra-cuatro/{fch?}',[InventarioBarraController::class,'barra_cuatro']);

    Route::get('vw_principal_cocina',[InventarioBarraController::class,'vw_principal_cocina']);
    Route::get('almacen-principal-cocina/{fch?}',[InventarioBarraController::class,'principal_cocina']);
    Route::get('vw_cocina_uno',[InventarioBarraController::class,'vw_cocina_uno']);
    Route::get('almacen-cocina-uno/{fch?}',[InventarioBarraController::class,'cocina_uno']);
    Route::get('vw_cocina_dos',[InventarioBarraController::class,'vw_cocina_dos']);
    Route::get('almacen-cocina-dos/{fch?}',[InventarioBarraController::class,'cocina_dos']);
    
    /**PRODUCTOS */
    Route::get('almacen-productos/{query?}{origen?}', [ProductosController::class, 'find_producto']);// buscardor de productos barra
    Route::get('productos-entradas/{query}', [ProductosController::class, 'find_producto_entradas']);// buscardor de productos view entradas
    Route::resource('alm-productos', ProductosController::class)->names('alm-productos');
    Route::get('productos-recuento-barra', [ProductosController::class, 'recuento_barra']);
    Route::get('productos-recuento-cocina', [ProductosController::class, 'recuento_cocina']);
    Route::get('recargar-inventarios', [ProductosController::class, 'recargar_inventarios']);

    /**REPORTE TOTALES ALMACEN */
    Route::get('vw_totales_barra',[ReportesAlmacenController::class,'vw_totales_barra']);
    Route::get('rep-totales-barra/{fch?}',[ReportesAlmacenController::class,'totales_barra']);
    Route::get('vw_totales_cocina',[ReportesAlmacenController::class,'vw_totales_cocina']);
    Route::get('rep-totales-cocina/{fch?}',[ReportesAlmacenController::class,'totales_cocina']);


    Route::get('carbon',[ProductosController::class, 'ccc']);

    // /**INGRESOS */     
    // Route::get('ingresos_list', [IngresosController::class, 'getIngresos'])->name('ingresos.list');
    // Route::get('check-apertura-caja', [IngresosController::class, 'check_apertura_caja']);
    // Route::resource('ingresosctrl', IngresosController::class)->names('ingresosctrl');  
    // Route::post('insert-ingreso', [IngresosController::class, 'insert_ingreso']);

    // /**EGRESOS */
    // Route::get('egresos_list', [EgresosController::class, 'getEgresos'])->name('egresos.list');
    // Route::resource('egresosctrl', EgresosController::class)->names('egresosctrl');
    // Route::post('insert-egreso', [EgresosController::class, 'insert_egreso']);
});







