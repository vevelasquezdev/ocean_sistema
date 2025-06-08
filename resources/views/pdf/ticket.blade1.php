<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Ticket</title>
        <style>           
            @page { margin: 0in; }
            * {
                font-size: 4px;
                text-align: center;
                font-family: Arial, Helvetica, sans-serif;
            }
            header {               
                position: fixed;
                left: 0px;
                right: 0px;
                height: 50px;
                text-align: center;
                line-height: 35px;
            } 
            footer {
                position: fixed; 
                bottom: 0px; 
                left: 0px; 
                right: 0px;
                height: 30px; 
                text-align: center;
                line-height: 5px;
            }
               
           
            #img{
                position: absolute; margin-top: 10px; 
                margin-left: 34px;
            }
            #img_halconsys{
                position: absolute; margin-top: 16px; 
                margin-left: 34px;
            }
            #direccion{
                width: 80px;   
                text-align: center;
                line-height: 5px;
                margin-top: 38px;
                margin-left: 13px; 
            }            
            .page-break {
                page-break-after: always;                
            }
                  
        </style>
       
    </head>
    <body>
        <header>
            <img id="img" src="{{ asset('smartadmin/dist/img/ocean_logo2.png') }}" width="20%; mergin-left:30px"/>
            <div id="direccion">
                Av. Arancota 123 Sachaca-Arequipa
                Costado del grupo Gloria
            </div>
        </header>
        <footer>
            <div style="width:80px; margin-left: 14px; font-size:3px">
                <img id="img_halconsys" src="{{ asset('smartadmin/dist/img/logo_claro.png') }}" width="20%"/>
                GRACIAS POR SU PREFERENCIA
                <a href="">www.halconsys.com</a><br>
                Sistemas para empresas---992378451
            </div>            
        </footer>
        <div id="nro_ticket" style="position: absolute; margin-top: 52px; margin-left: 10px;  text-align: center;">
            Nro. Ticket: {{$datos[0]->id}}
        </div>
        <div style="position: absolute; margin-top: 57px; margin-left: 10px; text-align: center;">
            Fecha Ped.: {{ date('d-m-Y', strtotime($datos[0]->fecha)) }}
        </div>
        <div style="position: absolute; margin-top: 62px; margin-left: 10px; text-align: center;">
            Fecha Imp.: @php echo date('d-m-Y') @endphp &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hora @php echo date('H:ia') @endphp
        </div>
        <div style="position: absolute; width:57px; margin-top: 68px; margin-left: 10px; text-align: left;">
            Mesero: {{$datos[0]->mozo}}
        </div>
        <div style="position: absolute; width:20px; margin-top: 68px; margin-left: 68px; text-align: left;">
            Mesa:{{$datos[0]->id_mesa}}
        </div>
        
        <div style="position: absolute; margin-top: 80px; width:95px; margin-left: 8px;">
            <div style="position: relative; width:50px; float:left; text-align: left; font-weight:bold">Producto</div>
            <div style="position: relative; width:13px; float:left; text-align: left; font-weight:bold">Cant</div>
            <div style="position: relative; width:16px; float:left; text-align: left; font-weight:bold">Precio</div>
            <div style="position: relative; width:20px;float:left; text-align: left; font-weight:bold">Total</div>
        </div>
        
        
        <div style="position: absolute; margin-top: 87px;width:90px; border-top: 0.5px solid rgb(91, 91, 91); height: 1px; margin-left: 8px;"></div>

        <div style="position: absolute; margin-top: 90px; width:90px; margin-left: 8px;"> 
            
            @php $total=0; @endphp
            
            @foreach($datos as $dato)
                @php
                    $total+=$dato->cant*$dato->pre_pro;
                @endphp
                
                <div style="position: relative; width:55px; float:left; text-align: left; font-size:4px">{{ $dato->des_pro }}</div>
                <div style="position: relative; width:10px; float:left; text-align: left; font-size:4px">{{ $dato->cant }}</div>
                <div style="position: relative; width:15px; float:left; text-align: left; font-size:4px">{{ number_format((float) $dato->pre_pro, 2, '.', '') }}</div>
                <div style="position: relative; width:15px; float:left; text-align: left; font-size:4px">{{ number_format((float) $dato->cant*$dato->pre_pro, 2, '.', '') }}</div>
                <br>
                @if( $dato->num==12 ||  $dato->num==24 ) 
                    @php echo '<div class="page-break"></div>'; @endphp
                @endif                      
            @endforeach
            <div style="position: relative; width:90px; border-top: 0.5px solid rgb(91, 91, 91); height: 1px;"></div>
            <div style="position: relative; width:95px; float:left; text-align: left;font-size:4px"> SUBTOTAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S/.&nbsp;@php echo number_format((float)$total/1.18, 2, '.', ''); @endphp</div><br>
            <div style="position: relative; width:95px; float:left; text-align: left;font-size:4px">IGV 18% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S/.&nbsp;@php echo number_format((float)(($total/1.18)*0.18), 2, '.', '');  @endphp</div><br>
            <div style="position: relative; width:95px; float:left; text-align: left;font-size:4px">TOTAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S/.&nbsp;@php echo number_format((float)$total, 2, '.', '') @endphp</div><br>
        </div>
    </body>
</html>
