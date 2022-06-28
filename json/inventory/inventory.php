<?php
	require_once('../../config/connection/connection.php');
	require_once('../../config/connection/security.php');
	require_once('../../config/function/data.php');
	require_once('../../config/function/paging.php');
	$base	= new DB;
	$secu	= new Security;
	$data	= new Data;
	$paging	= new Paging;
	$conn	= $base->open();
	//ACCESS DATA
	$admin	= $secu->injection(@$_COOKIE['adminkuy']);
	$kunci	= $secu->injection(@$_COOKIE['kuncikuy']);
	$level	= $secu->injection(@$_COOKIE['jeniskuy']);
	$valid	= $secu->validadmin($admin, $kunci);
	//POST DATA
	$cari	= $secu->injection(@$_GET['caridata']);
	$carii	= $secu->injection(@$_GET['cariitem']);
	$page	= $secu->injection(@$_GET['halaman']);
	$maxi	= $secu->injection(@$_GET['maximal']);
	$menu	= $secu->injection(@$_GET['menudata']);
	$mulai	= ($page>1) ? (($page * $maxi) - $maxi) : 0;
	//READ DATA
	if($valid==false){
		$tabel	= '<tr><td colspan="10">Session login anda habis...</td></tr>';
		$navi	= '';
	} else {
		$tabel	= '';
		$active	= 'Active';
		$no		= $mulai;
		$master	= $conn->prepare("SELECT A.id_psd, A.no_bcode, A.tgl_expired, A.gudang, A.tgl_psd, A.sisa_psd, B.nama_pro, B.berat_pro,B.minstok_pro, C.harga_phg, C.hargap_phg, E.nama_spr FROM produk_stokdetail AS A LEFT JOIN produk AS B ON A.id_pro=B.id_pro LEFT JOIN produk_harga AS C ON B.id_pro=C.id_pro LEFT JOIN kategori_produk AS D ON B.id_kpr=D.id_kpr LEFT JOIN satuan_produk AS E ON B.id_spr=E.id_spr WHERE A.sisa_psd>0 AND B.nama_pro LIKE '%$cari%' AND C.status_phg=:active ORDER BY B.nama_pro ASC");
		$master->bindParam(':active', $active, PDO::PARAM_STR);
		$master->execute();
		while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
			$no++;
			$awal  = date_create($hasil['tgl_psd']);
			$akhir = date_create();
			$diff  = date_diff( $awal, $akhir );
			$status	= empty($hasil['sisa_psd']) ? 'Kosong' : (($hasil['sisa_psd']<50) ? 'Order Ulang' : 'Cukup');
			$nama	= '<a href="#modal1" onclick="crud(\'inventory\', \'update\', \''.$hasil['id_psd'].'\')" data-toggle="modal">'.$hasil['nama_pro'].'</a>';
			$tabel	.= '<tr><td><center>'.$no.'</center></td><td>'.$nama.'</td><td>'.$hasil['gudang'].'</td><td>'.$hasil['berat_pro'].' '.$hasil['nama_spr'].'</td><td>'.$hasil['no_bcode'].'</td><td>'.$hasil['tgl_expired'].'</td><td><div align="right"><center>'.$diff->days. " Hari ".'</center></div></td><td><div align="right">'.$data->angka($hasil['harga_phg']).'</div></td><td><div align="right">'.$data->angka($hasil['hargap_phg']).'</div></td><td><div align="right">'.$data->angka($hasil['sisa_psd']).'</div></td><td><center>'.$hasil['minstok_pro'].'</center></td><td>'.$status.'</td></tr>';
		}
		$navi	= '';
	}
	$conn	= $base->close();
	$json	= array("tabel" => $tabel, "halaman" => $page, "paginasi" => $navi);
	http_response_code(200);
	header('Access-Control-Allow-Origin: *');
	header("Content-type: application/json; charset=utf-8");
	//header('Content-type: text/html; charset=UTF-8');
	echo(json_encode($json));
?>