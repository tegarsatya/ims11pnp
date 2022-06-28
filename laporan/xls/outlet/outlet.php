<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
	header("Content-Type: application/force-download");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Laporan"); 
	header("content-disposition:attachment; filename=outlet.xls");
	require_once('../../../config/connection/connection.php');
	require_once('../../../config/connection/security.php');
	require_once('../../../config/function/data.php');
	require_once('../../../config/function/date.php');
	$secu	= new Security;
	$base	= new DB;
	$data	= new Data;
	$date	= new Date;
	$admin	= $secu->injection(@$_COOKIE['adminkuy']);
	$kunci	= $secu->injection(@$_COOKIE['kuncikuy']);
	$secu->validadmin($admin, $kunci);
	if($secu->validadmin($admin, $kunci)==false){ header('location:'.$data->sistem('url_sis').'/signout'); } else {
	$conn	= $base->open();
	$cari	= $secu->injection(@$_GET['key']);
	$search	= $data->cekcari($cari, '-', ' ');
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Data Outlet</title>
    </head>


    <body>
		<table>
        	<tr>
            	<th colspan="26">DATA OUTLET</th>
            </tr>
        	<tr>
            	<th colspan="26"><?php echo($data->sistem('pt_sis')); ?></th>
            </tr>
            <tr>
            	<td colspan="26"></td>
            </tr>
        </table>
    	<table border="1">
        	<thead>
            	<tr>
                    <th><center>NO</center></th>
                    <th>NAMA OUTLET</th>
                    <th>NAMA RESMI</th>
                    <th>KATEGORI</th>
                    <th>NPWP</th>
                    <th>KETERANGAN</th>
                    <th>TELP.</th>
                    <th>HP</th>
                    <th>FAX</th>
                    <th>EMAIL</th>
                    <th>WEBSTIE</th>
                    <th>PROVINSI</th>
                    <th>KABUPATEN</th>
                    <th>KODE POS</th>
                    <th>PIC PROCUREMENT</th>
                    <th>HP</th>
                    <th>PIC FINANCE</th>
                    <th>HP</th>
                    <th>JADWAL TUKAR</th>
                    <th>ALAMAT KANTOR</th>
                    <th>ALAMAT PENGIRIMAN</th>
                    <th>ALAMAT TUKAR FAKTUR</th>
                    <th>TOP</th>
                    <th>MINIMAL</th>
                    <th>DISKON <=MINIMAL</th>
                    <th>DISKON >MINIMAL</th>
				</tr>
    		</thead>
            <tbody>
			<?php
				$nomor	= 1;
				$master	= $conn->prepare("SELECT A.kode_out, A.nama_out, A.resmi_out, A.npwp_out, A.ket_out, B.telp_ola, B.hp_ola, B.fax_ola, B.email_ola, B.web_ola, B.kopos_ola, B.picp_ola, B.picpk_ola, B.picf_ola, B.picfk_ola, B.jatuk_ola, B.kantor_ola, B.pengiriman_ola, B.atuk_ola, E.nama_rkb, F.nama_rpo, D.nama_kot, C.top_odi, C.parameter_odi, C.diskon1_odi, C.diskon2_odi FROM outlet AS A LEFT JOIN outlet_alamat AS B ON A.id_out=B.id_out LEFT JOIN outlet_diskon AS C ON A.id_out=C.id_out INNER JOIN kategori_outlet AS D ON A.id_kot=D.id_kot LEFT JOIN regional_kabupaten AS E ON B.id_rkb=E.id_rkb LEFT JOIN regional_provinsi AS F ON E.id_rpo=F.id_rpo WHERE A.nama_out LIKE '%$search%' ORDER BY A.nama_out");
				$master->execute();
				while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
			?>
            	<tr>
                	<td><center><?php echo($nomor); ?></center></td>
                	<td><?php echo($hasil['nama_out']); ?></td>
                	<td><?php echo($hasil['resmi_out']); ?></td>
                	<td><?php echo($hasil['nama_kot']); ?></td>
                	<td><?php echo($hasil['npwp_out']); ?></td>
                	<td><?php echo($hasil['ket_out']); ?></td>
                    <td><?php echo($hasil['telp_ola']); ?></td>
                	<td><?php echo($hasil['hp_ola']); ?></td>
                	<td><?php echo($hasil['fax_ola']); ?></td>
                	<td><?php echo($hasil['email_ola']); ?></td>
                	<td><?php echo($hasil['web_ola']); ?></td>
                	<td><?php echo($hasil['nama_rpo']); ?></td>
                	<td><?php echo($hasil['nama_rkb']); ?></td>
                	<td><?php echo($hasil['kopos_ola']); ?></td>
                	<td><?php echo($hasil['picp_ola']); ?></td>
                	<td><?php echo($hasil['picpk_ola']); ?></td>
                	<td><?php echo($hasil['picf_ola']); ?></td>
                	<td><?php echo($hasil['picfk_ola']); ?></td>
                	<td><?php echo($hasil['jatuk_ola']); ?></td>
                	<td><?php echo($hasil['kantor_ola']); ?></td>
                	<td><?php echo($hasil['pengiriman_ola']); ?></td>
                	<td><?php echo($hasil['atuk_ola']); ?></td>
                	<td><?php echo($hasil['top_odi']); ?> Hari</td>
                	<td><?php echo($hasil['parameter_odi']); ?></td>
                	<td><?php echo($hasil['diskon1_odi']); ?>%</td>
                	<td><?php echo($hasil['diskon2_odi']); ?>%</td>
                </tr>
			<?php
				$nomor++;
            	}
			?>
            </tbody>
        </table>
    </body>
<?php } ?>
</html>
