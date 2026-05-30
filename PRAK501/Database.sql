CREATE DATABASE IF NOT EXISTS perpustakaan
    CHARACTER SET utf8
    COLLATE utf8_general_ci;

USE perpustakaan;

CREATE TABLE IF NOT EXISTS member (
    id_member       INT AUTO_INCREMENT PRIMARY KEY,
    nama_member     VARCHAR(250) NOT NULL,
    nomor_member    VARCHAR(15)  NOT NULL UNIQUE,
    alamat          TEXT,
    tgl_mendaftar   DATETIME     DEFAULT CURRENT_TIMESTAMP,
    tgl_terakhir_bayar DATE
);

CREATE TABLE IF NOT EXISTS buku (
    id_buku         INT AUTO_INCREMENT PRIMARY KEY,
    judul_buku      VARCHAR(500) NOT NULL,
    penulis         VARCHAR(500) NOT NULL,
    penerbit        VARCHAR(250),
    tahun_terbit    INT
);

CREATE TABLE IF NOT EXISTS peminjaman (
    id_peminjaman   INT AUTO_INCREMENT PRIMARY KEY,
    id_member       INT  NOT NULL,
    id_buku         INT  NOT NULL,
    tgl_pinjam      DATE NOT NULL,
    tgl_kembali     DATE NOT NULL,
    status          ENUM('aktif','selesai') NOT NULL DEFAULT 'aktif',
    CONSTRAINT fk_peminjaman_member
        FOREIGN KEY (id_member) REFERENCES member(id_member)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_peminjaman_buku
        FOREIGN KEY (id_buku)   REFERENCES buku(id_buku)
        ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO member (nama_member, nomor_member, alamat, tgl_mendaftar, tgl_terakhir_bayar) VALUES
('Ahmad Fauzi',      'M001', 'Jl. Veteran No. 10, Banjarmasin', NOW(), '2025-12-01'),
('Siti Rahmawati',   'M002', 'Jl. A. Yani KM 5, Banjarmasin',  NOW(), '2025-11-15'),
('Budi Santoso',     'M003', 'Jl. Lambung Mangkurat No. 3',     NOW(), NULL);

INSERT INTO buku (judul_buku, penulis, penerbit, tahun_terbit) VALUES
('Negeri Para Bedebah',      'Tere Liye', 'Gramedia', 2012),
('Negeri Di Ujung Tanduk',   'Tere Liye', 'Gramedia', 2013),
('Bumi',                     'Tere Liye', 'Gramedia', 2014),
('Laskar Pelangi',           'Andrea Hirata', 'Bentang Pustaka', 2005),
('Sang Pemimpi',             'Andrea Hirata', 'Bentang Pustaka', 2006);

INSERT INTO peminjaman (id_member, id_buku, tgl_pinjam, tgl_kembali) VALUES
(1, 1, '2025-01-10', '2025-01-24'),
(2, 3, '2025-01-15', '2025-01-29'),
(3, 5, '2025-02-01', '2025-02-15');