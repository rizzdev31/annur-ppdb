<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th {
            background-color: #2563EB;
            color: white;
            font-weight: bold;
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .status-diterima {
            color: #16A34A;
            font-weight: bold;
        }
        .status-ditolak {
            color: #DC2626;
            font-weight: bold;
        }
        .status-pending {
            color: #EAB308;
            font-weight: bold;
        }
        .status-seleksi {
            color: #2563EB;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Data Client PPDB - {{ date('d F Y') }}</h2>
    <p>Total Data: {{ count($clients) }} pendaftar</p>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NISN</th>
                <th>Password</th>
                <th>Nama Lengkap</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Jenjang</th>
                <th>Asal Sekolah</th>
                <th>Nama Ayah</th>
                <th>Nama Ibu</th>
                <th>Pekerjaan Ayah</th>
                <th>Pekerjaan Ibu</th>
                <th>No WhatsApp</th>
                <th>Provinsi</th>
                <th>Kota</th>
                <th>Kecamatan</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Gelombang</th>
                <th>Tahun Ajaran</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $index => $client)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $client->nisn }}</td>
                <td>{{ $client->decrypted_password }}</td>
                <td>{{ $client->nama_lengkap }}</td>
                <td>{{ $client->tempat_lahir }}</td>
                <td>{{ $client->tanggal_lahir->format('d/m/Y') }}</td>
                <td>{{ $client->jenjang }}</td>
                <td>{{ $client->asal_sekolah }}</td>
                <td>{{ $client->nama_ayah }}</td>
                <td>{{ $client->nama_ibu }}</td>
                <td>{{ $client->pekerjaan_ayah }}</td>
                <td>{{ $client->pekerjaan_ibu }}</td>
                <td>{{ $client->no_whatsapp }}</td>
                <td>{{ $client->provinsi }}</td>
                <td>{{ $client->kota }}</td>
                <td>{{ $client->kecamatan }}</td>
                <td>{{ $client->alamat_lengkap }}</td>
                <td class="status-{{ $client->status }}">{{ ucfirst($client->status) }}</td>
                <td>{{ $client->gelombang->nama_gelombang ?? '-' }}</td>
                <td>{{ $client->tahunAjaran->tahun ?? '-' }}</td>
                <td>{{ $client->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p style="margin-top: 20px;">
        <small>Diekspor pada: {{ date('d F Y H:i:s') }}</small>
    </p>
</body>
</html>