<?php
	//  Buat fungsi bernama total_rupiah untuk menghitung nilai rupiah hasil penukaran valas 
	//	sesuai INSTRUKSI KERJA 7.

      function total_rupiah($jumlah, $nilai_valas){
		return $jumlah * $nilai_valas;
      }

	//  Buat sebuah array satu dimensi yang berisi beberapa valuta asing (valas)
	//	sesuai INSTRUKSI KERJA 1 dan urutkan sesuai INSTURKSI KERJA 2.
	$valas = array("u"=> "us_dollar","s"=>"singapore_dollar","p"=>"pound_sterling",
				   "j"=>"japan_yen","s2"=>"south_korea_won","c"=>"chinese_yuan");
	

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Money Changer Amanah</title>
		<!-- Hubungkan halaman web dengan file library CSS yang sudah tersedia -->
		<!-- sesuai INSTRUKSI KERJA 4. -->
		<link rel="stylesheet" href="style/bootstrap.css" >
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

	</head>
	
	<body>
	<div class="container border">
		<!-- Menampilkan judul halaman -->
		<h1 style="display: inline-block;"> Money Changer Amanah</h1>
		
		<!-- Tampilkan logo sesuai INSTRUKSI KERJA 5. -->
		<img src="image/money-logo.png" alt="money_logo" style="width: 40px; height: 40px; vertical-align: top;">


		
		<!-- Form untuk memasukkan data pemesanan. -->
		<form action="index.php" method="post" id="formMoneyChanger">
			<div class="row">
				<!-- Masukan nama pemesan. Tipe data text. -->
				<div class="col-lg-2"><label for="nama">Nama Pemesan:</label></div>
				<div class="col-lg-2"><input type="text" id="nama" name="nama"></div>
			</div>
			<div class="row">
				<!-- Masukan NIK pemesan. Tipe data text. -->
			 	<!-- Modifikasi input supaya NIK yang dimasukkan harus tepat 16 karakter sesuai INSTRUKSI KERJA 6. -->

				<div class="col-lg-2"><label for="nik">NIK:</label></div>
				<div class="col-lg-2"><input type="text" id="nik" name="nik"></div> 
				<!--Type berubah menjadi text karena NIK bukan Number -->

			</div>
			<div class="row">
				<!-- Masukan pilihan valuta asing. -->
				<div class="col-lg-2"><label for="valas">Valuta asing:</label></div>
				<div class="col-lg-2">
					<select id="valas" name="valas">
					<option value="">- Pilih valas -</option>

					<!-- Tampilkan dropdown valas berdasarkan data pada array valas menggunakan perulangan -->
					<!-- sesuai INSTRUKSI KERJA 3. -->
					<?php
					arsort($valas);
					foreach ($valas as $key => $value) {
							echo "<option value='$value'>$value</option>";
						}
					?>

					</select>
				</div>
			</div>
			<div class="row">
				<!-- Masukan jumlah valas. Tipe data number. -->
				<div class="col-lg-2"><label for="jumlah">Jumlah valas:</label></div>
				<div class="col-lg-2"><input type="number" id="jumlah" name="jumlah" maxlength="4"></div>
			</div>
			<div class="row">
				<!-- Tombol Submit -->
				<div class="col-lg-2"><button class="btn btn-primary" type="submit" form="formMoneyChanger" value="Hitung" name="Hitung">Hitung</button></div>
				<div class="col-lg-2"></div>		
			</div>
		</form>
	</div>
	<?php
		//	Kode berikut dieksekusi setelah tombol Hitung ditekan.
		if(isset($_POST['Hitung'])) {
			
			$dataKonversiValas = array(
				'nama' => $_POST['nama'],
				'nik' => $_POST['nik'],
				'valas' => $_POST['valas'],
				'jumlah' => $_POST['jumlah']
			);

		//	Simpan data pemesanan valas dari array $dataKonversiValas ke dalam file JSON/TXT/Excel/database sesuai INSTRUKSI KERJA 11.
		$berkas = "json/data.json";
		$dataJson = json_encode($dataKonversiValas, JSON_PRETTY_PRINT);
		file_put_contents($berkas,$dataJson);
		$dataJson = file_get_contents($berkas);
		$dataKonversiValas = json_decode($dataJson, true);


		//	Simpan jumlah valas dalam variabel $jumlah sesuai INSTRUKSI KERJA 8

		//	Variabel $nilaiValas menyimpan nilai valas berdasarkan valas yang dipilih.
		//	Gunakan pencabangan untuk menentukan nilai variabel $nilaiValas berdasarkan INSTRUKSI KERJA 9.
		$valas = $_POST['valas'];
		function conver ($valas){

		if($valas == 'us_dollar'){
			return 15000;
		}elseif ($valas == 'singapore_dollar'){
			return 11000;
		}elseif ($valas == 'japan_yen'){
			return 110;
		}elseif ($valas == 'pound_sterling'){
			return 18500;
		}elseif ($valas == 'south_korea_won'){
			return 11;
		}elseif ($valas == 'chinese_yuan'){
			return 2200;
		}else{
			return 0;
		}
	}

	$nilaiValas = conver($valas);
	// echo $nilaiValas;

      


		//	Variabel $totalRupiah menyimpan nilai konversi valas ke dalam Rupiah.
		//	Gunakan fungsi yang sudah dibuat dalam Instruksi Kerja 7 untuk menghitung nilai $totalRupiah
		//		sesuai INSTRUKSI KERJA 10.
		$total_rupiah = total_rupiah($dataKonversiValas['jumlah'], $nilaiValas);


		//	Tampilkan data pemesanan dan hasil perhitungan konversi valas.
			echo "
				<br/>
				<div class='container'>
					<div class='row'>
						<!-- Menampilkan nama pemesan. -->
						<div class='col-lg-2'>Nama pemesan:</div>
						<div class='col-lg-2'>".$dataKonversiValas['nama']."</div>
					</div>
					<div class='row'>
						<!-- Menampilkan NIK pemesan. -->
						<div class='col-lg-2'>NIK:</div>
						<div class='col-lg-2'>".$dataKonversiValas['nik']."</div>
					</div>
					<div class='row'>
						<!-- Menampilkan valas yang dikonversi. -->
						<div class='col-lg-2'>Valas:</div>
						<div class='col-lg-2'>".$dataKonversiValas['valas']."</div>
					</div>
					<div class='row'>
						<!-- Menampilkan jumlah valas. -->
						<div class='col-lg-2'>Jumlah valas:</div>
						<div class='col-lg-2'>".$dataKonversiValas['jumlah']."</div>
					</div>
					<div class='row'>
						<!-- Menampilkan hasil konversi. -->
						<div class='col-lg-2'>Total Rupiah:</div>
						<div class='col-lg-2'>Rp".number_format($total_rupiah, 0, ".", ".").",-</div>
					</div>
			</div>
			";
		}
	?>
	</body>
</html>