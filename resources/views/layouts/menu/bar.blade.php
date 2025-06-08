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
    </ul>
</li>