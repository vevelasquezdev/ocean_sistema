<html>
<head>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 11px;
        }
        body { margin: 5px;}

        header {
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 5.3cm;
            text-align: center;            
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 0.8cm;           
            text-align: center;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
<header>
    <div style="text-align: center;">
        <img id="img" src="{{ asset('smartadmin/dist/img/atipaq.png') }}" width="30%; margin-top:10px"/>
    </div>
    <div style="margin-top:5px;text-align: center;">
        Urb. Esperanza L-2 Parque adepa JLByR<br>
        Frente al parque esperanza
    </div>
    
    <div style="margin-top:5px;text-align: left;margin-left:12%">
        Nro. Ticket: {{$datos[0]->id}}<br>
        Fecha Ped.: {{ date('d-m-Y', strtotime($datos[0]->fecha)) }}<br>
        Fecha Imp.: @php echo date('d-m-Y') @endphp &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hora @php echo date('H:ia') @endphp<br>
        Mesero: {{$datos[0]->mozo}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mesa:{{$datos[0]->id_mesa}}<br>
    </div>
    <div style="border-top: 0.5px solid rgb(91, 91, 91); height: 1px; margin-top: 10px"></div>
</header>
<footer>
    GRACIAS POR SU PREFERENCIA<br>
    <div style="margin-top:1px; font-size:8px !important; font-style: oblique;">               
        Sistemas para empresas <a href="">www.halconsys.com</a> 992378451<br>
    </div>
</footer>

<main>
    @php $total=0; @endphp
   
        <table style="width: 100%">
            <thead>
                <tr>
                    <th style="width: 65% !important;">Producto</th>
                    <th style="width: 10% !important;">Can.</th>
                    <th style="width: 12% !important;">Prec.</th>
                    <th style="width: 13% !important;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $dato)
                    @php
                        $total+=$dato->cant*$dato->pre_pro;
                    @endphp
                    <tr>
                        <td>{{$dato->des_pro}}</td>
                        <td style="text-align: center !important;">{{$dato->cant}}</td>
                        <td style="text-align: right !important;">{{ number_format((float) $dato->pre_pro, 2, '.', '') }}</td>
                        <td style="text-align: right !important;">{{ number_format((float) $dato->cant*$dato->pre_pro, 2, '.', '') }}</td>
                    </tr>
                    @if($loop->iteration == 14 || $loop->iteration == 28)
                        </tbody>
                    </table> 
                    <div class="page-break"></div> 
                    <table class="width:100%;">
                        <thead>
                            <tr>
                                <th style="width: 65% !important;">Producto</th>
                                <th style="width: 10% !important;">Can.</th>
                                <th style="width: 12% !important;">Prec.</th>
                                <th style="width: 13% !important;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                    @endif 
                @endforeach
            </tbody>
        </table>
    <div style="width:100%; border-top: 0.5px solid rgb(91, 91, 91); height: 1px;"></div>
    <div style="text-align:right;">
        <div style="float:right;margin-left:19px;">
            @php echo number_format((float)$total/1.18, 2, '.', ''); @endphp<br>
            @php echo number_format((float)(($total/1.18)*0.18), 2, '.', '');  @endphp<br>
            @php echo number_format((float)$total, 2, '.', '') @endphp
        </div>
        <div style="float:right">
            SUBTOTAL S/.<br>IGV 18% S/.<br>TOTAL S/.
        </div>
    </div>
</main>



</body>
</html>


