<?php
	require_once('../../config/connection/connection.php');
	require_once('../../config/connection/security.php');
	require_once('../../config/function/data.php');
	$secu	= new Security;
	$base	= new DB;
	$data	= new Data;
	$conn	= $base->open();
	$catat	= date('Y-m-d H:i:s');
	$admin	= $secu->injection(@$_COOKIE['adminkuy']);
	$kunci	= $secu->injection(@$_COOKIE['kuncikuy']);
	$menu	= $secu->injection(@$_POST['namamenu']);
	$secu->validadmin($admin, $kunci);
	if($secu->validadmin($admin, $kunci)==false){
		//header('location:'.$data->sistem('url_sis').'/signout');
		$url	= 'signout';
	} else {
		switch($menu){
			case 'faktur':
				$id		= 0;
				$uniq	= $secu->injection($_POST['keycode']);
				$code	= base64_decode($uniq);
				$outlet	= $secu->injection($_POST['outlet']);
				$invoice= $secu->injection($_POST['invoice']);
				$pecah	= explode("/", $invoice);
				$gabung	= '/SJ/'.$pecah[2].'/'.$data->romawi(date('m')).'/'.date('y');
				//$kode	= $data->transcode($gabung, 'kode_tsl', 'transaksi_sales');
				$kode	= $invoice;
				$nofak	= $secu->injection($_POST['nomorfaktur']);
				$tglfak	= $secu->injection($_POST['tglfaktur']);
				$nomorpo= $secu->injection($_POST['nomorpo']);
				$tglpo	= $secu->injection($_POST['tglpo']);
				$tglsj	= $secu->injection($_POST['tglsales']);
				$jatuh	= $secu->injection($_POST['jatuhtempo']);
				//$stotal	= str_replace('.', '', $_POST['pstotal']);
				//$ppn	= str_replace('.', '', $_POST['pppn']);
				//$gtotal	= str_replace('.', '', $_POST['pgtotal']);
				//$status	= 'Proses';
				$status	= 'Faktur';
				//$nol	= 0;
				//CEKING
				$read	= $conn->prepare("SELECT top_odi FROM outlet_diskon WHERE id_out=:outlet");
				$read->bindParam(':outlet', $sales, PDO::PARAM_STR);
				$read->execute();
				$view	= $read->fetch(PDO::FETCH_ASSOC);
				//$limit	= $secu->injection($_POST['topoutlet']);
				//$batas	= date("Y-m-d H:i:s", strtotime("+$view[top_odi] Days", strtotime($catat)));
				$mcek	= $conn->prepare("SELECT COUNT(id_tfk) AS total FROM transaksi_faktur WHERE id_tfk=:code");
				$mcek->bindParam(':code', $code, PDO::PARAM_STR);
				$mcek->execute();
				$hcek	= $mcek->fetch(PDO::FETCH_ASSOC);
				if(empty($hcek['total'])){
					$save	= $conn->prepare("INSERT INTO transaksi_faktur VALUES(:code, :id, :outlet, :kode, :tglsj, :nomorpo, :tglpo, :nofak, :tglfak, :jatuh, :id, :id, :id, :status, :catat, :admin, :catat, :admin)");
					$save->bindParam(':code', $code, PDO::PARAM_STR);
					$save->bindParam(':id', $id, PDO::PARAM_STR);
					$save->bindParam(':outlet', $outlet, PDO::PARAM_STR);
					$save->bindParam(':kode', $kode, PDO::PARAM_STR);
					$save->bindParam(':tglsj', $tglsj, PDO::PARAM_STR);
					$save->bindParam(':nomorpo', $nomorpo, PDO::PARAM_STR);
					$save->bindParam(':tglpo', $tglpo, PDO::PARAM_STR);
					$save->bindParam(':nofak', $nofak, PDO::PARAM_STR);
					$save->bindParam(':tglfak', $tglfak, PDO::PARAM_STR);
					$save->bindParam(':jatuh', $jatuh, PDO::PARAM_STR);
					$save->bindParam(':stotal', $stotal, PDO::PARAM_STR);
					$save->bindParam(':ppn', $ppn, PDO::PARAM_STR);
					$save->bindParam(':gtotal', $gtotal, PDO::PARAM_STR);
					$save->bindParam(':status', $status, PDO::PARAM_STR);
					$save->bindParam(':catat', $catat, PDO::PARAM_STR);
					$save->bindParam(':admin', $admin, PDO::PARAM_STR);
					$save->execute();
					//DETAIL
					/*
					$jum	= count($_POST['kodestok']);
					$no		= 0;
					while($no<$jum){
						$kodestok= $secu->injection($_POST['kodestok'][$no]);
						$produk	= $secu->injection($_POST['product'][$no]);
						$jumlah	= str_replace('.', '', $_POST['jumlah'][$no]);
						$harga	= str_replace('.', '', $_POST['harga'][$no]);
						$diskon	= $secu->injection($_POST['diskon'][$no]);
						$total	= str_replace('.', '', $_POST['total'][$no]);
						//INPUT
						$save	= $conn->prepare("INSERT INTO transaksi_fakturdetail VALUES(:id, :code, :kodestok, :pro, :jumlah, :harga, :diskon, :total, :catat, :admin, :catat, :admin)");
						$save->bindParam(':id', $id, PDO::PARAM_STR);
						$save->bindParam(':code', $code, PDO::PARAM_STR);
						$save->bindParam(':kodestok', $kodestok, PDO::PARAM_STR);
						$save->bindParam(':pro', $produk, PDO::PARAM_STR);
						$save->bindParam(':jumlah', $jumlah, PDO::PARAM_STR);
						$save->bindParam(':harga', $harga, PDO::PARAM_STR);
						$save->bindParam(':diskon', $diskon, PDO::PARAM_STR);
						$save->bindParam(':total', $total, PDO::PARAM_STR);
						$save->bindParam(':catat', $catat, PDO::PARAM_STR);
						$save->bindParam(':admin', $admin, PDO::PARAM_STR);
						$save->execute();
						//EDIT
						$edit	= $conn->prepare("UPDATE produk_stokdetail SET keluar_psd=keluar_psd+:jumlah, sisa_psd=sisa_psd-:jumlah WHERE id_psd=:kodestok");
						$edit->bindParam(':kodestok', $kodestok, PDO::PARAM_STR);
						$edit->bindParam(':jumlah', $jumlah, PDO::PARAM_STR);
						$edit->execute();
					$no++;
					}
					*/
					//RIWAYAT
					$riwayat= $conn->query("INSERT INTO riwayat (kode_riwayat,menu_riwayat,status_riwayat,ket_riwayat,created_at,created_by) VALUES('$code', 'Faktur Penjualan', 'Create', '', '$catat', '$admin')");
					//$hasil	= ($save==true) ? "success" : "error";
					if($save==true){
						//setcookie('info', 'success', time() + 5, '/');
						//setcookie('pesan', 'Data diskon produk berhasil diupdate.', time() + 5, '/');
						$url	= "itemsales/$uniq";
					} else {
						setcookie('info', 'danger', time() + 5, '/');
						setcookie('pesan', 'Data faktur sales gagal diinput.', time() + 5, '/');
						$url	= "fsales";
					}
				} else {
					setcookie('info', 'danger', time() + 5, '/');
					setcookie('pesan', 'Data faktur sales gagal diinput.', time() + 5, '/');
					$url	= "fsales";
				}
			break;
			case 'items':
				$uniq	= $secu->injection($_POST['keycode']);
				$code	= base64_decode($uniq);
				$stotal	= str_replace('.', '', $_POST['pstotal']);
				// $ppn	= str_replace('.', '', $_POST['pppn']);
				$gtotal	= str_replace('.', '', $_POST['pgtotal']);
				$status	= 'Tagihan';
				$jum	= count($_POST['kodestok']);
				$no		= 0;
				while($no<$jum){
					$kodestok= $secu->injection($_POST['kodestok'][$no]);
					$produk	= $secu->injection($_POST['product'][$no]);
					$jumlah	= str_replace('.', '', $_POST['jumlah'][$no]);
					$harga	= str_replace('.', '', $_POST['harga'][$no]);
					$diskon	= $secu->injection($_POST['diskon'][$no]);
					$total	= str_replace('.', '', $_POST['total'][$no]);
					//INPUT
					$save	= $conn->prepare("INSERT INTO transaksi_fakturdetail VALUES(:id, :code, :kodestok, :pro, :jumlah, :harga, :diskon, :total, :catat, :admin, :catat, :admin)");
					$save->bindParam(':id', $id, PDO::PARAM_STR);
					$save->bindParam(':code', $code, PDO::PARAM_STR);
					$save->bindParam(':kodestok', $kodestok, PDO::PARAM_STR);
					$save->bindParam(':pro', $produk, PDO::PARAM_STR);
					$save->bindParam(':jumlah', $jumlah, PDO::PARAM_STR);
					$save->bindParam(':harga', $harga, PDO::PARAM_STR);
					$save->bindParam(':diskon', $diskon, PDO::PARAM_STR);
					$save->bindParam(':total', $total, PDO::PARAM_STR);
					$save->bindParam(':catat', $catat, PDO::PARAM_STR);
					$save->bindParam(':admin', $admin, PDO::PARAM_STR);
					$save->execute();
					//EDIT
					$edit	= $conn->prepare("UPDATE produk_stokdetail SET keluar_psd=keluar_psd+:jumlah, sisa_psd=sisa_psd-:jumlah WHERE id_psd=:kodestok");
					$edit->bindParam(':kodestok', $kodestok, PDO::PARAM_STR);
					$edit->bindParam(':jumlah', $jumlah, PDO::PARAM_STR);
					$edit->execute();
				$no++;
				}
				//EDIT
				$edit	= $conn->prepare("UPDATE transaksi_faktur SET subtot_tfk=:stotal, ppn_tfk=:ppn, total_tfk=:gtotal, status_tfk=:status, updated_at=:catat, updated_by=:admin WHERE id_tfk=:code");
				$edit->bindParam(':code', $code, PDO::PARAM_STR);
				$edit->bindParam(':stotal', $stotal, PDO::PARAM_STR);
				$edit->bindParam(':ppn', $ppn, PDO::PARAM_STR);
				$edit->bindParam(':gtotal', $gtotal, PDO::PARAM_STR);
				$edit->bindParam(':status', $status, PDO::PARAM_STR);
				$edit->bindParam(':catat', $catat, PDO::PARAM_STR);
				$edit->bindParam(':admin', $admin, PDO::PARAM_STR);
				$edit->execute();
				if($edit==true){
					setcookie('info', 'success', time() + 5, '/');
					setcookie('pesan', 'Data faktur sales berhasil diinput.', time() + 5, '/');
				} else {
					setcookie('info', 'danger', time() + 5, '/');
					setcookie('pesan', 'Data faktur sales gagal diinput.', time() + 5, '/');
				}
				$url	= 'fsales';
			break;
			case 'update':
				$kode	= $secu->injection($_POST['keycode']);
				$nofak	= $secu->injection($_POST['nomorfak']);
				$tglfak	= $secu->injection($_POST['tglfak']);
				$nosj	= $secu->injection($_POST['nomorsj']);
				$tglsj	= $secu->injection($_POST['tglsj']);
				$nopo	= $secu->injection($_POST['nomorpo']);
				$tglpo	= $secu->injection($_POST['tglpo']);
				$jatuh	= $secu->injection($_POST['jatuhtempo']);
				$edit	= $conn->prepare("UPDATE transaksi_faktur SET kode_tfk=:nofak, tgl_tfk=:tglfak, sj_tfk=:nosj, tglsj_tfk=:tglsj, po_tfk=:nopo, tglpo_tfk=:tglpo, tgl_limit=:jatuh, updated_at=:catat, updated_by=:admin WHERE id_tfk=:kode");
				$edit->bindParam(':kode', $kode, PDO::PARAM_STR);
				$edit->bindParam(':nofak', $nofak, PDO::PARAM_STR);
				$edit->bindParam(':tglfak', $tglfak, PDO::PARAM_STR);
				$edit->bindParam(':nosj', $nosj, PDO::PARAM_STR);
				$edit->bindParam(':tglsj', $tglsj, PDO::PARAM_STR);
				$edit->bindParam(':nopo', $nopo, PDO::PARAM_STR);
				$edit->bindParam(':tglpo', $tglpo, PDO::PARAM_STR);
				$edit->bindParam(':jatuh', $jatuh, PDO::PARAM_STR);
				$edit->bindParam(':catat', $catat, PDO::PARAM_STR);
				$edit->bindParam(':admin', $admin, PDO::PARAM_STR);
				$edit->execute();
				//RIWAYAT
				$riwayat= $conn->query("INSERT INTO riwayat VALUES('', '$kode', 'Faktur Penjualan', 'Update', '', '$catat', '$admin')");
				//$hasil	= ($edit==true) ? "success" : "error";
				if($edit==true){
					setcookie('info', 'success', time() + 5, '/');
					setcookie('pesan', 'Data faktur penjualan berhasil diupdate.', time() + 5, '/');
				} else {
					setcookie('info', 'danger', time() + 5, '/');
					setcookie('pesan', 'Data faktur penjualan gagal diupdate.', time() + 5, '/');
				}
				$url	= "fsales";
			break;
			case 'delete':
				$kode	= $secu->injection($_POST['keycode']);
				$master	= $conn->prepare("SELECT id_psd, jumlah_tfd FROM transaksi_fakturdetail WHERE id_tfk=:kode");
				$master->bindParam(':kode', $kode, PDO::PARAM_STR);
				$master->execute();
				while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
					$edit	= $conn->prepare("UPDATE produk_stokdetail SET keluar_psd=keluar_psd-:jumlah, sisa_psd=sisa_psd+:jumlah WHERE id_psd=:kode");
					$edit->bindParam(':jumlah', $hasil['jumlah_tfd'], PDO::PARAM_INT);
					$edit->bindParam(':kode', $hasil['id_psd'], PDO::PARAM_STR);
					$edit->execute();
				}
				/*
				$delete	= $conn->prepare("DELETE FROM pembayaran_faktur WHERE id_tfk=:kode");
				$delete->bindParam(':kode', $kode, PDO::PARAM_STR);
				$delete->execute();
				$delete	= $conn->prepare("DELETE FROM transaksi_fakturdetail WHERE id_tfk=:kode");
				$delete->bindParam(':kode', $kode, PDO::PARAM_STR);
				$delete->execute();
				$delete	= $conn->prepare("DELETE FROM transaksi_faktur WHERE id_tfk=:kode");
				$delete->bindParam(':kode', $kode, PDO::PARAM_STR);
				$delete->execute();
				*/
				$remove	= $conn->prepare("DELETE A, B, C FROM transaksi_faktur AS A LEFT JOIN transaksi_fakturdetail AS B ON A.id_tfk=B.id_tfk LEFT JOIN pembayaran_faktur AS C ON A.id_tfk=C.id_tfk WHERE A.id_tfk=:kode");
				$remove->bindParam(':kode', $kode, PDO::PARAM_STR);
				$remove->execute();
				//RIWAYAT
				$riwayat= $conn->query("INSERT INTO riwayat VALUES('', '$kode', 'Faktur Penjualan', 'Delete', '', '$catat', '$admin')");
				//$hasil	= ($delete==true) ? "success" : "error";
				if($remove==true){
					setcookie('info', 'success', time() + 5, '/');
					setcookie('pesan', 'Data faktur penjualan berhasil dihapus.', time() + 5, '/');
				} else {
					setcookie('info', 'danger', time() + 5, '/');
					setcookie('pesan', 'Data faktur penjualan gagal dihapus.', time() + 5, '/');
				}
				$url	= "fsales";
			break;
		}
	}
	$conn	= $base->close();
	echo($url);
?>