<!DOCTYPE html>
<html>
<head>
<style>
/* BAGIAN 1: CSS UNTUK TAMPILAN (UI) */
/* Mengambil gaya form dari W3Schools agar input terlihat rapi dan modern */
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

/* Tombol submit diberi warna hijau khas W3Schools */
input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

/* Pengaturan tabel: border-collapse agar garis menyatu, dan warna selang-seling[cite: 1] */
#hasilTable {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#hasilTable td, #hasilTable th {
  border: 1px solid #ddd;
  padding: 8px;
}

/* Memberikan warna abu-abu muda pada baris genap agar mudah dibaca[cite: 1] */
#hasilTable tr:nth-child(even){background-color: #f2f2f2;}

#hasilTable th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
</head>
<body>

<h3>Pencarian Data Mahasiswa</h3>

<div class="container">
  <!-- BAGIAN 2: FORM INPUT -->
  <!-- Menggunakan metode POST untuk mengirim data pencarian ke server[cite: 1] -->
  <form action="" method="POST">
    <label>Pencarian</label>
    <!-- Dropdown 'jenisCari' digunakan sebagai parameter kolom database (nama/prodi/alamat)[cite: 1] -->
    <select name="jenisCari">
      <option value="nama">Nama</option>
      <option value="prodi">Program Studi</option>
      <option value="alamat">Alamat</option>
    </select>

    <label>Data Pencarian</label>
    <input type="text" name="dataCari" placeholder="Masukkan kata kunci..">
    
    <input type="submit" name="submit" value="Submit">
  </form>
</div>

<?php
/* BAGIAN 3: LOGIKA PHP & DATABASE */
// Mengecek apakah tombol submit sudah ditekan oleh user[cite: 1]
if (isset($_POST['submit'])) {
    // Inisialisasi variabel koneksi sesuai konfigurasi di datamhs.php[cite: 1, 2]
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "kampus";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Menangkap data dari form input ke dalam variabel PHP[cite: 1]
    $jenisCari = $_POST['jenisCari'];
    $dataCari = $_POST['dataCari'];

    /* QUERY DINAMIS: Ini adalah inti dari tugas ini. 
       Nama kolom diambil dari variabel $jenisCari sehingga pencarian bisa fleksibel[cite: 1] */
    $sql = "SELECT * FROM mahasiswa WHERE $jenisCari LIKE '%$dataCari%'";
    $result = $conn->query($sql);

    echo "<h3>Hasil Pencarian</h3>";
    
    // Jika data ditemukan (lebih dari 0 baris), maka tampilkan tabel[cite: 1]
    if ($result->num_rows > 0) {
        echo "<table id='hasilTable'>";
        echo "<tr><th>NIM</th><th>Nama</th><th>Program Studi</th><th>Alamat</th></tr>";
        
        // Melakukan perulangan untuk menampilkan setiap baris data dari database[cite: 1, 2]
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["nim"]."</td>
                    <td>".$row["nama"]."</td>
                    <td>".$row["prodi"]."</td>
                    <td>".$row["alamat"]."</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        // Jika hasil query kosong[cite: 1]
        echo "Data tidak ditemukan.";
    }
    // Menutup koneksi database
    $conn->close();
}
?>

</body>
</html>