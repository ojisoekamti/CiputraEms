<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link href="<?= base_url() ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<script src="<?= base_url() ?>vendors/select2/dist/js/select2.min.js"></script>


<!-- switchery -->
<link href="<?= base_url(); ?>vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<script src="<?= base_url(); ?>vendors/switchery/dist/switchery.min.js"></script>
<!-- date time picker -->
<script type="text/javascript" src="<?= base_url(); ?>vendors/moment/min/moment.min.js"></script>

<link href="<?= base_url(); ?>vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script type="text/javascript" src="<?= base_url(); ?>vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>


<!DOCTYPE html>
<div style="float:right">
	<h2>
		<button class="btn btn-warning" onClick="window.location.href='<?= site_url() ?>/transaksi_lain/P_registrasi_layanan_lain'">
			<i class="fa fa-arrow-left"></i>
			Back
		</button>
		<button class="btn btn-success" onClick="window.location.href='<?= site_url() ?>/transaksi_lain/P_registrasi_layanan_lain/edit?unit_id=<?= $this->input->get('unit_id') ?>'">
			<i class="fa fa-repeat"></i>
			Refresh
		</button>
	</h2>
</div>
<div class="clearfix"></div>
</div>
<div class="x_content">
	<br>
	<form id="form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="" method="post" action="<?= site_url() ?>/transaksi_lain/P_registrasi_layanan_lain/edit?id=<?= $this->input->get('id') ?>">
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" style="width: 14%">Unit</label>
			<div class="col-md-11 col-sm-9 col-xs-12" style="width: 85%">
				<select required="" id="unit" name="unit" class="form-control select2">
					<!-- <option value="" selected="" disabled="">--Pilih Unit-- ( Kawasan - Blok - No Unit )</option>
					<option value="non_unit">--Non Unit--</option> -->
					<?php
					foreach ($dataUnit as $v) {
						if ($data_detail_service[0]->unit_id == $v['id'])
							echo ("<option value='$v[id]'>$v[kawasan_name] - $v[blok_name] - $v[no_unit]</option>");
					}
					?>
				</select>
			</div>
		</div>
		<div class="clear-fix"></div>
		<br>
		<div id="data_unit" class="col-md-4 col-xs-12">
			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">Tipe Unit</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<input id="bangunan_type" type="text" class="form-control" name="bangunan_type" value="" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">No. Registrasi</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<input id="nomor_registrasi" type="text" class="form-control" required name="nomor_registrasi" value="<?= $no_regis ?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">Luas Tanah (m2)</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<input id="unit_luas_tanah" type="text" class="form-control" required name="unit_luas_tanah" value="" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">Luas Bangunan (m2)</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<input id="unit_luas_bangunan" type="text" class="form-control" required name="unit_luas_bangunan" value="" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">Luas Taman (m2)</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<input id="unit_luas_taman" type="text" class="form-control" required name="unit_luas_taman" value="" readonly>
				</div>
			</div>

		</div>

		<div id="pemilik" class="col-md-4 col-xs-12">

			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">Kode Pemilik</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<input id="pemilik_kode" type="text" class="form-control" required name="pemilik_kode" value="" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">Pemilik</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<input id="pemilik_nama" type="text" class="form-control" required name="pemilik_nama" value="" readonly>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">Mobile Phone</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<input id="pemilik_mobile_phone" type="text" class="form-control" required name="pemilik_mobile_phone" value="" readonly>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">Home Phone</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<input id="pemilik_home_phone" type="text" class="form-control" required name="pemilik_home_phone" value="" readonly>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">Email</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<input id="pemilik_email" type="text" class="form-control" required name="pemilik_email" value="" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">Alamat</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<textarea id="pemilik_alamat" type="text" class="form-control" required name="pemilik_alamat" readonly>
					</textarea>
				</div>
			</div>
		</div>
		<div id="penghuni" class="col-md-4 col-xs-12">
			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">Kode Penghuni</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<input id="penghuni_kode" type="text" class="form-control" required name="penghuni_kode" value="" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">Penghuni</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<input id="penghuni_nama" type="text" class="form-control" required name="penghuni_nama" value="" readonly>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">Mobile Phone</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<input id="penghuni_mobile_phone" type="text" class="form-control" required name="penghuni_mobile_phone" value="" readonly>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">Home Phone</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<input id="penghuni_home_phone" type="text" class="form-control" required name="penghuni_home_phone" value="" readonly>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">Email</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<input id="penghuni_email" type="text" class="form-control" required name="penghuni_email" value="" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-5 col-sm-4 col-xs-12">Alamat</label>
				<div class="col-md-7 col-sm-8 col-xs-12">
					<textarea id="penghuni_alamat" type="text" class="form-control" required name="penghuni_alamat" readonly>
					</textarea>
				</div>
			</div>
		</div>


		<div id="data_registrasi" class="col-md-12 col-xs-12">
			<div class="x_title" style="margin-top:20px">
				<h2>Service</h2>
				<div class="clearfix"></div>
			</div>
			<div class="accordion kumpulan-form" id="accordion" role="tablist" aria-multiselectable="true">
				<?php
				$i = 1;
				foreach ($data_detail_service as $detail) :
						// echo($detail->kuantitas);
						?>
						<div class="panel form_untuk_service">
							<h4 class="panel-title col-md 10"> Form <?php echo ($i) ?> <button id='' type="button" class="btn btn-danger btn-xs pull-right btn-delete-service" style="padding-bottom:5px"><i class="fa fa-trash"></i> Delete </button></h4>
							<div class="panel-body service_form">
								<div class="col-md-12 col-xs-12">
									<div class="col-md-12">
										<div class="form-group col-md-6">
											<label class="control-label col-md-3 col-sm-4 col-xs-12" style="padding-left:0;">Service</label>
											<div class="col-md-9 col-sm-8 col-xs-12">
												<select id="service-1" class="service form-control select2" value="0" name="service_id[]" disabled>
													<?php
													echo ("<option selected disabled>-- Pilih Service --</option>");
													foreach ($dataService as $v) {
														if ($detail->service_id == $v->id) {
															echo ("<option value=" . $v->id . " selected>" . $v->name . "</option>");
														} else {
															echo ("<option value=" . $v->id . ">" . $v->name . "</option>");
														}
													}
													?>
												</select>
											</div>
										</div>
										<div class="form-group col-md-6">
											<label class="control-label col-md-3 col-sm-4 col-xs-12" style="padding-left:0;">Paket Service</label>
											<div class="col-md-9 col-sm-8 col-xs-12">
												<select id="paket-service-1" class="paket-service form-control select2" name="paket_service_id[]" disabled>
													<?php
													echo ("<option selected disabled>-- Pilih Paket Service --</option>");
													foreach ($data_paket_service as $v) {
														if ($detail->paket_service_id == $v->id) {
															echo ("<option value=" . $v->id . " selected>" . $v->name . "</option>");
														} else {
															echo ("<option value=" . $v->id . ">" . $v->name . "</option>");
														}
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group col-md-6">
											<label class="control-label col-md-3 col-sm-12 col-xs-12" style="padding-left:0;">Periode <br> Awal - Akhir</label>
											<div class="col-md-2 col-sm-12 col-xs-12">
												<input type="" id="periode-awal-1" class="form-control datetimepicker_month hitung-periode periode-awal" name="periode_awal[]" value="<?= $detail->periode_awal ?>" disabled>
											</div>
											<div class="col-md-2 col-sm-12 col-xs-12">
												<input type='' id='periode-akhir-1' class='form-control datetimepicker_month hitung-periode periode-akhir' name='periode_akhir[]' value="<?= $detail->periode_akhir ?>" disabled>
												<?php
												$diff = abs(strtotime($detail->periode_awal) - strtotime($detail->periode_akhir));

												$years = floor($diff / (365 * 60 * 60 * 24));
												$months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
												?>
											</div>
											<label class="control-label col-md-2 col-sm-12 col-xs-12" style="padding-left:0;">Jumlah Periode (Bulan)</label>
											<div class="col-md-3 col-sm-12 col-xs-12">
												<input type='' id='' class='form-control jumlah-periode' name='jumlah_periode[]' value="<?= $months + ($years * 12) + 1 ?>" readonly>
											</div>
										</div>
										<div class="form-group col-md-6">
											<label class="control-label col-md-3 col-sm-12 col-xs-12" style="padding-left:0;"> Minimun Berlangganan<br>(Bulan)</label>
											<div class="col-md-4 col-sm-12 col-s-12">
												<input type='' id='' class='form-control minimal-langganan' name='minimal_berlangganan[]' value="<?= $detail->minimal_langganan ?>" disabled>
											</div>
											<label class="control-label col-md-2 col-sm-12 col-xs-12" style="padding-left:0;"> Status <br> Berlangganan</label>
											<div class="col-md-3 col-sm-12 col-xs-12">
												<input type='' id='' class='form-control status-berlangganan' name='status_berlangganan[]' value="<?= $detail->status_berlangganan == 0 ? 'Non Berlangganan' : 'Berlangganan' ?>" readonly>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div id="view_biaya_pemasangan">
											<div class="form-group col-md-6">
												<label class="control-label col-md-3 col-sm-12 col-xs-12">Biaya Pemasangan</label>
												<div class="col-md-3 col-sm-12 col-xs-12">
													<div class="">
														<label>
															<input id="" type="checkbox" class="js-switch biaya-pemasangan-aktif " name="biaya_pemasangan_aktif[]" value='' <?= $detail->biaya_pemasangan_flag == 1 ? 'checked' : ''; ?>> Aktif
														</label>
													</div>
												</div>
												<div class="col-md-6 col-sm-12 col-xs-12">
													<input id="" name="" required="" value="<?= $detail->active == 1 ? $detail->biaya_pemasangan : ''; ?>" readonly class="form-control biaya-pemasangan-aktif col-md-1 col-xs-12 currency">
												</div>
											</div>
										</div>
										<div class="form-group col-md-6">
											<label class="control-label col-md-3 col-sm-12 col-xs-12" style="padding-left:0;">Tagihan Bulan - 1 (Rp.) </label>
											<div class="col-md-9 col-sm-12 col-xs-12">
												<input id="" type="text" class="harga-bulan-pertama form-control" name="harga_bulan_pertama[]" 
												value="<?= 
													(($detail->biaya_satuan) * ($detail->kuantitas)) + ($detail->biaya_registrasi) + $detail->biaya_pemasangan
												?>" readonly style='text-align: right'>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group col-md-6">
											<label class="control-label col-md-3 col-sm-12 col-xs-12" style="padding-left:0;">Volume</label>
											<div class="col-md-4 col-sm-12 col-s-12">
												<input id='kuantitas' class='jumlah-satuan form-control' name='kuantitas[]' value="<?= $detail->kuantitas ?>" disabled>
											</div>
											<label class="control-label col-md-2 col-sm-12 col-xs-12" style="padding-left:0;">Satuan</label>
											<div class="col-md-3 col-sm-12 col-xs-12">
												<input id='' class='satuan form-control' name='satuan[]' value="<?= $detail->satuan ?>" readonly style='text-align: center'>
											</div>
										</div>
										<div class="form-group col-md-6">
											<label class="control-label col-md-3 col-sm-12 col-xs-12" style="padding-left:0;">Tagihan Bulan Selanjutnya (Rp.)</label>
											<div class="col-md-9 col-sm-12 col-xs-12">
												<input id="" type="text" class="harga-bulanan form-control" name="harga_bulanan[]" value="<?= $months + ($years * 12) + 1  == 1 ? '' : (($months + ($years * 12) + 1 < ($detail->minimal_langganan)) ? ((($detail->biaya_satuan) * ($detail->kuantitas)) + ($detail->biaya_registrasi)) : ((($detail->harga_satuan) * ($detail->kuantitas))))?>" readonly style='text-align: right'>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group col-md-6">
											<label class="control-label col-md-3 col-sm-12 col-xs-12" style="padding-left:0;">Bea Registrasi (Rp.)</label>
											<div class="col-md-4 col-sm-12 col-xs-12">
												<input id="" type="text" class="harga-registrasi form-control" name="biaya_registrasi[]" value="<?= $detail->biaya_registrasi ?>" readonly style='text-align: right'>
											</div>
											<label class="control-label col-md-2 col-sm-12 col-xs-12" style="padding-left:0;">Harga Satuan (Rp.)</label>
											<div class="col-md-3 col-sm-12 col-xs-12">
												<input id="" type="text" class="harga-satuan form-control" name="harga_satuan[]" value="<?= $months + ($years * 12) + 1 < ($detail->minimal_langganan) ? ($detail->biaya_satuan) : ($detail->harga_satuan) ?>" readonly style='text-align: right'>
											</div>
										</div>
										<div class="form-group col-md-6">
											<label class="control-label col-md-3 col-sm-12 col-xs-12" style="padding-left:0;">Total Tagihan (Rp.)</label>
											<div class="col-md-9 col-sm-12 col-xs-12">
												<input id="total" type="text" class="total form-control" name="total[]" value="<?= $months + ($years * 12) + 1 < ($detail->minimal_langganan) ? ((($detail->biaya_satuan) * ($detail->kuantitas)) + ($detail->biaya_registrasi)) * ($months + ($years * 12) + 1)  : (((($detail->harga_satuan) * ($detail->kuantitas))) * ($months + ($years * 12) + 1)) + ($detail->biaya_registrasi) ?>" readonly style='text-align: right'>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php
			$i++;
		endforeach;
		?>
		</div>
</div>
<button id='btn-add-service' type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>Add Service</button>
<div class="col-md-12 col-xs-12">
	<div class="center-margin">
		<button class="btn btn-primary" type="reset">Reset</button>
		<button type="submit" class="btn btn-success">Submit</button>
		<!-- <button type="btn-update" class="btn btn-success" value="Edit">Edit</button> -->

		<input id="btn-update" class="btn btn-success col-md-3 col-md-offset-5" value="Edit">
		<input id="btn-cancel" class="btn btn-danger col-md-3" value="Cancel" style="display:none">
	</div>



	</form>
</div>
</div>

<script type="text/javascript">
	disableForm = 1;
	$(".select2").select2();

	$(function() {
		$("#btn-update").click(function() {
			disableForm = 0;
			$(".disabled-form").removeAttr("disabled");
			$("#btn-cancel").removeAttr("style");
			$("#btn-update").val("Update");
			$("#btn-update").attr("type", "submit");
		});
		$("#btn-cancel").click(function() {
			disableForm = 1;
			$(".disabled-form").attr("disabled", "")
			$("#btn-cancel").attr("style", "display:none");
			$("#btn-update").val("Edit")
			$("#btn-update").removeAttr("type");
		});
	});



	// <script type="text/javascript">

	// 	var tmp_service = "<tr id='row-1'>";
	// 	var form = $(".form_untuk_service")[0].outerHTML;

	// 	const item_struct = $(".form_untuk_service");
	// 	const a = item_struct[0].outerHTML;


	//  $("#tbody_service").append(tmp_service);
	//     function currency(input) {
	// 		var input = input.toString().replace(/[\D\s\._\-]+/g, "");
	// 		input = input ? parseInt(input, 10) : 0;
	// 		return (input === 0) ? "" : input.toLocaleString("en-US");
	// 	}


	$(function() {
		url = '<?= site_url(); ?>/transaksi_lain/P_registrasi_layanan_lain/get_pemilik_penghuni';
		var id = $("#unit").val();
		//console.log(this.value);
		$.ajax({
			type: "post",
			url: url,
			data: {
				id: id
			},
			dataType: "json",
			success: function(data) {
				console.log(data);
				$("#pemilik_email").val(data.pemilik_email);
				$("#pemilik_home_phone").val(data.pemilik_home_phone);
				$("#pemilik_kode").val(data.pemilik_kode);
				$("#pemilik_mobile_phone").val(data.pemilik_mobile_phone);
				$("#pemilik_nama").val(data.pemilik_nama);
				$("#pemilik_alamat").html(data.pemilik_alamat);
				$("#penghuni_email").val(data.penghuni_email);
				$("#penghuni_home_phone").val(data.penghuni_home_phone);
				$("#penghuni_kode").val(data.penghuni_kode);
				$("#penghuni_mobile_phone").val(data.penghuni_mobile_phone);
				$("#penghuni_nama").val(data.penghuni_nama);
				$("#penghuni_alamat").html(data.penghuni_alamat);

				$("#unit_luas_tanah").val(data.luas_tanah);
				$("#unit_luas_bangunan").val(data.luas_bangunan);
				$("#unit_luas_taman").val(data.luas_taman);

			}
		});
		$('.datetimepicker_month').datetimepicker({
			viewMode: 'years',
			format: 'YYYY/MM'
		});

		$("#btn-add-service").click(function() {
			no_service++;
			$("#tbody_service").append(tmp_service);
			$(".no").last().val(no_service);
			$('.datetimepicker_month').datetimepicker({
				viewMode: 'years',
				format: 'YYYY/MM'
			});
		});
		$("#tbody_service").on("click", ".delete", function() {
			console.log('delete');
			$(this).parent().parent().remove();
		});
		$("#tbody_service").on("change", ".service", function() {
			console.log("haha");
			// $(".service").change(function(){
			url = '<?= site_url(); ?>/transaksi_lain/P_registrasi_layanan_lain/get_paket_service';
			var thisRow = $(this);
			var id = thisRow.val();

			$.ajax({
				type: "post",
				url: url,
				data: {
					id: id
				},
				dataType: "json",
				success: function(data) {
					thisRow.parent().parent().children().children(".paket-service").html('');
					thisRow.parent().parent().children().children(".paket-service").append("<option selected disabled>-- Pilih Paket Service --</option>");
					data.forEach(v => {
						thisRow.parent().parent().children().children(".paket-service").append("<option value='" + v.id + "'>" + v.name + "</option>");
					});
				}
			});
		});
		$("#tbody_service").on("change", ".paket-service", function() {
			url = '<?= site_url(); ?>/transaksi_lain/P_registrasi_layanan_lain/get_info_paket_service';
			var thisRow = $(this);
			var id = thisRow.val();

			$.ajax({
				type: "post",
				url: url,
				data: {
					id: id
				},
				dataType: "json",
				success: function(data) {
					console.log(data);
					console.log(thisRow);
					thisRow.parent().parent().children().children(".jumlah-satuan").val(1);
					thisRow.parent().parent().children().children(".satuan").val(data.satuan);
					thisRow.parent().parent().children().children(".harga-satuan").val(data.harga);
					thisRow.parent().parent().children().children(".harga-registrasi").val(data.biaya_registrasi);
					thisRow.parent().parent().children().children(".total").val(data.harga + data.biaya_registrasi);


				}
			});
		});
		$('.select2').select2();

	});


	$("#service").change(function() {
		url = '<?= site_url(); ?>/transaksi_lain/P_registrasi_layanan_lain/get_paket';
		var id = $("#service").val();
		//console.log(this.value);
		$.ajax({
			type: "post",
			url: url,
			data: {
				id: id
			},
			dataType: "json",
			success: function(data) {
				console.log(data);
				$("#paket").html("");
				$("#paket").append("<option value='' disabled selected>-- Pilih Paket --</option>");
				data.forEach(v => {
					$("#paket").append("<option value='" + v.id + "'>" + v.name + "</option>");
				});
			}
		});
	});
	$("#paket").change(function() {
		url = '<?= site_url(); ?>/transaksi_lain/P_registrasi_layanan_lain/get_harga_paket';
		var id = $("#paket").val();
		console.log(id);
		$("#tagihan_total").val("");
		$.ajax({
			type: "post",
			url: url,
			data: {
				id: id
			},
			dataType: "json",
			success: function(data) {
				console.log(data);
				$("#tagihan_total").val(currency(data.harga));
			}
		});
	});
</script>