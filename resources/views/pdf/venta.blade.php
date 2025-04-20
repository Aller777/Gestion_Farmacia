<!-- resources/views/pdf/venta.blade.php -->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Venta PDF</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f0f2f5;
        margin: 0;
        padding: 40px;
        color: #333;
        line-height: 1.6;
      }

      .container {
        background-color: #ffffff;
        padding: 30px;
        border: 4px double #4472c4;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      }

      h1 {
        color: #4472c4;
        margin: 0 0 20px 0;
        padding-bottom: 10px;
        border-bottom: 2px solid #4472c4;
        font-size: 26px;
      }

      p {
        margin: 6px 0;
        font-size: 14px;
      }

      h3 {
        color: #333;
        margin: 25px 0 15px 0;
        font-size: 18px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 5px;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        border-radius: 6px;
        overflow: hidden;
      }

      th,
      td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
        font-size: 13px;
      }

      th {
        background-color: #4472c4;
        color: white;
        font-weight: normal;
      }

      tbody tr:nth-child(even) {
        background-color: #f9f9f9;
      }

      tbody tr:hover {
        background-color: #f1f1f1;
      }

      .total {
        font-weight: bold;
        font-size: 18px;
        text-align: right;
        margin-top: 20px;
        padding: 12px;
        background-color: #eef1f7;
        border: 2px solid #4472c4;
        border-radius: 6px;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05);
      }

      strong {
        color: #4472c4;
      }
    </style>
  </head>
  <body>
  <div style="text-align: center; margin-bottom: 20px;">
    <img src="{{ public_path('img/pastillas.png') }}" alt="Icono" width="50" style="margin-bottom: 10px;">
    <h1 style="color: #4472c4; font-size: 28px; margin: 0;">BOTICA SUPERPASTILLA</h1>
</div>
    <div style="text-align: center; margin-bottom: 20px;">
      <h2 style="color: #333; font-size: 24px;">Comprobante de Venta</h2>
      <p style="font-size: 16px; color: #555;">Sistema de Ventas</p>


    <div class="container">
      <h1>Venta #{{ $venta->id }}</h1>
      <p><strong>Cliente:</strong> {{ $venta->cliente->nombre }}</p>
      <p><strong>Vendedor:</strong> {{ $venta->user->name }}</p>
      <p><strong>Fecha:</strong> {{ $venta->fecha_venta }}</p>

      <h3>Detalle de Productos:</h3>
      <table>
        <thead>
          <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Total (S/)</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($venta->productos as $producto)
          @php
            $productoDetalle = \App\Models\Producto::find($producto['producto_id']);
            $totalProducto = $producto['cantidad'] * $productoDetalle->precio_venta;
          @endphp
          <tr>
            <td>{{ $productoDetalle->nombre }}</td>
            <td>{{ $producto['cantidad'] }}</td>
            <td>S/ {{ number_format($totalProducto, 2) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <p class="total">Total General: S/ {{ number_format($venta->total, 2) }}</p>
    </div>
  </body>
</html>
