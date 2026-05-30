<?php
require_once 'Koneksi.php';

function getAllMember() {
    $koneksi = koneksiDatabase();
    $query   = "SELECT * FROM member ORDER BY id_member ASC";
    $result  = mysqli_query($koneksi, $query);
    $data    = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_close($koneksi);
    return $data;
}

function getMemberById($id_member) {
    $koneksi = koneksiDatabase();
    $id      = mysqli_real_escape_string($koneksi, $id_member);
    $query   = "SELECT * FROM member WHERE id_member = '$id' LIMIT 1";
    $result  = mysqli_query($koneksi, $query);
    $data    = mysqli_fetch_assoc($result);
    mysqli_close($koneksi);
    return $data;
}

function insertMember($nama_member, $nomor_member, $alamat, $tgl_mendaftar, $tgl_terakhir_bayar) {
    $koneksi           = koneksiDatabase();
    $nama_member       = mysqli_real_escape_string($koneksi, $nama_member);
    $nomor_member      = mysqli_real_escape_string($koneksi, $nomor_member);
    $alamat            = mysqli_real_escape_string($koneksi, $alamat);
    $tgl_mendaftar     = mysqli_real_escape_string($koneksi, $tgl_mendaftar);
    $tgl_terakhir_bayar = mysqli_real_escape_string($koneksi, $tgl_terakhir_bayar);

    $tgl_bayar_val = ($tgl_terakhir_bayar !== '') ? "'$tgl_terakhir_bayar'" : "NULL";

    $query = "INSERT INTO member (nama_member, nomor_member, alamat, tgl_mendaftar, tgl_terakhir_bayar)
              VALUES ('$nama_member', '$nomor_member', '$alamat', '$tgl_mendaftar', $tgl_bayar_val)";

    $result = mysqli_query($koneksi, $query);
    mysqli_close($koneksi);
    return $result;
}

function updateMember($id_member, $nama_member, $nomor_member, $alamat, $tgl_mendaftar, $tgl_terakhir_bayar) {
    $koneksi           = koneksiDatabase();
    $id_member         = mysqli_real_escape_string($koneksi, $id_member);
    $nama_member       = mysqli_real_escape_string($koneksi, $nama_member);
    $nomor_member      = mysqli_real_escape_string($koneksi, $nomor_member);
    $alamat            = mysqli_real_escape_string($koneksi, $alamat);
    $tgl_mendaftar     = mysqli_real_escape_string($koneksi, $tgl_mendaftar);
    $tgl_terakhir_bayar = mysqli_real_escape_string($koneksi, $tgl_terakhir_bayar);

    $tgl_bayar_val = ($tgl_terakhir_bayar !== '') ? "'$tgl_terakhir_bayar'" : "NULL";

    $query = "UPDATE member
              SET nama_member       = '$nama_member',
                  nomor_member      = '$nomor_member',
                  alamat            = '$alamat',
                  tgl_mendaftar     = '$tgl_mendaftar',
                  tgl_terakhir_bayar = $tgl_bayar_val
              WHERE id_member = '$id_member'";

    $result = mysqli_query($koneksi, $query);
    mysqli_close($koneksi);
    return $result;
}

function deleteMember($id_member) {
    $koneksi  = koneksiDatabase();
    $id       = mysqli_real_escape_string($koneksi, $id_member);
    $query    = "DELETE FROM member WHERE id_member = '$id'";
    $result   = mysqli_query($koneksi, $query);
    mysqli_close($koneksi);
    return $result;
}

function getAllBuku() {
    $koneksi = koneksiDatabase();
    $query   = "SELECT * FROM buku ORDER BY id_buku ASC";
    $result  = mysqli_query($koneksi, $query);
    $data    = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_close($koneksi);
    return $data;
}

function getBukuById($id_buku) {
    $koneksi = koneksiDatabase();
    $id      = mysqli_real_escape_string($koneksi, $id_buku);
    $query   = "SELECT * FROM buku WHERE id_buku = '$id' LIMIT 1";
    $result  = mysqli_query($koneksi, $query);
    $data    = mysqli_fetch_assoc($result);
    mysqli_close($koneksi);
    return $data;
}

function insertBuku($judul_buku, $penulis, $penerbit, $tahun_terbit) {
    $koneksi      = koneksiDatabase();
    $judul_buku   = mysqli_real_escape_string($koneksi, $judul_buku);
    $penulis      = mysqli_real_escape_string($koneksi, $penulis);
    $penerbit     = mysqli_real_escape_string($koneksi, $penerbit);
    $tahun_terbit = mysqli_real_escape_string($koneksi, $tahun_terbit);

    $query = "INSERT INTO buku (judul_buku, penulis, penerbit, tahun_terbit)
              VALUES ('$judul_buku', '$penulis', '$penerbit', '$tahun_terbit')";

    $result = mysqli_query($koneksi, $query);
    mysqli_close($koneksi);
    return $result;
}

