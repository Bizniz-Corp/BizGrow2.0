<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penjualan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }
    </style>
</head>

<body>
    <h2>Laporan Riwayat Penjualan</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Produk</th>
                <th>Tanggal</th>
                <th>Kuantitas</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $row)
                <tr>
                    <td>{{ $row->sales_id }}</td>
                    <td>{{ $row->product_name }}</td>
                    <td>{{ $row->sales_date }}</td>
                    <td>{{ $row->sales_quantity }}</td>
                    <td>Rp {{ number_format($row->price_per_item, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($row->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
