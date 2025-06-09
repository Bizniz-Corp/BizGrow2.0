{{-- filepath: resources/views/stok/stok_history_pdf.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Riwayat Perubahan Stok</title>
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
    <h2>Laporan Riwayat Perubahan Stok</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Produk</th>
                <th>Tanggal</th>
                <th>Perubahan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stockChanges as $row)
                <tr>
                    <td>{{ $row->stock_change_id }}</td>
                    <td>{{ $row->product_name }}</td>
                    <td>{{ $row->changes_date }}</td>
                    <td>{{ $row->changes_quantity }}</td>
                    <td>{{ $row->total_stock }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
