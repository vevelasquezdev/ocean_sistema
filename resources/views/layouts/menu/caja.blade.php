<li id="menu_mesas">
    <a href="{!! route('vwmesas') !!}" title="Caja" data-filter-tags="caja">
        <i class="fa fa-window-maximize"></i>
        <span class="nav-link-text">Mesas</span>                                    
    </a>               
</li>
<li id="menu_pedidos">
    <a href="#" title="Pedidos General" data-filter-tags="pedidos">
        <i class="fal fa-table"></i>
        <span class="nav-link-text">Pedidos</span>                                    
    </a>
    <ul>
        <li id="submenu_cocina">
            <a href="{!! route('cocina.index') !!}" title="Cocina" data-filter-tags="cocina">
                <span class="nav-link-text" >Cocina</span>
            </a>
        </li>
        <li id="submenu_barra">
            <a href="{!! route('barra.index') !!}" title="Barra" data-filter-tags="barra">
                <span class="nav-link-text" >Barra</span>
            </a>
        </li>
        <li id="submenu_eliminados">
            <a href="{!! route('eliminados.index') !!}" title="Eliminados" data-filter-tags="eliminados">
                <span class="nav-link-text" >Eliminados</span>
            </a>
        </li>
    </ul>
</li>
<li id="menu_caja">
    <a href="#" title="Caja" data-filter-tags="caja">
        <i class="fal fa-chart-line"></i>
        <span class="nav-link-text" data-i18n="nav.datatables">Caja</span>                                    
    </a>
    <ul>                                    
        <li id="submenu_apertura_cierre">
            <a href="{!! route('apecierrecaja.index') !!}" title="Apertura y Cierre de Caja" data-filter-tags="apertura cierre">
                <span class="nav-link-text" >Apertura-Cierre</span>
            </a>
        </li>
        <li id="submenu_caja_ingresos">
            <a href="{!! route('movimientosctrl.index') !!}" title="Movimientos" data-filter-tags="movimientos">
                <span class="nav-link-text" >Movimientos</span>
            </a>
        </li>                   
    </ul>
</li>

<li class="nav-title">Reportes</li>
<li id="menu_reportes_pedidos"> 
    <a href="#" title="Reporte de pedidos" data-filter-tags="pedidos">
        <i class="fa fa-clipboard"></i>
        <span class="nav-link-text" >Reportes Pedidos</span>
    </a>
    <ul>                    
        <li id="submenu_report_cocina">
            <a href="vwreportcocina" title="Cocina" data-filter-tags="cocina">
                <span class="nav-link-text">Cocina</span>
            </a>
        </li>
        <li id="submenu_report_barra">
            <a href="vwreportbarra" title="Barra" data-filter-tags="barra">
                <span class="nav-link-text">Barra</span>
            </a>
        </li>               
    </ul>                
</li>
<li id="menu_reportes_caja">
    <a href="#" title="Caja" data-filter-tags="caja">
        <i class="fa fa-clipboard"></i>
        <span class="nav-link-text">Reportes Caja</span>                                    
    </a>
    <ul>
        <li id="submenu_report_movimientos">
            <a href="vwreportmovimientos" title="Movimientos" data-filter-tags="movimientos">
                <span class="nav-link-text" >Movimientos</span>
            </a>
        </li>                   
    </ul>
</li>

