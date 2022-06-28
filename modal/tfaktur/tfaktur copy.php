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
        <link rel="stylesheet" href="<?php echo("$sistem/sumoselect/sumoselect.min.css"); ?>" type="text/css" />
        <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel">Input Data - Tuker Faktur</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
            </button>
        </div>
        <form id="formtransaksi" action="#" method="post" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="nmenu" id="nmenu" value="tfaktur" readonly="readonly" />
        <input type="hidden" name="nact" id="nact" value="input" readonly="readonly" />
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">
                	<table width="100%">
                    <tr>
                        	<td width="35%"><label>Nomor Faktur <span class="tx-danger">*</span></label></td>
                        	<td width="5%"></td>
                        	<td width="60%">
                            <select name="kodetukerfaktur" id="kodetukerfaktur" class="form-control sumoselect" onchange="caritukerfaktur()" required="required">
                                <option value="">-- Select Nomor Faktur --</option>
                            <?php
                                // $lunas	= 'Sudah Tuker Faktur';
                                $master	= $conn->prepare("SELECT A.id_tfk, A.kode_tfk, B.nama_out FROM transaksi_faktur AS A LEFT JOIN outlet AS B ON A.id_out=B.id_out ORDER BY A.tgl_tfk ASC");
                                $master->bindParam(PDO::PARAM_STR);
                                $master->execute();
                                while($hasil	= $master->fetch(PDO::FETCH_ASSOC)){
                            ?>
                                <option value="<?php echo($hasil['id_tfk']); ?>"><?php echo("$hasil[kode_tfk] ($hasil[nama_out])"); ?></option>
                            <?php } ?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                        	<td><label>Outlet <span class="tx-danger">*</span></label></td>
                        	<td></td>
                        	<td><input type="text" name="namaoutlet" id="namaoutlet" class="form-control" style="background:#FFFFFF;" placeholder="-" readonly="readonly" /></td>
                        </tr>
                        <tr>
                        	<td><label>Tgl. Faktur <span class="tx-danger">*</span></label></td>
                        	<td></td>
                        	<td><input type="text" name="tglfaktur" id="tglfaktur" class="form-control" style="background:#FFFFFF;" placeholder="-" readonly="readonly" /></td>
                        </tr>
                        <tr>
                        	<td><label>Jatuh Tempo Faktur <span class="tx-danger">*</span></label></td>
                        	<td></td>
                        	<td><input type="text" name="tgltempo" id="tgltempo" class="form-control" style="background:#FFFFFF;" placeholder="-" readonly="readonly" /></td>
                        </tr>
                    </table>
                </div>
			</div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Tanggal Tuker Faktur<span class="tx-danger">*</span></label>
                    <input type="text" name="tanggal_tkf" id="tanggal_tkf" class="form-control fortgl" value="<?php echo(date('Y-m-d')); ?>" placeholder="9999-99-99" required="required" />
                    <div id="imgloading"></div>
                </div>
                 <div class="form-group col-sm-6">
                    <label>Status Tuker Faktur<span class="tx-danger"></span></label>
                    <input type="text" name="status" id="status" class="form-control" value="<?php echo('Sudah Tuker Faktur'); ?>" readonly="readonly" />
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
	}
	$conn	= $base->close();
?>
	<script type="text/javascript" src="<?php echo("$sistem/sumoselect/jquery.sumoselect.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo($data->sistem('url_sis').'/config/js/fazlurr.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo("$sistem/sumoselect/jquery.sumoselect.min.js"); ?>"></script>
	<script type="text/javascript">
	$('.sumoselect').SumoSelect({
		csvDispCount: 3,
		search: true,
		searchText:'Enter here.'
	});
    </script>