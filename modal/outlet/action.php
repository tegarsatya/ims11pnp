<?php
	error_reporting(0);
	require_once('../../config/connection/connection.php');
	require_once('../../config/connection/security.php');
	require_once('../../config/function/data.php');
	$secu	= new Security;
	$base	= new DB;
	$data	= new Data;
	$admin	= $secu->injection(@$_COOKIE['adminkuy']);
	$kunci	= $secu->injection(@$_COOKIE['kuncikuy']);
	$catat	= date('Y-m-d H:i:s');
	$act	= $secu->injection(@$_GET['act']);
	$secu->validadmin($admin, $kunci);
	if($secu->validadmin($admin, $kunci)==false){ header('location:'.$data->sistem('url_sis').'/signout'); } else {
	$conn	= $base->open();
	switch($act){
		case "input":
			// Basic
			$id		= '';
			$code	= 'OUT'.time();
			$kate	= $secu->injection($_POST['kategori']);
			$koka	= $data->koutlet($kate, 'kode_kot');
			$kode	= $data->bcode($koka, 'kode_out', 'outlet');
			$namao	= $secu->injection($_POST['namaoutlet']);
			$namar	= $secu->injection($_POST['namaresmi']);
			$npwp	= $secu->injection($_POST['npwp']);
			$limit	= $secu->injection($_POST['limit']);
			$ofcode	= $secu->injection($_POST['ofcode']);
			$kete	= $secu->injection($_POST['kete']);
			// Alamat
			$telp	= $secu->injection($_POST['telp']);
			$hape	= $secu->injection($_POST['hape']);
			$fax	= $secu->injection($_POST['fax']);
			$email	= $secu->injection($_POST['email']);
			$web	= $secu->injection($_POST['website']);
			$prov	= $secu->injection($_POST['provinsi']);
			$kab	= $secu->injection($_POST['kabupaten']);
			$kopos	= $secu->injection($_POST['kopos']);
			$jadwal	= $secu->injection($_POST['jadwal']);
			$altor	= $secu->injection($_POST['alamatkantor']);
			$alkir	= $secu->injection($_POST['alamatkirim']);
			$altuk	= $secu->injection($_POST['alamattukar']);
			$picp	= $secu->injection($_POST['picp']);
			$picpk	= $secu->injection($_POST['picpk']);
			$picf	= $secu->injection($_POST['picf']);
			$picfk	= $secu->injection($_POST['picfk']);
			$status	= 'Active';
			// Diskon & Kondisi
			$diskon	= $secu->injection($_POST['diskon']);
			// Save Outlet
			$save	= $conn->prepare("INSERT INTO outlet VALUES(:code, :kate, :kode, :namao, :namar, :npwp, :id, :ofcode, :kete, :status, :catat, :admin, :catat, :admin)");
			$save->bindParam(":id", $id, PDO::PARAM_STR);
			$save->bindParam(":code", $code, PDO::PARAM_STR);
			$save->bindParam(":kate", $kate, PDO::PARAM_STR);
			$save->bindParam(":kode", $kode, PDO::PARAM_STR);
			$save->bindParam(":namao", $namao, PDO::PARAM_STR);
			$save->bindParam(":namar", $namar, PDO::PARAM_STR);
			$save->bindParam(":npwp", $npwp, PDO::PARAM_STR);
			$save->bindParam(":legal", $legal, PDO::PARAM_STR);
			$save->bindParam(":ofcode", $ofcode, PDO::PARAM_STR);
			$save->bindParam(":kete", $kete, PDO::PARAM_STR);
			$save->bindParam(":status", $status, PDO::PARAM_STR);
			$save->bindParam(":catat", $catat, PDO::PARAM_STR);
			$save->bindParam(":admin", $admin, PDO::PARAM_STR);
			$save->execute();
			// Save Alamat
			$save	= $conn->prepare("INSERT INTO outlet_alamat VALUES(:id, :code, :telp, :hape, :fax, :email, :web, :prov, :kab, :kopos, :picp, :picpk, :picf, :picfk, :jadwal, :altor, :alkir, :altuk, :catat, :admin, :catat, :admin)");
			$save->bindParam(":id", $id, PDO::PARAM_STR);
			$save->bindParam(":code", $code, PDO::PARAM_STR);
			$save->bindParam(":telp", $telp, PDO::PARAM_STR);
			$save->bindParam(":hape", $hape, PDO::PARAM_STR);
			$save->bindParam(":fax", $fax, PDO::PARAM_STR);
			$save->bindParam(":email", $email, PDO::PARAM_STR);
			$save->bindParam(":web", $web, PDO::PARAM_STR);
			$save->bindParam(":prov", $prov, PDO::PARAM_STR);
			$save->bindParam(":kab", $kab, PDO::PARAM_STR);
			$save->bindParam(":kopos", $kopos, PDO::PARAM_STR);
			$save->bindParam(":picp", $picp, PDO::PARAM_STR);
			$save->bindParam(":picpk", $picpk, PDO::PARAM_STR);
			$save->bindParam(":picf", $picf, PDO::PARAM_STR);
			$save->bindParam(":picfk", $picfk, PDO::PARAM_STR);
			$save->bindParam(":jadwal", $jadwal, PDO::PARAM_STR);
			$save->bindParam(":altor", $altor, PDO::PARAM_STR);
			$save->bindParam(":alkir", $alkir, PDO::PARAM_STR);
			$save->bindParam(":altuk", $altuk, PDO::PARAM_STR);
			$save->bindParam(":catat", $catat, PDO::PARAM_STR);
			$save->bindParam(":admin", $admin, PDO::PARAM_STR);
			$save->execute();
			// Save Diskon Produk
			$save	= $conn->prepare("INSERT INTO produk_diskon(id_out, id_pro, persen_pds, created_at, created_by, updated_at, updated_by) SELECT :code, id_pro, :diskon, :catat, :admin, :catat, :admin FROM produk");
			$save->bindParam(":id", $id, PDO::PARAM_STR);
			$save->bindParam(":code", $code, PDO::PARAM_STR);
			$save->bindParam(":diskon", $diskon, PDO::PARAM_STR);
			$save->bindParam(":catat", $catat, PDO::PARAM_STR);
			$save->bindParam(":admin", $admin, PDO::PARAM_STR);
			$save->execute();
			// Save Legal
			$no		= 0;
			$jumlah	= count(@$_POST['legal']);
			while($no<$jumlah){
				$legal	= $secu->injection(@$_POST['legal'][$no]);
				$klegal	= $secu->injection(@$_POST['ketlegal'][$no]);
				$tlegal	= $secu->injection(@$_POST['tgllegal'][$no]);
				// Save
				$save	= $conn->prepare("INSERT INTO outlet_legal VALUES(:id, :code, :legal, :klegal, :tlegal, :catat, :admin, :catat, :admin)");
				$save->bindParam(":id", $id, PDO::PARAM_STR);
				$save->bindParam(":code", $code, PDO::PARAM_STR);
				$save->bindParam(":legal", $legal, PDO::PARAM_STR);
				$save->bindParam(":klegal", $klegal, PDO::PARAM_STR);
				$save->bindParam(":tlegal", $tlegal, PDO::PARAM_STR);
				$save->bindParam(":catat", $catat, PDO::PARAM_STR);
				$save->bindParam(":admin", $admin, PDO::PARAM_STR);
				$save->execute();
			$no++;
			}
			// Update Kondisi Diskon
			$no		= 0;
			$jumlah	= count(@$_POST['product']);
			while($no<$jumlah){
				$product= $secu->injection(@$_POST['product'][$no]);
				$dispro	= $secu->injection(@$_POST['dispro'][$no]);
				// Save
				$edit	= $conn->prepare("UPDATE produk_diskon SET persen_pds=:dispro, updated_at=:catat, updated_by=:admin WHERE id_out=:code AND id_pro=:product");
				$edit->bindParam(":code", $code, PDO::PARAM_STR);
				$edit->bindParam(":product", $product, PDO::PARAM_STR);
				$edit->bindParam(":dispro", $dispro, PDO::PARAM_STR);
				$edit->bindParam(":catat", $catat, PDO::PARAM_STR);
				$edit->bindParam(":admin", $admin, PDO::PARAM_STR);
				$edit->execute();
			$no++;
			}
			// Save Diskon & Kondisi
			$save	= $conn->prepare("INSERT INTO outlet_diskon(id_out, top_odi, diskon_odi, created_at, created_by, updated_at, updated_by) VALUES(:code, :limit, :diskon, :catat, :admin, :catat, :admin)");
			$save->bindParam(":id", $id, PDO::PARAM_STR);
			$save->bindParam(":code", $code, PDO::PARAM_STR);
			$save->bindParam(":limit", $limit, PDO::PARAM_STR);
			$save->bindParam(":diskon", $diskon, PDO::PARAM_STR);
			$save->bindParam(":catat", $catat, PDO::PARAM_STR);
			$save->bindParam(":admin", $admin, PDO::PARAM_STR);
			$save->execute();
			//RIWAYAT
			$riwayat= $conn->query("INSERT INTO riwayat VALUES('', '$code', 'Outlet', 'Create', '', '$catat', '$admin')");
			$hasil	= ($save==true) ? "success" : "error";
			echo($hasil);
		break;
		case "update":
			// Basic
			$code	= $secu->injection($_POST['keycode']);
			$kate	= $secu->injection($_POST['kategori']);
			//$koka	= $data->koutlet($kate, 'kode_kot');
			//$kode	= $data->bcode($koka, 'kode_out', 'outlet');
			$namao	= $secu->injection($_POST['namaoutlet']);
			$namar	= $secu->injection($_POST['namaresmi']);
			$npwp	= $secu->injection($_POST['npwp']);
			$limit	= $secu->injection($_POST['limit']);
			$legal	= implode("_", $_POST['legal']);
			$ofcode	= $secu->injection($_POST['ofcode']);
			$kete	= $secu->injection($_POST['kete']);
			// Alamat
			$telp	= $secu->injection($_POST['telp']);
			$hape	= $secu->injection($_POST['hape']);
			$fax	= $secu->injection($_POST['fax']);
			$email	= $secu->injection($_POST['email']);
			$web	= $secu->injection($_POST['website']);
			$prov	= $secu->injection($_POST['provinsi']);
			$kab	= $secu->injection($_POST['kabupaten']);
			$kopos	= $secu->injection($_POST['kopos']);
			$jadwal	= $secu->injection($_POST['jadwal']);
			$altor	= $secu->injection($_POST['alamatkantor']);
			$alkir	= $secu->injection($_POST['alamatkirim']);
			$altuk	= $secu->injection($_POST['alamattukar']);
			$picp	= $secu->injection($_POST['picp']);
			$picpk	= $secu->injection($_POST['picpk']);
			$picf	= $secu->injection($_POST['picf']);
			$picfk	= $secu->injection($_POST['picfk']);
			$status	= 'Active';
			// Diskon & Kondisi
			$diskon	= $secu->injection($_POST['diskon']);
			// Update Outlet
			$edit	= $conn->prepare("UPDATE outlet SET nama_out=:namao, resmi_out=:namar, npwp_out=:npwp, legal_out=:legal, ofcode_out=:ofcode, ket_out=:kete, updated_at=:catat, updated_by=:admin WHERE id_out=:code");
			$edit->bindParam(":code", $code, PDO::PARAM_STR);
			$edit->bindParam(":namao", $namao, PDO::PARAM_STR);
			$edit->bindParam(":namar", $namar, PDO::PARAM_STR);
			$edit->bindParam(":npwp", $npwp, PDO::PARAM_STR);
			$edit->bindParam(":legal", $legal, PDO::PARAM_STR);
			$edit->bindParam(":ofcode", $ofcode, PDO::PARAM_STR);
			$edit->bindParam(":kete", $kete, PDO::PARAM_STR);
			$edit->bindParam(":catat", $catat, PDO::PARAM_STR);
			$edit->bindParam(":admin", $admin, PDO::PARAM_STR);
			$edit->execute();
			// Update Alamat
			$edit	= $conn->prepare("UPDATE outlet_alamat SET telp_ola=:telp, hp_ola=:hape, fax_ola=:fax, email_ola=:email, web_ola=:web, id_rpo=:prov, id_rkb=:kab, kopos_ola=:kopos, picp_ola=:picp, picpk_ola=:picpk, picf_ola=:picf, picfk_ola=:picfk, jatuk_ola=:jadwal, kantor_ola=:altor, pengiriman_ola=:alkir, atuk_ola=:altuk, updated_at=:catat, updated_by=:admin WHERE id_out=:code");
			$edit->bindParam(":code", $code, PDO::PARAM_STR);
			$edit->bindParam(":telp", $telp, PDO::PARAM_STR);
			$edit->bindParam(":hape", $hape, PDO::PARAM_STR);
			$edit->bindParam(":fax", $fax, PDO::PARAM_STR);
			$edit->bindParam(":email", $email, PDO::PARAM_STR);
			$edit->bindParam(":web", $web, PDO::PARAM_STR);
			$edit->bindParam(":prov", $prov, PDO::PARAM_STR);
			$edit->bindParam(":kab", $kab, PDO::PARAM_STR);
			$edit->bindParam(":kopos", $kopos, PDO::PARAM_STR);
			$edit->bindParam(":picp", $picp, PDO::PARAM_STR);
			$edit->bindParam(":picpk", $picpk, PDO::PARAM_STR);
			$edit->bindParam(":picf", $picf, PDO::PARAM_STR);
			$edit->bindParam(":picfk", $picfk, PDO::PARAM_STR);
			$edit->bindParam(":jadwal", $jadwal, PDO::PARAM_STR);
			$edit->bindParam(":altor", $altor, PDO::PARAM_STR);
			$edit->bindParam(":alkir", $alkir, PDO::PARAM_STR);
			$edit->bindParam(":altuk", $altuk, PDO::PARAM_STR);
			$edit->bindParam(":catat", $catat, PDO::PARAM_STR);
			$edit->bindParam(":admin", $admin, PDO::PARAM_STR);
			$edit->execute();
			// Hapus Legal
			$remove	= $conn->prepare("DELETE FROM outlet_legal WHERE id_out=:code");
			$remove->bindParam(":code", $code, PDO::PARAM_STR);
			$remove->execute();
			// Hapus Diskon
			$remove	= $conn->prepare("DELETE FROM produk_diskon WHERE id_out=:code");
			$remove->bindParam(":code", $code, PDO::PARAM_STR);
			$remove->execute();
			// Update Legal
			$no		= 0;
			$jumlah	= count(@$_POST['legal']);
			while($no<$jumlah){
				$legal	= $secu->injection(@$_POST['legal'][$no]);
				$klegal	= $secu->injection(@$_POST['ketlegal'][$no]);
				$tlegal	= $secu->injection(@$_POST['tgllegal'][$no]);
				// Save
				$save	= $conn->prepare("INSERT INTO outlet_legal VALUES(:id, :code, :legal, :klegal, :tlegal, :catat, :admin, :catat, :admin)");
				$save->bindParam(":id", $id, PDO::PARAM_STR);
				$save->bindParam(":code", $code, PDO::PARAM_STR);
				$save->bindParam(":legal", $legal, PDO::PARAM_STR);
				$save->bindParam(":klegal", $klegal, PDO::PARAM_STR);
				$save->bindParam(":tlegal", $tlegal, PDO::PARAM_STR);
				$save->bindParam(":catat", $catat, PDO::PARAM_STR);
				$save->bindParam(":admin", $admin, PDO::PARAM_STR);
				$save->execute();
			$no++;
			}
			// Update Diskon Produk
			$save	= $conn->prepare("INSERT INTO produk_diskon(id_out, id_pro, persen_pds, created_at, created_by, updated_at, updated_by) SELECT :code, id_pro, :diskon, :catat, :admin, :catat, :admin FROM produk");
			$save->bindParam(":id", $id, PDO::PARAM_STR);
			$save->bindParam(":code", $code, PDO::PARAM_STR);
			$save->bindParam(":diskon", $diskon, PDO::PARAM_STR);
			$save->bindParam(":catat", $catat, PDO::PARAM_STR);
			$save->bindParam(":admin", $admin, PDO::PARAM_STR);
			$save->execute();
			// Update Kondisi Diskon
			$jumlah	= count(@$_POST['product']);
			$no		= 0;
			while($no<=$jumlah){
				$product= $secu->injection(@$_POST['product'][$no]);
				$dispro	= $secu->injection(@$_POST['dispro'][$no]);
				// Save
				$save	= $conn->prepare("UPDATE produk_diskon SET persen_pds=:dispro, updated_at=:catat, updated_by=:admin WHERE id_out=:code AND id_pro=:product");
				$save->bindParam(":code", $code, PDO::PARAM_STR);
				$save->bindParam(":product", $product, PDO::PARAM_STR);
				$save->bindParam(":dispro", $dispro, PDO::PARAM_STR);
				$save->bindParam(":catat", $catat, PDO::PARAM_STR);
				$save->bindParam(":admin", $admin, PDO::PARAM_STR);
				$save->execute();
			$no++;
			}
			// Update Diskon & Kondisi
			$edit	= $conn->prepare("UPDATE outlet_diskon SET top_odi=:limit, diskon_odi=:diskon, updated_at=:catat, updated_by=:admin WHERE id_out=:code");
			$edit->bindParam(":code", $code, PDO::PARAM_STR);
			$edit->bindParam(":limit", $limit, PDO::PARAM_STR);
			$edit->bindParam(":diskon", $diskon, PDO::PARAM_STR);
			$edit->bindParam(":catat", $catat, PDO::PARAM_STR);
			$edit->bindParam(":admin", $admin, PDO::PARAM_STR);
			$edit->execute();
			//RIWAYAT
			$riwayat= $conn->query("INSERT INTO riwayat VALUES('', '$code', 'Outlet', 'Update', '', '$catat', '$admin')");
			$hasil	= ($edit==true) ? "success" : "error";
			echo($hasil);
		break;
		case "delete":
			$kode	= $secu->injection($_POST['keycode']);
			$dele	= $conn->prepare("DELETE A, B, C, D, E FROM outlet AS A LEFT JOIN outlet_alamat AS B ON A.id_out=B.id_out LEFT JOIN outlet_diskon AS C ON A.id_out=C.id_out LEFT JOIN outlet_legal AS D ON A.id_out=D.id_out LEFT JOIN produk_diskon AS E ON A.id_out=E.id_out WHERE A.id_out=:kode");
			$dele->bindParam(":kode", $kode, PDO::PARAM_STR);
			$dele->execute();
			/*
			$dele	= $conn->prepare("DELETE FROM outlet_alamat WHERE id_out=:kode");
			$dele->bindParam(":kode", $kode, PDO::PARAM_STR);
			$dele->execute();
			$dele	= $conn->prepare("DELETE FROM outlet_diskon WHERE id_out=:kode");
			$dele->bindParam(":kode", $kode, PDO::PARAM_STR);
			$dele->execute();
			*/
			//RIWAYAT
			$riwayat= $conn->query("INSERT INTO riwayat VALUES('', '$kode', 'Outlet', 'Delete', '', '$catat', '$admin')");
			$hasil	= ($dele==true) ? "success" : "error";
			echo($hasil);
		break;
	}
	$conn	= $base->close();
	}
?>