<?php
	switch($menu){
		default:
			require_once("content/home/home.php");
		break;
		case "":
			require_once("content/home/home.php");
		break;
		case "home":
			require_once("content/home/home.php");
		break;
		case "provinsi":
			require_once("content/provinsi/provinsi.php");
		break;
		case "kabupaten":
			require_once("content/kabupaten/kabupaten.php");
		break;
		case "koutlet":
			require_once("content/koutlet/koutlet.php");
		break;
		case "ksupplier":
			require_once("content/ksupplier/ksupplier.php");
		break;
		case "kproduk":
			require_once("content/kproduk/kproduk.php");
		break;
		case "klegal":
			require_once("content/klegal/klegal.php");
		break;
		case "sproduk":
			require_once("content/sproduk/sproduk.php");
		break;
		case "outlet":
			require_once("content/outlet/outlet.php");
		break;
		case "dispro":
			require_once("content/dispro/dispro.php");
		break;
		case "ioutlet":
			require_once("content/outlet/input.php");
		break;
		case "eoutlet":
			require_once("content/outlet/edit.php");
		break;
		case "voutlet":
			require_once("content/outlet/view.php");
		break;
		case "supplier":
			require_once("content/supplier/supplier.php");
		break;
		case "isupplier":
			require_once("content/supplier/input.php");
		break;
		case "esupplier":
			require_once("content/supplier/edit.php");
		break;
		case "vsupplier":
			require_once("content/supplier/view.php");
		break;
		case "batchcode":
			require_once("content/batchcode/batchcode.php");
		break;
		case "produk":
			require_once("content/produk/produk.php");
		break;
		case "vproduk":
			require_once("content/produk/view.php");
		break;
		case "hproduk":
			require_once("content/hproduk/hproduk.php");
		break;
		case "order":
			require_once("content/order/order.php");
		break;
		case "iorder":
			require_once("content/order/input.php");
		break;
		case "eorder":
			require_once("content/order/edit.php");
		break;
		case "vorder":
			require_once("content/order/view.php");
		break;
		case "rorder":
			require_once("content/rorder/rorder.php");
		break;
		case "irorder":
			require_once("content/rorder/input.php");
		break;
		case "erorder":
			require_once("content/rorder/edit.php");
		break;
		case "vrorder":
			require_once("content/rorder/view.php");
		break;
		case "inventory":
			require_once("content/inventory/inventory.php");
		break;
		case "tfstok":
			require_once("content/tfstok/tfstok.php");
		break;
		case "itfstok":
			require_once("content/tfstok/input.php");
		break;
		case "etfstok":
			require_once("content/tfstok/edit.php");
		break;
		case "vtfstok":
			require_once("content/tfstok/view.php");
		break;
		case "sales":
			require_once("content/sales/sales.php");
		break;
		case "isales":
			require_once("content/sales/input.php");
		break;
		case "vsales":
			require_once("content/sales/view.php");
		break;
		case "porder":
			require_once("content/porder/porder.php");
		break;
		case "fsales":
			require_once("content/fsales/fsales.php");
		break;
		case "ifsales":
			require_once("content/fsales/input.php");
		break;
		case "itemsales":
			require_once("content/fsales/item.php");
		break;
		case "efsales":
			require_once("content/fsales/edit.php");
		break;
		case "tfsales":
			require_once("content/fsales/tf.php");
		break;
		case "vfsales":
			require_once("content/fsales/view.php");
		break;
		case "psales":
			require_once("content/psales/psales.php");
		break;
		case "tfaktur":
			require_once("content/tfaktur/tfaktur.php");
		break;
		case "sistem":
			require_once("content/sistem/sistem.php");
		break;
		case "esistem":
			require_once("content/sistem/edit.php");
		break;
		case "rstok":
			require_once("content/rstok/rstok.php");
		break;
		case "rpenjualan":
			require_once("content/rpenjualan/rpenjualan.php");
		break;
		case "rspenjualan":
			require_once("content/rspenjualan/rspenjualan.php");
		break;
		case "rpembelian":
			require_once("content/rpembelian/rpembelian.php");
		break;
		case "red":
			require_once("content/red/red.php");
		break;
		case "rjtoutlet":
			require_once("content/rjtoutlet/rjtoutlet.php");
		break;
		case "rjtsupplier":
			require_once("content/rjtsupplier/rjtsupplier.php");
		break;
		case "rpjoutlet":
			require_once("content/rpjoutlet/rpjoutlet.php");
		break;
		case "rpjobat":
			require_once("content/rpjobat/rpjobat.php");
		break;
		case "gpembelian":
			require_once("content/gpembelian/gpembelian.php");
		break;
		case "gpenjualan":
			require_once("content/gpenjualan/gpenjualan.php");
		break;
		case "administrator":
			require_once("content/administrator/administrator.php");
		break;
		case "iadministrator":
			require_once("content/administrator/input.php");
		break;
		case "eadministrator":
			require_once("content/administrator/edit.php");
		break;
		case "hakakses":
			require_once("content/hakakses/hakakses.php");
		break;
		case "apoteker":
			require_once("content/apoteker/apoteker.php");
		break;
		case "riwayat":
			require_once("content/riwayat/riwayat.php");
		break;
		case "rankpenjualan":
			require_once("content/rankpenjualan/rankpenjualan.php");
		break;
		case "rankpembelian":
			require_once("content/rankpembelian/rankpembelian.php");
		break;
		case "kmenu":
			require_once("content/kmenu/kmenu.php");
		break;
		case "icon":
			require_once("content/icon/icon.php");
		break;
		case "menu":
			require_once("content/menu/menu.php");
		break;
		case "submenu":
			require_once("content/submenu/submenu.php");
		break;
		case "rolemenu":
			require_once("content/rolemenu/rolemenu.php");
		break;
		case "account":
			require_once("content/account/account.php");
		break;
		case "rproduk":
			require_once("content/rproduk/rproduk.php");
		break;
		case "cabang":
			require_once("content/cabang/cabang.php");
		break;
		case "transferstok":
			require_once("content/transferstok/transferstok.php");
		break;
		case "itransferstok":
			require_once("content/transferstok/input.php");
		break;
		case "etransferstok":
			require_once("content/transferstok/edit.php");
		break;
		case "vtransferstok":
			require_once("content/transferstok/view.php");
		break;
		case "rtransferstok":
			require_once("content/rtransferstok/rtransferstok.php");
		break;
		
		case "fsalespe":
			require_once("content/fsalespe/fsales.php");
		break;
	}
?>