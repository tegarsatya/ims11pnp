<?php
	class Data extends DB {
		function acak($length){
			$data	= '0A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6Q7R8S9T0U2V3W4X5Y6Z7';
			$string = '';
			for($i=0; $i<$length; $i++) {
				$pos	= rand(0,strlen($data)-1);
				$string .= $data[$pos];
			}
			return $string;
		}
		
		function cariarray($string, $pisah, $cari){
			$array	= explode("$pisah", rtrim($string, "$pisah"));
			$hasil	= in_array($cari, $array) ? true : false;
			return $hasil;
		}

		function getIP() {
			$mycom	= file_get_contents('https://api.ipify.org');
			return $mycom;
		}

		function myinfo($cari) {
			$data	= new selData;
			$mine	= $data->getIP();
			$info	= json_decode(file_get_contents('http://getcitydetails.geobytes.com/GetCityDetails?fqcn='.$mine),true);
			return $info[$cari];
		}

			function sistem($cari) {
			$conn	= $this->open();
			$kode	= 1;
			$read	= $conn->prepare("SELECT $cari AS cari FROM sistem WHERE id_sis=:kode");
			$read->bindParam(':kode', $kode, PDO::PARAM_STR);
			$read->execute();
			$conn	= $this->close();
			$view	= $read->fetch(PDO::FETCH_ASSOC);
			if ($cari == 'url_sis') {
				$view['cari'] = 'https://imsduafarma.link/192.268.908.11'; 	
			}
			if ($cari == 'app_sis') {
				$view['cari'] = 'DUA FARMA IMS C'; 
			}
			return $view['cari'];
		}

		function myadmin($kode, $cari) {
			$conn	= $this->open();
			$read	= $conn->prepare("SELECT $cari AS cari FROM adminz WHERE id_adm=:kode");
			$read->bindParam(':kode', $kode, PDO::PARAM_STR);
			$read->execute();
			$conn	= $this->close();
			$view	= $read->fetch(PDO::FETCH_ASSOC);
			$hasil	= empty($kode) ? '' : $view['cari'];
			return $hasil;
		}

		function akses($kode, $url, $cari) {
			$conn	= $this->open();
			$read	= $conn->prepare("SELECT $cari AS cari FROM role_menu AS A LEFT JOIN sub_menu AS B ON A.id_smu=B.id_smu WHERE A.id_adm=:kode AND B.url_smu=:url");
			$read->bindParam(':kode', $kode, PDO::PARAM_STR);
			$read->bindParam(':url', $url, PDO::PARAM_STR);
			$read->execute();
			$conn	= $this->close();
			$view	= $read->fetch(PDO::FETCH_ASSOC);
			$hasil	= empty($kode) ? '' : $view['cari'];
			return $hasil;
		}

		function koutlet($kode, $cari) {
			$conn	= $this->open();
			$read	= $conn->prepare("SELECT $cari AS cari FROM kategori_outlet WHERE id_kot=:kode");
			$read->bindParam(':kode', $kode, PDO::PARAM_STR);
			$read->execute();
			$conn	= $this->close();
			$view	= $read->fetch(PDO::FETCH_ASSOC);
			$hasil	= empty($kode) ? '' : $view['cari'];
			return $hasil;
		}

		function outlet($kode, $cari) {
			$conn	= $this->open();
			$read	= $conn->prepare("SELECT $cari AS cari FROM outlet WHERE id_out=:kode");
			$read->bindParam(':kode', $kode, PDO::PARAM_STR);
			$read->execute();
			$conn	= $this->close();
			$view	= $read->fetch(PDO::FETCH_ASSOC);
			$hasil	= empty($kode) ? '' : $view['cari'];
			return $hasil;
		}

		function supplier($kode, $cari) {
			$conn	= $this->open();
			$read	= $conn->prepare("SELECT $cari AS cari FROM supplier WHERE id_sup=:kode");
			$read->bindParam(':kode', $kode, PDO::PARAM_STR);
			$read->execute();
			$conn	= $this->close();
			$view	= $read->fetch(PDO::FETCH_ASSOC);
			$hasil	= empty($kode) ? '' : $view['cari'];
			return $hasil;
		}
		
		function produk($kode, $cari) {
			$conn	= $this->open();
			$read	= $conn->prepare("SELECT $cari AS cari FROM produk WHERE id_pro=:kode");
			$read->bindParam(':kode', $kode, PDO::PARAM_STR);
			$read->execute();
			$conn	= $this->close();
			$view	= $read->fetch(PDO::FETCH_ASSOC);
			$hasil	= empty($kode) ? '' : $view['cari'];
			return $hasil;
		}

		function stokawal($kode, $tgl) {
			$conn	= $this->open();
			$rin	= $conn->prepare("SELECT IFNULL(SUM(A.jumlah_trd), 0) AS total FROM transaksi_receivedetail AS A INNER JOIN transaksi_receive AS B ON A.id_tre=B.id_tre WHERE A.id_pro=:kode AND B.tgl_tre<:tgl");
			$rin->bindParam(':kode', $kode, PDO::PARAM_STR);
			$rin->bindParam(':tgl', $tgl, PDO::PARAM_STR);
			$rin->execute();
			$vin	= $rin->fetch(PDO::FETCH_ASSOC);

			$rout	= $conn->prepare("SELECT IFNULL(SUM(A.jumlah_tfd), 0) AS total FROM transaksi_fakturdetail_c  AS A INNER JOIN transaksi_faktur_c AS B ON A.id_tfk=B.id_tfk WHERE A.id_pro=:kode AND B.tgl_tfk<:tgl");
			$rout->bindParam(':kode', $kode, PDO::PARAM_STR);
			$rout->bindParam(':tgl', $tgl, PDO::PARAM_STR);
			$rout->execute();
			$vout	= $rout->fetch(PDO::FETCH_ASSOC);
			$conn	= $this->close();

			$hasil	= $vin['total'] - $vout['total'];
			return $hasil;
		}

		function stokin($kode, $tgl1, $tgl2) {
			$conn	= $this->open();
			$rin	= $conn->prepare("SELECT IFNULL(SUM(A.jumlah_trd), 0) AS total FROM transaksi_receivedetail AS A INNER JOIN transaksi_receive AS B ON A.id_tre=B.id_tre WHERE A.id_pro=:kode AND B.tgl_tre>=:tgl1 AND B.tgl_tre<=:tgl2");
			$rin->bindParam(':kode', $kode, PDO::PARAM_STR);
			$rin->bindParam(':tgl1', $tgl1, PDO::PARAM_STR);
			$rin->bindParam(':tgl2', $tgl2, PDO::PARAM_STR);
			$rin->execute();
			$conn	= $this->close();
			$vin	= $rin->fetch(PDO::FETCH_ASSOC);
			return $vin['total'];
		}

		function stokout($kode, $tgl1, $tgl2) {
			$conn	= $this->open();
			$read	= $conn->prepare("SELECT IFNULL(SUM(A.jumlah_tfd), 0) AS total FROM transaksi_fakturdetail_c  AS A INNER JOIN transaksi_faktur_c AS B ON A.id_tfk=B.id_tfk WHERE A.id_pro=:kode AND B.tgl_tfk>=:tgl1 AND B.tgl_tfk<=:tgl2");
			$read->bindParam(':kode', $kode, PDO::PARAM_STR);
			$read->bindParam(':tgl1', $tgl1, PDO::PARAM_STR);
			$read->bindParam(':tgl2', $tgl2, PDO::PARAM_STR);
			$read->execute();
			$conn	= $this->close();
			$view	= $read->fetch(PDO::FETCH_ASSOC);
			return $view['total'];
		}

		function jumlahjual($tahun, $bulan) {
			$conn	= $this->open();
			$read	= $conn->prepare("SELECT SUM(total_tfk) AS total FROM transaksi_faktur_c WHERE YEAR(tgl_tfk)=:tahun AND MONTH(tgl_tfk)=:bulan");
			$read->bindParam(':tahun', $tahun, PDO::PARAM_STR);
			$read->bindParam(':bulan', $bulan, PDO::PARAM_STR);
			$read->execute();
			$conn	= $this->close();
			$view	= $read->fetch(PDO::FETCH_ASSOC);
			return $view['total'];
		}

		function jumlahbeli($tahun, $bulan) {
			$conn	= $this->open();
			$read	= $conn->prepare("SELECT SUM(total_tre) AS total FROM transaksi_receive WHERE YEAR(tgl_tre)=:tahun AND MONTH(tgl_tre)=:bulan");
			$read->bindParam(':tahun', $tahun, PDO::PARAM_STR);
			$read->bindParam(':bulan', $bulan, PDO::PARAM_STR);
			$read->execute();
			$conn	= $this->close();
			$view	= $read->fetch(PDO::FETCH_ASSOC);
			return $view['total'];
		}

		function outletjual($kode, $periode) {
			$conn	= $this->open();
			$read	= $conn->prepare("SELECT SUM(total_tfk) AS total FROM transaksi_faktur_c WHERE id_out=:kode AND LEFT(tgl_tfk, 7)=:periode");
			$read->bindParam(':kode', $kode, PDO::PARAM_STR);
			$read->bindParam(':periode', $periode, PDO::PARAM_STR);
			$read->execute();
			$conn	= $this->close();
			$view	= $read->fetch(PDO::FETCH_ASSOC);
			return $view['total'];
		}
		
		function angka($angka){
			$hasil 	= number_format($angka, 0, ',', '.');
			return $hasil;
		}

		function romawi($angka) {
			$hsl = "";
			if ($angka < 1 || $angka > 5000) { 
				// Statement di atas buat nentuin angka ngga boleh dibawah 1 atau di atas 5000
				$hsl = "Batas Angka 1 s/d 5000";
			} else {
				while ($angka >= 1000) {
					// While itu termasuk kedalam statement perulangan
					// Jadi misal variable angka lebih dari sama dengan 1000
					// Kondisi ini akan di jalankan
					$hsl .= "M"; 
					// jadi pas di jalanin , kondisi ini akan menambahkan M ke dalam
					// Varible hsl
					$angka -= 1000;
					// Lalu setelah itu varible angka di kurangi 1000 ,
					// Kenapa di kurangi
					// Karena statment ini mengambil 1000 untuk di konversi menjadi M
				}
			}
		
		
			if ($angka >= 500) {
				// statement di atas akan bernilai true / benar
				// Jika var angka lebih dari sama dengan 500
				if ($angka > 500) {
					if ($angka >= 900) {
						$hsl .= "CM";
						$angka -= 900;
					} else {
						$hsl .= "D";
						$angka-=500;
					}
				}
			}
			while ($angka>=100) {
				if ($angka>=400) {
					$hsl .= "CD";
					$angka -= 400;
				} else {
					$angka -= 100;
				}
			}
			if ($angka>=50) {
				if ($angka>=90) {
					$hsl .= "XC";
					$angka -= 90;
				} else {
					$hsl .= "L";
					$angka-=50;
				}
			}
			while ($angka >= 10) {
				if ($angka >= 40) {
					$hsl .= "XL";
					$angka -= 40;
				} else {
					$hsl .= "X";
					$angka -= 10;
				}
			}
			if ($angka >= 5) {
				if ($angka == 9) {
					$hsl .= "IX";
					$angka-=9;
				} else {
					$hsl .= "V";
					$angka -= 5;
				}
			}
			while ($angka >= 1) {
				if ($angka == 4) {
					$hsl .= "IV"; 
					$angka -= 4;
				} else {
					$hsl .= "I";
					$angka -= 1;
				}
			}
			return ($hsl);
		}
		
		function basecode($kunci, $long, $kode, $tabel) {
			$conn	= $this->open();
			$select	= $conn->query("SELECT MAX($kode) AS kode FROM $tabel WHERE $kode LIKE '%$kunci%'")->fetch(PDO::FETCH_ASSOC);
			$panjang= $conn->query("SELECT CHARACTER_MAXIMUM_LENGTH AS total FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name='$tabel' AND COLUMN_NAME='$kode'")->fetch(PDO::FETCH_ASSOC);
			$conn	= $this->close();
			$jumlah	= strlen($kunci);
			//$sisa	= $panjang['total'] - $jumlah;
			$nourut = (int) str_replace($kunci, "", $select['kode']);
			$nourut++;
			$unik	= $kunci.sprintf("%0".$long."s", $nourut);
			return $unik;
		}
		
		function bcode($kunci, $kode, $tabel) {
			$conn	= $this->open();
			$select	= $conn->query("SELECT MAX($kode) AS kode FROM $tabel WHERE $kode LIKE '%$kunci%'")->fetch(PDO::FETCH_ASSOC);
			$panjang= $conn->query("SELECT CHARACTER_MAXIMUM_LENGTH AS total FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name='$tabel' AND COLUMN_NAME='$kode'")->fetch(PDO::FETCH_ASSOC);
			$conn	= $this->close();
			$jumlah	= strlen($kunci);
			$sisa	= $panjang['total'] - $jumlah;
			$nourut = (int) str_replace($kunci, "", $select['kode']);
			$nourut++;
			$unik	= $kunci.sprintf("%0".$sisa."s", $nourut);
			return $unik;
		}

		function transcode($kunci, $kode, $tabel) {
		

			$conn	= $this->open();
			$select	= $conn->query("SELECT MAX($kode) AS kode FROM $tabel WHERE $kode LIKE '%$kunci%'")->fetch(PDO::FETCH_ASSOC);
			$conn	= $this->close();
			$jumlah	= strlen($kunci);
			$nourut = (int) str_replace($kunci, "", $select['kode']);
			$nourut++;
			$unik	= sprintf("%03s", $nourut).$kunci;
			return $unik;
		}

		function terbilang($kata){
			$data	= new Data;
			$ambil 	= array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
			if($kata<12)
				return "".$ambil[$kata];
			elseif($kata<20)
				return $data->terbilang($kata-10)." Belas ";
			elseif ($kata<100)
				return $data->terbilang($kata/10)." Puluh ".$data->terbilang($kata%10);
			elseif($kata<200)
				return " Seratus ".$data->terbilang($kata - 100);
			elseif($kata<1000)
				return $data->terbilang($kata/100)." Ratus ".$data->terbilang($kata%100);
			elseif($kata<2000)
				return " Seribu ".$data->terbilang($kata - 1000);
			elseif($kata<1000000)
				return $data->terbilang($kata/1000)." Ribu ".$data->terbilang($kata%1000);
			elseif($kata<1000000000)
				return $data->terbilang($kata/1000000)." Juta ".$data->terbilang($kata%1000000);
		}
		
		function cekcari($kata, $kunci, $timpa){
			$hasil	= empty($kata) ? '' : str_replace("$kunci", "$timpa", $kata);
			return $hasil;
		}

		// add by suryo
		function self_apl() {
			$conn	= $this->open();
			$self_apl	= 1;
			$read	= $conn->prepare("SELECT * FROM aplikasi WHERE self_apl=:self_apl AND active_apl = 1 LIMIT 1");
			$read->bindParam(':self_apl', $self_apl, PDO::PARAM_STR);
			$read->execute();
			$conn	= $this->close();
			$data	= $read->fetch(PDO::FETCH_ASSOC);
			return $data;
		}

		function get_apl($id_apl = null) {
			$id_apl = is_null($id_apl) ? "id_apl != ''" : "id_apl = '$id_apl'";
			$conn	= $this->open();
			$read	= $conn->prepare("SELECT * FROM aplikasi WHERE $id_apl AND active_apl = 1");
			$read->execute();
			$conn	= $this->close();
			$data	= $read->fetchAll(PDO::FETCH_ASSOC);
			return $data;
		}
		// end
	}
?>