function updateBuku($id_buku, $judul_buku, $penulis, $penerbit, $tahun_terbit) {
    $koneksi      = koneksiDatabase();
    $id_buku      = mysqli_real_escape_string($koneksi, $id_buku);
    $judul_buku   = mysqli_real_escape_string($koneksi, $judul_buku);
    $penulis      = mysqli_real_escape_string($koneksi, $penulis);
    $penerbit     = mysqli_real_escape_string($koneksi, $penerbit);
    $tahun_terbit = mysqli_real_escape_string($koneksi, $tahun_terbit);

    $query = "UPDATE buku
              SET judul_buku   = '$judul_buku',
                  penulis      = '$penulis',
                  penerbit     = '$penerbit',
                  tahun_terbit = '$tahun_terbit'
              WHERE id_buku = '$id_buku'";

    $result = mysqli_query($koneksi, $query);
    mysqli_close($koneksi);
    return $result;
}

function deleteBuku($id_buku) {
    $koneksi = koneksiDatabase();
    $id      = mysqli_real_escape_string($koneksi, $id_buku);
    $query   = "DELETE FROM buku WHERE id_buku = '$id'";
    $result  = mysqli_query($koneksi, $query);
    mysqli_close($koneksi);
    return $result;
}

function getAllPeminjaman() {
    $koneksi = koneksiDatabase();
    $query   = "SELECT p.*, m.nama_member, m.nomor_member, b.judul_buku
                FROM peminjaman p
                JOIN member m ON p.id_member = m.id_member
                JOIN buku   b ON p.id_buku   = b.id_buku
                ORDER BY p.id_peminjaman ASC";
    $result  = mysqli_query($koneksi, $query);
    $data    = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_close($koneksi);
    return $data;
}

function getPeminjamanById($id_peminjaman) {
    $koneksi = koneksiDatabase();
    $id      = mysqli_real_escape_string($koneksi, $id_peminjaman);
    $query   = "SELECT p.*, m.nama_member, b.judul_buku
                FROM peminjaman p
                JOIN member m ON p.id_member = m.id_member
                JOIN buku   b ON p.id_buku   = b.id_buku
                WHERE p.id_peminjaman = '$id'
                LIMIT 1";
    $result  = mysqli_query($koneksi, $query);
    $data    = mysqli_fetch_assoc($result);
    mysqli_close($koneksi);
    return $data;
}

function insertPeminjaman($id_member, $id_buku, $tgl_pinjam, $tgl_kembali) {
    $koneksi    = koneksiDatabase();
    $id_member  = mysqli_real_escape_string($koneksi, $id_member);
    $id_buku    = mysqli_real_escape_string($koneksi, $id_buku);
    $tgl_pinjam = mysqli_real_escape_string($koneksi, $tgl_pinjam);
    $tgl_kembali = mysqli_real_escape_string($koneksi, $tgl_kembali);

    $query = "INSERT INTO peminjaman (id_member, id_buku, tgl_pinjam, tgl_kembali)
              VALUES ('$id_member', '$id_buku', '$tgl_pinjam', '$tgl_kembali')";

    $result = mysqli_query($koneksi, $query);
    mysqli_close($koneksi);
    return $result;
}

function updatePeminjaman($id_peminjaman, $id_member, $id_buku, $tgl_pinjam, $tgl_kembali) {
    $koneksi       = koneksiDatabase();
    $id_peminjaman = mysqli_real_escape_string($koneksi, $id_peminjaman);
    $id_member     = mysqli_real_escape_string($koneksi, $id_member);
    $id_buku       = mysqli_real_escape_string($koneksi, $id_buku);
    $tgl_pinjam    = mysqli_real_escape_string($koneksi, $tgl_pinjam);
    $tgl_kembali   = mysqli_real_escape_string($koneksi, $tgl_kembali);

    $query = "UPDATE peminjaman
              SET id_member   = '$id_member',
                  id_buku     = '$id_buku',
                  tgl_pinjam  = '$tgl_pinjam',
                  tgl_kembali = '$tgl_kembali'
              WHERE id_peminjaman = '$id_peminjaman'";

    $result = mysqli_query($koneksi, $query);
    mysqli_close($koneksi);
    return $result;
}

function deletePeminjaman($id_peminjaman) {
    $koneksi = koneksiDatabase();
    $id      = mysqli_real_escape_string($koneksi, $id_peminjaman);
    $query   = "DELETE FROM peminjaman WHERE id_peminjaman = '$id'";
    $result  = mysqli_query($koneksi, $query);
    mysqli_close($koneksi);
    return $result;
}

function selesaikanPeminjaman($id_peminjaman) {
    $koneksi       = koneksiDatabase();
    $id            = mysqli_real_escape_string($koneksi, $id_peminjaman);
    $tgl_selesai   = date('Y-m-d');
    $query = "UPDATE peminjaman
              SET status       = 'selesai',
                  tgl_kembali = '$tgl_selesai'
              WHERE id_peminjaman = '$id' AND status = 'aktif'";
    $result = mysqli_query($koneksi, $query);
    mysqli_close($koneksi);
    return $result;
}