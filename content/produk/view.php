<div class="content-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Menu</a></li>
                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
            </ol>
        </nav>
        <h4 class="content-title">Historis</h4>
    </div>
</div>
<?php
	$kode	= $secu->injection($_GET['keycode']);
	$read	= $conn->prepare("SELECT nama_pro FROM produk WHERE id_pro=:kode");
	$read->bindParam(':kode', $kode, PDO::PARAM_STR);
	$read->execute();
	$view	= $read->fetch(PDO::FETCH_ASSOC);
?>
<div class="content-body">
    <div class="component-section no-code">
        <div class="row row-sm">
            <div class="col-sm-12">
            	<table width="50%">
                	<tr>
                    	<td>Produk</td>
                    	<td><center>:</center></td>
                    	<td><?php echo($view['nama_pro']); ?></td>
                    </tr>
                </table>
                <div class="clearfix mg-t-15 mg-b-15"></div>
            	<div class="table-responsive">
				<table class="table table-bordered">
                	<thead>
                    	<tr>
                            <th><center>No.</center></th>
                            <th>Jenis</th>
                            <th>Supplier/Outlet</th>
                            <th>Kode</th>
                            <th>Faktur</th>
                            <th>Tanggal</th>
                            <th>Batchcode</th>
                            <th><div align="right">In</div></th>
                            <th><div align="right">Out</div></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
						$in		= 0;
						$out	= 0;
						$tin	= 0;
						$tout	= 0;
						$no		= 1;
						$proses	= $conn->query("CALL reportproduk('$kode');");
						$master	= $conn->prepare("SELECT jenis_rpo, bcode_rpo, mitra_rpo, kode_rpo, faktur_rpo, tgl_rpo, jumlah_rpo FROM report_produk WHERE id_pro=:kode ORDER BY tgl_rpo ASC");
						$master->bindParam(':kode', $kode, PDO::PARAM_STR);
						$master->execute();
						while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
							$in		= ($hasil['jenis_rpo']=='Order' || $hasil['jenis_rpo']=='TF-OUT') ? $hasil['jumlah_rpo'] : 0;
							$out	= ($hasil['jenis_rpo']=='Sales' || $hasil['jenis_rpo']=='TF-IN') ? $hasil['jumlah_rpo'] : 0;
							$tin	+= $in;
							$tout	+= $out;
					?>
                    	<tr>
                        	<td><center><?php echo($no); ?></center></td>
                        	<td><?php echo($hasil['jenis_rpo']); ?></td>
                        	<td><?php echo($hasil['mitra_rpo']); ?></td>
                        	<td><?php echo($hasil['kode_rpo']); ?></td>
                        	<td><?php echo($hasil['faktur_rpo']); ?></td>
                        	<td><?php echo($hasil['tgl_rpo']); ?></td>
                        	<td><?php echo($hasil['bcode_rpo']); ?></td>
                        	<td><div align="right"><?php echo($data->angka($in)); ?></div></td>
                        	<td><div align="right"><?php echo($data->angka($out)); ?></div></td>
                        </tr>
                  	<?php $no++; } ?>
                    	<tr>
                        	<th colspan="7"><div align="right">TOTAL</div></th>
                        	<th><div align="right"><?php echo($data->angka($tin)); ?></div></th>
                        	<th><div align="right"><?php echo($data->angka($tout)); ?></div></th>
                        </tr>
                    	<tr>
                        	<th colspan="7"><div align="right">BALANCE</div></th>
                        	<th colspan="2"><div align="center"><?php echo($data->angka($tin - $tout)); ?></div></th>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="clearfix mg-t-25 mg-b-25"></div>
        <div class="row row-sm">
            <div class="col-sm-12">
                <a href="<?php echo("$sistem/produk"); ?>" title="Kembai"><button type="button" class="btn btn-secondary btn-xs"><i class="fa fa-chevron-circle-left"></i> Kembali</button></a>
                <a target="_blank" href="<?php echo("$sistem/laporan/xls/produk/historis.php?key=$kode"); ?>" title="Cetak"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-print"></i> Cetak</button></a>
            </div>
		</div>
    </div>
</div>