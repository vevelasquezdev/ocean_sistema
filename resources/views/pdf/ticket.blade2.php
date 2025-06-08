<html>
<head>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
            font-size: 4.5px;
        }

        body {
            margin: 3px;
        }

        header {
            
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            text-align: center;
            line-height: 30px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 0.8cm;           
            text-align: center;
            background: yellow;           
        }
        .page-break {
            page-break-before: always;
        }

        tr {
            height: 20px !important;
        }
      
    </style>
</head>
<body>
<header>
    <img id="img" src="{{ asset('smartadmin/dist/img/ocean_logo2.png') }}" width="20%; mergin-left:32px;margin-top:5px"/>
    <div style="width:65%; line-height: 4px; margin-left:19px;margin-top:5px">
        Av. Arancota 123 Sachaca-Arequipa<br>
        Costado del grupo Gloria
    </div>
    <div style="width:81%; line-height: 4.5px; margin-left:10px;margin-top:5px; height:20px; text-align:left !important;">
        Nro. Ticket: {{$datos[0]->id}}<br>
        Fecha Ped.: {{ date('d-m-Y', strtotime($datos[0]->fecha)) }}<br>
        Fecha Imp.: @php echo date('d-m-Y') @endphp &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hora @php echo date('H:ia') @endphp<br>
        Mesero: {{$datos[0]->mozo}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mesa:{{$datos[0]->id_mesa}}
    </div>
</header>
<footer>
    <div style="width:65%; line-height: 4px; margin-left:19px;margin-top:5px; font-size:4px !important;">
        GRACIAS POR SU PREFERENCIA<br>
        <a href="">www.halconsys.com</a><br>
        Sistemas para empresas---992378451<br>
        <img src="{{ asset('smartadmin/dist/img/logo_claro.png') }}" width="20%"/>
    </div>
</footer>

<main style="background:red">
    @php $total=0; @endphp
   
        <table style="width:100%">
            <thead>
                <tr>
                    <th style="width: 50px !important;">Producto</th>
                    <th>Can</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $dato)
                    @php
                        $total+=$dato->cant*$dato->pre_pro;
                    @endphp
                    <tr style="height: 10px;">
                        <td>{{$dato->des_pro}}</td>
                        <td>{{$dato->cant}}</td>
                        <td>{{ number_format((float) $dato->pre_pro, 2, '.', '') }}</td>
                        <td>{{ number_format((float) $dato->cant*$dato->pre_pro, 2, '.', '') }}</td>
                    </tr>
                    @if($loop->iteration == 8)
                        </tbody>
                    </table> 
                    <div class="page-break"></div> 
                    <table class="margin-top:63px !important; background:red; width:100%">
                        <thead>
                            <tr>
                                <th style="width: 50px !important;">Producto</th>
                                <th>Can</th>
                                <th>Precio</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                    @endif 
                @endforeach
            </tbody>
        </table>
    <div style="position: relative; width:95px; border-top: 0.5px solid rgb(91, 91, 91); height: 1px;"></div>
    <div style="position: relative; width:95px; float:left; text-align: left;font-size:4px"> SUBTOTAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S/.&nbsp;@php echo number_format((float)$total/1.18, 2, '.', ''); @endphp</div><br>
    <div style="position: relative; width:95px; float:left; text-align: left;font-size:4px">IGV 18% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S/.&nbsp;@php echo number_format((float)(($total/1.18)*0.18), 2, '.', '');  @endphp</div><br>
    <div style="position: relative; width:95px; float:left; text-align: left;font-size:4px">TOTAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S/.&nbsp;@php echo number_format((float)$total, 2, '.', '') @endphp</div><br>

</main>


</body>
</html>

 {{-- <div style="margin-top: 80px; width:95px; margin-left: 8px;">
        <div style="position: relative; width:50px; float:left; text-align: left; font-weight:bold">Producto</div>
        <div style="position: relative; width:13px; float:left; text-align: left; font-weight:bold">Cant</div>
        <div style="position: relative; width:16px; float:left; text-align: left; font-weight:bold">Precio</div>
        <div style="position: relative; width:20px;float:left; text-align: left; font-weight:bold">Total</div>
    </div>
    <div style=" width:90px;"> 
            
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
    </div> --}}


{{-- <table id="datos" style="width:100%">
    <thead>
       <tr>
          <th style="min-width: 70px !important;">Producto</th>
          <th>Cant</th>
          <th>Precio</th>
          <th>Total</th>
      </tr>
    </thead>
    <tbody>
        @php $check=0 @endphp
        @foreach ($datos as $dato)
            @php $check++ @endphp
            <tr style="font-size: 3px !important;">
                <td>{{$dato->des_pro}}</td>
                <td>{{$dato->cant}}</td>
                <td>{{$dato->pre_pro}}</td>
                <td>{{$dato->id}}</td>
            </tr>
            @if( $check % 5 == 0 ) 
                @php echo '<div class="page-break"></div>'; @endphp
            @endif                   
        @endforeach
    </tbody>
</table> --}}
