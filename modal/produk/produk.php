<?php
	require_once('../../config/connection/connection.php');
	require_once('../../config/connection/security.php');
	require_once('../../config/function/data.php');
	$secu	= new Security;
	$base	= new DB;
	$data	= new Data;
	$conn	= $base->open();
	$sistem	= $data->sistem('url_sis');
	$modal	= $secu->injection(@$_GET['modal']);
	switch($modal){
		case "input":
?>
        <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel">Input Data - Produk</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
            </button>
        </div>
        <form id="formmenu" action="#" method="post" autocomplete="off">
        <input type="hidden" name="namamodal" id="namamodal" value="produk" readonly="readonly" />
        <input type="hidden" name="namamenu" value="input" readonly="readonly" />
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Nama <span class="tx-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" placeholder="ex. ALBUCETINE ED" required="required" />
                </div>
                <div class="form-group col-md-6">
                    <label>Min. Stok <span class="tx-danger">*</span></label>
                    <input type="text" name="minstok" class="form-control" onkeyup="angka(this)" placeholder="0" required="required" />
                </div>
			</div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Kode / Nomor <span class="tx-danger">*</span></label>
                    <input type="text" name="nomor" class="form-control" placeholder="ex. A001" required="required" />
                </div>
                <div class="form-group col-md-6">
                    <label>Kategori <span class="tx-danger">*</span></label>
                    <select name="kategori" class="form-control" required="required">
                    	<option value="">-- Pilih Data --</option>
                    <?php
						$master		= $conn->prepare("SELECT id_kpr, nama_kpr FROM kategori_produk ORDER BY nama_kpr ASC");
						$master->execute();
						while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
					?>
                    	<option value="<?php echo($hasil['id_kpr']); ?>"><?php echo($hasil['nama_kpr']); ?></option>
                    <?php } ?>
                    </select>
                </div>
			</div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Rak <span class="tx-danger">*</span></label>
                    <input type="text" name="rak" class="form-control" placeholder="ex. Rak A" required="required" />
                </div>
                <div class="form-group col-md-6">
                    <label>Section <span class="tx-danger">*</span></label>
                    <input type="text" name="sek" class="form-control" placeholder="ex. Section 3" required="required" />
                </div>
			</div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Satuan <span class="tx-danger">*</span></label>
                    <select name="satuan" class="form-control" required="required">
                    	<option value="">-- Pilih Data --</option>
                    <?php
						$master		= $conn->prepare("SELECT id_spr, nama_spr FROM satuan_produk ORDER BY nama_spr ASC");
						$master->execute();
						while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
					?>
                    	<option value="<?php echo($hasil['id_spr']); ?>"><?php echo($hasil['nama_spr']); ?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Berat <span class="tx-danger">*</span></label>
                    <input type="text" name="berat" class="form-control" placeholder="0" required="required" />
                </div>
			</div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Kategori Obat <span class="tx-danger">*</span></label>
                    <select name="kategori_obat" class="form-control" required="required">
                    	<option value="">-- Pilih Data --</option>
                            <option value="">-- Pilih Data --</option>
                            <option value="Obat Bebas Terbatas">Obat Bebas Terbatas</option>
                            <option value="Obat Bebas">Obat Bebas</option>
                            <option value="Obat Keras">Obat Keras</option>
                    </select>
                </div>
			</div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Harga <span class="tx-danger">*</span></label>
                    <input type="text" name="harga" id="harga" class="form-control" onkeyup="angka(this)" placeholder="0" required="required" />
                    <div id="imgloading"></div>
                </div>
                <div class="form-group col-md-6">
                    <label>Harga + PPN <span class="tx-danger">*</span></label>
                    <input type="text" name="hargappn" id="hargappn" class="form-control" onkeyup="angka(this)" placeholder="0" required="required" />
                </div>
			</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Batal</button>
            <button type="submit" id="bsave" class="btn btn-dark btn-xs">Simpan</button>
        </div>
		</form>
<?php
		break;
		case "update":
		$kode	= $secu->injection($_GET['keycode']);
		$read	= $conn->prepare("SELECT kode_pro, nama_pro, berat_pro, id_kpr, id_spr, rak_pro, section_pro, minstok_pro FROM produk WHERE id_pro=:kode");
		$read->bindParam(':kode', $kode, PDO::PARAM_STR);
		$read->execute();
		$view	= $read->fetch(PDO::FETCH_ASSOC);
