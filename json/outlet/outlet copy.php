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
		$no		= $mulai;
		$jumlah	= $conn->query("SELECT COUNT(A.id_out) AS total FROM outlet AS A INNER JOIN outlet_alamat AS B ON A.id_out=B.id_out INNER JOIN outlet_diskon AS C ON A.id_out=C.id_out INNER JOIN kategori_outlet AS D ON A.id_kot=D.id_kot WHERE A.nama_out LIKE '%$cari%'")->fetch(PDO::FETCH_ASSOC);
		$master	= $conn->prepare("SELECT A.id_out, A.kode_out, A.nama_out, A.resmi_out, A.npwp_out, A.ofcode_out, B.telp_ola, B.email_ola, D.nama_kot, C.top_odi FROM outlet AS A INNER JOIN outlet_alamat AS B ON A.id_out=B.id_out INNER JOIN outlet_diskon AS C ON A.id_out=C.id_out INNER JOIN kategori_outlet AS D ON A.id_kot=D.id_kot WHERE A.nama_out LIKE '%$cari%' ORDER BY A.created_at DESC LIMIT :mulai, :maxi");
		$master->bindParam(':mulai', $mulai, PDO::PARAM_INT);
		$master->bindParam(':maxi', $maxi, PDO::PARAM_INT);
		$master->execute();
		while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
			$no++;
			$uniq	= base64_encode($hasil['id_out']);
			$diskon	= ($data->akses($admin, $menu, 'A.update_status')==='Active') ? '<a href="'.$data->sistem('url_sis').'/dispro/out='.$uniq.'&cari="><span class="badge badge-success"><i class="fa fa-tag"></i></span></a>' : '';
			$edit	= ($data->akses($admin, $menu, 'A.update_status')==='Active') ? '<a href="'.$data->sistem('url_sis').'/outlet/e/'.$hasil['id_out'].'"><span class="badge badge-info"><i class="fa fa-edit"></i></span></a>' : '';
			$delete	= ($data->akses($admin, $menu, 'A.delete_status')==='Active') ? ' <a href="#modal1" onclick="crud(\'outlet\', \'delete\', \''.$hasil['id_out'].'\')" data-toggle="modal"><span class="badge badge-danger"><i class="fa fa-trash"></i></span></a>' : '';
			$tabel	.= '<tr><td><center>'.$no.'</center></td><td>'.$hasil['kode_out'].'</td><td><a href="'.$data->sistem('url_sis').'/outlet/v/'.$hasil['id_out'].'">'.$hasil['nama_out'].'</a></td><td>'.$hasil['nama_kot'].'</td><td>'.$hasil['ofcode_out'].'</td><td>'.$hasil['npwp_out'].'</td><td>'.$hasil['telp_ola'].'</td><td>'.$hasil['email_ola'].'</td><td><center>'.$diskon.'</center></td><td><center>'.$edit.$delete.'</center></td></tr>';
		}
		$navi	= $paging->myPaging($menu, $jumlah['total'], $maxi, $page); 
	}
	$conn	= $base->close();
	$json	= array("tabel" => $tabel, "halaman" => $page, "paginasi" => $navi);
	http_response_code(200);
	header('Access-Control-Allow-Origin: *');
	header("Content-type: application/json; charset=utf-8");
	//header('Content-type: text/html; charset=UTF-8');
	echo(json_encode($json));
?>