<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url()?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<script src="<?=base_url()?>vendors/select2/dist/js/select2.min.js"></script>


<!-- switchery -->
<link href="<?=base_url(); ?>vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<script src="<?=base_url(); ?>vendors/switchery/dist/switchery.min.js"></script>
<!-- date time picker -->
<script type="text/javascript" src="<?=base_url(); ?>vendors/moment/min/moment.min.js"></script>

<link href="<?=base_url(); ?>vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script type="text/javascript" src="<?=base_url(); ?>vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>


<!DOCTYPE html>
<div style="float:right">
	<h2>
		<button class="btn btn-primary" onClick="window.location.href='<?=site_url()?>/transaksi_lain/p_registrasi_tvi'">
			<i class="fa fa-arrow-left"></i>
			Back
		</button>
		<button class="btn btn-success" onClick="window.location.href='<?=site_url()?>/transaksi_lain/p_registrasi_tvi/add'">
			<i class="fa fa-repeat"></i>
			Refresh
		</button>
	</h2>
</div>
<div class="clearfix"></div>
</div>
<div class="x_content">
	<br>
	<form id="form" data-parsley-validate="" enctype="multipart/form-data" class="form-horizontal form-label-left" novalidate="" method="post" action="<?=site_url()?>/transaksi_lain/p_aktifasi_liaison_officer/add?id=<?=$this->input->get('id');?>">

		<div class="col-md-6">
			<div class="form-group two">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori LOI</label>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<select name="kategori_loi_id" id="kategori" required="" disabled class="form-control select2">
						<option value="">--Pilih Kategori--</option>
						<?php foreach($dataKategori as $v){?>
							<option value="<?=$v['id']?>" <?=($dataSelect->kategori == $v['id'])?"selected":""?>><?=$v['nama']?></option>
						<?php }?>
					</select>
				</div>
			</div>
			<div class="form-group two">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis LOI</label>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<select name="jenis_loi_id" id="jenis" required="" disabled class="form-control select2">
						<option value="">--Pilih Jenis--</option>
						<?php foreach($dataJenis as $v){?>
                            <option value="<?=$v['id']?>"<?=($dataSelect->jenis == $v['id'])?"selected":""?>><?=$v['nama']?></option>
                        <?php }?>
					</select>
				</div>
			</div>
			<div class="form-group two">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Peruntukkan</label>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<select name="peruntukan_loi_id" id="peruntukan" disabled required="" class="peruntukan form-control select2">
						<option value="">--Pilih Peruntukan--</option>
						<?php foreach($dataPeruntukan as $v){?>
                            <option value="<?=$v['id']?>"<?=($dataSelect->peruntukan == $v['id'])?"selected":""?>><?=$v['nama']?></option>
                        <?php }?>
					</select>
				</div>
			</div>         	
			
        </div>

        <div class="clear-fix"></div>
        <br>

		<div id="view_data">
			<div class="row" style="margin-top: 35px;">
				<div class="col-md-12">
					<div class="col-md-6">
						<div class="form-group unit">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Project</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" id="project_name" name="project_name" value="<?=$dataSelect->project?>" readonly class="form-control">
							</div>
						</div>
						<div class="form-group unit">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Kawasan</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" value="<?=$dataSelect->kawasan?>" id="kawasan_name" name="kawasan_name" readonly class="form-control">
							</div>
						</div>
						<div class="form-group unit">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Blok</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" value="<?=$dataSelect->blok?>" id="blok_name" name="blok_name" readonly class="form-control unit">
							</div>
						</div>
						<div class="form-group unit">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Nomor Unit</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" value="<?=$dataSelect->unit?>" id="unit_name" name="unit_name" readonly class="form-control unit">
							</div>
						</div>

						<div class="form-group unit">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Customer</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" placeholder="Masukkan nama customer" value="<?=$dataSelect->customer?>" id="customer_name" name="customer_name"
								 readonly class="form-control unit">
							</div>
						</div>
						<div class="form-group unit">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Nomor VA</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="nomor_va" id="nomor_va" value="" readonly class="form-control unit">
							</div>
						</div>

						<div class="form-group non_unit">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Customer</label>
							<div class="col-md-7 col-sm-9 col-xs-12">
								<input type="hidden" name="customer_id"  id="customer_id"  >
								<select name="customer_name2" id="customer_name2" class="form-control select2 non_unit">
									<option value="" selected="" disabled="">--Pilih Customer--</option>
									<?php
										foreach ($dataCustomer as $v) {
											echo("<option value='$v[id] | $v[name] '>$v[name]</option>");
										}
									?>
								</select>
								
							</div>
							<div class="col-md-2 col-sm-9 col-xs-12">
							<a class="btn btn-primary" href="<?=site_url(); ?>/p_master_customer/add">           
								DAFTAR
							</a>
							</div>
						</div>
						
					</div>
					<div class="col-md-6">
						<div class="form-group unit">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">No. Registrasi</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="nomor_registrasi" id="nomor_registrasi" value="<?= $dataSelect->nomor_registrasi?>" readonly class="form-control unit">
							</div>
						</div>
						<div class="form-group unit">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Telp</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="nomor_telepon" id="nomor_telepon" value="<?=$dataSelect->telepon?>" readonly class="form-control unit">
							</div>
						</div>
						<div class="form-group unit">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">No Hp</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" readonly="" name="nomor_handphone" id="nomor_handphone" value="<?=$dataSelect->no_hp?>" class="form-control unit">
							</div>
						</div>
						<div class="form-group unit">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="email" required="" placeholder="Email" id="email" readonly="" name="email" value="<?=$dataSelect->email?>" class="form-control unit">
							</div>
						</div>
						<div class="form-group unit">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">L. Bangunan Lama (m<sup>2</sup>)</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" required="" placeholder="Luas Bangunan" id="luaslama" readonly="" name="luaslama" value="<?=$dataSelect->luaslama?>" class="form-control unit">
							</div>
						</div>
						<div class="form-group luasanbaru">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">L. Bangunan Baru (m<sup>2</sup>)</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" required="" disabled placeholder="Luas Bangunan" id="luasbaru" name="luasbaru" value="<?=$dataSelect->luasbaru?>" class="form-control unit">
							</div>
						</div>

						<div class="form-group non_unit">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">No. Registrasi</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="nomor_registrasi2" id="nomor_registrasi2" value="Auto Generate" class="form-control non_unit" readonly>
							</div>
						</div>
						<div class="form-group non_unit">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Telp</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="nomor_telepon2" id="nomor_telepon2" placeholder="Masukkan Nomor Telepon" value=""
								 class="form-control non_unit">
							</div>
						</div>
						<div class="form-group non_unit">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">No Hp</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" placeholder="Masukkan Nomor Handphone" name="nomor_handphone2" id="nomor_handphone2" value=""
								 class="form-control non_unit">
							</div>
						</div>
						<div class="form-group non_unit">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="email" placeholder="Masukkan Email" name="email2" id="email2" value="" class="form-control non_unit">
							</div>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="clearfix"></div>
			<h4 id="label_transaksi">Paket Liaison Officer</h4>
			<hr>
			<div class="col-md-6">
				
				<div class="form-group two">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Pilih Paket</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select name="jenis_paket" id="paket" required="" disabled class="paket form-control select2">
							<option value="">--Pilih Paket--</option>
							<?php foreach($dataPaket as $v){?>
								<option value="<?=$v['id']?>"<?=($dataSelect->paket == $v['id'])?"selected":""?>><?=$v['nama']?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="clearfix"></div>
			<h4 id="label_transaksi">Deposit</h4>
			<hr>
			<div class="col-md-6">
				
				<div class="form-group two">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Deposit</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="deposit_masuk" id="deposit_masuk" value='<?=number_format($dataSelect->deposit_masuk)?>' readonly>
					</div>
				</div>
				<div class="form-group two">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Pemakaian Deposit</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control currency" readonly id="deposit_pakai" name="deposit_pemakaian">
					</div>
				</div>
				<div class="form-group two">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Sisa Deposit</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control currency" name="sisa_deposit" id="sisa_deposit" disabled>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<h4 id="label_transaksi">Transaksi</h4>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group two ">
						<table class="table table-responsive">
							<thead>
								<tr>
									<th class="col-md-3">Item</th>
									<th class="col-md-1">Volume</th>
                                    <th class="col-md-2">Satuan</th>
                                    <th class="col-md-2">Harga Satuan</th>
									<th class="col-md-3">Jenis</th>
									<th>Hapus</th>
								</tr>
							</thead>
							<tbody id="tbody">
								<tr class="isi">
									<td>
										<select class="nama_item form-control col-md-1 col-xs-12 select2" value="0" id="nama_item" name="nama_item[]">
											<option value="">Pilih Item</option>
											<?php
											foreach($dataItemPaket as $v){
												echo ("<option satuan=".$v->satuan." harga_satuan=".$v->harga_satuan." status_item=".$v->status_item." value=" . $v->id . ">" . $v->nama . "</option>");
											}
											?>
										</select>
									</td>
									<td>
										<input id="volume" name="volume[]" required="" value="" class="volume form-control col-md-1 col-xs-12 currency">
									</td>
									<td>
										<input id="satuan" name="satuan[]" readonly required="" class="satuan form-control col-md-1 col-xs-12">
									</td>
									<td>
										<input id="harga_satuan" name="harga_satuan[]" required="" class="harga_satuan form-control col-md-1 col-xs-12">
									</td>
									<td>
										<input id="status_item" name="status_item[]" readonly required="" class="status_item form-control col-md-1 col-xs-12">
									</td>
									<td>
										<a class='delete btn btn-danger' href='#' id="btn-delete-paket"><i class='fa fa-trash'></i> </a>
									</td>
								</tr>
							</tbody>
						</table>
						<button type="button" id='btn-add-paket' class="btn btn-danger pull-right" ><i class="fa fa-plus"></i> Add Paket</button>
					</div>
				</div>
			</div>

			<div class="col-md-12 col-xs-12">
				<div class="center-margin">
					<button class="btn btn-primary" type="reset">Reset</button>
					<button type="submit" class="btn btn-success" id="submit">Submit</button>
				</div>
			</div>
		</div>
    </form>
</div>
</div>

<script type="text/javascript">
    var komponen = $(".isi")[0].outerHTML;
    function currency(input) {
		var input = input.toString().replace(/[\D\s\._\-]+/g, "");
		input = input ? parseInt(input, 10) : 0;
		return (input === 0) ? "" : input.toLocaleString("en-US");
	}

	$(".unit").show();
	$(".non_unit").hide();
	$(".two").show();
	$("body").on("click",".preview",function(){
		var project = $("project_name").val();
		$("#modal_unit").val(project);
    });
    $("#btn-add-paket").click(function(){
		$("#tbody").append(komponen);
		$('.select2').select2();
    });

    $("body").on("click",".delete",function(){
		$(this).parent().parent().remove();
	});

	$("#jenis").change(function(){
		url = '<?=site_url(); ?>/transaksi_lain/P_registrasi_liaison_officer/ajax_get_peruntukan';
		$.ajax({
			type: "post",
			url: url,
			data: {
				jenis : $("#jenis").val()
			},
			dataType: "json",
			success: function (data) {
				console.log(data);
				$("#peruntukan")[0].innerHTML = "";
				$("#peruntukan").append("<option value=''>Pilih Peruntukan</option>");
				$.each(data, function (key, val) {
					$("#peruntukan").append("<option value='" + val.id + "'    >" + val.nama + "</option>");
				});
			}
		});

		url2 = '<?= site_url();?>/transaksi_lain/P_registrasi_liaison_officer/ajax_get_paket';
		$.ajax({
			type: "post",
			url: url2,
			data: {
				jenis : $("#jenis").val()
			},
			dataType: "json",
			success: function (data) {
				console.log(data);
				$("#paket")[0].innerHTML = "";
				$("#paket").append("<option value=''>--Pilih Paket--</option>");
				$.each(data, function (key, val) {
					$("#paket").append("<option value='" + val.id + "|" + val.kode + "|" + val.biaya_registrasi + "|" + val.harga_jasa +"|" + val.biaya_prakiraan + "'>" + val.nama + "</option>");
				});
			}
		});
    });
    
    $("body").on("change",".nama_item",function(){
		var satuan = $("option:selected",$(this)).attr("satuan");
		var status_item = $("option:selected",$(this)).attr("status_item");
		var hrg = $("option:selected",$(this)).attr("harga_satuan");
		if(status_item =='1'){
			status = 'Dipinjamkan';
		}else{
			status = 'Hak Milik';
		}
		$(this).parent().parent().children().eq(2).children().val(satuan);
		$(this).parent().parent().children().eq(3).children().val(formatNumber(hrg));
		$(this).parent().parent().children().eq(4).children().val(status);
		// $(this).parent().parent().children().eq(4).children().val(4+7);
	});

	$("body").on("keyup",".volume",function(){
		console.log($(this).val());
		console.log($(this).parent().parent().children().eq(3).children().val());
		console.log($(this));
		// $(this).val(formatNumber($(this).val()));
		$(this).parent().parent().children().eq(5).children().val(
			formatNumber(
				unformatNumber($(this).val()) * 
				unformatNumber($(this).parent().parent().children().eq(3).children().val())
			)
		);
		var total = 0;
		for(i = 0 ; i < $(".isi").length ; i++){
			total += parseInt(unformatNumber($(".isi").eq(i).children().eq(5).children().val()));
		}
		$("#hrg_prediksi").val(formatNumber(total));
	});
	
	$("body").on("keyup","#deposit_pakai",function(){
		var deposit_masuk = $("#deposit_masuk").val();
		var deposit_pakai = $("#deposit_pakai").val();
		var sisa = formatNumber(unformatNumber(deposit_masuk)-unformatNumber(deposit_pakai));
		$("#sisa_deposit").val(formatNumber(sisa));
	});

	$("#peruntukan").change(function(){
		var jenis = $("#jenis").val();
		var peruntukan = $("#peruntukan").val();
		if(jenis == '1'){
			if(peruntukan == '1'){
				$(".luasanbaru").show();
				$("#luasbaru").removeAttr("disabled");
			}
		}
	});

	$("#paket").change(function(){
		$(".paket_internet").show();
		var paket = $("#paket").val();
		var pecah = paket.split('|');
		var kode = pecah[1];
		var biaya_registrasi = pecah[2];
		var harga_jasa = pecah[3];
		var biaya_prakiraan = pecah[4];
		$("#kode").val(kode);
		$("#biaya_registrasi").val(currency(biaya_registrasi));
		$("#harga_jasa").val(currency(harga_jasa));
		$("#biaya_prakiraan").val(currency(biaya_prakiraan));

		var total = parseInt(biaya_registrasi) + parseInt(harga_jasa) + parseInt(biaya_prakiraan);
		$("#subtotal").val(currency(total));
		var subtotal = $("#subtotal").val();
		$("#totalpaket").val(subtotal);
		$("#total_bayar").val(subtotal);
	});

	function formatNumber(data) {
		data = data + '';
		data = data.replace(/,/g, "");

		data = parseInt(data) ? parseInt(data) : 0;
		data = data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
		return data;
	}

	function unformatNumber(data) {
		data = data + '';
		return data.replace(/,/g, "");
	}

	function getDate() 
	{
		var jumhari = $('#jumlah_hari_aktifasi').val();

		var  awal = $('#tanggal_pemasangan_mulai').val();

		awal = awal.substr(3,2)+"-"+awal.substr(0,2)+"-"+awal.substr(6,4)
		
		var pasang = new Date(awal);
		var dd = String(pasang.getDate()).padStart(2, '0');
		var mm = String(pasang.getMonth() + 1).padStart(2, '0'); //January is 0!
		var yyyy = pasang.getFullYear();

		//today = mm + '/' + dd + '/' + yyyy;

		var pemasangan = yyyy + '-' + mm + '-' + dd;

		var startdate = new Date(pemasangan);
		var newdate = new Date();
		newdate.setDate(startdate.getDate() +  parseInt(jumhari) );
		var dd = newdate.getDate();
		var mm = newdate.getMonth() + 1;
		var y = newdate.getFullYear();

		//var someFormattedDate = ("0" + mm).slice(-2) + '-' + ("0" + dd).slice(-2) + '-' + y;

		var someFormattedDate = ("0" + dd).slice(-2) + '-' +  ("0" + mm).slice(-2) + '-' +   y;
		console.log(dd);
		console.log(mm);
		console.log(y);
		$('#tanggal_aktifasi').val(someFormattedDate);  
	}

	$(function () {
		$('.datetimepicker').datetimepicker({
			viewMode: 'days',
			format: 'DD-MM-YYYY'
		});

	});

	$("#internet_flag").change(function(){
		if($("#internet_flag").is(':checked')){
			$(".form_inet").attr('disabled',false);
		}else{
			$(".form_inet").attr('disabled','disabled');
			$(".form_inet").val('0');
		}
	})
	$("#tv_flag").change(function(){
		if($("#tv_flag").is(':checked')){
			$(".form_tv").attr('disabled',false);
		}else{
			$(".form_tv").attr('disabled','disabled');
			$(".form_tv").val('0');
		}
	})

	$("#pilih_unit").change(function () {
		$("#submit").removeAttr("disabled");
		$("#paket").removeAttr("disabled");
		$("#jenis_pemasangan").removeAttr("disabled");
		$("#tanggal_document").removeAttr("disabled");
		$("#tanggal_rencana_survei").removeAttr("disabled");
		$("#tanggal_pemasangan_mulai").removeAttr("disabled");
		$("#jumlah_hari_aktifasi").removeAttr("disabled");
		$("#tanggal_aktifasi").removeAttr("disabled");
		$("#keterangan").removeAttr("disabled");
		$("#dokumen").removeAttr("disabled");
		$("#jumlah_hari_aktifasi").removeAttr("disabled");
		var pilih_unit = $("#pilih_unit").val();
		if (pilih_unit != 'non_unit')
		{
			url = '<?=site_url(); ?>/transaksi_lain/p_registrasi_liaison_officer/lihat_unit';
			var pilih_unit = $("#pilih_unit").val();
			$.ajax({
				type: "post",
				url: url,
				data: {
					pilih_unit: pilih_unit
				},
				dataType: "json",
				success: function (data) {
					console.log(data);
					$(".unit").show();
					$(".non_unit").hide();
					$(".two").show();
					$("#project_name").val(data.project_name);
					$("#kawasan_name").val(data.kawasan_name);
					$("#blok_name").val(data.blok_name);
					$("#unit_name").val(data.no_unit);
					$("#luaslama").val(data.luas_bangunan);
					$("#customer_name").val(data.customer_name);
					$("#customer_id").val(data.customer_id);
					$("#type_unit").val('unit');
					$("#unit_id").val(data.unit_id);
					$("#nomor_va").val('0');
					$("#nomor_telepon").val(data.customer_homephone);
					$("#nomor_handphone").val(data.customer_mobilephone);
					$("#email").val(data.customer_email);
				}
			})

		} else if (pilih_unit == 'non_unit') {
			$(".unit").hide();
			$(".non_unit").show();
			$(".two").show();
			$("#type_unit").val('non_unit');

		}

	});

		$("#jenis_pemasangan").change(function () {
       
		var jenis_pemasangan = $("#jenis_pemasangan").val();

		if (jenis_pemasangan == '0')

		{

			$(".start").hide();

		var type_unit = $("#type_unit").val();

        if (type_unit == 'unit')
		{
			url = '<?=site_url(); ?>/transaksi_lain/p_registrasi_tvi/lihat_nomorreg_unit';
			var unit_id = $("#unit_id").val();
			//console.log(this.value);
			$.ajax({
				type: "post",
				url: url,
				data: {
					unit_id: unit_id
				},
				dataType: "json",
				success: function (data) {
					console.log(data);
     				$("#nomor_registrasi").val(data);
				}
			})
			url = '<?=site_url(); ?>/transaksi_lain/p_registrasi_tvi/lihat_aktifasi_unit';

			var unit_id = $("#unit_id").val();

			$.ajax({
				type: "post",
				url: url,
				data: {
					unit_id: unit_id
				},
				dataType: "json",
				success: function (data) {
					console.log(data);
     				$("#tanggal_aktifasi").val(data);
				}

			})

        }else if (type_unit == 'non_unit')

        {
            url = '<?=site_url(); ?>/transaksi_lain/p_registrasi_tvi/lihat_nomorreg_non_unit';


			var customer_id = $("#customer_id").val();
			//console.log(this.value);
			$.ajax({
				type: "post",
				url: url,
				data: {
					customer_id: customer_id
				},
				dataType: "json",
				success: function (data) {
					console.log(data);
     				$("#nomor_registrasi2").val(data);
				}


			})
			url = '<?=site_url(); ?>/transaksi_lain/p_registrasi_tvi/lihat_aktifasi_non_unit';


			var customer_id = $("#customer_id").val();


           	alert(customer_id);


			//console.log(this.value);
			$.ajax({
				type: "post",
				url: url,
				data: {
					customer_id: customer_id
				},
				dataType: "json",
				success: function (data) {
					console.log(data);


     				$("#tanggal_aktifasi").val(data);
				

				}

			})
        }
      
		} else if (jenis_pemasangan == '1') {

			$(".start").show();

		var type_unit = $("#type_unit").val();

        if (type_unit == 'unit')

		{
			
			$("#nomor_registrasi").val('Auto Generate');

		}
		else  if (type_unit == 'non_unit')
		{
            $("#nomor_registrasi2").val('Auto Generate');
		}
	}

	});

    $("#jenis_pemasangan").change(function () {

		// alert('tess');
       	var jenis_pemasangan = $("#jenis_pemasangan").val();
       	if (jenis_pemasangan == '0' )
       	{
           $("#harga_registrasi").val('0');
       	}
    });


	$("#customer_name2").change(function () {
		// alert('tess');
       	var customer = $("#customer_name2").val();
		var customer = customer.split('|');
		var pilih_customer = customer[0];
		url = '<?=site_url(); ?>/transaksi_lain/p_registrasi_tvi/lihat_customer';
		$.ajax({
			type: "post",
			url: url,
			data: {
				pilih_customer: pilih_customer
			},
			dataType: "json",
			success: function (data) {
				console.log(data);
				$("#nomor_telepon2").val(data.customer_homephone);
				$("#nomor_handphone2").val(data.customer_mobilephone);
				$("#email2").val(data.customer_email);
				$("#customer_id").val(data.customer_id);
			}
		});
	});

</script>
