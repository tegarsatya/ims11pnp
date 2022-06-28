<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
    require_once('../../../config/connection/connection.php');
    require_once('../../../config/connection/security.php');
    require_once('../../../config/function/data.php');
    require_once('../../../config/function/date.php');
    $secu   = new Security;
    $base   = new DB;
    $data   = new Data;
    $date   = new Date;
    $admin  = $secu->injection(@$_COOKIE['adminkuy']);
    $kunci  = $secu->injection(@$_COOKIE['kuncikuy']);
    $secu->validadmin($admin, $kunci);
    if($secu->validadmin($admin, $kunci)==false){ header('location:'.$data->sistem('url_sis').'/signout'); } else {
    $conn   = $base->open();
    $kode   = $secu->injection(@$_GET['key']);
    $read   = $conn->prepare("SELECT A.sj_tfk, A.po_tfk, A.tglsj_tfk, B.nama_out, B.npwp_out, C.pengiriman_ola FROM transaksi_faktur_c AS A LEFT JOIN outlet AS B ON A.id_out=B.id_out LEFT JOIN outlet_alamat AS C ON B.id_out=C.id_out WHERE A.id_tfk=:kode");
    $read->bindParam(':kode', $kode, PDO::PARAM_STR);
    $read->execute();
    $view   = $read->fetch(PDO::FETCH_ASSOC);
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Surat Jalan</title>
        <link href="<?php echo($data->sistem('url_sis')."/config/css/laporan.css"); ?>" rel="stylesheet">
        <style type="text/css" media="print">
          @page { size: portrait; }
        </style>
    </head>


    <body>
        <!-- <div>
            <div style="float:left; font-size:60px; font-family:'Times New Roman', Times, serif;"><img src="<?php echo("../../../berkas/sistem/".$data->sistem('logo_sis')); ?>" height="70" width="100" /></div>
            <div align="right" style="font-size:10px; font-family:Arial, Helvetica, sans-serif;"><?php echo($data->sistem('pt_sis')); ?></div>
            <div align="right" style="font-size:10px; font-family:Arial, Helvetica, sans-serif;"><?php echo($data->sistem('alamat_sis')); ?></div>
            <div align="right" style="font-size:10px; font-family:Arial, Helvetica, sans-serif;">PHONE <?php echo($data->sistem('telp_sis')); ?></div>
            <div align="right" style="font-size:10px; font-family:Arial, Helvetica, sans-serif;">NPWP : <?php echo($data->sistem('npwp_sis')); ?></div>
            <div align="right" style="font-size:10px; font-family:Arial, Helvetica, sans-serif;">IZIN PBF : <?php echo($data->sistem('pbf_sis')); ?></div>
        </div> -->
        <br /> 
        <br /> 
        <br /> 
        <table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:10px;">
            <tr>
                <td width="50%"></td>
                <td width="15%">Tanggal</td>
                <td width="3%"><center>:</center></td>
                <td width="32%"><?php echo($date->tgl_indo($view['tglsj_tfk'])); ?></td>
            </tr>
            <tr>
                <td><div align="left">Kepada Yth,</div></td>
                <td>Surat Jalan No.</td>
                <td><center>:</center></td>
                <td><?php echo($view['sj_tfk']); ?></td>
            </tr>
        </table>
        <table class="tabelinfo">
            <tr>
                <td width="35%">NAMA PELANGGAN</td>
                <td width="3%"><center>:</center></td>
                <td width="62%"><?php echo($view['nama_out']); ?></td>
            </tr>
            <tr>
                <td>ALAMAT KIRIM</td>
                <td><center>:</center></td>
                <td><?php echo($view['pengiriman_ola']); ?></td>
            </tr>
            <tr>
                <td>NPWP</td>
                <td><center>:</center></td>
                <td><?php echo($view['npwp_out']); ?></td>
            </tr>
            <tr>
                <td>NO. PO</td>
                <td><center>:</center></td>
                <td><?php echo($view['po_tfk']); ?></td>
            </tr>
        </table>
        <p></p>
        <table class="tabel">
            <thead>
                <tr>
                    <th rowspan="2">ID BARANG</th>
                    <th rowspan="2">NAMA BARANG</th>
                    <th colspan="2">SEDIAAN</th>
                    <th rowspan="2">NO. BATCH</th>
                    <th rowspan="2">EXP. DATE</th>
                    <th rowspan="2">KUANTITAS</th>
                    <th rowspan="2">HARGA</th>
                    <th rowspan="2">DISKON</th>
                    <th rowspan="2">TOTAL</th>
                </tr>
                <tr>
                    <th>SEDIAAN</th>
                    <th>UKURAN</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $subtot = 0;
                $diskon = 0;
                $total  = 0;
                $stotal = 0;
                $master = $conn->prepare("SELECT A.jumlah_tfd, A.harga_tfd, A.diskon_tfd, B.no_bcode, B.tgl_expired, C.kode_pro, C.nama_pro, C.berat_pro, D.nama_kpr, E.nama_spr FROM transaksi_fakturdetail_c AS A LEFT JOIN produk_stokdetail AS B ON A.id_psd=B.id_psd LEFT JOIN produk AS C ON B.id_pro=C.id_pro LEFT JOIN kategori_produk AS D ON C.id_kpr=D.id_kpr LEFT JOIN satuan_produk AS E ON C.id_spr=E.id_spr WHERE A.id_tfk=:kode");
                $master->bindParam(':kode', $kode, PDO::PARAM_STR);
                $master->execute();
                while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                    $subtot = $hasil['jumlah_tfd'] * $hasil['harga_tfd'];
                    $diskon = ($subtot * $hasil['diskon_tfd']) / 100;
                    $total  = $subtot - $diskon;
                    $stotal += $total;
            ?>
                <tr>
                    <td><?php echo($hasil['kode_pro']); ?></td>
                    <td><?php echo($hasil['nama_pro']); ?></td>
                    <td><?php echo($hasil['nama_kpr']); ?></td>
                    <td><?php echo("$hasil[berat_pro] $hasil[nama_spr]"); ?></td>
                    <td><center><?php echo($hasil['no_bcode']); ?></center></td>
                    <td><center><?php echo($hasil['tgl_expired']); ?></center></td>
                    <td><div align="right"><?php echo($data->angka($hasil['jumlah_tfd'])); ?></div></td>
                    <td><div align="right"><?php echo($data->angka($hasil['harga_tfd'])); ?></div></td>
                    <td><center><?php echo($hasil['diskon_tfd']); ?>%</center></td>
                    <td><div align="right"><?php echo($data->angka($total)); ?></div></td>
                </tr>
            <?php
                }
                // $ppn = ($stotal * 10) / 100;
                $gtotal = round(($stotal), 0);
            ?>
            </tbody>
        </table>
        <br />
        <div style="width:100%;">
            <div style="width:45%; display:inline-block;" align="left">
            <div style="margin-bottom:50px;"></div>
            <!-- <table class="tabel" style="font-size:10px;">
                <thead>
                    <tr>
                        <th width="60%"><div align="left"><?php echo($data->sistem('pt_sis')); ?></div></th>
                        <th width="40%"><div align="left">TTD dan CAP</div></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td height="60" style="vertical-align:bottom;">
                        <div align="left">Nama : <?php echo($data->sistem('apoteker_sis')); ?></div>
                        <div align="left">Jabatan : Apoteker</div>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table> -->
            <br />
            <table class="tabel" style="font-size:10px;">
                <thead>
                    <tr>
                        <th width="60%"><div align="left">Penerima</div></th>
                        <th width="40%"><div align="left">TTD dan CAP</div></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td height="60">
                        <div align="left" style="margin-bottom:30px; font-weight:bold;"><?php echo($view['nama_out']); ?></div>
                        <div align="left">Nama :</div>
                        <div align="left">Jabatan :</div>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            </div>
            <div style="width:45%; display:inline-block; float:right;">
                <div align="right">
                <table width="80%" style="font-size:12px; font-family:Arial, Helvetica, sans-serif;">
                    <tr>
                        <td><div align="left">Total 1</div></td>
                        <td></td>
                        <td><div align="right"><span style="float:left;">Rp.</span><?php echo($data->angka($stotal)); ?></div></td>
                    </tr>
                    <tr>
                        <td><div align="left">Potongan</div></td>
                        <td></td>
                        <td><div align="right"><span style="float:left;">Rp.</span><?php echo($data->angka(0)); ?></div></td>
                    </tr>
                    <!-- <tr>
                        <td><div align="left">PPN <span style="float:right;">10%</span></div></td>
                        <td></td>
                        <td><div align="right"><span style="float:left;">Rp.</span><?php echo($data->angka($ppn)); ?></div></td>
                    </tr> -->
                    <tr>
                        <td colspan="3"><div style="background:#666666; width:100%; height:1px;"></div></td>
                    </tr>
                    <tr>
                        <td><div align="left"><b>Total Faktur</b></div></td>
                        <td></td>
                        <td><div align="right"><span style="float:left; font-weight:bold;">Rp.</span><b><?php echo($data->angka($gtotal)); ?></b></div></td>
                    </tr>
                </table>
                </div>
                <div style="min-height:30px; height:auto; border:solid 1px #666666; text-align:center; font-weight:bold; margin-top:10px; padding:5px; font-size:12px;">NB : Dokumen Ini Di Buat Secara Elektronik, Sehingga Tidak Membutuhkan Tanda Tangan </div>
                <!--<div style="min-height:30px; height:auto; border:solid 1px #666666; text-align:center; font-weight:bold; margin-top:10px; line-height:25px; font-size:12px; font-family:Arial, Helvetica, sans-serif;">Terbilang : # <?php //echo($data->terbilang($gtotal)); ?> Rupiah #</div>-->
            </div>
        </div>
        <script type="text/javascript">window.print();</script>
    </body>
<?php } ?>
</html>
