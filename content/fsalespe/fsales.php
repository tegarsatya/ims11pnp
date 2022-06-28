<div class="content-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Faktur Pengeluaran Barang</a></li>
                <li class="breadcrumb-item active" aria-current="page">Faktur Pengeluaran Barang</li>
            </ol>
        </nav>
        <h4 class="content-title">List Faktur Pengeluaran Barang</h4>
    </div>
</div>
<?php $cari	= $secu->injection(@$_GET['cari']); ?>
<input type="hidden" name="caridata" id="caridata" value="<?php echo($cari); ?>" readonly="readonly" />
<input type="hidden" name="halaman" id="halaman" value="1" readonly="readonly" />
<input type="hidden" name="maximal" id="maximal" value="15" readonly="readonly" />
<div class="content-body">
	<div class="row mg-b-10">
        <div class="col-sm-6">
        	<!-- <?php echo(($data->akses($admin, $menu, 'A.create_status')==='Active') ? '<a href="'.$sistem.'/fsalesp/i"><button class="btn btn-primary btn-pill btn-xs"><i class="fa fa-plus-circle"></i> Tambah Data</button></a>' : ''); ?>
			<a href="#modal1" onclick="<?php echo("caridata('carifsales', 'fsalesp', '$cari')"); ?>" data-toggle="modal"><button class="btn btn-warning btn-pill btn-xs"><i class="fa fa-search"></i> Cari Data</button></a> -->
			<a href="<?php echo($data->sistem('url_sis').'/fsalespe'); ?>"><button class="btn btn-info btn-pill btn-xs"><i class="fa fa-spinner"></i> Refresh</button></a>
        </div>
    </div>
    <div class="row mg-b-10">
        <div class="col-sm-6">
        	<!-- <?php echo(($data->akses($admin, $menu, 'A.create_status')==='Active') ? '<a href="'.$sistem.'/fsalesp/i"><button class="btn btn-primary btn-pill btn-xs"><i class="fa fa-plus-circle"></i> Tambah Data</button></a>' : ''); ?>
			<a href="#modal1" onclick="<?php echo("caridata('carifsales', 'fsalesp', '$cari')"); ?>" data-toggle="modal"><button class="btn btn-warning btn-pill btn-xs"><i class="fa fa-search"></i> Cari Data</button></a> -->
			<!-- <a href="<?php echo($data->sistem('url_sis').'/fsalespe'); ?>"><button class="btn btn-info btn-pill btn-xs"><i class="fa fa-spinner"></i> Refresh</button></a> -->
        </div>
    </div>
    <?php require_once('config/frame/alert.php'); ?>
    <div class="table-responsive">
        <table class="table table-hover mg-b-0">

            <ul>
                <li><a href="<?php echo($data->sistem('url_sis').'/fsales'); ?>"><button class="btn btn-primary btn-pill btn-xs"> <i class="fa-solid fa-file-code"></i> Faktur Penjualan</button></a></li>            
            </ul>

            <ul>
                <li><a href="<?php echo($data->sistem('url_sis').'/fsalesp'); ?>"><button class="btn btn-secondary btn-pill btn-xs"> <i class="fa-solid fa-file-code"></i> Faktur Peminjaman</button></a></li>            
            </ul>

            <ul>
                <li><a href="<?php echo($data->sistem('url_sis').'/fsalesr'); ?>"><button class="btn btn-success btn-pill btn-xs"><i class="fa-solid fa-file-code"></i> Faktur Retur</button></a></li>
            </ul>

            <ul>
                <li><a href="<?php echo($data->sistem('url_sis').'/fsalesd'); ?>"><button class="btn btn-danger btn-pill btn-xs"><i class="fa-solid fa-file-code"></i> Faktur Donasi</button></a></li>
            </ul>

            <ul>
                <li><a href="<?php echo($data->sistem('url_sis').'/fsalesl'); ?>"><button class="btn btn-warning btn-pill btn-xs"><i class="fa-solid fa-file-code"></i> Faktur Lain - Lain</button></a></li>
            </ul>

            <tbody id="isitabel"></tbody>
        </table>
        <div class="mg-t-10">
            <nav aria-label="Page navigation example">
                <ul class="pagination pagination-circle mg-b-0" id="paginasi"></ul>
            </nav>
		</div>
    </div>
</div>