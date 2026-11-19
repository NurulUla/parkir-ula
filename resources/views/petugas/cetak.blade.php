<!DOCTYPE html>
<html>
<head>
    <title>Cetak Struk Parkir</title>
    <style>
        body { font-family: monospace; width: 280px; margin: 0 auto; padding: 10px; }
        .garis { border-bottom: 1px dashed black; margin: 8px 0; }
        .tengah { text-align: center; }
        table { width: 100%; }
    </style>
</head>
<body>
    <!-- 1. BAGIAN ATAS: Judul Struk -->
<h3 class="tengah">SISTEM E-PARKIR</h3>
<div class="garis"></div>

<!-- 2. BAGIAN TENGAH: Tabel Data Transaksi -->
<table>
    <tr><td>No. Transaksi</td><td>: TRX{{ $transaksi->id_parkir }}</td></tr>
    <tr><td>Tanggal Masuk</td><td>: {{ \Carbon\Carbon::parse($transaksi->waktu_masuk)->format('d-m-Y H:i:s') }}</td></tr>
    <tr><td>Tanggal Keluar</td><td>: {{ \Carbon\Carbon::parse($transaksi->waktu_keluar)->format('d-m-Y H:i:s') }}</td></tr>
    <tr><td>Durasi Parkir</td><td>: {{ $transaksi->durasi_teks }}</td></tr>
    <tr><td>Plat Nomor</td><td>: {{ $transaksi->plat_nomor }}</td></tr>
    <tr><td>Jenis Kendaraan</td><td>: {{ $transaksi->jenis_kendaraan }}</td></tr>
    <tr><td>Area Parkir</td><td>: {{ $transaksi->nama_area }}</td></tr>
    
    <div class="garis"></div>
    
    <tr><td>Tarif Parkir</td><td>: Rp {{ number_format($transaksi->tarif_per_jam, 0, ',', '.') }} / Jam</td></tr>
    <tr><td>Total Durasi</td><td>: {{ $transaksi->total_durasi_jam }}</td></tr>
    
    <div class="garis"></div>
    
    <tr style="font-size: 16px;">
        <td><b>Total Biaya</b></td>
        <td>: <b>Rp {{ number_format($transaksi->biaya_hitung, 0, ',', '.') }}</b></td>
    </tr>
</table>

<!-- 3. BAGIAN BAWAH: Kata-kata Tambahan & Perhatian -->
<div class="garis"></div>
<!-- DIUBAH MENJADI RATA KIRI (text-align: left) DENGAN PADDING AGAR LEBIH RAPI -->
<div style="font-size: 10px; line-height: 1.3; margin-top: 5px; text-align: left; padding-left: 10px;">
    <p style="margin: 2px 0;"><b>PERHATIAN:</b></p>
    <p style="margin: 2px 0;">1. Karcis jangan sampai hilang.</p>
    <p style="margin: 2px 0;">2. Kehilangan karcis denda Rp 20.000.</p>
    <p style="margin: 2px 0;">3. Jangan tinggalkan barang berharga.</p>
    <p style="margin: 2px 0;">4. Kehilangan barang bukan tanggung jawab kami.</p>
</div>

<div class="garis" style="margin: 5px 0;"></div>

<!-- Bagian salam penutupnya tetap biarkan rata tengah agar manis -->
<div class="tengah" style="font-size: 11px; line-height: 1.2;">
    <p style="font-weight: bold; margin: 2px 0;">✨ Sampai Jumpa Lagi! ✨</p>
    <p style="margin: 2px 0;">Semoga Selamat Sampai Tujuan</p>
</div>

<script>
    // 1. Picu jendela print printer otomatis saat halaman terbuka
    window.print();

    // 2. BEGITU PRINT/CANCEL DIKLIK, LANGSUNG DIALIKHKAN SECARA PAKSA (RELOAD DATA)
    window.onafterprint = function() {
        window.location.href = "{{ route('petugas.transaksi') }}"; 
    }
</script>