<?php
include_once "../../sysconf/global_func.php";
include "../../sysconf/session.php";
include_once "../../sysconf/db_config.php";
//include "global_func_ticket.php";


$condb = connectDB();
$v_agentid      = get_session("v_agentid");
$v_agentlevel   = get_session("v_agentlevel");
$v_agentname   = get_session("v_agentname");

$iddet 			= $library['iddet'];

$ffolder		= $library['folder'];
$fmenu_link		= $library['menu_link'];
$fdescription	= $library['description'];
$fmenu_id		= $library['menu_id'];
$ficon			= $library['icon'];
$fiddet			= $library['iddet'];
$fblist			= $library['blist'];

$fmenu_link_back = "ticket_log_list";

    	
$blist 			= $library['blist'];
$strblist       = explode(";", $blist); 
$blist_date		= $strblist[0];
$blist_fcount	= $strblist[1];
$blist_csearch0	= $strblist[2];
$blist_tsearch0	= $strblist[3];
$blist_csearch1	= $strblist[4];
$blist_tsearch1	= $strblist[5];
$blist_csearch2	= $strblist[6];
$blist_tsearch2	= $strblist[7];
$blist_csearch3	= $strblist[8];
$blist_tsearch3	= $strblist[9];
$blist_csearch4	= $strblist[10];
$blist_tsearch4	= $strblist[11];


$txtcompletion			= get_param("txtcompletion");
$txtname			= get_param("txtname");
$txtsimulation			= get_param("txtsimulation");
$cmbcountry			= get_param("cmbcountry");
$cmbprovince		= get_param("cmbprovince");
$cmbdistrict		= get_param("cmbdistrict");
$cmbsubdistrict		= get_param("cmbsubdistrict");
$cmbvillage			= get_param("cmbvillage");
$txtmobileno		= get_param("txtmobileno");
$txtcompletionphoneno	= get_param("txtcompletionphoneno");
$txtemail			= get_param("txtemail");
	
$txtsubject			= get_param("txtsubject");
$cmbpriority		= get_param("cmbpriority");
$cmbchannel			= get_param("cmbchannel");
$cmbcategory		= get_param("cmbcategory");
$cmbsubcategory		= get_param("cmbsubcategory");
$cmbsubticket		= get_param("cmbsubticket");
$txtremark			= get_param("txtremark");
$statusnow			= get_param("statusnow");

$followphoneno		= get_param("followphoneno");
$followpriority		= get_param("followpriority");
$followescalation	= get_param("followescalation");
$followactiontaken	= get_param("followactiontaken");
$followstatus		= get_param("followstatus");

$accid				= get_param("accid");
$contact_id			= get_param("contact_id");
$mode			    = get_param("mode");


$v 					= get_param("v");
// $form_id            = date("ymhs").$v_agentid;
$form_id            = date("Ymdhis").$v_agentid."0";


$SesExt             = get_session("v_extension");

$ws_ip				= "http://".$host_server.":7675";
$ws_ip				= "https://crmtangcity1.wom.co.id:7675";

$SesIP              = $ws_ip;
if (substr($SesExt,0,3) == '531') {
	$SesIP = "https://crmtangcity1.wom.co.id:7675";
}else if (substr($SesExt,0,3) == '532') {
	$SesIP = "https://crmtangcity1.wom.co.id:7675";
}else if (substr($SesExt,0,3) == '533') {
	$SesIP = "http://10.1.49.222:7675";
}else if (substr($SesExt,0,3) == '534') {
	$SesIP = "http://10.1.49.223:7675";
}else if (substr($SesExt,0,3) == '535') {
	$SesIP = "http://10.1.49.224:7675";
}else if (substr($SesExt,0,3) == '538') {
        $SesIP = "http://10.2.19.235:7675";
}else if (substr($SesExt,0,3) == '539') {
        $SesIP = "http://10.3.41.235:7675";
}else if (substr($SesExt,0,3) == '540') {
        $SesIP = "https://crmjatim.wom.co.id:7675";
}else if (substr($SesExt,0,3) == '536') {
        $SesIP = "https://crmridar.wom.co.id:7675";
}else if (substr($SesExt,0,3) == '537') {
        $SesIP = "https://crmsumbagsel.wom.co.id:7675";
}else if (substr($SesExt,0,3) == '541') {
        $SesIP = "http://10.6.25.235:7675";
}else if (substr($SesExt,0,3) == '543') {
        $SesIP = "https://crmmedan.wom.co.id:7675";
}

$vr 				= explode("|", base64_decode($_GET['v']));
$idkonfirmasi	    = $vr[7];


$mode  = get_param("mode");
if ($mode=="es") {
	echo $idkonfirmasi;
	// $idkonfirmasi = "1574";
	// $idkonfirmasi = "1815";
	// $idkonfirmasi = "1709";
	$idkonfirmasi = "23970";
}

// echo "string $idkonfirmasi";
	$sql = " SELECT a.agent_name, b.emp_name, c.referantor_id, c.referantor_no, c.referantor_name FROM cc_agent_profile a 
			 LEFT JOIN cc_employee b ON a.agent_id=b.ref_no
			 LEFT JOIN cc_master_referantor c ON b.ref_emp_id=c.ref_emp_id WHERE a.id='$v_agentid' ";
	$res = mysqli_query($condb, $sql);
	if($rec = mysqli_fetch_array($res)) {
	  $referantor_id   = $rec["referantor_id"];
	  $referantor_no   = $rec["referantor_no"];
	  $referantor_name2 = $rec["referantor_name"];
	}

	$iddet = 0;
	$task_id = 0;
	// $sqlv = " SELECT a.id AS id_buck, a.task_id, c.campaign_name, d.prod_offering_name, IF(a.status_kontrak IN ('RRD', 'EXP'),'LUNAS','BELUM LUNAS') AS statuskontrak, a.* FROM cc_ts_konfirmasi a 
	// LEFT JOIN cc_campaign c ON (a.campaign_id=c.id) 
	// LEFT JOIN cc_prod_offering d ON (a.product_offering_code=d.prod_offering_code)
	// WHERE a.id = '".$idkonfirmasi."' ORDER BY ISNULL(a.priority) ASC, a.priority=0, a.priority  ASC LIMIT 1 "; 
	
	$sqlv = " SELECT a.id AS id_buck, a.task_id, c.campaign_name, d.prod_offering_name, IF(a.status_kontrak IN ('RRD', 'EXP'),'LUNAS',IF(a.status_kontrak='' OR a.status_kontrak IS NULL ,'','BELUM LUNAS')) AS statuskontrak, a.* FROM cc_ts_konfirmasi a 
	LEFT JOIN cc_campaign c ON (a.campaign_id=c.id) 
	LEFT JOIN cc_prod_offering d ON (a.product_offering_code=d.prod_offering_code)
	WHERE a.id = '".$idkonfirmasi."' ORDER BY ISNULL(a.priority) ASC, a.priority=0, a.priority  ASC LIMIT 1 "; 

if ($mode=="es") {
	echo "string $sqlv";
}
	// echo "string $idkonfirmasi $sqlv";
	$resv = mysqli_query($condb,$sqlv);
	if($recv = mysqli_fetch_array($resv)){
    	@extract($recv,EXTR_OVERWRITE);
		$task_id = $task_id;
		$campaign_name = $campaign_name;
		$contact_name = $customer_name;
		// $region_name = $region_code;
		$tenor = $tenor_new;
		$sisa_tenor = $sisa_tenor;
		$legal_alamat = $legal_alamat;
		$nama_pasangan_rtrw = $legal_rt."/".$legal_rw;
		$iddet = $id_buck;
		$cust_no = $order_no;
		$cust_id_no = $customer_id;
		$cust_religion = $religion;
		$tempat_lahir = $tempat_lahir;
		$tanggal_lahir = $tanggal_lahir;
		$nama_pasangan = $nama_pasangan;
		$tanggal_lahir_pasangan = $tanggal_lahir_pasangan;
		$item_type = $item_type;
		$polo_order_in_id = $polo_order_in_id;
		$sisa_piutang = $tenor*$monthly_instalment;
		$tanggal_lahir = str_replace(" 00:00:00","", $tanggal_lahir);
		$tanggal_lahir_arr = explode("T", $tanggal_lahir);
		if (strpos($tanggal_lahir, "T") !== false) {
			$tanggal_lahir = $tanggal_lahir_arr[0];
		}
		#print_r($tanggal_lahir_arr);

		$tanggal_lahir_pasangan = str_replace(" 00:00:00","", $tanggal_lahir_pasangan);
		$tanggal_lahir_pasangan = str_replace("0000-00-00","", $tanggal_lahir_pasangan);

		$tanggal_jatuh_tempo = str_replace(" 00:00:00","", $tanggal_jatuh_tempo);
		$tanggal_jatuh_tempo = str_replace("0000-00-00","", $tanggal_jatuh_tempo);

		$maturity_date = str_replace(" 00:00:00","", $maturity_date);
		$maturity_date = str_replace("0000-00-00","", $maturity_date);

		$release_date_bpkb = str_replace(" 00:00:00","", $release_date_bpkb);
		$release_date_bpkb = str_replace("0000-00-00","", $release_date_bpkb);


		$phone_check_result		= $phone_check_result;
		$slik_result			= $slik_result;
		$negative_customer_result	= $negative_customer_result;
		$duplicate_result		= $duplicate_result;
		$duplicate_ke			= $duplicate_ke;
		$sumber_data			= $sumber_data;
		$order_no_rating		= $order_no_rating;
		$region				= $region;
		$office				= $office;
		$contract_stat			= $contract_stat;
		$due_date			= $due_date;
		$est_max_jumlah_pembiayaan	= $est_max_jumlah_pembiayaan;
		$asset_code			= $asset_code;
		$asset_price			= $asset_price;
		$tahun_kendaraan		= $tahun_kendaraan;
		$result				= $result;
		$education			= $education;
		$stay_length			= $stay_length;
		$status_ktp			= $status_ktp;
		$npwp				= $npwp;
		$nomor_akta_pendirian		= $nomor_akta_pendirian;
		$nama_badan_usaha		= $nama_badan_usaha;
		$tempat_pendirian		= $tempat_pendirian;
		$tanggal_akta_pendirian		= $tanggal_akta_pendirian;
		$order_no			= $order_no;
		$ownership			= $ownership;

		$marital_status 		= $status_perkawinan;
		$dp 				= $down_payment;
		$survey_alamat      = $survey_alamat;
		$survey_provinsi      = $survey_provinsi;
		$survey_city      = $survey_city;
		$survey_kecamatan      = $survey_kecamatan;
		$survey_kelurahan      = $survey_kelurahan;
		$survey_rt      = $survey_rt;
		$survey_rw      = $survey_rw;
		$survey_kabupaten      = $survey_kabupaten;
		$survey_kodepos      = $survey_kodepos;
		$survey_sub_kodepos      = $survey_sub_kodepos;
		$residence_status    = $kepemilikan_rumah;
		$income              = $monthly_income;
		$txt_activity_waktuvisit = $visit_dt;
		$lenght_of_work = $length_of_work;
		$notes = $notes;

		$spouse_profession 			= $spouse_profession;
		$spouse_customer_model 		= $spouse_customer_model;
		$guarantor_profession 		= $guarantor_profession;
		$guarantor_customer_model 	= $guarantor_customer_model;

	}

	if ($marital_status=="SIN") {
		$marital_status="SINGLE";
	}else if ($marital_status=="MAR") {
		$marital_status="MENIKAH";
	}else if ($marital_status=="WID") {
		$marital_status="DUDA/JANDA";
	}

    $txt_profession_code     = $profession_code;
    $txt_mother_cust         = $nama_ibukandung;
	$txt_job_modelname			= $profession_cat_name;

	$sqllob = " SELECT a.profession_name FROM cc_master_profession a WHERE a.profession_code = '$jenis_pekerjaan'";
	$reslob = mysqli_query($condb, $sqllob);
	if($reclob = mysqli_fetch_array($reslob)) {
	  $profession_name   = $reclob["profession_name"];

	}

	// model customer
	$arr_cust_model = array();
	$sql_cust_model = "SELECT cust_model_name, cust_type, cust_model_code FROM cc_master_customer_model WHERE is_active=1";
	$res_cust_model = mysqli_query($condb, $sql_cust_model);
	while ($row_cm = mysqli_fetch_array($res_cust_model)) {
		$arr_cust_model[$row_cm["cust_model_code"]] = $row_cm["cust_model_name"];
	}

	// profession
	$arr_profession = array();
	$sql_profession = "SELECT * FROM cc_master_profession";
	$res_profession = mysqli_query($condb, $sql_profession);
	while ($row_profesion = mysqli_fetch_array($res_profession)) {
		$arr_profession[$row_profesion["profession_code"]] = $row_profesion["profession_name"];
	}

	$sqllob = " SELECT a.descr FROM cc_master_house_ownership a WHERE a.master_code = '$residence_status'";
	$reslob = mysqli_query($condb, $sqllob);
	if($reclob = mysqli_fetch_array($reslob)) {
	  $descr   = $reclob["descr"];
	  if ($descr!='') {
	  	$residence_status=$descr;
	  }
	}


	// $sqlv = " SELECT a.agrmnt_no, a.agrmnt_rating as agrmno, a.product_offering_code, d.prod_offering_name, a.region_name, a.cabang_code, a.cabang_name,a.cust_rating,IF(a.status_kontrak IN ('RRD', 'EXP'),'LUNAS','BELUM LUNAS') AS statuskontrak,
	// a.angsuran_ke,a.sisa_tenor, a.tenor,a.monthly_instalment,a.sisa_piutang,a.release_date_bpkb,a.max_past_due_date,a.tanggal_jatuh_tempo,a.maturity_date,a.no_mesin,a.no_rangka,a.asset_type,a.item_type,a.item_desc,a.otr_price,
	// a.item_year,a.kepemilikan_bpkb
	// FROM cc_ts_consumer_detail_all_date a 
	// LEFT JOIN cc_prod_offering d ON (a.product_offering_code=d.prod_offering_code)
	// WHERE a.task_id='$task_id' ORDER BY a.id ASC LIMIT 1 "; 
	// // echo "string $sqlv";
	// $resv = mysqli_query($condb,$sqlv);
	// if($recv = mysqli_fetch_array($resv)){
	// 	@extract($recv,EXTR_OVERWRITE);
	// 	$sisa_piutang = $tenor*$monthly_instalment;
	// }
	$param_lob="";
	$sqllob = " SELECT a.lob_code, a.lob_name FROM cc_ts_lob a WHERE a.lob_code = '$lob'";
	$reslob = mysqli_query($condb, $sqllob);
	if($reclob = mysqli_fetch_array($reslob)) {
	  $lob_code   = $reclob["lob_code"];
	  $lob_name   = $reclob["lob_name"];
	  $param_lob=substr_count($lob_name,"Mobil");

	}

	$sqllob = " SELECT a.asset_hierarchy_l1_code, a.asset_hierarchy_l1_name FROM cc_master_merk a WHERE a.asset_hierarchy_l1_code = '$item'";
	$reslob = mysqli_query($condb, $sqllob);
	if($reclob = mysqli_fetch_array($reslob)) {
	  $asset_hierarchy_l1_code   = $reclob["asset_hierarchy_l1_code"];
	  $item2   = $reclob["asset_hierarchy_l1_name"];

	}

	// if ($param_lob=="") {
	// 	$lob="";
	// }
	//echo "string ".$param_lob[$lob];
	// cc_master_kendaraan
//file save data
$save_form = "view/telesales/tele_confirmation_data_save.php";

if($iddet  == "") {
	$desc_iddet = "Create New";
} else {
	$desc_iddet = "View";
}

function sbstr($str){
	$v = substr($str, -1, 1); 
	if($v == 'B'){
		$rest = substr($str, 0, -1); 
	} else {
		$rest = $str;
	}
	return  $rest;
}
?>

<style type="text/css">										
	.select2-selection--single{
		height:40px !important;
	}
	.select2-container--default {
		height:40px !important;
	}
	.nav-pills.nav-primary .nav-link.active {
	    background: #1572e8 !important;
	    border: 1px solid #1572e8 !important;
	}
</style>

<script>
function money_format (number){
	if (isNaN(number)) return"";
	var str = new String(number);
	var result ="", len = str.length;
	for (var i=len-1;i>=0;i--){
		if((i+1)%3 == 0 && i+1 !=len) result += ".";
		result += str.charAt(len-1-i);
		}
	return result;
	}

	

//end of update
</script>
<style>
.swal-duplicate .swal-title {
	font-size: 18px;
	width: 80%;
	text-align: center;
	margin: 0 auto;
	padding: 6px 16px 13px 16px;
}
.swal-duplicate .swal-text {
	max-height: 6em;  /* To be adjusted as you like */
	overflow-y: scroll;
	width: 80%;
}

