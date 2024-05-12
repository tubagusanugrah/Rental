<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Motor Tubagus</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <img class="foto-cetak img-fluid mb-4" src="honda.png" alt="">
                        <h1 class="text-center mb-4">Rental Motor</h1>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="mb-3">
                                <label for="namaPelanggan" class="form-label">Nama Pelanggan:</label>
                                <input type="text" class="form-control" id="namaPelanggan" name="namaPelanggan">
                            </div>
                            <div class="mb-3">
                                <label for="lamaRental" class="form-label">Lama Waktu Rental (per hari):</label>
                                <input type="number" class="form-control" id="lamaRental" name="lamaRental">
                            </div>
                            <div class="mb-3">
                                <label for="jenisMotor" class="form-label">Jenis Motor:</label>
                                <select class="form-select" id="jenisMotor" name="jenisMotor">
                                    <option value="BeatKarbu">Beat Karbu</option>
                                    <option value="Genio">Genio</option>
                                    <option value="KLX">KLX</option>
                                    <option value="Ninja">Ninja</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        <div class="output mt-4">
                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                // Tangani data formulir
                                $namaPelanggan = $_POST['namaPelanggan'];
                                $lamaRental = $_POST['lamaRental'];
                                $jenisMotor = $_POST['jenisMotor'];
            
                                // Harga per hari untuk semua jenis motor
                                $hargaRentalPerHari = array(
                                    "BeatKarbu" => 70000,
                                    "Genio" => 75000,
                                    "KLX" => 50000,
                                    "Ninja" => 90000
                                );
            
                                // Periksa jika jenis motor yang dipilih ada dalam daftar harga
                                if (array_key_exists($jenisMotor, $hargaRentalPerHari)) {
                                    // Buat objek dari kelas buy dengan harga rental sesuai jenis motor yang dipilih
                                    $rental = new buy($namaPelanggan, $hargaRentalPerHari[$jenisMotor], $lamaRental);
            
                                    // Pemanggilan untuk menampilkan struk
                                    $rental->struk();
                                } else {
                                    echo "<p>Jenis motor yang dipilih tidak valid.</p>";
                                }
                            }
            
                            // Definisikan kelas di luar blok if ($_SERVER["REQUEST_METHOD"] == "POST")
                            class Rental
                            {
                                protected $NamaPelanggan;
                                protected $Price;
                                protected $Total;
                                protected $Pajak;
                                protected $Diskon;
                                protected $members;
            
                                public function __construct($NamaPelanggan, $Price, $Total)
                                {
                                    $this->NamaPelanggan = $NamaPelanggan;
                                    $this->Price = $Price;
                                    $this->Total = $Total;
                                    $this->Pajak = 10000; // Pajak Rp 10.000
                                    $this->Diskon = 5 / 100;
                                    $this->members = array("ana", "udin", "jamal", "fajar"); // Nama member
                                }
            
                                public function getNamaPelanggan()
                                {
                                    return $this->NamaPelanggan;
                                }
            
                                public function getPrice()
                                {
                                    return $this->Price;
                                }
            
                                public function getTotal()
                                {
                                    return $this->Total;
                                }
            
                                public function getPajak()
                                {
                                    return $this->Pajak;
                                }
            
                                public function getDiskon()
                                {
                                    return $this->Diskon;
                                }
            
                                public function getMembers()
                                {
                                    return $this->members;
                                }
                            }
            
                            class buy extends Rental
                            {
                                public function __construct($NamaPelanggan, $Price, $Total)
                                {
                                    parent::__construct($NamaPelanggan, $Price, $Total);
                                }
            
                                public function HitungJumlah()
                                {
                                    $total = ($this->Price * $this->Total) + $this->Pajak;
            
                                    // Potongan harga untuk member
                                    if (in_array(strtolower($this->NamaPelanggan), $this->getMembers())) {
                                        $total -= ($total * $this->Diskon);
                                    }
                                    return $total;
                                }
            
                                public function struk()
                                {
                                    echo "<h1>Bukti Transaksi</h1>";
                                    $total = $this->HitungJumlah();
                                    echo "<p>" . $this->NamaPelanggan . " berstatus sebagai ";
                                    if (in_array(strtolower($this->NamaPelanggan), $this->getMembers())) {
                                        echo "member dan mendapat potongan harga 5%.</p>";
                                    } else {
                                        echo "non-member.</p>";
                                    }
                                    echo "Jenis motor yang di rental adalah " . $_POST["jenisMotor"] . " selama " . $_POST["lamaRental"] . " hari";
            
                                    // Menampilkan harga rental per hari untuk jenis motor yang dipilih
                                    echo "<p>Harga Rental Per Hari: Rp. " . number_format($this->Price, 2, ',', '.') . "</p>";
            
                                    // Menampilkan total harga dengan pajak
                                    echo "<p>Total Harga (termasuk pajak): Rp. " . number_format($total, 2, ',', '.') . "</p>";
            
                                    // Tambahkan tombol Print
                                    echo '<button onclick="window.print()" class="btn btn-primary">Print</button>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>