
{{-- /*ALMACEN*/ --}}
<li class="nav-title">Almacen</li>
<li id="menu_productos">
    <a href="{!! route('alm-productos.index') !!}" title="Productos" data-filter-tags="productos">
        <i class="fa fa-cart-plus"></i>
        <span class="nav-link-text">Productos</span>                                    
    </a>               
</li>
<li id="menu_almacen_ent_sal"> 
    <a href="#" title="entradas y salidas" data-filter-tags="entradas y salidas">
        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
        <span class="nav-link-text" >Entradas - Salidas</span>
    </a>
    <ul>                    
        <li id="submenu_entradas">
            <a href="{!! route('alm-entradas.index') !!}" title="entradas" data-filter-tags="entradas">
                <span class="nav-link-text">Entradas</span>
            </a>
        </li>
        <li id="submenu_salidas">
            <a href="{!! route('alm-salidas.index') !!}" title="salidas" data-filter-tags="salidas">
                <span class="nav-link-text">Salidas</span>
            </a>
        </li>               
    </ul>                
</li>
<li id="menu_alm_invent_cocina">
    <a href="#" title="inventario cocina" data-filter-tags="inventario cocina">
        <i class="fa fa-calculator" aria-hidden="true"></i>
        <span class="nav-link-text">Inventario Cocina</span>                                    
    </a>
    <ul>
        <li id="submenu_principal_cocina">
            <a href="vw_principal_cocina" title="inventario principal cocina" data-filter-tags="principal cocina">
                <span class="nav-link-text" >Principal Cocina</span>
            </a>
        </li>
        <li id="submenu_cocina_1">
            <a href="vw_cocina_uno" title="inventario cocina uno" data-filter-tags="cocina uno">
                <span class="nav-link-text" >Cocina 1</span>
            </a>
        </li> 
        <li id="submenu_cocina_2">
            <a href="vw_cocina_dos" title="inventario cocina dos" data-filter-tags="cocina dos">
                <span class="nav-link-text" >Cocina 2</span>
            </a>
        </li>                    
    </ul>
</li>
<li id="menu_alm_invent_barra">
    <a href="#" title="inventario barra" data-filter-tags="inventario barra">
        <i class="fa fa-calculator" aria-hidden="true"></i>
        <span class="nav-link-text">Inventario Barra</span>                                    
    </a>
    <ul>
        <li id="submenu_principal_barra">
            <a href="vw_principal_barra" title="inventario principal barra" data-filter-tags="principal barra">
                <span class="nav-link-text" >Principal Barra</span>
            </a>
        </li>
        <li id="submenu_barra_1">
            <a href="vw_barra_uno" title="inventario barra uno" data-filter-tags="barra uno">
                <span class="nav-link-text" >Barra 1</span>
            </a>
        </li>
        <li id="submenu_barra_2">
            <a href="vw_barra_dos" title="inventario barra dos" data-filter-tags="barra dos">
                <span class="nav-link-text" >Barra 2</span>
            </a>
        </li>
        <li id="submenu_barra_3">
            <a href="vw_barra_tres" title="inventario barra tres" data-filter-tags="barra tres">
                <span class="nav-link-text" >Barra 3</span>
            </a>
        </li>
        <li id="submenu_barra_4">
            <a href="vw_barra_cuatro" title="inventario barra cuatro" data-filter-tags="barra cuatro">
                <span class="nav-link-text" >Barra 4</span>
            </a>
        </li>                  
    </ul>
</li>
<li id="menu_reportes_almacen"> 
    <a href="#" title="Reporte de almacen" data-filter-tags="almacen">
        <i class="fa fa-clipboard"></i>
        <span class="nav-link-text" >Totales Almacen</span>
    </a>
    <ul>                    
        <li id="submenu_reporte_totales_cocina">
            <a href="vw_totales_cocina" title="Consolidado de Productos Cocina" data-filter-tags="totales cocina">
                <span class="nav-link-text">Totales Cocina</span>
            </a>
        </li>
        <li id="submenu_reporte_totales_barra">
            <a href="vw_totales_barra" title="Consolidado de Productos Barra" data-filter-tags="totales barra">
                <span class="nav-link-text">Totales Barra</span>
            </a>
        </li>               
    </ul>                
</li>

<li class="nav-title">Configuraciones</li>
<li id="menu_administracion"> {{-- active open --}}
    <a href="#" title="Application Intel" data-filter-tags="administracion">
        <i class="fal fa-cog"></i>
        <span class="nav-link-text" data-i18n="nav.application_intel">Administracion</span>
    </a>
    <ul>                    
       
        <li id="submenu_carta"> {{-- active --}}
            <a href="{!! route('vwcarta') !!}" title="Carta" data-filter-tags="carta">
                <span class="nav-link-text">Carta</span>
            </a>
        </li>                    
      
    </ul>
</li>