.swal-duplicate .swal-button-container .swal-button--cancel {  
	background: #1572e8 !important;
    border-color: #1572e8 !important;
	color: #ffffff;
}
.swal-duplicate .swal-button-container .swal-button--cancel:hover {
   background-color: #2B7FEA !important;
   border-color: #2B7FEA !important;
   color: #ffffff;
}
</style>
<div class="page-inner">
	<?php if($typecreate==''){ ?>
	<div class="page-header"  style="margin-bottom:0px;margin-top:-15px;padding-left:0px;padding:0px;margin-left:-20px;">
		<ul class="breadcrumbs" style="border-left:0px;margin:0px;">
			<li class="nav-home">
				<a href="index.php">
					<i class="fas fa-home"></i>
				</a>
			</li>
			<li class="separator">
				<i class="fas fa-chevron-right"></i>
			</li>
			<?php
				$menu_tree = explode("|", $library['page']);
				for ($i=0; $i <count($menu_tree) ; $i++) { 
					if ($i != 0) {
						echo "<li class=\"separator\"><i class=\"fas fa-chevron-right\"></i></li>";
					}
					echo "<li class=\"nav-item\">".$menu_tree[$i]."</li>";;
				}
				echo "<li class=\"separator\"><i class=\"fas fa-chevron-right\"></i></li>";
				echo "<li class=\"nav-item\">".$desc_iddet."</li>";;				
			?>
		</ul>
	</div>

	<div style="height:100%;top:0px;left:0px;position: fixed;z-index: 999999;text-align: center;width:100%;display: none" id="tempatLoading">
	 <div style="width:400px;margin:auto;margin-top:200px;padding:10px;">
	 	 <img src="assets/img/elyphsoft.gif" width="140px" style="border: 0px;border-radius: 4px;padding: 1px;border-radius:150px">
	  	<h1 style="font-weight:bold;color: white; text-shadow: -2px -2px 0 <?php echo $dominant_mastercolor_darker ?>, 2px -2px 0 <?php echo $dominant_mastercolor_darker ?>, -2px 2px 0 <?php echo $dominant_mastercolor_darker ?>, 2px 2px 0 <?php echo $dominant_mastercolor_darker ?>;">Please Wait</h1>
	  	<h2 style="font-weight:bold;color: white; text-shadow: -2px -2px 0 <?php echo $dominant_mastercolor_darker ?>, 2px -2px 0 <?php echo $dominant_mastercolor_darker ?>, -2px 2px 0 <?php echo $dominant_mastercolor_darker ?>, 2px 2px 0 <?php echo $dominant_mastercolor_darker ?>;">While We're Parsing Your Data</h2>
	 </div>
	</div>

	<div style="height:100%;top:0px;left:0px;position: fixed;z-index: 999999;text-align: center;width:100%;display: none" id="tempatDukcapil">
	 <div style="width:400px;margin:auto;margin-top:200px;padding:10px;">
	 	 <img src="assets/img/elyphsoft.gif" width="140px" style="border: 0px;border-radius: 4px;padding: 1px;border-radius:150px">
	  	<h1 style="font-weight:bold;color: white; text-shadow: -2px -2px 0 <?php echo $dominant_mastercolor_darker ?>, 2px -2px 0 <?php echo $dominant_mastercolor_darker ?>, -2px 2px 0 <?php echo $dominant_mastercolor_darker ?>, 2px 2px 0 <?php echo $dominant_mastercolor_darker ?>;">Please Wait</h1>
	  	<h2 style="font-weight:bold;color: white; text-shadow: -2px -2px 0 <?php echo $dominant_mastercolor_darker ?>, 2px -2px 0 <?php echo $dominant_mastercolor_darker ?>, -2px 2px 0 <?php echo $dominant_mastercolor_darker ?>, 2px 2px 0 <?php echo $dominant_mastercolor_darker ?>;">On Progress Validation Check</h2>
	 </div>
	</div>
	<?php }
	if($iddet > 0) { ?>

<form name="frmDataDet" id="frmDataDet" method="POST">
<input type="hidden" name="iddet" id="iddet" value="<?php echo $iddet;?>">
<input type="hidden" id="references_id" name="references_id" />
<input type="hidden" name="dialedno" id="dialedno">
<input type="hidden" name="ref_code" id="ref_code" value="<?php echo $referantor_no;?>">
<input type="hidden" name="ref_name" id="ref_name" value="<?php echo $referantor_name2;?>">
<input type="hidden" name="prod_ref" id="prod_ref">
<input type="hidden" name="form_id" id="form_id" value="<?php echo $form_id;?>">

<!-- NEW CAE 2 -->
<input type="hidden" name="txt_mother" id="txt_mother" value="<?php echo $txt_mother;?>">
<input type="hidden" name="txt_mother_cust" id="txt_mother_cust" value="<?php echo $txt_mother_cust;?>">
<input type="hidden" name="txt_job_modelname" id="txt_job_modelname" value="<?php echo $txt_job_modelname;?>">
<input type="hidden" name="txt_profession_code" id="txt_profession_code" value="<?php echo $txt_profession_code;?>">
<input type="hidden" name="custModelCode" id="custModelCode" value="<?php echo $custModelCode;?>">
<input type="hidden" name="custModelCodeSpouse" id="custModelCodeSpouse" value="<?php echo $custModelCodeSpouse;?>">
<input type="hidden" name="custModelCodeGuarantor" id="custModelCodeGuarantor" value="<?php echo $custModelCodeGuarantor;?>">
<input type="hidden" name="professionCodeGuarantor" id="professionCodeGuarantor" value="<?php echo $professionCodeGuarantor;?>">
<input type="hidden" name="custEdd" id="custEdd" value="<?php echo $custEdd;?>">
<input type="hidden" name="spouseEdd" id="spouseEdd" value="<?php echo $spouseEdd;?>">
<input type="hidden" name="guarantorEdd" id="guarantorEdd" value="<?php echo $guarantorEdd;?>">
<input type="hidden" name="professionCode" id="professionCode" value="<?php echo $professionCode;?>">
<input type="hidden" name="professionCodeSpouse" id="professionCodeSpouse" value="<?php echo $professionCodeSpouse;?>">
<input type="hidden" name="flagDeviationNegCust" id="flagDeviationNegCust" value="<?php echo $flagDeviationNegCust;?>">
<input type="hidden" name="flagDeviationNegSpouse" id="flagDeviationNegSpouse" value="<?php echo $flagDeviationNegSpouse;?>">
<input type="hidden" name="flagDeviationNegGuarantor" id="flagDeviationNegGuarantor" value="<?php echo $flagDeviationNegGuarantor;?>">
	<div id="page1">
					<div class="row">
						<div class="wizard-container wizard-round col-md-12">
							<div class="wizard-header text-center">
								<h3 class="wizard-title" id="font_contact_name" name="font_contact_name"><b><?=$campaign_name;?></b> # <?=$contact_name;?></h3>
							</div>
								<div class="wizard-body">
									<div class="row">

										<ul class="wizard-menu nav nav-pills nav-primary">
											<li class="step" style="width: 100%;">
												<a class="nav-link active" href="#inquiry" data-toggle="tab" aria-expanded="true"><i class="fa fa-user mr-0"></i> Inquiry Data</a>
											</li>
											<!-- <li class="step" style="width: 50%;">
												<a class="nav-link" href="#completion" data-toggle="tab"><i class="fa fa-file mr-2"></i> Completion Data</a>
											</li> -->
											<!-- <li class="step" style="width: 33.3333%;">
												<a class="nav-link" href="#simulation" data-toggle="tab"><i class="fa fa-map-signs mr-2"></i> Simulasi Pinjaman</a>
											</li> -->
										</ul>
									</div>
									<div class="tab-content">
										<div class="tab-pane active" id="inquiry">
											<div class="row">
					<div class="col-md-4">
								<?php
									$x				   = 0;	
		        					
		                    		$txtlabel[$x]      = "Customer Name";
		                    		$bodycontent[$x]   = input_text_readonly_temp("contact_name","contact_name",$contact_name,"","","form-control border-primary","");
		                    		$x++;
		                    		
		                    		echo label_form_det($txtlabel,$bodycontent,$x);


								?>
					</div>
					<div class="col-md-4">

								<?php
								
									$x				   = 0;		
		                    		// $txtlabel[$x]      = "Max Pencarian";
		                    		// $bodycontent[$x]   = input_text_readonly_temp("max_searching","max_searching",$max_searching,"","","form-control border-primary","");
		                    		// $x++;
		        					
		                    		$txtlabel[$x]      = "Sumber Data";
		                    		$bodycontent[$x]   = input_text_readonly_temp("source_data","source_data",$source_data,"","","form-control border-primary","");
		                    		$x++;
		                    		
		                    		echo label_form_det($txtlabel,$bodycontent,$x);
								?>
					</div>
					<div class="col-md-4">
						<?php
								
									$x				   = 0;	
		        					
		                    		// $txtlabel[$x]      = "&nbsp;";
		                    		// $bodycontent[$x]   = "</br><input type='button' name='addonphone' id='addonphone' class='btn btn-primary' value='Add Phone' data-toggle='modal' data-backdrop='false' data-target='#backcall'>";
		                    		// $x++;
		                    		// $addonphone = "<input type='button' name='addonphone' id='addonphone' class='btn btn-primary' value='Add Phone' data-toggle='modal' data-backdrop='false' data-target='#backcall'>";

		                    		// $txtlabel[$x]      = "&nbsp; AA";
		                    		// $bodycontent[$x]   = $addonphone;
		                    		// $x++;

									$phoneno = "<select class=\"form-control\" name=\"phoneNumber\" id=\"phoneNumber\" style='width:80%;' ><option value=''> -- Select -- </option> ";
									 if($mobile_1 !=''){
										$phoneno .="<option value=".$mobile_1. ">".sbstr($mobile_1)."</option>";
									 }
						             if($mobile_2 !=''){
										 $phoneno .="<option value=".$mobile_2. ">".sbstr($mobile_2)."</option>";
									 }
									 if($phone_1 !=''){
										 $phoneno .="<option value=".$phone_1. ">".sbstr($phone_1)."</option>";
									 }
									 if($phone_2 !=''){
										 $phoneno .="<option value=".$phone_2. ">".sbstr($phone_2)."</option>";
									 }
									 if($office_phone_1 !=''){
										 $phoneno .="<option value=".$office_phone_1. ">".sbstr($office_phone_1)."</option>";
									 }
									 if($office_phone_2 !=''){
									 	$phoneno .="<option value=".$office_phone_2. ">".sbstr($office_phone_2)."</option>";
									 }
									$phoneno .="</select>";
									$phonenya1 = "
									<div class=\"input-group mb-3\">
										".$phoneno."
										<div class=\"input-group-append\">
											<span class=\"input-group-text\"  id=\"callphone1\"><i class=\"fas fa-phone\"> Call</i></span>
										</div>
									</div>";

									$txtlabel[$x]      = "Phone Number";
									$bodycontent[$x]   = $phonenya1;
									$x++;
		        					
		                    		
		                    		
		                    		echo label_form_det($txtlabel,$bodycontent,$x);

		                    		
								?>
					</div>
						        
				</div>


				
				<div class="row">
					<div class="col-md-12">
						<div class="accordion" id="accordionCompletion">

						<div class="card">
						    <div class="card-header" id="headingContr">
						      <h2 class="mb-0">
						        <button style="width: 1000px !important; text-align: left;" class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						          <label style="font-size: 1.0375rem !important; width: 100% !important;"><i class="fas fa-sticky-note"></i> &nbsp;Detail Kontrak</label>
						        </button>
						      </h2>
						    </div>
						    <div id="collapseOne" class="collapse show" aria-labelledby="headingContr" data-parent="#accordionCompletion">
						      	<div class="card-body">
									<div class="row" id="div_edit" name="div_edit">
										<div class="col-md-4">
											<?php
													
														$txttitle	= "Data Konsumen";
							                    		$icofrm	  = "fas fa-users";
							                    		echo title_form_det($txttitle,$icofrm);
														$x				   = 0;
							        					
							                    		$txtlabel[$x]      = "Customer No";
							                    		$bodycontent[$x]   = input_text_readonly_temp("cust_id_no","cust_id_no",$cust_id_no,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Customer Rating (adding)";
							                    		$bodycontent[$x]   = input_text_readonly_temp("cust_rating","cust_rating",$cust_rating,"","","form-control border-primary","");
							                    		$x++;

							                    		$txtlabel[$x]      = "ID No.";
							                    		$bodycontent[$x]   = input_text_readonly_temp("nik_ktp","nik_ktp",$nik_ktp,"","","form-control border-primary","");
							                    		$x++;

							        					$sqlreligion = "SELECT a.religion_name FROM cc_master_religion a WHERE a.religion_code='$religion'";
														$resreligion = mysqli_query($condb,$sqlreligion);
														if($recreligion = mysqli_fetch_array($resreligion)){
															$religion2 	= $recreligion['religion_name'];
														}

							                    		$txtlabel[$x]      = "Religion";
							                    		$bodycontent[$x]   = input_text_readonly_temp("religion","religion",$religion2,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Birth Place";
							                    		$bodycontent[$x]   = input_text_readonly_temp("tempat_lahir","tempat_lahir",$tempat_lahir,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Birth Date";
							                    		$bodycontent[$x]   = input_text_readonly_temp("tanggal_lahir","tanggal_lahir",$tanggal_lahir,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Spouse Name";
							                    		$bodycontent[$x]   = input_text_readonly_temp("nama_pasangan","nama_pasangan",$nama_pasangan,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Spouse Birth Date";
							                    		$bodycontent[$x]   = input_text_readonly_temp("tanggal_lahir_pasangan","tanggal_lahir_pasangan",$tanggal_lahir_pasangan,"","","form-control border-primary","");
							                    		$x++;

							                    		$txtlabel[$x]      = "Spouse Profession";
							                    		$bodycontent[$x]   = input_text_readonly_temp("txt_spouse_profession","txt_spouse_profession",$arr_profession[$spouse_profession],"","","form-control border-primary","");
							                    		$x++;

							                    		$txtlabel[$x]      = "Spouse Customer Model";
							                    		$bodycontent[$x]   = input_text_readonly_temp("txt_spouse_customer_model","txt_spouse_customer_model",$arr_cust_model[$spouse_customer_model],"","","form-control border-primary","");
							                    		$x++;

							                    		$txtlabel[$x]      = "Guarantor Profession";
							                    		$bodycontent[$x]   = input_text_readonly_temp("txt_guarantor_profession","txt_guarantor_profession",$arr_profession[$guarantor_profession],"","","form-control border-primary","");
							                    		$x++;

							                    		$txtlabel[$x]      = "Guarantor Customer Model";
							                    		$bodycontent[$x]   = input_text_readonly_temp("txt_guarantor_customer_model","txt_guarantor_customer_model",$arr_cust_model[$guarantor_customer_model],"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Address";
							                    		$bodycontent[$x]   = input_textarea_readonly_temp("legal_alamat","legal_alamat",$legal_alamat,"","","form-control border-primary", 4);
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "RT/RW";
							                    		$bodycontent[$x]   = input_text_readonly_temp("nama_pasangan_rtrw","nama_pasangan_rtrw",$nama_pasangan_rtrw,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Province Name";
							                    		$bodycontent[$x]   = input_text_readonly_temp("legal_provinsi","legal_provinsi",$legal_provinsi,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Kabupaten";
							                    		$bodycontent[$x]   = input_text_readonly_temp("legal_kabupaten","legal_kabupaten",$legal_kabupaten,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Kecamatan";
							                    		$bodycontent[$x]   = input_text_readonly_temp("legal_kecamatan","legal_kecamatan",$legal_kecamatan,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Kelurahan";
							                    		$bodycontent[$x]   = input_text_readonly_temp("legal_kelurahan","legal_kelurahan",$legal_kelurahan,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "ZIP Code";
							                    		$bodycontent[$x]   = input_text_readonly_temp("legal_kodepos","legal_kodepos",$legal_kodepos,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Profession Name";
							                    		$bodycontent[$x]   = input_text_readonly_temp("profession_name","profession_name",$profession_name,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Profession Name Category";
							                    		$bodycontent[$x]   = input_text_readonly_temp("profession_cat_name","profession_cat_name",$profession_cat_name,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Job Position";
							                    		$bodycontent[$x]   = input_text_readonly_temp("job_position","job_position",$job_position,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Industry Type Name";
							                    		$bodycontent[$x]   = input_text_readonly_temp("industry_type_name","industry_type_name",$industry_type_name,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		
							                    		echo label_form_det($txtlabel,$bodycontent,$x);


														//new field 
														$x				   = 0;

														$txtlabel[$x]      = "";
							                    		$bodycontent[$x]   = "<hr>";
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Phone Check";
							                    		$bodycontent[$x]   = input_text_readonly_temp("phone_check_result","phone_check_result",$phone_check_result,"","","form-control border-primary","");
							                    		$x++;

														$txtlabel[$x]      = "Slik Result";
							                    		$bodycontent[$x]   = input_text_readonly_temp("slik_result","slik_result",$slik_result,"","","form-control border-primary","");
							                    		$x++;


														$txtlabel[$x]      = "Negative Customer Result";
							                    		$bodycontent[$x]   = input_text_readonly_temp("negative_customer_result","negative_customer_result",$negative_customer_result,"","","form-control border-primary","");
							                    		$x++;


														$txtlabel[$x]      = "Sumber Data";
							                    		$bodycontent[$x]   = input_text_readonly_temp("sumber_data","sumber_data",$sumber_data,"","","form-control border-primary","");
							                    		$x++;


														$txtlabel[$x]      = "Region";
							                    		$bodycontent[$x]   = input_text_readonly_temp("region","region",$region,"","","form-control border-primary","");
							                    		$x++;

														echo label_form_det($txtlabel,$bodycontent,$x);
													?>
										</div>
										
										<div class="col-md-4">
											<?php
													
														$txttitle	= "Data Kontrak";
							                    		$icofrm	  = "fas fa-tags";
							                    		echo title_form_det($txttitle,$icofrm);
														$x				   = 0;
							        					
							                    		$txtlabel[$x]      = "Order No";
							                    		$bodycontent[$x]   = input_text_readonly_temp("agrmnt_no","agrmnt_no",$no_kontrak_old,"","","form-control border-primary","");
							                    		$x++;
							        					
							        					
							                    		$txtlabel[$x]      = "Order No Rating";
							                    		$bodycontent[$x]   = input_text_readonly_temp("agrmnt_rating","agrmnt_rating",$agrmnt_rating,"","","form-control border-primary","");
							                    		$x++;
							        					
							        					
							                    		$txtlabel[$x]      = "Prod Offering Code";
							                    		$bodycontent[$x]   = input_text_readonly_temp("product_offering_code","product_offering_code",$product_offering_code,"","","form-control border-primary","");
							                    		$x++;
							        					
							        					
							                    		$txtlabel[$x]      = "Prod Offering Name";
							                    		$bodycontent[$x]   = input_text_readonly_temp("prod_offering_name","prod_offering_name",$prod_offering_name,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Office Code";
							                    		$bodycontent[$x]   = input_text_readonly_temp("cabang_code","cabang_code",$cabang_code,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Office Name";
							                    		$bodycontent[$x]   = input_text_readonly_temp("cabang_name","cabang_name",$cabang_name,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Customer Rating";
							                    		$bodycontent[$x]   = input_text_readonly_temp("cust_rating","cust_rating",$cust_rating,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Contract Status";
							                    		$bodycontent[$x]   = input_text_readonly_temp("cont_status","cont_status",$statuskontrak,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Next Inst Number";
							                    		$bodycontent[$x]   = input_text_readonly_temp("angsuran_ke","angsuran_ke",$angsuran_ke,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "OS Tenor";
							                    		$bodycontent[$x]   = input_text_readonly_temp("sisa_tenor","sisa_tenor",$sisa_tenor,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Tenor";
							                    		$bodycontent[$x]   = input_text_readonly_temp("tenor","tenor",$tenor,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Monthly Installment";
							                    		$bodycontent[$x]   = input_text_readonly_temp("monthly_instalment","monthly_instalment",number_format($monthly_instalment,0,'',','),"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "OS Installment AMT";
							                    		$bodycontent[$x]   = input_text_readonly_temp("sisa_piutang","sisa_piutang",number_format($sisa_piutang,0,'',','),"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "BPKB Release Date";
							                    		$bodycontent[$x]   = input_text_readonly_temp("release_date_bpkb","release_date_bpkb",$release_date_bpkb,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Max Past Due Date";
							                    		$bodycontent[$x]   = input_text_readonly_temp("max_past_due_date","max_past_due_date",$max_past_due_date,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Due Date";
							                    		$bodycontent[$x]   = input_text_readonly_temp("tanggal_jatuh_tempo","tanggal_jatuh_tempo",$tanggal_jatuh_tempo,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Maturity Date";
							                    		$bodycontent[$x]   = input_text_readonly_temp("maturity_date","maturity_date",$maturity_date,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Estimasi Max Jumlah Pembiayaan";
							                    		$bodycontent[$x]   = input_text_readonly_temp("estimasi_max","estimasi_max",number_format($estimasi_max,0,'',','),"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Marital Status";
							                    		$bodycontent[$x]   = input_text_readonly_temp("marital_status","marital_status",$marital_status,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Residence Status";
							                    		$bodycontent[$x]   = input_text_readonly_temp("residence_status","residence_status",$residence_status,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "DP";
							                    		$bodycontent[$x]   = input_text_readonly_temp("dp","dp",number_format($dp,0,'',','),"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Num Of Dependents";
							                    		$bodycontent[$x]   = input_text_readonly_temp("num_of_dependents","num_of_dependents",number_format($num_of_dependents,0,'',','),"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Length Of Work ";
							                    		$bodycontent[$x]   = input_text_readonly_temp("lenght_of_work","lenght_of_work",$lenght_of_work,"","","form-control border-primary","");
							                    		// number_format($lenght_of_work,"",'',',')
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Income";
							                    		$bodycontent[$x]   = input_text_readonly_temp("income","income",number_format($income,0,'',','),"","","form-control border-primary","");
							                    		$x++;
							                    		
							                    		echo label_form_det($txtlabel,$bodycontent,$x);


														//new field 
														$x				   = 0;

														$txtlabel[$x]      = "";
							                    		$bodycontent[$x]   = "<hr>";
							                    		$x++;

														echo label_form_det($txtlabel,$bodycontent,$x);
													?>
										</div>
										<div class="col-md-4">
											<?php
													
														$txttitle	= "Data Kendaraan";
							                    		$icofrm	  = "fas fa-motorcycle";
							                    		echo title_form_det($txttitle,$icofrm);
														$x				   = 0;
							        					
							                    		$txtlabel[$x]      = "Machine No";
							                    		$bodycontent[$x]   = input_text_readonly_temp("no_mesin","no_mesin",$no_mesin,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Chassis No";
							                    		$bodycontent[$x]   = input_text_readonly_temp("vehi_chassis_no","vehi_chassis_no",$no_rangka,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Asset Type";
							                    		$bodycontent[$x]   = input_text_readonly_temp("asset_type","asset_type",$asset_type,"","","form-control border-primary","");
							                    		$x++;
							                    		
							                    		$txtlabel[$x]      = "Asset Code";
							                    		$bodycontent[$x]   = input_text_readonly_temp("item_type","item_type",$item_type,"","","form-control border-primary","");
							                    		$x++;
							                    
							                    		$txtlabel[$x]      = "Merek";
							                    		$bodycontent[$x]   = input_text_readonly_temp("item","item",$item2,"","","form-control border-primary","");
							                    		$x++;

							                    		$txtlabel[$x]      = "Model";
							                    		$bodycontent[$x]   = input_text_readonly_temp("item_desc","item_desc",$item_desc,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Asset Price AMT";
							                    		$bodycontent[$x]   = input_text_readonly_temp("otr_price","otr_price",number_format($otr_price,0,'',','),"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Manufacturing Year";
							                    		$bodycontent[$x]   = input_text_readonly_temp("item_year","item_year",$item_year,"","","form-control border-primary","");
							                    		$x++;
							        					
							                    		$txtlabel[$x]      = "Owner Relationship";
							                    		$bodycontent[$x]   = input_text_readonly_temp("kepemilikan_bpkb","kepemilikan_bpkb",$kepemilikan_bpkb,"","","form-control border-primary","");
							                    		$x++;
							                    		
							                    		echo label_form_det($txtlabel,$bodycontent,$x);

														//new field 
														$x				   = 0;

														$txtlabel[$x]      = "";
							                    		$bodycontent[$x]   = "<hr>";
							                    		$x++;

														$txtlabel[$x]      = "Result";
							                    		$bodycontent[$x]   = input_text_readonly_temp("result","result",$result,"","","form-control border-primary","");
							                    		$x++;


														$txtlabel[$x]      = "Education";
							                    		$bodycontent[$x]   = input_text_readonly_temp("education","education",$education,"","","form-control border-primary","");
							                    		$x++;


														$txtlabel[$x]      = "Stay Length";
							                    		$bodycontent[$x]   = input_text_readonly_temp("stay_length","stay_length",$stay_length,"","","form-control border-primary","");
							                    		$x++;


														$txtlabel[$x]      = "Status KTP";
							                    		$bodycontent[$x]   = input_text_readonly_temp("status_ktp","status_ktp",$status_ktp,"","","form-control border-primary","");
							                    		$x++;


														$txtlabel[$x]      = "NPWP";
							                    		$bodycontent[$x]   = input_text_readonly_temp("npwp","npwp",$npwp,"","","form-control border-primary","");
							                    		$x++;


														$txtlabel[$x]      = "Nomor Akta Pendirian";
							                    		$bodycontent[$x]   = input_text_readonly_temp("nomor_akta_pendirian","nomor_akta_pendirian",$nomor_akta_pendirian,"","","form-control border-primary","");
							                    		$x++;

														$txtlabel[$x]      = "Nama Badan Usaha";
							                    		$bodycontent[$x]   = input_text_readonly_temp("nama_badan_usaha","nama_badan_usaha",$nama_badan_usaha,"","","form-control border-primary","");
							                    		$x++;

														$txtlabel[$x]      = "Tempat Pendirian";
							                    		$bodycontent[$x]   = input_text_readonly_temp("tempat_pendirian","tempat_pendirian",$tempat_pendirian,"","","form-control border-primary","");
							                    		$x++;

														$txtlabel[$x]      = "Tanggal Akta Pendirian";
							                    		$bodycontent[$x]   = input_text_readonly_temp("tanggal_akta_pendirian","tanggal_akta_pendirian",$tanggal_akta_pendirian,"","","form-control border-primary","");
							                    		$x++;

		
														echo label_form_det($txtlabel,$bodycontent,$x);
													?>
										</div>

								        
									</div>
						      	</div>
						    </div>
						</div>
						
						<div class="card">
						    <div class="card-header" id="headingActy">
						      <h2 class="mb-0">
						        <button style="width: 1000px !important; text-align: left;" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						          <label style="font-size: 1.0375rem !important; width: 100% !important;"><i class="fas fa-sort-amount-desc"></i> &nbsp;Activity</label>
						        </button>
						      </h2>
						    </div>
						    <div id="collapseThree" class="collapse" aria-labelledby="headingActy" data-parent="#accordionCompletion">
								
							<div class="card-action">
						        	<!-- &nbsp;&nbsp;<button class="btn btn-primary" id="btnValidForm" value="save">Validate Dukcapil</button> -->

						        	<div style="display: flex;">
						        		
						        		<div class="col-md-4">
											<div>
							        		<?php 
							        		// if ($mode=="es") {
							        				
							        				// echo '<div style="float:left;width:200px;background:white;height:200px;overflow-y:auto;margin:5px"><img src="data:image/jpg;base64,' . $cust_photo . '" style="width:200px;height:auto;"/></div>';
							        				// echo '<div style="float:left;width:200px;background:white;height:200px;overflow-y:auto;margin:5px"><img src="data:image/jpg;base64,' . $id_photo . '" style="width:200px;height:auto;"/></div>';
							        				echo '<div style="float:left;width:200px;background:white;height:200px;overflow-y:auto;margin:5px"><img src="public/konfirm/cust_photo/'.$cust_photo.'" style="width:200px;height:auto;"/></div>';
							        				echo '<div style="float:left;width:200px;background:white;height:200px;overflow-y:auto;margin:5px"><img src="public/konfirm/id_photo/'.$id_photo.'" style="width:200px;height:auto;"/></div>';
							        		// } 
							        		?>
							        		</div>
										</div>
						        		<div class="col-md-4">
						        		<?php
											
												$x				   = 0;	

					                    		$txtlabel[$x]      = "Alamat Survey <span class='required-label label_prospect' style='display:none;'>*</span>";
					                    		$bodycontent[$x]   = input_textarea_temp("survey_alamat","survey_alamat",$survey_alamat,"","","form-control border-primary val-prospect", 4);
					                    		$x++;

							                    $txtlabel[$x]      = "RT Survey <span class='required-label label_prospect' style='display:none;'>*</span>";
							                    $bodycontent[$x]   = input_number_temp_keypress_maxlength("rt_survey","rt_survey",$survey_rt,"","","form-control border-primary val-prospect","return validate_number(event)");//input_text_temp("rt_survey","rt_survey",number_format($rt_survey,0,'',','),"","","form-control border-primary","");
							                    $x++;

							                    $txtlabel[$x]      = "RW Survey <span class='required-label label_prospect' style='display:none;'>*</span>";
							                    $bodycontent[$x]   = input_number_temp_keypress_maxlength("rw_survey","rw_survey",$survey_rw,"","","form-control border-primary val-prospect","return validate_number(event)");
							                    $x++;
	        					
					        					function get_select_master_prov($conDB, $id, $name, $required, $product_id,$lob) {
														$sel = "<SELECT id=\"$id\" name=\"$name\" class=\"select2 form-control val-prospect\" style=\"width:100%;\" \"$required\" >";//disabled

														if ($lob !="") {
															$sql_whr="AND b.lob_code='$lob'";
														}
														$sql_str1 = " SELECT province_name FROM cc_province WHERE status = 1";
														$sql_res1  = execSQL($conDB, $sql_str1);
														$sel .= "<option value=\"\" selected>-- Select --</option>";
														while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
														  if(strtolower($sql_rec1['province_name']) == strtolower($product_id)) {
															$sel .= "<option value=\"".$sql_rec1['province_name']."\" selected>".$sql_rec1['province_name']."</option>";  
														  } else {
															$sel .= "<option value=\"".$sql_rec1['province_name']."\" >".$sql_rec1['province_name']."</option>";  
													  
														  }
														}
														$sel .= "</SELECT>";
													  
														return $sel;
													  }

					                    		$txtlabel[$x]      = "Provinsi Survey <span class='required-label label_prospect' style='display:none;'>*</span>";
					                    		$bodycontent[$x]   = get_select_master_prov($condb, "prov_survey", "prov_survey", "", $survey_provinsi,$prov_survey);
					                    		$x++;
					                    		
					                    		echo label_form_det($txtlabel,$bodycontent,$x);
					                    		//echo '<img src="data:image/jpg;base64,' . $cust_photo . '" />';
					                    		if ($mode=="es") {
					                    			//echo "string $cust_photo;";
					                    			// echo '<img src="data:image/jpg;base64,' . $cust_photo . '" style="width:200px;height:auto;"/>';
					                    		}

											?>
										</div>
						        		<div class="col-md-4">
						        		<?php
											
												$x				   = 0;	
	        					
					        					function get_select_master_kab($conDB, $id, $name, $required, $survey_kabupaten,$lob, $survey_provinsi) {
														$sel = "<SELECT id=\"$id\" name=\"$name\" class=\"select2 form-control val-prospect\" style=\"width:100%;\" \"$required\" >";//disabled

														if ($lob !="") {
															$sql_whr="AND b.lob_code='$lob'";
														}
														// $sql_str1 = " SELECT a.id, a.prod_offering_code, a.prod_offering_name FROM cc_prod_offering a
														// 	LEFT JOIN cc_ts_lob b ON a.prod_offering_code=b.prod_offering_code WHERE a.status='1' $sql_whr 
														// 	 ";
														// $sql_str1 = " SELECT a.id, a.city FROM cc_master_alamat a WHERE a.is_active=1 GROUP BY a.city ";
														// $sql_res1  = execSQL($conDB, $sql_str1);
														// $sel .= "<option value=\"\" selected>-- Select --</option>";
														// while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
														//   if(strtolower($sql_rec1['city']) == strtolower($survey_kabupaten)) {
														// 	$sel .= "<option value=\"".$sql_rec1['city']."\" selected>".$sql_rec1['city']."</option>";  
														//   } else {
														// 	$sel .= "<option value=\"".$sql_rec1['city']."\" >".$sql_rec1['city']."</option>";  
													  
														//   }
														// }

														if($survey_provinsi != ""){
															$sql0 = "SELECT b.ref_name AS dis, b.ref_prov_district_id as id, b.ref_name
																	FROM 
																	cc_master_ref_prov_district a
																	JOIN cc_master_ref_prov_district b ON b.parent_id=a.ref_prov_district_id AND b.is_active=1 AND b.ref_type='DIS'
																	WHERE 1=1 
																	AND a.ref_name='$survey_provinsi'
																	GROUP BY a.ref_name, b.ref_prov_district_id
																	ORDER BY b.ref_name";
															$res0 = mysqli_query($conDB, $sql0);
															$arr0 = mysqli_fetch_all($res0);
															$iddes0 =  implode(',', array_map(function ($entry) {
															                        return $entry[1];
															                      }
															                    , $arr0 ));
															mysqli_free_result($res0);

															// print_r($iddes);
															$sql = "SELECT a.city as city
																	FROM cc_master_alamat a 
																	WHERE a.ref_prov_district_id IN ($iddes0) AND a.is_active=1 GROUP BY a.city ORDER BY a.city ASC";
															// if($mode == "es"){ echo $sql_legal_kab."<br><br>"; }
															$res = mysqli_query($conDB, $sql);
														}else{
															$sql = "SELECT * FROM cc_master_alamat WHERE is_active=1 GROUP BY city";
															$res = mysqli_query($conDB,$sql);
														}

														while($sql_rec1=mysqli_fetch_array($res)){
															if(strtolower($sql_rec1['city']) == strtolower($survey_kabupaten)) {
															$sel .= "<option value=\"".$sql_rec1['city']."\" selected>".$sql_rec1['city']."</option>";  
														  	} else {
															$sel .= "<option value=\"".$sql_rec1['city']."\" >".$sql_rec1['city']."</option>";  
													  
															}
														}
														mysqli_free_result($res);
														$sel .= "</SELECT>";
													  
														return $sel;
													  }

					                    		$txtlabel[$x]      = "Kota / kabupaten Survey <span class='required-label label_prospect' style='display:none;'>*</span>";
					                    		$bodycontent[$x]   = get_select_master_kab($condb, "kab_survey", "kab_survey", "", $survey_kabupaten,$kab_survey, $survey_provinsi);
					                    		$x++;
	        					
					        					function get_select_master_kec($conDB, $id, $name, $required, $survey_kecamatan,$survey_kabupaten) {
														$sel = "<SELECT id=\"$id\" name=\"$name\" class=\"select2 form-control val-prospect\" style=\"width:100%;\" \"$required\" >";//disabled

														$city2 = strtolower($survey_kabupaten);
														$sql_str1 = " SELECT a.id, a.kecamatan FROM cc_master_alamat a WHERE LOWER(a.city)='$city2' AND a.is_active=1 GROUP BY a.kecamatan ";
														$sql_res1  = execSQL($conDB, $sql_str1);
														$sel .= "<option value=\"\" selected>-- Select --</option>";
														while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
														  if(strtolower($sql_rec1['kecamatan']) == strtolower($survey_kecamatan)) {
															$sel .= "<option value=\"".$sql_rec1['kecamatan']."\" selected>".$sql_rec1['kecamatan']."</option>";  
														  } else {
															$sel .= "<option value=\"".$sql_rec1['kecamatan']."\" >".$sql_rec1['kecamatan']."</option>";  
													  
														  }
														}
														$sel .= "</SELECT>";
													  
														return $sel;
													  }

					                    		$txtlabel[$x]      = "Kecamatan Survey <span class='required-label label_prospect' style='display:none;'>*</span>";
					                    		$bodycontent[$x]   = get_select_master_kec($condb, "kec_survey", "kec_survey", "", $survey_kecamatan,$survey_kabupaten);
					                    		$x++;
	        					
					        					function get_select_master_kel($conDB, $id, $name, $required, $survey_kelurahan,$survey_kecamatan) {
														$sel = "<SELECT id=\"$id\" name=\"$name\" class=\"select2 form-control val-prospect\" style=\"width:100%;\" \"$required\" >";//disabled

														$kec = strtolower($survey_kecamatan);
														$sql_str1 = " SELECT a.id, a.kelurahan FROM cc_master_alamat a WHERE LOWER(a.kecamatan)='$kec' AND a.is_active=1 GROUP BY a.kelurahan ";
														$sql_res1  = execSQL($conDB, $sql_str1);
														$sel .= "<option value=\"\" selected>-- Select --</option>";
														while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
														  if(strtolower($sql_rec1['kelurahan']) == strtolower($survey_kelurahan)) {
															$sel .= "<option value=\"".$sql_rec1['kelurahan']."\" selected>".$sql_rec1['kelurahan']."</option>";  
														  } else {
															$sel .= "<option value=\"".$sql_rec1['kelurahan']."\" >".$sql_rec1['kelurahan']."</option>";  
													  
														  }
														}
														$sel .= "</SELECT>";
													  
														return $sel;
													  }

					                    		$txtlabel[$x]      = "Kelurahan Survey <span class='required-label label_prospect' style='display:none;'>*</span>";
					                    		$bodycontent[$x]   = get_select_master_kel($condb, "kel_survey", "kel_survey", "", $survey_kelurahan,$survey_kecamatan);
					                    		$x++;
	        					
					        					function get_select_master_zipcode($conDB, $id, $name, $required, $product_id,$lob) {
														$sel = "<SELECT id=\"$id\" name=\"$name\" class=\"select2 form-control val-prospect\" style=\"width:100%;\" \"$required\" >";//disabled

														if ($lob !="") {
															$sql_whr="AND b.lob_code='$lob'";
														}
														// $sql_str1 = " SELECT a.id, a.prod_offering_code, a.prod_offering_name FROM cc_prod_offering a
														// 	LEFT JOIN cc_ts_lob b ON a.prod_offering_code=b.prod_offering_code WHERE a.status='1' $sql_whr 
														// 	 ";
														// $sql_res1  = execSQL($conDB, $sql_str1);
														$sel .= "<option value=\"\" selected>-- Select --</option>";
														
														if ($product_id !="") {
															$sel .= "<option value=\"".$product_id."\" selected>".$product_id."</option>";  
														}
														// while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
														//   if($sql_rec1['prod_offering_code'] == $product_id) {
														// 	$sel .= "<option value=\"".$sql_rec1['prod_offering_code']."\" selected>".$sql_rec1['prod_offering_code']." / ".$sql_rec1['prod_offering_name']."</option>";  
														//   } else {
														// 	$sel .= "<option value=\"".$sql_rec1['prod_offering_code']."\" >".$sql_rec1['prod_offering_code']." / ".$sql_rec1['prod_offering_name']."</option>";  
													  
														//   }
														// }
														$sel .= "</SELECT>";
													  
														return $sel;
													  } 

					                    		$txtlabel[$x]      = "Kode Pos Survey <span class='required-label label_prospect' style='display:none;'>*</span>";
					                    		$bodycontent[$x]   = get_select_master_zipcode($condb, "zipcode_survey", "zipcode_survey", "", $survey_kodepos,$zipcode_survey);
					                    		$x++;

					                    		$txtlabel[$x]      = "Survey Sub Zip code";
					                    		$bodycontent[$x]   = input_text_readonly_temp("subzipcode_survey","subzipcode_survey",$survey_sub_kodepos,"","","form-control border-primary","");
					                    		$x++;

									$txtlabel[$x]      = "Opsi Waktu Visit/Survey";
									$bodycontent[$x]   = '<input type="text" class="form-control form-control-sm" id="txt_activity_waktuvisit" name="txt_activity_waktuvisit" value="'.$txt_activity_waktuvisit.'">';
									$x++;
					                    		
					                    		echo label_form_det($txtlabel,$bodycontent,$x);
					                    		//echo '<img src="data:image/jpg;base64,' . $cust_photo . '" />';
					                    		if ($mode=="es") {
					                    			//echo "string $cust_photo;";
					                    			// echo '<img src="data:image/jpg;base64,' . $cust_photo . '" style="width:200px;height:auto;"/>';
					                    		}

											?>
										</div>
						        		<div style="clear:both"></div>
						        		
						        	</div>						        	
								</div>
						    	<div class="card-body">
						    			<!-- <div>	
											&nbsp;&nbsp;<button class="btn btn-warning" id="btnEditForm" value="save">Edit</button>
											&nbsp;&nbsp;<button class="btn btn-primary" id="btnSimpanForm" value="save" disabled >Simpan</button>
											&nbsp;&nbsp;<button class="btn btn-danger" id="btnCancel" value="save" disabled >Cancel</button>
										</div> -->
							      	<div class="row">
							      		
										<div class="col-md-4">

											<?php
											
												$x				   = 0;	

							                    $txtlabel[$x]      = "Tenor";
							                    $bodycontent[$x]   = input_text_readonly_temp("tenor","tenor",$tenor,"","","form-control border-primary","");
							                    $x++;

								                $callstatus = "<select name='call_status' id='call_status' class='form-control border-primary' required>";
								                $callstatus .= "<option value=''>-- Select --</option>";
												$sqlcs = "SELECT id, call_status FROM cc_ts_konfirmasi_call_status ";
												$rescs = mysqli_query($condb,$sqlcs);
												while($reccs = mysqli_fetch_array($rescs)){
													$id 		= $reccs['id'];
													$cstatus    = $reccs['call_status'];

													$callstatus .= "<option value='$id'>$cstatus</option>";
												}
								                $callstatus.= "</select>";
																                                                              
								                $txtlabel[$x]     = "Result <span class='required-label'>*</span>";
								                $bodycontent[$x]  = $callstatus;
								                $x++;


								                $callstatus = "<select name='call_status_sub1' id='call_status_sub1' class='form-control border-primary' >";
								                $callstatus .= "<option value=''>-- Select --</option>";
												$sqlcs = "SELECT id, call_status_sub1 
	                                                          FROM cc_ts_konfirmasi_sub1_call_status
	                                                          WHERE id='$call_status_sub1'
	                                                          ORDER BY call_status_sub1 ASC ";
												$rescs = mysqli_query($condb,$sqlcs);
												while($reccs = mysqli_fetch_array($rescs)){
													$id 		= $reccs['id'];
													$cstatus    = $reccs['call_status_sub1'];

													if ($id==$call_status_sub1) {
														$callstatus .= "<option value='$id' selected>$cstatus</option>";
													}else{
														$callstatus .= "<option value='$id'>$cstatus</option>";
													}
												}
								                $callstatus.= "</select>";
																                                                              
								                $txtlabel[$x]     = "Sub Result";
								                $bodycontent[$x]  = $callstatus;
								                $x++;

					                    		$txtlabel[$x]      = "Nama Ibu Kandung <span class='required-label'>*</span>";
					                    		$bodycontent[$x]   = input_text_temp("nama_ibukandung","nama_ibukandung",$nama_ibukandung,"","required","form-control border-primary");
					                    		$x++;
					                    		// xxx

					                    		$txtlabel[$x]      = "Dukcapil Result Pemohon";
					                    		$bodycontent[$x]   = input_text_readonly_temp("txt_activity_ducapil","txt_activity_ducapil",$txt_activity_ducapil,"","","form-control border-primary","");
					                    		$x++;
					                    			
					                    		$txtlabel[$x]      = "Neglist Result Pemohon";
					                    		$bodycontent[$x]   = input_text_readonly_temp("txt_activity_neglist","txt_activity_neglist",$txt_activity_neglist,"","","form-control border-primary","");
					                    		$x++;
					                    			
					                    		$txtlabel[$x]      = "Dukcapil Result Pasangan";
					                    		$bodycontent[$x]   = input_text_readonly_temp("txt_activity_pasangan_ducapil","txt_activity_pasangan_ducapil",$txt_activity_pasangan_ducapil,"","","form-control border-primary","");
					                    		$x++;
					                    			
					                    		$txtlabel[$x]      = "Neglist Result Pasangan";
					                    		$bodycontent[$x]   = input_text_readonly_temp("txt_activity_pasangan_neglist","txt_activity_pasangan_neglist",$txt_activity_pasangan_neglist,"","","form-control border-primary","");
					                    		$x++;
					                    		
					                    		echo label_form_det($txtlabel,$bodycontent,$x);



					                    		echo '<div id="div_followup" style="display: none;">';
					                    			$x				   = 0;	
						                    		$txtlabel[$x]      = "Follow Up <span class='required-label'>*</span>";
						                    		$bodycontent[$x]   = input_text_temp("txtfollowup","txtfollowup",$txtfollowup,"","","form-control border-primary");
						                    		$x++;

						                    		echo label_form_det($txtlabel,$bodycontent,$x);
												echo '</div>';

											?>
										</div>
										<!-- <div class="col-md-4">
											<?php
											
												$x				   = 0;		
					                    		$txtlabel[$x]      = "Status";
					                    		$bodycontent[$x]   = input_text_readonly_temp("two_status","two_status",$two_status,"","","form-control border-primary","");
					                    		$x++;
					                    		
					                    		echo label_form_det($txtlabel,$bodycontent,$x);
											?>
										</div> -->
										<div class="col-md-4">
											<?php
											
												$x				   = 0;	

							                    $txtlabel[$x]      = "Asset Price AMT";
							                    $bodycontent[$x]   = input_text_temp("otr_price2","otr_price2",number_format($otr_price,0,'',','),"","","form-control border-primary","");
							                    $x++;
								                	        					
					        					function get_select_master_lob($conDB, $id, $name, $required, $mlob,$asset_type,$param_lob) {
					        							$param_dis="";

					        							$sql_whr = "WHERE a.lob_name LIKE '%Mobil%' ";
					        							if ($param_lob==0) {
					        								$param_dis = "disabled";
					        								$sql_whr="";
					        							}
					        							// $param_dis = "disabled";
														$sel = "<SELECT id=\"$id\" name=\"$name\" class=\"select2 form-control\" style=\"width:100%;\" \"$required\" $param_dis>";//disabled
														$sql_str1 = " SELECT a.lob_code, a.lob_name FROM cc_ts_lob a $sql_whr GROUP BY a.lob_code ";
														$sql_res1  = execSQL($conDB, $sql_str1);
														while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
														  if($sql_rec1['lob_code'] == $mlob) {
															$sel .= "<option value=\"".$sql_rec1['lob_code']."\" selected>".$sql_rec1['lob_code']." / ".$sql_rec1['lob_name']."</option>";  
														  } else {
															$sel .= "<option value=\"".$sql_rec1['lob_code']."\" >".$sql_rec1['lob_code']." / ".$sql_rec1['lob_name']."</option>";  
													  
														  }
														}
														$sel .= "</SELECT>";
													  
														return $sel;
													  }

					                    		$txtlabel[$x]      = "LOB <span class='required-label label_prospect'>*</span>";
					                    		$bodycontent[$x]   = get_select_master_lob($condb, "mlob", "mlob", "required", $lob, $asset_type, $param_lob);
					                    		$x++;
	        					
					        					function get_select_master_product_offer($conDB, $id, $name, $required, $product_id,$lob) {
														$sel = "<SELECT id=\"$id\" name=\"$name\" class=\"select2 form-control\" style=\"width:100%;\" \"$required\" >";//disabled

														if ($lob !="") {
															$sql_whr="AND b.lob_code='$lob'";
														}
														$sql_str1 = " SELECT a.id, a.prod_offering_code, a.prod_offering_name FROM cc_prod_offering a
															LEFT JOIN cc_ts_lob b ON a.prod_offering_code=b.prod_offering_code WHERE a.status='1' $sql_whr
															GROUP BY a.prod_offering_code 
															 ";
														$sql_res1  = execSQL($conDB, $sql_str1);
														$sel .= "<option value=\"\" selected>-- Select --</option>";
														while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
														  if($sql_rec1['prod_offering_code'] == $product_id) {
															$sel .= "<option value=\"".$sql_rec1['prod_offering_code']."\" selected>".$sql_rec1['prod_offering_code']." / ".$sql_rec1['prod_offering_name']."</option>";  
														  } else {
															$sel .= "<option value=\"".$sql_rec1['prod_offering_code']."\" >".$sql_rec1['prod_offering_code']." / ".$sql_rec1['prod_offering_name']."</option>";  
													  
														  }
														}
														$sel .= "</SELECT>";
													  
														return $sel;
													  }

					                    		$txtlabel[$x]      = "Product Offering <span class='required-label label_prospect'>*</span>";
					                    		$bodycontent[$x]   = get_select_master_product_offer($condb, "select_product_offering_code", "select_product_offering_code", "required", $product_offering_code,$lob);
					                    		$x++;
					                    			
					                    		$txtlabel[$x]      = "";
					                    		$bodycontent[$x]   = "";
					                    		$x++;
					                    			
					                    		$txtlabel[$x]      = "";
					                    		$bodycontent[$x]   = "";
					                    		$x++;

					                    		$txtlabel[$x]      = "";
					                    		$bodycontent[$x]   = "";
					                    		$x++;
					                    			
					                    		$txtlabel[$x]      = "Dukcapil Result Guarantor";
					                    		$bodycontent[$x]   = input_text_readonly_temp("txt_activity_guarantor_ducapil","txt_activity_guarantor_ducapil",$txt_activity_guarantor_ducapil,"","","form-control border-primary","");
					                    		$x++;
					                    			
					                    		$txtlabel[$x]      = "Neglist Result Guarantor";
					                    		$bodycontent[$x]   = input_text_readonly_temp("txt_activity_guarantor_neglist","txt_activity_guarantor_neglist",$txt_activity_guarantor_neglist,"","","form-control border-primary","");
					                    		$x++;

					                    		$txtlabel[$x]      = "";
					                    		$bodycontent[$x]   = "<input type='button' name='btn_duckcapil' id='btn_duckcapil' class='btn btn-secondary btn-sm' value='Validation Check'>";
					                    		$x++;

					                    		
					                    		echo label_form_det($txtlabel,$bodycontent,$x);
											?>
										</div>
										<div class="col-md-4">
											<?php
											
												$x				   = 0;	

							                    $txtlabel[$x]      = "Monthly Installment";
							                    $bodycontent[$x]   = input_text_temp("monthly_instalment2","monthly_instalment2",number_format($monthly_instalment,0,'',','),"","","form-control border-primary","");
							                    $x++;

					                    		$txtlabel[$x]      = "Note";
					                    		$bodycontent[$x]   = input_textarea_temp("two_note","two_note",$notes,"","","form-control border-primary", 4);
					                    		$x++;
	        					
					        					function get_select_master_dealer($conDB, $id, $name, $required, $product_id,$lob, $kabupaten) {
														$sel = "<SELECT id=\"$id\" name=\"$name\" class=\"select2 form-control\" style=\"width:100%;\" \"$required\" >";//disabled

														// if ($lob !="") {
														// 	$sql_whr="AND b.lob_code='$lob'";
														// }
														if ($kabupaten !="") {
															$sql_whr.="AND ( LOWER(a.region_name) like LOWER('%$kabupaten%') OR (LOWER(a.region_name) like LOWER('%ALL%')) )";
														}else{
															$sql_whr.="AND (LOWER(a.region_name) like LOWER('%ALL%'))";
														}

														$sql_strlob = " SELECT a.lob_name FROM cc_ts_lob a WHERE a.lob_code='$lob'";
														$sql_reslob  = execSQL($conDB, $sql_strlob);
														if($sql_reclob = mysqli_fetch_array($sql_reslob)) {
															$lob2=$sql_reclob['lob_name'];
														}
														$lob2 = strpos($lob2, "Jasa");

														if($lob2>0 && $lob2 != "") {
														    $sel .= "<option value=\"528\" selected>SUPPLIER DUMMY</option>";											  
														}else{
															// $sql_str1 = "SELECT id, suppl_name FROM cc_master_supplier WHERE 1=1 $sql_whr"; //echo "string". $sql_str1;
																		// LEFT JOIN cc_master_supplier_branch b ON a.suppl_id=b.suppl_id 
																		// AND suppl_status=1 
															// $sql_str1 = "SELECT a.id, a.suppl_name FROM cc_master_supplier a 
															$sql_str1 = "SELECT a.suppl_branch_code as id, a.suppl_branch_name as suppl_name FROM cc_master_supplier_branch a 
																		WHERE 1=1 
																		$sql_whr
																		GROUP BY a.suppl_branch_id"; 
														if (get_param("mode") == "es") {
															echo "lob ".$sql_str1;
														}
															$sql_res1  = execSQL($conDB, $sql_str1);
															$sel .= "<option value=\"\" selected>-- Select --</option>";
															
															while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
																if($sql_rec1['suppl_name'] == $select_dealer) {
																	$sel .= "<option value=\"".$sql_rec1['id']."\" selected>".$sql_rec1['suppl_name']."</option>";  
																}else {
																	$sel .= "<option value=\"".$sql_rec1['id']."\" >".$sql_rec1['suppl_name']."</option>";														
																}
															}

															
														}
														
														$sel .= "</SELECT>";
													  
														return $sel;
													  }

					                    		$txtlabel[$x]      = "Dealer";
					                    		$bodycontent[$x]   = get_select_master_dealer($condb, "select_dealer", "select_dealer", "required", $select_dealer,$lob, $region);
					                    		$x++;
					                    		
					                    		echo label_form_det($txtlabel,$bodycontent,$x);
					                    		//echo '<img src="data:image/jpg;base64,' . $cust_photo . '" />';
					                    		if ($mode=="es") {
					                    			//echo "string $cust_photo;";
					                    			// echo '<img src="data:image/jpg;base64,' . $cust_photo . '" style="width:200px;height:auto;"/>';
					                    		}

											?>
										</div>
									</div>
						        </div>

								<hr style="margin: 2px" />
						        	<table width="100%">
						        		<tr>
						        			<td></td>
						        			<td align="right" width="100px">
						        				<button class="btn btn-success" id="btnSubmitForm" value="cancel">Submit</button></p>
						        			</td>
						        		</tr>
						        	</table>
								<!-- end disini -->
						    </div>
						</div>

						</div>
					</div>
				</div>

				<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<?php

					$txttitle	= "History Call";
	        		$icofrm	  = "fas fa-history";
	        		echo title_form_det($txttitle,$icofrm);
        		?>

					<div class="table-responsive">
						 <!-- class="table table-head-bg-info table-striped table-hover" -->
						<table id="datatablelist" class="display table table-striped table-hover" style="min-width:100%" >
							<thead>
								<tr>
									<th>Phone Number</th>
									<th>Result</th>
									<th>Sub Result</th>
									<th>Tenor</th>
									<th>Calculate Budget Plan Amount</th>
									<th>Budget Plan Amount Yang Diberikan</th>
									<th>Calculate Installment</th>
									<th>Note</th>
								</tr>
							</thead>
							<tbody>
								<tr>
		                          <td colspan="7" class="dataTables_empty">Loading data...</td>
		                        </tr>
							</tbody>
						</table>
					</div>
			</div>
		</div>
	</div>
</div>

										</div>
										
										
									</div>
								</div>

								<div class="wizard-action">
									<div class="pull-left">
										<!-- <input type="button" class="btn btn-previous btn-fill btn-default" name="previous" value="Previous"> -->
									</div>
									<div class="pull-right">
										<!-- <input type="button" class="btn btn-next btn-danger" name="next" value="Next"> -->
										<input type="button" class="btn btn-finish btn-danger" name="finish" value="Finish" style="display: none;">
									</div>
									<div class="clearfix"></div>
								</div>
							<!-- </form> -->
						</div>
					</div>

		<div class="row">
		<!-- start history -->
			<div class="col-md-12">
				
			</div>
		</div>
	</div> <!-- page1 -->

</div>

</form>
<?php
} else {
?>
<div id="page1">
	<div class="row">
		<div class="wizard-container wizard-round col-md-12">
			<div class="wizard-header text-center">
				<h3 class="wizard-title"><b>Blank</b> # Data </h3>
			</div>
				<div class="wizard-body">
					<div class="text-center">
						<img src="assets/img/empty-data.png" style="width:400px; height: 400px;">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php	
}
disconnectDB($condb);
?>

<!--   Core JS Files   -->
	<script src="assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="assets/js/core/popper.min.js"></script>
	<script src="assets/js/core/bootstrap.min.js"></script>
	<!-- jQuery UI -->
	<script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
	
	<script src="assets/number-thousand-separator/easy-number-separator.js"></script>

	<!-- Sweet Alert -->
	<script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>
	<!-- Bootstrap Toggle -->
	<script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
	<!-- jQuery Scrollbar -->
	<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
	<!-- Select2 -->
	<script src="assets/js/plugin/select2/select2.full.min.js"></script>
	<!-- jQuery Validation -->
	<script src="assets/js/plugin/jquery.validate/jquery.validate.min.js"></script>
	<!-- Bootstrap Tagsinput -->
	<script src="assets/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
	<!-- Atlantis JS -->
	<script src="assets/js/atlantis.min.js"></script>
	<script src="assets/js/setting.js"></script>

	<script src="assets/js/core/jquery.mask.min.js"></script>

	<script src="library/easy-number-separator.js"></script>
	
	<script type="text/javascript">
	$("#call_status").change(function() {
			  var call_status    = $("#call_status").val();
			  var dataString = 'call_statusid='+call_status+'&v=call_status2';
			  if (call_status==5) {
			  	$("#div_followup input").prop("required", true);
			  	$("#div_followup").show();
			  }else{
			  	$("#div_followup input").prop("required", false);
			  	$("#div_followup").hide();
			  }

			  if (call_status==1) {
			  	$(".label_prospect").show();
			  	$("#mlob").prop("required", true);
			  	$("#select_product_offering_code").prop("required", true);
			  	$("#survey_alamat").prop("required", true);
			  	$(".val-prospect").prop("required", true);

			  }else{
			  	$(".label_prospect").hide();
			  	$("#mlob").prop("required", false);
			  	$("#select_product_offering_code").prop("required", false);
			  	$("#survey_alamat").prop("required", false);
			  	$(".val-prospect").prop("required", false);
			  }

			  if (call_status==1||call_status==2) {
			  	$("#txt_activity_ducapil").prop("required", true);
			  	$("#txt_activity_neglist").prop("required", true);
			  	$("#required_activity_dukcapil").show();
			  	$("#required_activity_neglist").show();
			  }else{
			  	$("#txt_activity_ducapil").prop("required", false);
			  	$("#txt_activity_neglist").prop("required", false);
			  	$("#required_activity_dukcapil").hide();
			  	$("#required_activity_neglist").hide();
			  }
				$.ajax({ 
			      type: 'POST', 
			      url: 'view/telesales/get_data_value.php', 
			      data: dataString, 
			      dataType:'json',
			      success: function (data) { 
			        $('#call_status_sub1').html(data.arr_category);
					document.getElementById('txtcalllater').parentNode.parentNode.style.display = "none";
			      }
			      
			  });
		 });

	$("#mlob").change(function() {
			  var mlob    = $("#mlob").val();
			  var dataString = 'mlob='+mlob+'&v=mlob';
				// $.ajax({ 
			 //      type: 'POST', 
			 //      url: 'view/telesales/get_data_value.php', 
			 //      data: dataString, 
			 //      dataType:'json',
			 //      success: function (data) { 
				// 	$('#select_product_offering_code').html(data.arr_category);
				// 	var text      = data.lob_name;
				// 	var param_lob = text.indexOf("Jasa");
				// 	if (param_lob>0) {
				// 		$('#select_dealer').html(data.lob_name2);
				// 	}else{
				// 		$('#select_dealer').html(data.lob_name);
				// 	}
			 //      }
			      
			 //  });
			 
				$.ajax({ 
			      type: 'POST', 
			      url: 'view/telesales/get_data_value.php', 
			      data: dataString, 
			      dataType:'json',
			      success: function (data) { 
					$('#select_product_offering_code').html(data.arr_category);
			      }
			      
			  });
		 });

	$("#prov_survey").change(function(){
		var prov = $("#prov_survey").val();
		var dataString = 'v=get_kabupaten&prov='+prov;
		// console.log(prov);

		$.ajax({
			type 	: 'POST',
			url 	: 'view/telesales/get_data_value.php',
			data 	: dataString,
			dataType: 'json',
			success: function(data){
				// console.log(data)
				$('#kab_survey').html(data.arr_category);
			}
		})
	})

	$("#kab_survey").change(function(){
		var city   	= $("#kab_survey option:selected").text();
		var dataString 	= 'city='+city+'&v=get_kecamatan';
		console.log("changes")
		$.ajax({ 
			type: 'POST', 
			url: 'view/telesales/get_data_value.php', 
			data: dataString, 
			dataType:'json',
			success: function (data) { 
				$('#kec_survey').html(data.arr_category);
			}
		});

		var dataString 	= 'city='+city+'&v=get_dealer';
		// $.ajax({ 
		// 	type: 'POST', 
		// 	url: 'view/telesales/get_data_value.php', 
		// 	data: dataString, 
		// 	dataType:'json',
		// 	success: function (data) { 
		// 		console.log(data);
		// 		var param_dealer   	= $("#select_dealer option:selected").text();
		// 		if (param_dealer !='SUPPLIER DUMMY') {
		// 			$('#select_dealer').html(data.arr_category);
		// 		}
				
		// 	}
		// });

	});

	$("#kec_survey").change(function(){
		var kecamatan   = $("#kec_survey option:selected").text();
		var city   	= $("#kab_survey option:selected").text();
		var dataString 	= 'city='+city+'&kecamatan='+kecamatan+'&v=get_kelurahan';
		$.ajax({ 
			type: 'POST', 
			url: 'view/telesales/get_data_value.php', 
			data: dataString, 
			dataType:'json',
			success: function (data) { 
				$('#kel_survey').html(data.arr_category);
			}
		});
	});

	$("#kel_survey").change(function(){
		var kelurahan   = $("#kel_survey option:selected").text();
		var kecamatan   = $("#kec_survey option:selected").text();
		var city   	= $("#kab_survey option:selected").text();
		var dataString 	=  'city='+city+'&kecamatan='+kecamatan+'&kelurahan='+kelurahan+'&v=get_zipcode_survey';
		$.ajax({ 
			type: 'POST', 
			url: 'view/telesales/get_data_value.php', 
			data: dataString, 
			dataType:'json',
			success: function (data) { 
				$('#zipcode_survey').html(data.arr_category);
			}
		});
	});

	$("#zipcode_survey").change(function(){
		var zipcode = $("#zipcode_survey option:selected").text();
		var kelurahan   = $("#kel_survey option:selected").text();
		var kecamatan   = $("#kec_survey option:selected").text();
		var city   	= $("#kab_survey option:selected").text();
		var dataString 	= 'city='+city+'&kecamatan='+kecamatan+'&kelurahan='+kelurahan+'&zipcode='+zipcode+'&v=get_subzipcode_survey';
		$.ajax({ 
			type: 'POST', 
			url: 'view/telesales/get_data_value.php', 
			data: dataString, 
			dataType:'json',
			success: function (data) { 
				console.log(data);
				$('#subzipcode_survey').val(data.arr_category);
			}
		});
	});

	


	$("#btnSubmitForm").click(function(){ 
    	var param_dukcapil2= document.getElementById("txt_activity_ducapil").value;
	 	var param_neglist= document.getElementById("txt_activity_neglist").value;

	 	// NEW CAE PHASE 2 

			// var cust_no        = document.getElementById("cust_id_no").value;
			// // var app_no         = '';
			// var ip_user        = '';
			// var source         = document.getElementById("source_data").value;
			// var txt_job_modelname       = document.getElementById("txt_job_modelname").value;
			// var txt_profession_code       = document.getElementById("profession_name").value;
			// var txt_mother_cust       = document.getElementById("nama_ibukandung").value

	 	var param_custModelCode= document.getElementById("txt_job_modelname").value;
	 	var param_custModelCodeSpouse= document.getElementById("txt_spouse_customer_model").value;
	 	var param_custModelCodeGuarantor= document.getElementById("txt_guarantor_customer_model").value;
	 	var param_professionCodeGuarantor= document.getElementById("txt_guarantor_profession").value;
	 	var param_custEdd= document.getElementById("custEdd").value;
	 	var param_spouseEdd= document.getElementById("spouseEdd").value;
	 	var param_guarantorEdd= document.getElementById("guarantorEdd").value;
	 	// var param_professionCode= document.getElementById("txt_profession_code").value;
	 	var param_professionCode= document.getElementById("profession_name").value;
	 	var param_professionCodeSpouse= document.getElementById("txt_spouse_profession").value;
	 	var param_flagDeviationNegCust= document.getElementById("flagDeviationNegCust").value;
	 	var param_flagDeviationNegSpouse= document.getElementById("flagDeviationNegSpouse").value;
	 	var param_flagDeviationNegGuarantor= document.getElementById("flagDeviationNegGuarantor").value;
	 	
	 	console.log(param_neglist)
	 	if(param_neglist == "Match" || param_neglist=="MATCH" || param_neglist=="MATCH - FATAL"){
			$("#txt_activity_ducapil").prop("required", false);
		}
    	 var fvalid = form.valid();
    	 var param_status	= document.getElementById("call_status").value;
    	 if(fvalid==true){
 
    	swal({
						title: 'Are you sure want to Submit?',
						text: "",
						type: 'warning',
						buttons:{
							confirm: {
								text : 'Yes',
								className : 'btn btn-success'
							},
							cancel: {
								visible: true,
								className: 'btn btn-danger'
							}
						}
					}).then((Save) => {
						if (Save) {
							 var data = new FormData();
							 var form_data = $('#frmDataDet').serializeArray();
							 $.each(form_data, function (key, input) {
							    data.append(input.name, input.value);
							 });

							 data.append('key', 'value');
							
							 
							 $.ajax({
						        url: "<?php echo $save_form; ?>",
						        type: "post",
						        data: data,
							    processData: false,
							    contentType: false,
						        success: function(d) {
						        	var warn = d;
					            	if(warn=="Success") {
					            		var vtype = "success";
					            	} else {
										var vtype = "error";	
					            	}
						            // swal({ title: "Save Data!", type: vtype,  text: warn,   timer: 1000,   showConfirmButton: false });
						           if(warn=="Success!") {
					            		var nik            = document.getElementById("nik_ktp").value;
										var nama_lengkap   = document.getElementById("contact_name").value;
										var tempat_lahir   = document.getElementById("tempat_lahir").value;
										var tgl_lahir      = document.getElementById("tanggal_lahir").value; 
						            	// setTimeout(function(){history.back();}, 1500);
						            	// document.location.reload();
						            	var urlduplicate	   = "service/wom/check_duplicate.php?nik="+nik+"&nama_lengkap="+nama_lengkap+"&tempat_lahir="+tempat_lahir+"&tgl_lahir="+tgl_lahir;
										// $.ajax({
										// 		url: urlduplicate,
										// 		type: "POST",
										// 		dataType: 'json',
										// 		success: function(data){ 
													// var datares  = data.duplicateStatus;
													// var datares2 = data.responseMessage;
													// var datares3 = data.data;
													// var datares4 = datares3.duplicateStatus;
													// if (datares4=='MATCH') {
														// var vtype = "error";
														// swal({ title: "Save Data!", type: vtype,  text: "Warning Notification: Order Already Exist",   timer: 1000,   showConfirmButton: false });

													// }else if (datares4=='NOT MATCH'){
														var taskid         = "<?=$task_id;?>";
														document.getElementById('tempatLoading').style.display = "";
										            	if (param_status==2) {
										            		var urlupdatepolo  = "service/wom/api_fin_update_data_konfirmasi_new.php?taskId="+taskid+"&custModelCode="+param_custModelCode+"&custModelCodeSpouse="+param_custModelCodeSpouse+"&custModelCodeGuarantor="+param_custModelCodeGuarantor+"&professionCodeGuarantor="+param_professionCodeGuarantor+"&custEdd="+param_custEdd+"&spouseEdd="+param_spouseEdd+"&guarantorEdd="+param_guarantorEdd+"&professionCode="+param_professionCode+"&professionCodeSpouse="+param_professionCodeSpouse+"&flagDeviationNegCust="+param_flagDeviationNegCust+"&flagDeviationNegSpouse="+param_flagDeviationNegSpouse+"&flagDeviationNegGuarantor="+param_flagDeviationNegGuarantor;
															$.ajax({
																	url: urlupdatepolo,
																	type: "POST",
																	dataType: 'json',
																	success: function(data){ 
																		// document.getElementById('tempatLoading').style.display = "none";
																		var datares = data.responseMessage; 
																		var datares2 = data.errorMessage;
																		if (datares=='SUCCESS') {
																			//startnew
																			// var urlupdatepolo  = "service/wom/api_fin_update_konfrim_penawaran.php?taskId="+taskid;
																			// $.ajax({
																			// 		url: urlupdatepolo,
																			// 		type: "POST",
																			// 		dataType: 'json',
																			// 		success: function(data){ 
																			// 			var datares = data.responseMessage; 
																			// 			var datares2 = data.errorMessage;
																			// 			// var datares2 = 'TaskId is not Exist';
																			// 			if (datares=='Success') {
																			// 				// alert(datares);
																			// 				document.getElementById('tempatLoading').style.display = "none";
																			// 				swal({ title: "Save Data!", type: vtype,  text: datares,   timer: 1000,   showConfirmButton: false });
																			// 				// setTimeout(function(){ document.location.reload(); }, 1500);
																							
																			// 				setTimeout(function(){history.back();}, 1500);
																			// 			}else{
																			// 				// alert(datares2);
																			// 				document.getElementById('tempatLoading').style.display = "none";
																			// 				swal({ title: "Save Data!", type: vtype,  text: datares2,   timer: 1500,   showConfirmButton: false });
																			// 				setTimeout(function(){history.back();}, 1500);
																			// 			}		
																			// 			// document.location.reload();	
																			// 			// document.getElementById('tempatLoading').style.display = "none";
																			// 			// swal({ title: "Save Data!", type: vtype,  text: datares2,   timer: 1500,   showConfirmButton: false });
																			// 			// setTimeout(function(){history.back();}, 1500);															
																			// 		}
																			// });
																			// alert(datares);
																			// swal({ title: "Save Data!", type: vtype,  text: datares,   timer: 1000,   showConfirmButton: false });
																			// setTimeout(function(){ document.location.reload(); }, 1500);
																			// setTimeout(function(){history.back();}, 1500);
																			//endnew
																			document.getElementById('tempatLoading').style.display = "none";
																			var datares = data.responseMessage; 
																			var datares2 = data.errorMessage;
																			// alert(datares);
																			// alert(datares2);
																			if (datares=='SUCCESS') {
																				// alert(datares);
																				swal({ title: "Save Data!", type: vtype,  text: datares,   timer: 1000,   showConfirmButton: false });
																				// setTimeout(function(){ document.location.reload(); }, 1500);
																				document.getElementById('tempatLoading').style.display = "none";
																				setTimeout(function(){history.back();}, 1500);
																			}else{
																				// var datares3 = datares2.errDesc;
																				// alert(datares2);
																				document.getElementById('tempatLoading').style.display = "none";
																				swal({ title: "Save Data!", type: vtype,  text: datares2,   timer: 1500,   showConfirmButton: false });
																				setTimeout(function(){history.back();}, 1500);
																			}	
																		}else{
																			// var datares3 = datares2.errDesc;
																			// alert(datares2);
																			document.getElementById('tempatLoading').style.display = "none";
																			swal({ title: "Save Data!", type: vtype,  text: datares2,   timer: 1500,   showConfirmButton: false });
																			
																		}		
																		// document.location.reload();																
																	}
															});
										            		
										            	}//else if(param_status==1){
										            	else{
										            		var urlupdatepolo  = "service/wom/api_fin_update_data_konfirmasi_new.php?taskId="+taskid+"&custModelCode="+param_custModelCode+"&custModelCodeSpouse="+param_custModelCodeSpouse+"&custModelCodeGuarantor="+param_custModelCodeGuarantor+"&professionCodeGuarantor="+param_professionCodeGuarantor+"&custEdd="+param_custEdd+"&spouseEdd="+param_spouseEdd+"&guarantorEdd="+param_guarantorEdd+"&professionCode="+param_professionCode+"&professionCodeSpouse="+param_professionCodeSpouse+"&flagDeviationNegCust="+param_flagDeviationNegCust+"&flagDeviationNegSpouse="+param_flagDeviationNegSpouse+"&flagDeviationNegGuarantor="+param_flagDeviationNegGuarantor;
															$.ajax({
																	url: urlupdatepolo,
																	type: "POST",
																	dataType: 'json',
																	success: function(data){ 
																		document.getElementById('tempatLoading').style.display = "none";
																		var datares = data.responseMessage; 
																		var datares2 = data.errorMessage;
																		// alert(datares);
																		// alert(datares2);
																		if (datares=='SUCCESS') {
																			// alert(datares);
																			swal({ title: "Save Data!", type: vtype,  text: datares,   timer: 1000,   showConfirmButton: false });
																			// setTimeout(function(){ document.location.reload(); }, 1500);
																			document.getElementById('tempatLoading').style.display = "none";
																			setTimeout(function(){history.back();}, 1500);
																		}else{
																			// var datares3 = datares2.errDesc;
																			// alert(datares2);
																			document.getElementById('tempatLoading').style.display = "none";
																			swal({ title: "Save Data!", type: vtype,  text: datares2,   timer: 1500,   showConfirmButton: false });
																			setTimeout(function(){history.back();}, 1500);
																		}		
																		// document.location.reload();																
																	}
															});
										            	}
										            	// else{
										            	// 	setTimeout(function(){history.back();}, 1500);
										            	// }
													// }												
												// }
										// });	
						            	
							            
										
						           } 
						        }
							  });
						} else {
							swal.close();
						}
					});
			
		}else{
			swal({ title: "Info!", type: "error",  text: param_error,   timer: 1000,   showConfirmButton: false });
		}
        return false;
	}) 
	</script>

	
	<!-- <script src="assets/js/core/jquery.3.2.1.min.js"></script> -->
	<link rel="stylesheet" type="text/css" href="assets/css/pickers/daterange/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="assets/css/pickers/datetime/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="assets/css/pickers/pickadate/pickadate.css">
    
    <script src="assets/js/plugin/pickers/dateTime/moment-with-locales.min.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/dateTime/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/pickadate/picker.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/pickadate/picker.date.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/pickadate/picker.time.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/pickadate/legacy.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/daterange/daterangepicker.js" type="text/javascript"></script>
    

	 <script src="library/datetimepick/js/moment.min.js"></script>
    <link rel="stylesheet" href="library/datetimepick/css/bootstrap-datetimepicker.min.css"> 
    <script src="library/datetimepick/js/bootstrap-datetimepicker.min.js"></script>
    <!-- <script src="assets/js/plugin/ESScreenCap/screencap.js"></script> -->
	<!-- Datatables -->
	<script src="assets/js/plugin/datatables/datatables.min.js"></script>


    <script lang="javascript">

    	$(document).ready( function () {

			var nik            = document.getElementById("nik_ktp").value;
			var nama_lengkap   = document.getElementById("contact_name").value;
			var tempat_lahir   = document.getElementById("tempat_lahir").value;
			var tgl_lahir      = document.getElementById("tanggal_lahir").value;
			var urlduplicate	   = "service/wom/check_duplicate.php?nik="+nik+"&nama_lengkap="+nama_lengkap+"&tempat_lahir="+tempat_lahir+"&tgl_lahir="+tgl_lahir; 
			if (nik !='') {
				document.getElementById('tempatLoading').style.display = "";
		    	 $.ajax({
					url: urlduplicate,
					type: "POST",
					dataType: 'json',
					success: function(data){ 
						var datares  = data.duplicateStatus;
						var datares2 = data.responseMessage;
						var datares_total  = data.responseTotal;
						var datares_cabang = data.responseCabang;
						var datares3 = data.data;
						if (datares3 !=null) {
							var dataresmsg = datares3.duplicateMessage;
							var datares4   = datares3.duplicateStatus;
							var datares5   = datares3.numOfDuplicate;
							var datares6   = datares3.isActive;
							var dataresnum = datares3.numOfDuplicate;
							if (datares4=='MATCH' && datares5 > 1 && datares6 == '1') {
								
								var cabang = datares_cabang.replaceAll('</br>', '\n');
								var titles = "This Data is Duplicate, Want to Proccess? "+dataresnum;
								swal({
								  title: titles, 
								  text: cabang,
								  icon: "warning",
								  buttons: true,
								  dangerMode: true,
								  allowClickOutside: false,
								  closeOnClickOutside: false,
								  className: "swal-duplicate",
								  buttons: ["Yes", "No"],
								})
								.then((willDelete) => {
								  if (willDelete) {
								  	document.getElementById('tempatLoading').style.display = "";
								  	var iddet      = document.getElementById("iddet").value;	
									var taskid         = "<?=$task_id;?>";
									var urlupdatepolo  = "service/wom/api_fin_update_data_duplicate.php?taskId="+taskid+"&param=2";
									$.ajax({
										url: urlupdatepolo,
										type: "POST",
										dataType: 'json',
										success: function(data){ 
											$.ajax({
												type: 'POST',
												url: "view/telesales/tele_next_data2.php?iddet="+iddet,
												success: function(hv) {

												    var url = "http://10.1.49.224/wom/index.php?v=dGVsZXNhbGVzfHRlbGVfY29uZmlybWF0aW9uX2RhdGFfbGlzdHxQcm9zZXMgRGF0YSBUYXNrIEtvbmZpcm1hc2l8MjU2fA%3D%3D";  
											    	var url2=url; 
											    	// setTimeout(function(){ window.location.href = url2; }, 1500);
													var urlupdatepolo  = "service/wom/api_fin_update_konfrim_penawaran.php?taskId="+taskid;
													// $.ajax({
													// 		url: urlupdatepolo,
													// 		type: "POST",
													// 		dataType: 'json',
													// 		success: function(data){ 
													// 			var datares = data.responseMessage; 
													// 			var datares2 = data.errorMessage;
													// 			// var datares2 = 'TaskId is not Exist';
													// 			if (datares=='Success') {					
													// 				setTimeout(function(){ window.location.href = url2; }, 1500);
													// 			}else{
													// 				// alert(datares2);
													// 				document.getElementById('tempatLoading').style.display = "none";
													// 				swal({ title: "Save Data!", type: vtype,  text: datares2,   timer: 1500,   showConfirmButton: false });
													// 				setTimeout(function(){ window.location.href = url2; }, 1500);
													// 			}																
													// 		}
													// });
													var datares = hv; 
													// 			var datares2 = data.errorMessage;
													// 			// var datares2 = 'TaskId is not Exist';
													if (datares=='Success') {					
														setTimeout(function(){ window.location.href = url2; }, 1500);
													}else{
														// alert(datares2);
														document.getElementById('tempatLoading').style.display = "none";
														swal({ title: "Save Data!", type: vtype,  text: datares2,   timer: 1500,   showConfirmButton: false });
														setTimeout(function(){ window.location.href = url2; }, 1500);
													}
												}
											});																	
										}
									});							
									
								  } else {
								    // swal("Your imaginary file is safe!");
								  }
								});

							}
						}
						document.getElementById('tempatLoading').style.display = "none";
					}
				});	
			}
			
    
		    var oTable = $('#datatablelist').dataTable({
		    // "lengthMenu": [[10], [10, 25, 50, "All"]],
		     dom: 'Bfrtip<"top"><"bottom"l><"clear">',
				    "columnDefs": [ {
				    "targets": 0,
				    "orderable": false
				    } ],
				 "bProcessing": true,
				 "bSearchable": false,
				    "bServerSide": true,
				    "bLengthChange": false,
				    "sAjaxSource": "view/telesales/tele_confirmation_data_history.php",
				    "fnServerParams": function (aoData) {
				                aoData.push(		
									{ "name": "cmbcust", "value": "" },
									{ "name": "cmbtask", "value": "<?=$task_id;?>" } //$("#cmbcamcat").val()
				                );
				            }
		            
		});
	});

var form = $( "#frmDataDet" );
	form.validate();

    $("#btnSaveForm").click(function(){ 
    	 var fvalid = form.valid();
    	 if(fvalid==true){
 
    	swal({
						title: 'Are you sure want to save?',
						text: "",
						type: 'warning',
						buttons:{
							confirm: {
								text : 'Yes',
								className : 'btn btn-success'
							},
							cancel: {
								visible: true,
								className: 'btn btn-danger'
							}
						}
					}).then((Save) => {
						if (Save) {
							 var data = new FormData();
							 var form_data = $('#frmDataDet').serializeArray();
							 $.each(form_data, function (key, input) {
							    data.append(input.name, input.value);
							 });

							 data.append('key', 'value');	
							
							 $.ajax({
						        url: "<?php echo $save_form; ?>",
						        type: "post",
						        data: data,
							    processData: false,
							    contentType: false,
						        success: function(d) {
						        	var warn = d;
					            	if(warn=="Success") {
					            		var vtype = "success";
					            	} else {
										var vtype = "error";	
					            	}
						            swal({ title: "Save Data!", type: vtype,  text: warn,   timer: 1000,   showConfirmButton: false });
								  // alert(warn);
									// location.reload();
									if(warn=="Success!") {
						            	setTimeout(function(){history.back();}, 1500);
						           } 
						        }
							  });
						} else {
							swal.close();
						}
					});
			
		}else{
			swal({ title: "Info!", type: "error",  text: "Please fill in all mandatory",   timer: 1000,   showConfirmButton: false });
		}
        return false;
	}) 
   

	
	 $("#btnCancelForm").click(function(){
    	swal({
						title: 'Are you sure to return to the previous page?',
						text: "",
						type: 'warning',
						buttons:{
							confirm: {
								text : 'Yes',
								className : 'btn btn-success'
							},
							cancel: {
								visible: true,
								className: 'btn btn-danger'
							}
						}
					}).then((Save) => {
						if (Save) {
							/*
							var alink= "<?php echo $ffolder;?>|<?php echo $fmenu_link_back;?>|<?php echo $fdescription;?>|<?php echo $fmenu_id;?>|<?php echo $ficon;?>|<?php echo $fiddet;?>|<?php echo $fblist;?>"
							var link = "index.php?v="+encodeURI(btoa(alink));
							window.location.href = link;
							*/
							window.history.back();
						} else {
							swal.close();
						}
					});
        return false;
	})

	
    </script>


<script>
	function call_execute(AssignId){
		var ipserver	   = '<?php echo $SesIP?>';
		var SesExt   	   = '<?php echo get_session("v_extension")?>';
		var SesLoginId    = '<?php echo get_session("v_agentlogin")?>';
		var SesClientId   = '<?php echo $ws_cliendID?>';
		//var AssignId      = 
		var PhoneNoCall   = document.getElementById("phoneNumber").value;
		var PhoneNoCall   = PhoneNoCall.trim();
		document.getElementById("dialedno").value = PhoneNoCall;
		/*
		var urlser = ipserver+"/makecall?loginid="+SesLoginId+"&phoneno="+PhoneNoCall+"&assignid="+AssignId
	   	$.ajax({
			type: "POST",
			url: urlser
		});
		*/
		var userstatusid = document.getElementById("userstatusid").value;
		var urlser = ipserver+"/makecall?loginid="+SesLoginId+"&phoneno="+PhoneNoCall+"&assignid="+AssignId
		var urlout = ipserver+"/outbound?loginid="+SesLoginId
		if(userstatusid==10){
			//jika sudah outbound 
			$.ajax({
					 type: "POST",
					 url: urlser
				  });

		}else{
			//jika belum outbound 
			$.ajax({
				url: urlout,
				type: "POST",
				dataType: 'json',
				success: function(data){
					var datares = data.RespondStatus;
					if(datares=="Success"){
						$.ajax({
							type: "POST",
							url: urlser
						});
					}
				}
			});

		}
	
	}
	$("#callphone1").click(function(){
		var ref = document.getElementById("iddet").value;
		var v_agentid = '<?php echo get_session("v_agentid") ?>';
		var form_id = document.getElementById("form_id").value;
		// var taskid         = "<?=$task_id;?>";
		var v_polo_order_in_id = '<?php echo $task_id; ?>';
		var urlprospect		= "service/wom/get_prospect_data.php?prospect_id="+v_polo_order_in_id;
		$.ajax({
				url: urlprospect,
				type: "POST",
				dataType: 'json',
				success: function(data){ 
					var datares = data.responseMessage; 
					if(datares=="Success"){
						var datastatus = data.prospectStat;
						
						if (datastatus!='Prospek') {
							if (datastatus =="" ) {
								// alert(datares);
							}else{
								// alert(datastatus);
							}
							$.ajax({
								type:'GET',
								url:'service/system/outbound_call_generator.php',
								data:'ref=' + ref + '&agentid='+v_agentid + '&form_id='+form_id,
								success:function(html){
									if (html == 'false') {
										alert('Failed');
									}else{
										document.getElementById('references_id').value = html;
										call_execute(html);
									}
									
								}
							});	
						}else{
							var iddet2 = document.getElementById("iddet").value;
							alert("Data Sudah Prospect Oleh Agent Lain");
							$.ajax({
								url: "<?php echo $save_form; ?>?v=prospect&iddet="+iddet2,
								type: "POST",
								success: function(d) {
									// alert(d);
									if(d=="Success!"){
							            	// document.location.reload();
							            	setTimeout(function(){ document.location.reload(); }, 1500);
							        } 
							    }
							});
						}
						
					}else{
						var dataerr = data.errorMessage;
						alert(dataerr);
						var data = new FormData();
						var form_data = $('#frmDataDet').serializeArray();
						$.each(form_data, function (key, input) {
						    data.append(input.name, input.value);
						});

						data.append('key', 'value');
						$.ajax({
						// 	url: "<?php echo $save_form; ?>?v=prospect&iddet="+iddet,
						// 	type: "POST",
						//     data: data,
						// 	processData: false,
						// 	contentType: false,
						// 	success: function(d) {
						// 		// alert(d);
						// 		if(d=="Success"){
						//             	document.location.reload();
						//         } 
						//     }
						// });
							type:'GET',
							url:'service/system/outbound_call_generator.php',
							data:'ref=' + ref + '&agentid='+v_agentid,
							success:function(html){
								if (html == 'false') {
									alert('Failed');
								}else{
									document.getElementById('references_id').value = html;
									call_execute(html);
								}
								
							}
						});	
					}
				}
			});	    	 
    });

	    $("#callphone2").click(function(){
	    	 var ipserver	   = '<?php echo $ws_ip?>';
			 var SesExt   	   = '<?php echo get_session("v_extension")?>';
			 var SesLoginId    = '<?php echo get_session("v_agentlogin")?>';
			 var SesClientId   = '<?php echo $ws_cliendID?>';
			 var AssignId      = document.getElementById("iddet").value;
			 var PhoneNoCall   = document.getElementById("ecPhone").value;
			 document.getElementById("dialedno").value = PhoneNoCall;
		 	 var urlser = ipserver+"/makecall?loginid="+SesLoginId+"&phoneno="+PhoneNoCall+"&assignid="+AssignId
	   		$.ajax({
				type: "POST",
				url: urlser
			})
    });


$("#callphone3").click(function(){
	    	 var ipserver	   = '<?php echo $ws_ip?>';
			 var SesExt   	   = '<?php echo get_session("v_extension")?>';
			 var SesLoginId    = '<?php echo get_session("v_agentlogin")?>';
			 var SesClientId   = '<?php echo $ws_cliendID?>';
			 var AssignId      = document.getElementById("iddet").value;
			 var PhoneNoCall   = document.getElementById("addPhone").value;
			 document.getElementById("dialedno").value = PhoneNoCall;
		 	 var urlser = ipserver+"/makecall?loginid="+SesLoginId+"&phoneno="+PhoneNoCall+"&assignid="+AssignId
	   		$.ajax({
				type: "POST",
				url: urlser
			})
    });


	  function playvoicerec(id){
		 var url		= "view/ticket/ticket_log_play.php?id="+id;
	 	 var width  = 400;
		 var height = 600;
		 var left   = (screen.width  - width)/2;
		 var top    = (screen.height - height)/2;
		 var params = 'width='+width+', height='+height;
    		 params += ', top='+top+', left='+left;
    		 params += ', directories=no';
    		 params += ', location=no';
    		 params += ', menubar=no';
    		 params += ', resizable=no';
    		 params += ', scrollbars=yes';
    		 params += ', status=no';
    		 params += ', toolbar=no';
		 newwin=window.open(url,'windowname5', params);
		 if (window.focus) {newwin.focus()}
		 return false;
	  }

	  function cekstatusTelp(){
						
						
						 var ipserver	   = '<?php echo $ws_ip?>';
						 var SesExt   	   = '<?php echo get_session("v_extension")?>';
						 var SesLoginId    = '<?php echo get_session("v_agentlogin")?>';
						 var SesClientId   = '<?php echo $ws_cliendID?>';
						
						var url = ipserver+"/status?loginid="+SesLoginId+"&extno="+SesExt;
					 	
					 	$.ajax({
						  url : url,
						  type: 'post',
						  dataType: 'json',
						  success: function(data) {	  
						  	//alert(data + " = " + data.LastCallDetail['SessionKey'] + " ditulis");

						  	//if(data.ExtStatus == '1') { //Masukin call session kalo status dial == 1
						    	document.getElementById('tmp_callSession').value 	= data.LastCallDetail['SessionKey'];
						    	document.getElementById('sessionkey').value 	= data.LastCallDetail['SessionKey'];
						    	document.getElementById('phone_nor').value 		 	= data.LastCallDetail['ConnParty'];
						    	
						    //}else{
						    	//document.getElementById('tmp_callSession').value = "";
						    	//document.getElementById('phone_nor').value = "";
						    //}
						    

						  }
						});
						var t = setTimeout(cekstatusTelp, 3000);
						
					}
					cekstatusTelp();

		$("#btnEditForm").click(function() {
			  // $('#div_edit').load('view/ticket/get_contact_individual.php?acusid='+acusid+'&bcusid='+bcusid);
			  // $("#two_cust_no").prop("readonly", false);
			  // $("#two_cust_rating").prop("readonly", false);
			  $("#two_contact_name2").prop("readonly", false);
			  $("#two_nik_ktp").prop("readonly", false);
			  $("#two_cust_religion").prop("readonly", false);
			  $("#two_tempat_lahir").prop("readonly", false);
			  $("#two_tanggal_lahir").prop("readonly", false);
			  $("#two_nama_pasangan").prop("readonly", false);
			  $("#two_tanggal_lahir_pasangan").prop("readonly", false);
			  $("#two_legal_alamat").prop("readonly", false);
			  $("#two_nama_pasangan_rt").prop("readonly", false);
			  $("#two_legal_provinsi").prop("readonly", false);
			  $("#two_legal_kabupaten").prop("readonly", false);
			  $("#two_legal_kecamatan").prop("readonly", false);
			  $("#two_legal_kelurahan").prop("readonly", false);
			  $("#two_legal_kodepos").prop("readonly", false);
			  $("#two_profession_name").prop("readonly", false);
			  $("#two_profession_cat_name").prop("readonly", false);
			  $("#two_job_position").prop("readonly", false);
			  $("#two_industry_type_name").prop("readonly", false);
			  $("#two_surv_addr").prop("readonly", false);
			  $("#two_surv_rt").prop("readonly", false);
			  $("#two_surv_rw").prop("readonly", false);
			  $("#two_surv_province").prop("readonly", false);
			  $("#two_surv_kab").prop("readonly", false);
			  $("#two_surv_kec").prop("readonly", false);
			  $("#two_surv_kel").prop("readonly", false);
			  $("#two_surv_zip").prop("readonly", false);
			  $("#two_surv_subzip").prop("readonly", false);
			  $("#two_surv_mphon1").prop("readonly", false);
			  $("#two_surv_mphon2").prop("readonly", false);
			  $("#two_surv_phon1").prop("readonly", false);
			  $("#two_surv_phon2").prop("readonly", false);
			  $("#two_surv_jphon1").prop("readonly", false);
			  $("#two_surv_jphon2").prop("readonly", false);
			  $("#two_surv_provname").prop("readonly", false);
			  $("#two_surv_cusmodname").prop("readonly", false);
			  document.getElementById("btnSimpanForm").disabled = false; 
			  document.getElementById("btnCancel").disabled = false;
			  document.getElementById("btnEditForm").disabled = true;


			  return false;
		});

		$("#btnCancel").click(function() { 
				$('#frmDataDet')[0].reset();

			  // $('#div_edit').load('view/ticket/get_contact_individual.php?acusid='+acusid+'&bcusid='+bcusid);
			  // $("#two_cust_no").prop("readonly", false);
			  // $("#two_cust_rating").prop("readonly", false);
			  $("#two_contact_name2").prop("readonly", true);
			  $("#two_nik_ktp").prop("readonly", true);
			  $("#two_cust_religion").prop("readonly", true);
			  $("#two_tempat_lahir").prop("readonly", true);
			  $("#two_tanggal_lahir").prop("readonly", true);
			  $("#two_nama_pasangan").prop("readonly", true);
			  $("#two_tanggal_lahir_pasangan").prop("readonly", true);
			  $("#two_legal_alamat").prop("readonly", true);
			  $("#two_nama_pasangan_rt").prop("readonly", true);
			  $("#two_legal_provinsi").prop("readonly", true);
			  $("#two_legal_kabupaten").prop("readonly", true);
			  $("#two_legal_kecamatan").prop("readonly", true);
			  $("#two_legal_kelurahan").prop("readonly", true);
			  $("#two_legal_kodepos").prop("readonly", true);
			  $("#two_profession_name").prop("readonly", true);
			  $("#two_profession_cat_name").prop("readonly", true);
			  $("#two_job_position").prop("readonly", true);
			  $("#two_industry_type_name").prop("readonly", true);
			  $("#two_surv_addr").prop("readonly", true);
			  $("#two_surv_rt").prop("readonly", true);
			  $("#two_surv_rw").prop("readonly", true);
			  $("#two_surv_province").prop("readonly", true);
			  $("#two_surv_kab").prop("readonly", true);
			  $("#two_surv_kec").prop("readonly", true);
			  $("#two_surv_kel").prop("readonly", true);
			  $("#two_surv_zip").prop("readonly", true);
			  $("#two_surv_subzip").prop("readonly", true);
			  $("#two_surv_mphon1").prop("readonly", true);
			  $("#two_surv_mphon2").prop("readonly", true);
			  $("#two_surv_phon1").prop("readonly", true);
			  $("#two_surv_phon2").prop("readonly", true);
			  $("#two_surv_jphon1").prop("readonly", true);
			  $("#two_surv_jphon2").prop("readonly", true);
			  $("#two_surv_provname").prop("readonly", true);
			  $("#two_surv_cusmodname").prop("readonly", true);
			  document.getElementById("btnSimpanForm").disabled = true; 
			  document.getElementById("btnCancel").disabled = true;
			  document.getElementById("btnEditForm").disabled = false;

			  // var iddet2 = document.getElementById("iddet").value;
			  // var dataString = 'v=cek_consumer_detail&iddet='+iddet2;
			  // $('#two_nik_ktp')[0].reset();
			  
			  return false;
		});

		$("#btnSimpanForm").click(function() {
			  // $('#div_edit').load('view/ticket/get_contact_individual.php?acusid='+acusid+'&bcusid='+bcusid);
			 
			  var fvalid = form.valid();
		    	 if(fvalid==true){
		 
		    	swal({
								title: 'Are you sure want to Save?',
								text: "",
								type: 'warning',
								buttons:{
									confirm: {
										text : 'Yes',
										className : 'btn btn-success'
									},
									cancel: {
										visible: true,
										className: 'btn btn-danger'
									}
								}
							}).then((Save) => {
								if (Save) {
									 var data = new FormData();
									 var form_data = $('#frmDataDet').serializeArray();
									 $.each(form_data, function (key, input) {
									    data.append(input.name, input.value);
									 });

									 data.append('key', 'value');	
									
									 $.ajax({
								        url: "<?php echo $save_form; ?>?v=dukcapil&iddet="+iddet,
								        type: "post",
								        data: data,
									    processData: false,
									    contentType: false,
								        success: function(d) {
								        	var warn = d;
							            	if(warn=="Success") {
							            		var vtype = "success";
							            	} else {
												var vtype = "error";	
							            	}
								            swal({ title: "Save Data!", type: vtype,  text: warn,   timer: 1000,   showConfirmButton: false });
								           if(warn=="Success!") {
								            	// setTimeout(function(){history.back();}, 1500);
								      //       	 $("#two_cust_no").prop("readonly", true);
												  // $("#two_cust_rating").prop("readonly", true);
			  									  $("#two_contact_name2").prop("readonly", true);
												  $("#two_nik_ktp").prop("readonly", true);
												  $("#two_cust_religion").prop("readonly", true);
												  $("#two_tempat_lahir").prop("readonly", true);
												  $("#two_tanggal_lahir").prop("readonly", true);
												  $("#two_nama_pasangan").prop("readonly", true);
												  $("#two_tanggal_lahir_pasangan").prop("readonly", true);
												  $("#two_legal_alamat").prop("readonly", true);
												  $("#two_nama_pasangan_rt").prop("readonly", true);
												  $("#two_legal_provinsi").prop("readonly", true);
												  $("#two_legal_kabupaten").prop("readonly", true);
												  $("#two_legal_kecamatan").prop("readonly", true);
												  $("#two_legal_kelurahan").prop("readonly", true);
												  $("#two_legal_kodepos").prop("readonly", true);
												  $("#two_profession_name").prop("readonly", true);
												  $("#two_profession_cat_name").prop("readonly", true);
												  $("#two_job_position").prop("readonly", true);
												  $("#two_industry_type_name").prop("readonly", true);
												  $("#two_surv_addr").prop("readonly", true);
												  $("#two_surv_rt").prop("readonly", true);
												  $("#two_surv_rw").prop("readonly", true);
												  $("#two_surv_province").prop("readonly", true);
												  $("#two_surv_kab").prop("readonly", true);
												  $("#two_surv_kec").prop("readonly", true);
												  $("#two_surv_kel").prop("readonly", true);
												  $("#two_surv_zip").prop("readonly", true);
												  $("#two_surv_subzip").prop("readonly", true);
												  $("#two_surv_mphon1").prop("readonly", true);
												  $("#two_surv_mphon2").prop("readonly", true);
												  $("#two_surv_phon1").prop("readonly", true);
												  $("#two_surv_phon2").prop("readonly", true);
												  $("#two_surv_jphon1").prop("readonly", true);
												  $("#two_surv_jphon2").prop("readonly", true);
												  $("#two_surv_provname").prop("readonly", true);
												  $("#two_surv_cusmodname").prop("readonly", true);
												  document.getElementById("btnSimpanForm").disabled = true; 
												  document.getElementById("btnEditForm").disabled = false;
			  									  document.getElementById("btnCancel").disabled = true;
			  									  document.getElementById("contact_name").value = document.getElementById("two_contact_name2").value;
			  									  document.getElementById("two_contact_name").value = document.getElementById("two_contact_name2").value;
			  									  var param_campaign = document.getElementById("font_contact_name").innerText;
			  									  var param_campaign_arr = param_campaign.split("#");
			  									  document.getElementById("font_contact_name").innerText = param_campaign_arr[0]+"# "+document.getElementById("two_contact_name2").value;


								           } 
								        }
									  });
								} else {
									swal.close();
								}
							});
					
				}else{
					swal({ title: "Info!", type: "error",  text: "Please fill in all mandatory",   timer: 1000,   showConfirmButton: false });
				}
		        return false;
		});

$("#btnEditForm2").click(function() {
			  // $('#div_edit').load('view/ticket/get_contact_individual.php?acusid='+acusid+'&bcusid='+bcusid);
			  $("#three_or_office").prop("readonly", false);
			  document.getElementById("three_or_office").disabled = false;
			  document.getElementById("mlob").disabled = false;
			  document.getElementById("three_asset_name").disabled = false;
			  $("#three_asset_name").prop("readonly", false);
			  $("#three_mfr_year").prop("readonly", false);
			  $("#three_otr").prop("readonly", false);
			  $("#three_asset_usage").prop("readonly", false);
			  $("#three_admin_fee").prop("readonly", false);
			  $("#three_add_adminfee").prop("readonly", false);
			  $("#three_biaya_pro").prop("readonly", false);
			  $("#three_ltv_maks").prop("readonly", false);
			  $("#three_ltv_yang").prop("readonly", false);
			  $("#three_ph_maks").prop("readonly", false);
			  $("#three_ph_yang").prop("readonly", false);
			  $("#three_ins_type").prop("readonly", false);
			  $("#three_calcu_ins").prop("readonly", false);
			  $("#three_self_ins").prop("readonly", false);
			  $("#three_tenor").prop("readonly", false);
			  $("#three_calcu_budget").prop("readonly", false);
			  $("#three_budget_plan").prop("readonly", false);
			  $("#three_calcu_install").prop("readonly", false);
			  document.getElementById("btnSimpanForm2").disabled = false; 
			  document.getElementById("btnEditForm2").disabled = true;
			  document.getElementById("btnCancel2").disabled = false;
			  return false;
		});

$("#btnCancel2").click(function() { 
			  $('#frmDataDet')[0].reset();
		      $("#three_or_office")[0].selectedIndex = 0;
		      $("#mlob")[0].selectedIndex = 0;
		      $("#three_asset_name")[0].selectedIndex = 0;
			  document.getElementById("three_or_office").disabled = true;
			  document.getElementById("mlob").disabled = true;
			  document.getElementById("three_asset_name").disabled = true;
			  $("#three_mfr_year").prop("readonly", true);
			  $("#three_otr").prop("readonly", true);
			  $("#three_asset_usage").prop("readonly", true);
			  $("#three_admin_fee").prop("readonly", true);
			  $("#three_add_adminfee").prop("readonly", true);
			  $("#three_biaya_pro").prop("readonly", true);
			  $("#three_ltv_maks").prop("readonly", true);
			  $("#three_ltv_yang").prop("readonly", true);
			  $("#three_ph_maks").prop("readonly", true);
			  $("#three_ph_yang").prop("readonly", true);
			  $("#three_ins_type").prop("readonly", true);
			  $("#three_calcu_ins").prop("readonly", true);
			  $("#three_self_ins").prop("readonly", true);
			  $("#three_tenor").prop("readonly", true);
			  $("#three_calcu_budget").prop("readonly", true);
			  $("#three_budget_plan").prop("readonly", true);
			  $("#three_calcu_install").prop("readonly", true);
			  document.getElementById("btnSimpanForm2").disabled = true; 
			  document.getElementById("btnEditForm2").disabled = false;
			  document.getElementById("btnCancel2").disabled = true;

			  // var iddet2 = document.getElementById("iddet").value;
			  // var dataString = 'v=cek_consumer_detail&iddet='+iddet2;
			  // $('#two_nik_ktp')[0].reset();
			  
			  return false;
		});

$("#btnSimpanForm2").click(function() {
			  // $('#div_edit').load('view/ticket/get_contact_individual.php?acusid='+acusid+'&bcusid='+bcusid);
			 
			  var fvalid = form.valid();
		    	 if(fvalid==true){
		 
		    	swal({
								title: 'Are you sure want to Save?',
								text: "",
								type: 'warning',
								buttons:{
									confirm: {
										text : 'Yes',
										className : 'btn btn-success'
									},
									cancel: {
										visible: true,
										className: 'btn btn-danger'
									}
								}
							}).then((Save) => {
								if (Save) {
									 var data = new FormData();
									 // var form_data = $('#frmDataDet').serializeArray();
									 // $.each(form_data, function (key, input) {
									 //    data.append(input.name, input.value);
									 // });
									var iddet2 = document.getElementById("iddet").value;
									var three_or_office					= document.getElementById("three_or_office").value;
									var mlob				= document.getElementById("mlob").value;
									var three_asset_name				= document.getElementById("three_asset_name").value;
									var three_mfr_year					= document.getElementById("three_mfr_year").value;
									var three_otr						= document.getElementById("three_otr").value;
									var three_asset_usage				= document.getElementById("three_asset_usage").value;
									var three_admin_fee					= document.getElementById("three_admin_fee").value;
									var three_add_adminfee				= document.getElementById("three_add_adminfee").value;
									var three_biaya_pro					= document.getElementById("three_biaya_pro").value;
									var three_ltv_maks					= document.getElementById("three_ltv_maks").value;
									var three_ltv_yang					= document.getElementById("three_ltv_yang").value;
									var three_ph_maks					= document.getElementById("three_ph_maks").value;
									var three_ph_yang					= document.getElementById("three_ph_yang").value;
									var three_ins_type					= document.getElementById("three_ins_type").value;
									var three_calcu_ins					= document.getElementById("three_calcu_ins").value;
									var three_self_ins					= document.getElementById("three_self_ins").value;
									var three_tenor						= document.getElementById("three_tenor").value;
									var three_calcu_budget				= document.getElementById("three_calcu_budget").value;
									var three_budget_plan				= document.getElementById("three_budget_plan").value;
									var three_calcu_install				= document.getElementById("three_calcu_install").value;

									data.append('three_or_office', three_or_office);
									data.append('mlob', mlob);
									data.append('three_asset_name', three_asset_name);
									data.append('three_mfr_year', three_mfr_year);
									data.append('three_otr', three_otr);
									data.append('three_asset_usage', three_asset_usage);
									data.append('three_admin_fee', three_admin_fee);
									data.append('three_add_adminfee', three_add_adminfee);
									data.append('three_biaya_pro', three_biaya_pro);
									data.append('three_ltv_maks',three_ltv_maks);
									data.append('three_ltv_yang',three_ltv_yang);
									data.append('three_ph_maks', three_ph_maks);
									data.append('three_ph_yang', three_ph_yang);
									data.append('three_ins_type', three_ins_type);
									data.append('three_calcu_ins', three_calcu_ins);
									data.append('three_self_ins', three_self_ins);
									data.append('three_tenor', three_tenor);
									data.append('three_calcu_budget', three_calcu_budget);
									data.append('three_budget_plan', three_budget_plan);
									data.append('three_calcu_install', three_calcu_install);
									
									 $.ajax({
								        url: "<?php echo $save_form; ?>?v=dukcapil2&iddet="+iddet2,
								        type: "post",
								        data: data,
									    processData: false,
									    contentType: false,
								        success: function(d) {
								        	var warn = d;
							            	if(warn=="Success") {
							            		var vtype = "success";
							            	} else {
												var vtype = "error";	
							            	}
								            swal({ title: "Save Data!", type: vtype,  text: warn,   timer: 1000,   showConfirmButton: false });
								           if(warn=="Success!") {
								            	// setTimeout(function(){history.back();}, 1500);
								            	 
												  document.getElementById("three_or_office").disabled = true;
												  document.getElementById("mlob").disabled = true;
												  document.getElementById("three_asset_name").disabled = true;
												  $("#three_mfr_year").prop("readonly", true);
												  $("#three_otr").prop("readonly", true);
												  $("#three_asset_usage").prop("readonly", true);
												  $("#three_admin_fee").prop("readonly", true);
												  $("#three_add_adminfee").prop("readonly", true);
												  $("#three_biaya_pro").prop("readonly", true);
												  $("#three_ltv_maks").prop("readonly", true);
												  $("#three_ltv_yang").prop("readonly", true);
												  $("#three_ph_maks").prop("readonly", true);
												  $("#three_ph_yang").prop("readonly", true);
												  $("#three_ins_type").prop("readonly", true);
												  $("#three_calcu_ins").prop("readonly", true);
												  $("#three_self_ins").prop("readonly", true);
												  $("#three_tenor").prop("readonly", true);
												  $("#three_calcu_budget").prop("readonly", true);
												  $("#three_budget_plan").prop("readonly", true);
												  $("#three_calcu_install").prop("readonly", true);
												  document.getElementById("btnSimpanForm2").disabled = true; 
												  document.getElementById("btnEditForm2").disabled = false;
			  									  document.getElementById("btnCancel2").disabled = true;
								           } 
								        }
									  });
								} else {
									swal.close();
								}
							});
					
				}else{
					swal({ title: "Info!", type: "error",  text: "Please fill in all mandatory",   timer: 1000,   showConfirmButton: false });
				}
		        return false;
		});

		$("#btnValidForm").click(function() {
			var nik            = document.getElementById("two_nik_ktp").value;
			var nama_lengkap   = document.getElementById("two_contact_name").value;
			var tempat_lahir   = document.getElementById("two_tempat_lahir").value;
			var tgl_lahir      = document.getElementById("two_tanggal_lahir").value; //06-07-1987
			var user_name      = document.getElementById("two_nama_pasangan").value;
			var emp_name       = document.getElementById("two_profession_name").value;
			var office_code    = document.getElementById("two_cabang_code").value;
			var office_name    = document.getElementById("two_cabang_name").value;
			var region         = document.getElementById("two_region_name").value; //1
			var cust_no        = document.getElementById("two_cust_no").value;
			var app_no         = '';
			var ip_user        = '';
			var source         = document.getElementById("two_source_data").value;

			var urldukcapil	   = "service/wom/check_dukcapil.php?nik="+nik+"&nama_lengkap="+nama_lengkap+"&tempat_lahir="+tempat_lahir+"&tgl_lahir="+tgl_lahir+"&user_name="+user_name+"&emp_name="+emp_name+"&office_code="+office_code+"&office_name="+office_name+"&region="+region+"&cust_no="+cust_no+"&app_no="+app_no+"&ip_user="+ip_user+"&source="+source;
			$.ajax({
					url: urldukcapil,
					type: "POST",
					dataType: 'json',
					success: function(data){ 
						var datares = data.FinalResult; 
						var datares2 = data.ResponseMessage;
						if (datares == 'Match') {
							alert(datares);
							document.getElementById("txtdukcapil").value = datares;

							var dataString = 'status_dukcapil=1&v=call_status_dukcapil';
							$.ajax({ 
							    type: 'POST', 
							    url: 'view/telesales/get_data_value.php', 
							    data: dataString, 
							    dataType:'json',
							    success: function (data) { 
							        $('#call_status').html(data.arr_status_call_dukcapil);
							    }
							      
							});
						}else if (datares == 'Not Match'){
							alert(datares);
							document.getElementById("txtdukcapil").value = datares;

							var dataString = 'status_dukcapil=2&v=call_status_dukcapil';
							$.ajax({ 
							    type: 'POST', 
							    url: 'view/telesales/get_data_value.php', 
							    data: dataString, 
							    dataType:'json',
							    success: function (data) { 
							        $('#call_status').html(data.arr_status_call_dukcapil);
							    }
							      
							});
						}else{
							alert(datares2);
							document.getElementById("txtdukcapil").value = datares2;

							var dataString = 'status_dukcapil=2&v=call_status_dukcapil';
							$.ajax({ 
							    type: 'POST', 
							    url: 'view/telesales/get_data_value.php', 
							    data: dataString, 
							    dataType:'json',
							    success: function (data) { 
							        $('#call_status').html(data.arr_status_call_dukcapil);
							    }
							      
							});
						}
												
					}
			});	
			// alert("xx");
		    return false;
		});



		$("#btn_duckcapil").click(function() {
			var nik            = document.getElementById("nik_ktp").value;
			var nama_lengkap   = document.getElementById("contact_name").value;
			var tempat_lahir   = document.getElementById("tempat_lahir").value;
			var tgl_lahir      = document.getElementById("tanggal_lahir").value; //06-07-1987
			var user_name      = document.getElementById("nama_pasangan").value;
			var emp_name       = document.getElementById("profession_name").value;
			var app_no         = "<?=$task_id;?>";
			var IS_PRE_APPROVAL= "";//document.getElementById("txt_IS_PRE_APPROVAL").value
			var param_dukcapil = 0;
			if (nik =='') {
				param_dukcapil = 1;
			}
			if (nama_lengkap =='') {
				param_dukcapil = 1;
			}
			if (tempat_lahir =='') {
				param_dukcapil = 1;
			}
			if (tgl_lahir =='') {
				param_dukcapil = 1;
			}

			var office_code    = '';//document.getElementById("two_cabang_code").value;
			var office_name    = '';//document.getElementById("two_cabang_name").value;
			var region         = '';//document.getElementById("two_region_name").value; //1
			var cust_no        = document.getElementById("cust_id_no").value;
			// var app_no         = '';
			var ip_user        = '';
			var source         = document.getElementById("source_data").value;
			var txt_job_modelname       = document.getElementById("txt_job_modelname").value;
			var txt_profession_code       = document.getElementById("profession_name").value;
			var txt_mother_cust       = document.getElementById("nama_ibukandung").value;
			var cabang_code       = document.getElementById("cabang_code").value;
			
			
			if (param_dukcapil==0) {
				if (nik.length == 16) {
				document.getElementById('tempatDukcapil').style.display = "";
				var urlcheckcust	   = "service/wom/check_negative.php?nik="+nik+"&nama_lengkap="+nama_lengkap+"&tempat_lahir="+tempat_lahir+"&tgl_lahir="+tgl_lahir+"&customer_id="+cust_no+"&source="+source+"&PreApproval="+IS_PRE_APPROVAL+"&app_no="+app_no+"&txt_mother="+txt_mother_cust+"&txt_job_modelname="+txt_job_modelname+"&three_or_office="+cabang_code+"&txt_profession_code="+txt_profession_code;
					$.ajax({
							url: urlcheckcust,
							type: "POST",
							dataType: 'json',
							success: function(data2){ 
								var datarnegres  = data2.result; 
								var datarnegres2 = data2.negativeType;
								var datarnegres3 = data2.isEdd;
								var datarnegres4 = data2.flagDeviasi;
								document.getElementById("custEdd").value = datarnegres3;
								document.getElementById("flagDeviationNegCust").value = datarnegres4;

								datarnegres      = datarnegres.replace("CUstomer", "Customer");
								console.log("masuk")
								if (datarnegres == 'Match' || datarnegres == 'MATCH' || datarnegres == 'MATCH - FATAL') {
									alert("Result Neglist : "+datarnegres);
									document.getElementById("txt_activity_neglist").value = datarnegres;
			  						$("#txt_activity_ducapil").prop("required", false);
								}else if (datarnegres == 'Not Match' || datarnegres == 'NOT MATCH' || datarnegres == 'MATCH - WARNING'){
									alert("Result Neglist : "+datarnegres);
									document.getElementById("txt_activity_neglist").value = datarnegres;
									var urldukcapil	   = "service/wom/check_dukcapil_new.php?nik="+nik+"&nama_lengkap="+nama_lengkap+"&tempat_lahir="+tempat_lahir+"&tgl_lahir="+tgl_lahir+"&user_name="+user_name+"&emp_name="+emp_name+"&office_code="+office_code+"&office_name="+office_name+"&region="+region+"&cust_no="+cust_no+"&app_no="+app_no+"&ip_user="+ip_user+"&source="+source+"&PreApproval="+IS_PRE_APPROVAL;
									$.ajax({
										url: urldukcapil,
										type: "POST",
										dataType: 'json',
										success: function(data){ 
											var datares = data.FinalResult; 
											var datares2 = data.ResponseMessage;
											if (datares == 'Match') {
												alert("Result Dukcapil : "+datares);
												document.getElementById("txt_activity_ducapil").value = datares;
											}else if (datares == 'Not Match'){
												alert("Result Dukcapil : "+datares);
												document.getElementById("txt_activity_ducapil").value = datares;
											}else{
												alert("Result Dukcapil : "+datares);
												document.getElementById("txt_activity_ducapil").value = datares;
											}
										}
									});
								}else{
									alert("Result Neglist : "+datarnegres);
									document.getElementById("txt_activity_neglist").value = datarnegres;
								}

								document.getElementById('tempatDukcapil').style.display = "none";
														
							}
					});	

				}else{
					// swal("NIK Tidak Sesuai", "NIK kurang/lebih dari 16 digit", "warning");
					alert("NIK Tidak Sesuai", "NIK kurang/lebih dari 16 digit");
				}

				//start spouse
				var spouse_nik= document.getElementById("txt_spouse_nik").value;
				var spouse_name= document.getElementById("txt_spouse_name").value;
				var spouse_bod= document.getElementById("txt_spouse_birthdate").value;
				var spouse_bod_place= document.getElementById("txt_spouse_birthplace").value;

				if (spouse_nik!='') {
					var urlcheckcust	   = "service/wom/check_negative.php?nik="+spouse_nik+"&nama_lengkap="+spouse_name+"&tempat_lahir="+spouse_bod_place+"&tgl_lahir="+spouse_bod+"&source="+source+"&PreApproval="+IS_PRE_APPROVAL+"&app_no="+app_no;					setTimeout(function() { 
					$.ajax({
							url: urlcheckcust,
							type: "POST",
							dataType: 'json',
							success: function(data2){ 
								var urldukcapil	   = "service/wom/check_dukcapil_new.php?nik="+spouse_nik+"&nama_lengkap="+spouse_name+"&tempat_lahir="+spouse_bod_place+"&tgl_lahir="+spouse_bod+"&app_no="+app_no+"&ip_user="+ip_user+"&source="+source+"&PreApproval="+IS_PRE_APPROVAL+"&app_no="+app_no;
								var datarnegres  = data2.result; 
								var datarnegres2 = data2.negativeType;
								var datarnegres3 = data2.isEdd;
								var datarnegres4 = data2.flagDeviasi;
								document.getElementById("spouseEdd").value = datarnegres3;
								document.getElementById("flagDeviationNegSpouse").value = datarnegres4;

								datarnegres      = datarnegres.replace("CUstomer", "Customer");
								// alert(datarnegres);
								if (datarnegres == 'Match') {
									alert("Result Spouse Neglist : "+datarnegres);
									document.getElementById("txt_activity_pasangan_neglist").value = datarnegres;
								}else if (datarnegres == 'Not Match' || datarnegres == 'NOT MATCH'){
									alert("Result Spouse Neglist : "+datarnegres);
									document.getElementById("txt_activity_pasangan_neglist").value = datarnegres;

									$.ajax({
										url: urldukcapil,
										type: "POST",
										dataType: 'json',
										success: function(data){ 
											// document.getElementById('tempatDukcapil').style.display = "none";
											var datares = data.FinalResult; 
											var datares2 = data.ResponseMessage;
											if (datares == 'Match') {
												alert("Result Spouse Dukcapil : "+datares);
												document.getElementById("txt_activity_pasangan_ducapil").value = datares;
											}else if (datares == 'Not Match'){
												alert("Result Spouse Dukcapil : "+datares);
												document.getElementById("txt_activity_pasangan_ducapil").value = datares;
											}else{
												// alert("Result Dukcapil : "+datares);
												document.getElementById("txt_activity_pasangan_ducapil").value = datares;
											}
										}
										});
								}else{
									// alert("Result Neglist : "+datarnegres);
									document.getElementById("txt_activity_pasangan_neglist").value = datarnegres;
								}						
							}
					});	
					}, 1500);
				}
				
				//end spouse
				//start guarantor
				var guarantor_nik= document.getElementById("txt_guarantor_nik").value;
				var guarantor_name= document.getElementById("txt_guarantor_name").value;
				var guarantor_bod= document.getElementById("txt_guarantor_bod").value;
				var guarantor_bod_place= document.getElementById("txt_guarantor_bod_place").value;

				if (guarantor_nik!='') {
					var urlcheckcust	   = "service/wom/check_negative.php?nik="+guarantor_nik+"&nama_lengkap="+guarantor_name+"&tempat_lahir="+guarantor_bod_place+"&tgl_lahir="+guarantor_bod+"&source="+source+"&PreApproval="+IS_PRE_APPROVAL+"&app_no="+app_no;
					setTimeout(function() {
					$.ajax({
							url: urlcheckcust,
							type: "POST",
							dataType: 'json',
							success: function(data2){ 
								var urldukcapil	   = "service/wom/check_dukcapil_new.php?nik="+guarantor_nik+"&nama_lengkap="+guarantor_name+"&tempat_lahir="+guarantor_bod_place+"&tgl_lahir="+guarantor_bod+"&app_no="+app_no+"&ip_user="+ip_user+"&source="+source+"&PreApproval="+IS_PRE_APPROVAL+"&app_no="+app_no;
								var datarnegres  = data2.result; 
								var datarnegres2 = data2.negativeType;
								var datarnegres3 = data2.isEdd;
								var datarnegres4 = data2.flagDeviasi;
								document.getElementById("guarantorEdd").value = datarnegres3;
								document.getElementById("flagDeviationNegGuarantor").value = datarnegres4;
								
								datarnegres      = datarnegres.replace("CUstomer", "Customer");
								if (datarnegres == 'Match') {
									alert("Result Guarantor Neglist : "+datarnegres);
									document.getElementById("txt_activity_guarantor_neglist").value = datarnegres;
								}else if (datarnegres == 'Not Match' || datarnegres == 'NOT MATCH'){
									alert("Result Guarantor Neglist : "+datarnegres);
									document.getElementById("txt_activity_guarantor_neglist").value = datarnegres;

									$.ajax({
										url: urldukcapil,
										type: "POST",
										dataType: 'json',
										success: function(data){ 
											// document.getElementById('tempatDukcapil').style.display = "none";
											var datares = data.FinalResult; 
											var datares2 = data.ResponseMessage;
											if (datares == 'Match') {
												alert("Result Guarantor Dukcapil : "+datares);
												document.getElementById("txt_activity_guarantor_ducapil").value = datares;
											}else if (datares == 'Not Match'){
												alert("Result Guarantor Dukcapil : "+datares);
												document.getElementById("txt_activity_guarantor_ducapil").value = datares;
											}else{
												// alert("Result Dukcapil : "+datares);
												document.getElementById("txt_activity_guarantor_ducapil").value = datares;
											}					
										}
										});
								}else{
									// alert("Result Neglist : "+datarnegres);
									document.getElementById("txt_activity_guarantor_neglist").value = datarnegres;
								}	
														
							}
					});	}, 1500);
				}

				//end guarantor
			}else{
				alert("Customer Info is Required");
			}
			// alert("xx");
		    return false;
		});


</script>
<input type="hidden" id="tmp_callSession">
<input type="hidden" id="remarkCall">

<input type="hidden" id="sessionkey">
<input type="hidden" id="phone_nor">

<script type="text/javascript">

	$('#three_otr').attr('onkeyup', 'return auto_numeric(this);');
	// $('#monthly_instalment2').attr('onkeyup', 'return auto_numeric(this);');
	$('#otr_price2').mask('#,##0', {reverse: true});
	$('#monthly_instalment2').mask('#,##0', {reverse: true});

	$('#txtcalllater').datetimepicker({
		format: 'YYYY-MM-DD HH:ss',
	});

	$('.two_tanggal_lahir').datetimepicker({
		format: 'YYYY-MM-DD',
	});

	$('.two_tanggal_lahir_pasangan').datetimepicker({
		format: 'YYYY-MM-DD',
	});

	$('#txtfollowup').datetimepicker({
		format: 'YYYY-MM-DD HH:ss',
		minDate: 'now'
	});
	
	$('#txt_activity_waktuvisit').datetimepicker({
		format: 'YYYY-MM-DD HH:ss',
	});

</script>

<!-- Modal -->
		<div class="modal fade text-xs-left" id="backcall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
		  <div class="modal-dialog" role="document" style="border: 2px solid #0a4fa7;border-radius:10px 10px 0px 0px;">
			<div class="modal-content" class="border border-primary">
			  <div class="modal-header">
				<h4 class="modal-title" id="myModalLabel4">Addon Phone</h4>
			  </div>
			  <div class="modal-body" style="background:white;height:400px;overflow-y:auto">
			  		<input type="hidden" name="v" id="v" value="<?php echo $v;?>">
			  		<?php
			  		$txtphonenoadd1   = "";
			  		$txtphonenoteadd1 = "";
			  		$txtphonenoadd2   = "";
			  		$txtphonenoteadd2 = "";
			  		$txtphonenoadd3   = "";
			  		$txtphonenoteadd3 = "";
			  		$txtphonenoadd4   = "";
			  		$txtphonenoteadd4 = "";
				$condb = connectDB();	
				/*
			  		$sqlsp = "SELECT * FROM cc_customer_profile_prv_addphone WHERE id_cust='$iddet'";
			  		$ressp = mysqli_query($condb,$sqlsp);
			  		$nop=1;
			  		while($recsp = mysqli_fetch_array($ressp)){
						$txtphonenoadd  = $recsp['phone_no'];
						$remark_no = $recsp['remark_no'];
					$nop++;
			  		}
				*/
			  		function getItem($type,$condb)
					{
						
						$arrRet = array();
						$sql2 = "select * from cc_customer_profile_prv_addphone where id_cust='".$type."'";
						$res2 = mysqli_query($condb,$sql2);
						while($row = mysqli_fetch_array($res2))
						{
							 $phoneno   = $row['phone_no'];
							 $remark_no = $row['remark_no'];
							$arrRet[] = array($phoneno,$remark_no);
						}
						return $arrRet;
					}
	
	
	 		$conten = getItem("$iddet",$condb);

	    for($i=0 ; $i<4 ; $i++){
                $x = $i+1;
				
			//	$txtphonenoadd[]		= $conten[$i][0];
			//	$txtphonenoteadd[]		= $conten[$i][1];
		}

		 $sqladd = "SELECT add_phone_1,
					add_phone_2,
					add_phone_3,
					add_phone_4,
					add_remark_1,
					add_remark_2,
					add_remark_3,
					add_remark_4
					FROM cc_customer_profile_prv WHERE id='$iddet'";
		$resadd = mysqli_query($condb,$sqladd);
		if($recadd = mysqli_fetch_array($resadd)){
			$txtphonenoadd_1		= $recadd['add_phone_1'];
			$txtphonenoteadd_1 	= $recadd['add_remark_1'];
			
			$txtphonenoadd_2		= $recadd['add_phone_2'];
			$txtphonenoteadd_2 	= $recadd['add_remark_2'];

			$txtphonenoadd_3		= $recadd['add_phone_3'];
			$txtphonenoteadd_3 	= $recadd['add_remark_3'];

			$txtphonenoadd_4		= $recadd['add_phone_4'];
			$txtphonenoteadd_4 	= $recadd['add_remark_4'];
		}

		disconnectDB($condb);
			  		?>
					
					<table width="100%">
						<?php

						for($j = 0; $j<4; $j++)
						{
							$k = $j+1;
							
							$txtphonenoaddxx = ${"txtphonenoadd_$k"};
							$txtphonenoteaddxx = ${"txtphonenoteadd_$k"};
						?>
						<tr>
							<td>
								<div class="form-group">
									<label for="email2">Addon Phone <?php echo $k;?></label>
									<input type="text" class="form-control" id="txtphonenoadd<?php echo $k?>" name="txtphonenoadd[]" value="<?php echo $txtphonenoaddxx;?>">
								</div>
							</td>
							<td>
								<div class="form-group">
									<label for="email2">Remark</label>
									<input type="text" class="form-control" id="txtphonenoteadd<?php echo $k?>" name="txtphonenoteadd[]" value="<?php echo $txtphonenoteaddxx;?>">
								</div>
							</td>
						</tr>
						<?php
						}
						?>
						<!--
						<tr>
							<td>
								<div class="form-group">
									<label for="email2">Addon Phone 2</label>
									<input type="text" class="form-control" id="txtphonenoadd2" name="txtphonenoadd2" value="<?php echo $txtphonenoadd2;?>">
								</div>
							</td>
							<td>
								<div class="form-group">
									<label for="email2">Remark</label>
									<input type="text" class="form-control" id="txtphonenoteadd2" name="txtphonenoteadd2" value="<?php echo $txtphonenoteadd2;?>">
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label for="email2">Addon Phone 3</label>
									<input type="text" class="form-control" id="txtphonenoadd3" name="txtphonenoadd3" value="<?php echo $txtphonenoadd3;?>">
								</div>
							</td>
							<td>
								<div class="form-group">
									<label for="email2">Remark</label>
									<input type="text" class="form-control" id="txtphonenoteadd3" name="txtphonenoteadd3" value="<?php echo $txtphonenoteadd3;?>">
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label for="email2">Addon Phone 4</label>
									<input type="text" class="form-control" id="txtphonenoadd4" name="txtphonenoadd4" value="<?php echo $txtphonenoadd4;?>">
								</div>
							</td>
							<td>
								<div class="form-group">
									<label for="email2">Remark</label>
									<input type="text" class="form-control" id="txtphonenoteadd4" name="txtphonenoteadd4" value="<?php echo $txtphonenoteadd4;?>">
								</div>
							</td>
						</tr>
						-->
					</table>

			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn grey btn-outline-primary" data-dismiss="modal">Close</button>
				<button type="button" class="btn grey btn-outline-primary" onclick="savephonenoadd();return false;">Save</button>


			  </div>
			</div>
		  </div>
		</div>

		<script type="text/javascript">
		function savephonenoadd(){
					 var v					= document.getElementById("v").value;
					 var iddet				= document.getElementById("iddet").value;
					 var txtphonenoadd1		= document.getElementById("txtphonenoadd1").value;
					 var txtphonenoteadd1	= document.getElementById("txtphonenoteadd1").value;
					 var txtphonenoadd2		= document.getElementById("txtphonenoadd2").value;
					 var txtphonenoteadd2	= document.getElementById("txtphonenoteadd2").value;
					 var txtphonenoadd3		= document.getElementById("txtphonenoadd3").value;
					 var txtphonenoteadd3	= document.getElementById("txtphonenoteadd3").value;
					 var txtphonenoadd4		= document.getElementById("txtphonenoadd4").value;
					 var txtphonenoteadd4	= document.getElementById("txtphonenoteadd4").value;

					 var data = "?txtphonenoadd1="+txtphonenoadd1+"&txtphonenoteadd1="+txtphonenoteadd1+"&txtphonenoadd2="+txtphonenoadd2+"&txtphonenoteadd2="+txtphonenoteadd2+"&txtphonenoadd3="+txtphonenoadd3+"&txtphonenoteadd3="+txtphonenoteadd3+"&txtphonenoadd4="+txtphonenoadd4+"&txtphonenoteadd4="+txtphonenoteadd4+"&iddet="+iddet;
					$.ajax({
						type: 'POST',
						url: "view/telesales/tele_customer_addon_phone_save.php"+data,
						success: function() {
							alert("Insert Add Phone No Success");
							window.location.href = "index.php?v="+v;
						}
					});

			}


$("#call_status").change(function(){
	var idsel = this.value;
	if(idsel==1){
		var valsel =2;
	}else if(idsel==2){
		var valsel =1;
	}else{
		var valsel =0;
	}
	//alert(idsel);
	document.getElementById("laststatus").value = valsel;

});
	

    document.getElementById('txtcalllater').parentNode.parentNode.style.display = "none";
	document.getElementById('assigned_to').parentNode.parentNode.style.display = "none";
	function cekCallStatus(tujuan){
			if (tujuan == 14) {
				document.getElementById('txtcalllater').parentNode.parentNode.style.display = "block";
				document.getElementById('assigned_to').parentNode.parentNode.style.display = "block";
			}else{
				document.getElementById('txtcalllater').parentNode.parentNode.style.display = "none";
				document.getElementById('assigned_to').parentNode.parentNode.style.display = "none";

			}
	}

	//screenrecording
	function btnChangeStart() {alert("xx11");
   	startScreenRecord();alert("xx");
  }
   	 
  function btnChangeStop() {
   	document.getElementById('btn-start-recording').disabled = false;
   	document.getElementById('btn-stop-recording').disabled = true;  
   	document.getElementById('btn-pause-recording').disabled = true;
   	document.getElementById('btn-resume-recording').disabled = true;   	
   	
   	// nama file di dapat dari session id voice call  
   	// di atas hanya sample yg di input manual
  	var sessionid = document.getElementById('sessionid').value;
  	
   	stopScreenRecord(sessionid);
  }

  function btnChangePause() {
   	document.getElementById('btn-start-recording').disabled = true;
   	document.getElementById('btn-stop-recording').disabled = true;  
   	document.getElementById('btn-pause-recording').disabled = true;
   	document.getElementById('btn-resume-recording').disabled = false;   	
  	
   	pauseScreenRecord();
  }
  
  function btnChangeResume() {
   	document.getElementById('btn-start-recording').disabled = true;
   	document.getElementById('btn-stop-recording').disabled = false;  
   	document.getElementById('btn-pause-recording').disabled = false;
   	document.getElementById('btn-resume-recording').disabled = true;  
   	
   	resumeScreenRecord();  	
  }

	function auto_numeric(e){
		// var number = e.value;
		// let dollarIndianLocale = Intl.NumberFormat('en-IN');
		// $("#"+e.id).val(dollarIndianLocale.format(number));
	}

  $("#btnstart").click(function(){ 
	 	alert("xx11");
   	// startScreenRecord();alert("xx");
    	return false;
	})
			

		</script>