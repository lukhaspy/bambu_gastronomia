@php
$total = 0; 
@endphp

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pedido-{{$sale->client->name}}-{{date('d/m/Y H:i', strtotime($sale->created_at))}}</title>

    <style type="text/css">
        * {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        table {
            font-size: x-small;
        }

        table thead {
            background-color: #60A7A6;
            color: #FFF;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .button-green {
            background-color: #c2eded;
            color: #333;
            font-size: 1rem;
            font-weight: 400;
            padding: 0.1rem 0.2rem;
            border-radius: 5px;
            width: auto;
        }
    </style>

</head>

<body>
    <div width="100%" align="right">
        <small style="font-size: 0.7rem;">{{date('d/m/Y H:i', strtotime($sale->created_at))}}</small>
    </div>

    <div align="center" width="100%">

        <img class="avatar" style="border-radius: rounded;" src="{{config('app.url')}}/assets/img/bambu-logo.jpg" width="50px" alt="">

    </div>
    <table width=" 100%">
        <tr>
            <td align="center">

                <h1>Bambu Gastronomia</h1>
                <p style="font-size: 0.7rem;">Tel: (0983) 149-332 -
                    Sta. Rosa del Monday</p>
                <hr style="border-style: dotted;">

            </td>
        </tr>

    </table>

    <table width="100%">
        <tr>
            <td><strong>Cliente:</strong> {{$sale->client->name}}</td>
        </tr>
        <tr>
            <td><strong>Pedido Cod: </strong> {{$sale->id}}</td>

        </tr>
    </table>

    <br />

    <table width="100%">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio Un.</th>
                <th>Cant.</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->products as $sold)
            @php
            $total += $sold->price * $sold->qty;
            @endphp
            <tr>
                <td>{{$sold->product->name}}</td>
                <td align="right">{{number_format($sold->price, 0, '', '.')}}</td>
                <td align="right">{{$sold->qty}}</td>
                <td align="right">{{number_format($sold->price * $sold->qty, 0, '', '.')}}</td>
            </tr>
            @endforeach
        </tbody>


        <!-- <tr style="border-top: 2px solid #e1e1e1; margin-top:50px;" >
            <td colspan="2"></td>
            <td align="right">Total Gs.</td>
            <td align="right" class="gray"></td>
        </tr>--->
    </table>

    <div style="margin-top: 30px; " class="button-green" align="center">
        <strong>Total:</strong>
        {{number_format($total, 0, '', '.')}} Gs
    </div>

    <hr style="border-style: dashed; color:#e1e1e1;">
    <div align="center">
        <pre align="center" style="font-weight: bolder; font-style: italic;">¡Gracias por su preferencia!</pre>
    </div>
</body>

</html>