?>
        <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel">Update Data - Produk</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
            </button>
        </div>
        <form id="formmenu" action="#" method="post" autocomplete="off">
        <input type="hidden" name="namamodal" id="namamodal" value="produk" readonly="readonly" />
        <input type="hidden" name="namamenu" value="update" readonly="readonly" />
        <input type="hidden" name="keycode" value="<?php echo($kode); ?>" readonly="readonly" />
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Nama <span class="tx-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="<?php echo($view['nama_pro']); ?>" placeholder="ex. ALBUCETINE ED" required="required" />
                </div>
                <div class="form-group col-md-6">
                    <label>Min. Stok <span class="tx-danger">*</span></label>
                    <input type="text" name="minstok" class="form-control" onkeyup="angka(this)" value="<?php echo($view['minstok_pro']); ?>" placeholder="0" required="required" />
                </div>
			</div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Kode / Nomor <span class="tx-danger">*</span></label>
                    <input type="text" name="nomor" class="form-control" value="<?php echo($view['kode_pro']); ?>" placeholder="ex. A001" required="required" />
                </div>
                <div class="form-group col-md-6">
                    <label>Kategori <span class="tx-danger">*</span></label>
                    <select name="kategori" class="form-control" required="required">
                    	<option value="">-- Pilih Data --</option>
                    <?php
						$master		= $conn->prepare("SELECT id_kpr, nama_kpr FROM kategori_produk ORDER BY nama_kpr ASC");
						$master->execute();
						while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
							$pilih	= ($view['id_kpr']==$hasil['id_kpr']) ? 'selected="selected"' : '';
					?>
                    	<option value="<?php echo($hasil['id_kpr']); ?>" <?php echo($pilih); ?>><?php echo($hasil['nama_kpr']); ?></option>
                    <?php } ?>
                    </select>
                </div>
			</div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Rak <span class="tx-danger">*</span></label>
                    <input type="text" name="rak" class="form-control" value="<?php echo($view['rak_pro']); ?>" placeholder="ex. Rak A" required="required" />
                </div>
                <div class="form-group col-md-6">
                    <label>Section <span class="tx-danger">*</span></label>
                    <input type="text" name="sek" class="form-control" value="<?php echo($view['section_pro']); ?>" placeholder="ex. Section 3" required="required" />
                </div>
			</div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Satuan <span class="tx-danger">*</span></label>
                    <select name="satuan" class="form-control" required="required">
                    	<option value="">-- Pilih Data --</option>
                    <?php
						$master		= $conn->prepare("SELECT id_spr, nama_spr FROM satuan_produk ORDER BY nama_spr ASC");
						$master->execute();
						while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
							$pilih	= ($view['id_spr']==$hasil['id_spr']) ? 'selected="selected"' : '';
					?>
                    	<option value="<?php echo($hasil['id_spr']); ?>" <?php echo($pilih); ?>><?php echo($hasil['nama_spr']); ?></option>
                    <?php } ?>
                    </select>
                    <div id="imgloading"></div>
                </div>
                <div class="form-group col-md-6">
                    <label>Berat <span class="tx-danger">*</span></label>
                    <input type="text" name="berat" class="form-control" value="<?php echo($view['berat_pro']); ?>" placeholder="0" required="required" />
                </div>
			</div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Kategori Obat <span class="tx-danger">*</span></label>
                    <select name="kategori_obat" class="form-control" required="required">
                    	<option value="">-- Pilih Data --</option>
                        <option value="Obat Bebas Terbatas">Obat Bebas Terbatas</option>
                        <option value="Obat Bebas">Obat Bebas</option>
                        <option value="Obat Keras">Obat Keras</option>
                    </select>
                    <div id="imgloading"></div>
                </div>
			</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Batal</button>
            <button type="submit" id="bsave" class="btn btn-dark btn-xs">Update</button>
        </div>
		</form>
<?php
		break;
		case "delete":
		$kode	= $secu->injection($_GET['keycode']);
?>
        <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel">Konfirmasi</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
            </button>
        </div>
        <form id="formmenu" action="#" method="post" autocomplete="off">
        <input type="hidden" name="namamodal" id="namamodal" value="produk" readonly="readonly" />
        <input type="hidden" name="namamenu" value="delete" readonly="readonly" />
        <input type="hidden" name="keycode" value="<?php echo($kode); ?>" readonly="readonly" />
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="alert alert-danger alert-dismissible mg-b-0 fade show" role="alert">
                        <strong>Informasi!</strong> Hapus data produk?
                    </div>
                    <div id="imgloading"></div>
                </div>
			</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Batal</button>
            <button type="submit" id="bsave" class="btn btn-dark btn-xs">Hapus</button>
        </div>
		</form>
<?php
		break;
	}
	$conn	= $base->close();
?>
	<script type="text/javascript" src="<?php echo("$sistem/config/js/fazlurr.js"); ?>"></script>