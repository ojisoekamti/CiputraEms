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
		<button class="btn btn-success" onClick="window.location.href='<?= site_url() ?>/transaksi_lain/P_registrasi_layanan_lain/add'">
			<i class="fa fa-repeat"></i>
			Refresh
		</button>
	</h2>
</div>
<div class="clearfix"></div>
</div>
<div class="x_content">
	<br>
	<form id="form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="" method="post" action="<?= site_url() ?>/transaksi_lain/P_registrasi_layanan_lain/save">
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" style="width: 14%">Unit</label>
			<div class="col-md-11 col-sm-9 col-xs-12" style="width: 85%">
				<select required="" id="unit" name="unit" class="form-control select2">
					<option value="" selected="" disabled="">--Pilih Unit-- ( Kawasan - Blok - No Unit )</option>
					<!-- <option value="non_unit">--Non Unit--</option> -->
					<?php
					foreach ($dataUnit as $v) {
						echo ("<option value='$v[id]' ");
						echo ($v["telah_registrasi"] == 1 ? "disabled>" : ">");
						echo ("$v[kawasan_name] - $v[blok_name] - $v[no_unit]");
						echo ($v["telah_registrasi"] == 1 ? " Telah Registrasi" : "");
						echo ("</option>");
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
				<div class="panel form_untuk_service">
					<h4 class="panel-title col-md 10"> Form 1 <button id='' type="button" class="btn btn-danger btn-xs pull-right btn-delete-service" style="padding-bottom:5px"><i class="fa fa-trash"></i> Delete </button></h4>
					<div class="panel-body service_form">
						<div class="col-md-12 col-xs-12">
							<div class="col-md-12">
								<div class="form-group col-md-6">
									<label class="control-label col-md-3 col-sm-4 col-xs-12" style="padding-left:0;">Service</label>
									<div class="col-md-9 col-sm-8 col-xs-12">
										<select id="service-1" class="service form-control select2" value="0" name="service_id[]">"
											<?php
											echo ("<option selected disabled>-- Pilih Service --</option>");
											foreach ($dataService as $v) {
												echo ("<option value=" . $v->id . ">" . $v->name . "</option>");
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group col-md-6">
									<label class="control-label col-md-3 col-sm-4 col-xs-12" style="padding-left:0;">Paket Service</label>
									<div class="col-md-9 col-sm-8 col-xs-12">
										<select id="paket_service-1" class="paket-service form-control select2" name="paket_service_id[]" disabled>
											<option selected disabled>-- Pilih Paket Service --</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group col-md-6">
									<label class="control-label col-md-3 col-sm-12 col-xs-12" style="padding-left:0;">Periode <br> Awal - Akhir</label>
									<div class="col-md-2 col-sm-12 col-xs-12">
										<input type="" id="periode-awal-1" class="paket_service_form-1 form-control datetimepicker_month hitung-periode periode-awal" name="periode_awal[]" disabled>
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12">
										<input type='' id='periode-akhir-1' class='paket_service_form-1 form-control datetimepicker_month hitung-periode periode-akhir' name='periode_akhir[]' value="" disabled>
									</div>
									<label class="control-label col-md-2 col-sm-12 col-xs-12" style="padding-left:0;">Jumlah Periode (Bulan)</label>
									<div class="col-md-3 col-sm-12 col-xs-12">
										<input type='' id='' class='form-control jumlah-periode' name='jumlah_periode[]' value="" readonly>
									</div>
								</div>
								<div class="form-group col-md-6">
									<label class="control-label col-md-3 col-sm-12 col-xs-12" style="padding-left:0;"> Minimun Berlangganan<br>(Bulan)</label>
									<div class="col-md-4 col-sm-12 col-s-12">
										<input type='' id='' class='form-control minimal-langganan' name='minimal_berlangganan[]' value='' readonly>
									</div>
									<label class="control-label col-md-2 col-sm-12 col-xs-12" style="padding-left:0;"> Status <br> Berlangganan</label>
									<div class="col-md-3 col-sm-12 col-xs-12">
										<input type='' id='' class='form-control status-berlangganan' name='status_berlangganan[]' value='' readonly>
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
													<input id="biaya_pemasangan_id_1" type="checkbox" class="paket_service_form-1 js-switch biaya-pemasangan-aktif" name="biaya_pemasangan_aktif[]" value='' disabled> Aktif
												</label>
											</div>
										</div>
										<div class="col-md-6 col-sm-12 col-xs-12">
											<input id="" name="biaya_pemasangan[]" required="" value="" readonly class="form-control biaya-pemasangan-aktif col-md-1 col-xs-12 currency">
										</div>
									</div>
								</div>
								<div class="form-group col-md-6">
									<label class="control-label col-md-3 col-sm-12 col-xs-12" style="padding-left:0;">Tagihan Bulan - 1 (Rp.) </label>
									<div class="col-md-9 col-sm-12 col-xs-12">
										<input id="" type="text" class="harga-bulan-pertama form-control" name="harga_bulan_pertama[]" value="" readonly style='text-align: right'>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group col-md-6">
									<label class="control-label col-md-3 col-sm-12 col-xs-12" style="padding-left:0;">Volume</label>
									<div class="col-md-4 col-sm-12 col-s-12">
										<input id='kuantitas' class='paket_service_form-1 jumlah-satuan form-control' name='kuantitas[]' disabled>
									</div>
									<label class="control-label col-md-2 col-sm-12 col-xs-12" style="padding-left:0;">Satuan</label>
									<div class="col-md-3 col-sm-12 col-xs-12">
										<input id='' class='satuan form-control' name='satuan[]' readonly style='text-align: center'>
									</div>
								</div>
								<div class="form-group col-md-6">
									<label class="control-label col-md-3 col-sm-12 col-xs-12" style="padding-left:0;">Tagihan Bulan Selanjutnya (Rp.)</label>
									<div class="col-md-9 col-sm-12 col-xs-12">
										<input id="" type="text" class="harga-bulanan form-control" name="harga_bulanan[]" value="" readonly style='text-align: right'>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group col-md-6">
									<label class="control-label col-md-3 col-sm-12 col-xs-12" style="padding-left:0;">Bea Registrasi (Rp.)</label>
									<div class="col-md-4 col-sm-12 col-xs-12">
										<input id="" type="text" class="harga-registrasi form-control" name="biaya_registrasi[]" value="" readonly style='text-align: right'>
									</div>
									<label class="control-label col-md-2 col-sm-12 col-xs-12" style="padding-left:0;">Harga Satuan (Rp.)</label>
									<div class="col-md-3 col-sm-12 col-xs-12">
										<input id="" type="text" class="harga-satuan form-control" name="harga_satuan[]" value="" readonly style='text-align: right'>
									</div>
								</div>
								<div class="form-group col-md-6">
									<label class="control-label col-md-3 col-sm-12 col-xs-12" style="padding-left:0;">Total Tagihan (Rp.)</label>
									<div class="col-md-9 col-sm-12 col-xs-12">
										<input id="total" type="text" class="total form-control" name="total[]" value="" readonly style='text-align: right'>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
<button id='btn-add-service' type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>Add Service</button>
<div class="col-md-12 col-xs-12">
	<div class="center-margin">
		<button class="btn btn-primary" type="reset">Reset</button>
		<button type="submit" class="btn btn-success">Submit</button>


		</form>
	</div>
</div>

<script type="text/javascript">
	var no_service = 1;
	var form = $(".form_untuk_service")[0].outerHTML;

	const item_struct = $(".form_untuk_service");
	const a = item_struct[0].outerHTML;

	function currency(input) {
		var input = input.toString().replace(/[\D\s\._\-]+/g, "");
		input = input ? parseInt(input, 10) : 0;
		return (input === 0) ? "" : input.toLocaleString("en-US");
	}

	function diffDate(m1, y1, m2, y2) {
		return (((parseInt(y2) - parseInt(y1)) * 12) + (parseInt(m2) - parseInt(m1)));
	}

	//id_paket_service = array
	function disabled_paket_service() {
		paket_service_id = [];
		$.each($('.paket-service'), function(key, tmp) {
			if (tmp.value != '-- Pilih Paket Service --')
				paket_service_id.push(tmp.value);
		});

		$(".paket-service>option").attr('disabled', false);

		$.each(paket_service_id, function(key, value) {
			// console.log($(".paket-service")[key].value);
			// console.log(value);
			$(".paket-service>option[value=" + value + "]").attr('disabled', true);

		});
		$.each(paket_service_id, function(key, value) {
			for (index = 0; index < $(".paket-service").length; index++) {
				if ($(".paket-service")[index].value == value) {
					$(".paket-service").eq(index).children("option[value=" + value + "]").attr('disabled', false)
					// console.log($(".paket-service")[index].value +" - "+value);
					// console.log(index +" - "+value);
					// console.log($(".paket-service"));
				}
			}
		});
		$(".select2").select2();
		// 	$.each($('.paket-service'),function(key,tmp){
		// })
	}

	$(function() {

		$("body").on('change', '.paket-service', function() {
			disabled_paket_service();
			console.log($(this));
			var index = $(this).attr('id');
			index = parseInt(index.substr(index.indexOf('-') + 1));
			$(".paket_service_form-" + index).attr('disabled', false);
		});

		$(document).on('dp.change', ".hitung-periode", function() {
			url = '<?= site_url(); ?>/transaksi_lain/P_registrasi_layanan_lain/get_info_paket_service';
			var parent = $(this).parents(".service_form");
			var id = parent.find(".paket-service").val();
			m1 = parent.find(".periode-awal").val().substr(0, 2);
			y1 = parent.find(".periode-awal").val().substr(3, 4);
			m2 = parent.find(".periode-akhir").val().substr(0, 2);
			y2 = parent.find(".periode-akhir").val().substr(3, 4);
			// minimal_berlangganan = parent.find(".minimal-langganan").val(data.minimal_langganan);
			$.ajax({
				type: "post",
				url: url,
				data: {
					id: id
				},
				dataType: "json",
				success: function(data) {
					console.log(data);
					hasil = diffDate(m1, y1, m2, y2);
					parent.find(".jumlah-periode").val(hasil ? hasil + 1 : 1);
					if (parent.find(".jumlah-periode").val() < parent.find(".minimal-langganan").val()) {
						console.log('a');
						if (parent.find(".jumlah-periode").val() == 1) {
							parent.find(".status-berlangganan").val('Non Berlangganan');
							parent.find(".harga-satuan").val(data.biaya_satuan_tanpa_registrasi);
							parent.find(".harga-bulan-pertama").val((parseInt(parent.find(".harga-satuan").val())) + (parseInt($(".harga-registrasi").val())));
							parent.find(".harga-bulanan").val('');

							harga_total = (parseInt(parent.find(".jumlah-satuan").val()?parent.find(".jumlah-satuan").val():0) * (parseInt(parent.find(".harga-satuan").val()))) + (parseInt($(".harga-registrasi").val()));
							parent.find(".total").val(harga_total);
						} else {
							parent.find(".status-berlangganan").val('Non Berlangganan');
							parent.find(".harga-satuan").val(data.biaya_satuan_tanpa_registrasi);
							parent.find(".harga-bulan-pertama").val((parseInt(parent.find(".harga-satuan").val())) + (parseInt($(".harga-registrasi").val())));
							parent.find(".harga-bulanan").val((parseInt(parent.find(".harga-satuan").val())) + (parseInt($(".harga-registrasi").val())));
							harga_total = (parseInt(parent.find(".harga-bulanan").val()) * (parseInt(parent.find(".jumlah-periode").val())));
							parent.find(".total").val(harga_total);
						}
					} else if (parent.find(".jumlah-periode").val() >= parent.find(".minimal-langganan").val()) {
						console.log('b');
						parent.find(".status-berlangganan").val('Berlangganan');
						parent.find(".harga-satuan").val(data.harga);
						parent.find(".harga-bulan-pertama").val((parseInt(parent.find(".harga-satuan").val())) + (parseInt($(".harga-registrasi").val())));
						parent.find(".harga-bulanan").val(parseInt(parent.find(".harga-satuan").val()));
						harga_total = (parseInt(parent.find(".harga-bulanan").val()) * (parseInt(parent.find(".jumlah-periode").val()))) + (parseInt($(".harga-registrasi").val()));
						parent.find(".total").val(harga_total);
					}

					// parent.find(".harga-bulan-pertama").val((parseInt(parent.find(".harga-satuan").val())) + (parseInt($(".harga-registrasi").val())));
					// harga_total = (parseInt(parent.find(".harga-bulanan").val()) * (parseInt(parent.find(".jumlah-periode").val()))) + (parseInt($(".harga-registrasi").val()));
					// parent.find(".total").val(harga_total);

				}
			});



		});




		$("#berlangganan_aktif").change(function(data) {
			if ($("#berlangganan_aktif").is(':checked')) {
				$("#berlangganan").attr('disabled', false);

			} else {
				$("#berlangganan").attr('disabled', true);
				$("#berlangganan").val('0');
			}
		});


		$('.datetimepicker_month').datetimepicker({
			viewMode: 'years',
			format: 'MM/YYYY'
		});

		$("#btn-add-service").click(function() {
			no_service++;
			tmp = a.replace('Form 1', 'Form ' + no_service);
			tmp = tmp.replace(/service-1/g, 'service-' + no_service);
			tmp = tmp.replace(/paket-service-1/g, 'paket-service-' + no_service);
			tmp = tmp.replace(/periode-awal-1/g, 'periode-awal-' + no_service);
			tmp = tmp.replace(/periode-akhir-1/g, 'periode-akhir-' + no_service);
			tmp = tmp.replace(/biaya_pemasangan_aktif-1/g, 'biaya_pemasangan_aktif_' + no_service);
			tmp = tmp.replace(/biaya_pemasangan_id_1/g, 'biaya_pemasangan_id_' + no_service);
			tmp = tmp.replace(/biaya_pemasangan_aktif\[0/g, "biaya_pemasangan_aktif\[" + (no_service - 1));
			tmp = tmp.replace(/paket_service_form-1/g, 'paket_service_form-' + no_service);


			$(".kumpulan-form").append(tmp);

			Switchery($('#biaya_pemasangan_id_' + no_service)[0]);
			$('.datetimepicker_month').datetimepicker({
				viewMode: 'years',
				format: 'MM/YYYY'
			});
			$('.select2').select2();
		});
		// $("#btn-delete-service").click(function() {
		$(document).on("click", ".btn-delete-service", function() {
			var parent = $(this).parents(".form_untuk_service");
			parent.remove();
			i = 0;
			$(".form_untuk_service").each(function() {
				i++;
			});
			// console.log('delete-service');
			// no_service--;
			// var numItems = $('.no').length;
			// console.log(numItems);
			// $(this).parent().parent().remove();
		});
		$(document).on("change", ".service", function() {

			var index = $(this).attr('id');
			index = parseInt(index.substr(index.indexOf('-') + 1));
			$("#paket_service-" + index).attr("disabled", false);

			url = '<?= site_url(); ?>/transaksi_lain/P_registrasi_layanan_lain/get_paket_service';
			var thisRow = $(this);
			var id = thisRow.val();
			var parent = $(this).parents(".service_form");
			$.ajax({
				type: "post",
				url: url,
				data: {
					id: id
				},
				dataType: "json",
				success: function(data) {
					// console.log(data);
					parent.find(".paket-service").html('');
					parent.find(".paket-service").append("<option disabled selected >-- Pilih Paket Service --</option>");
					data.forEach(v => {
						parent.find(".paket-service").append("<option value='" + v.id + "'>" + v.name + "</option>");
					});
				}
			});
		});

		$(document).on("change", ".jumlah-periode", function() {
			console.log($(this));
			url = '<?= site_url(); ?>/transaksi_lain/P_registrasi_layanan_lain/get_info_paket_service';
			var parent = $(this).parents(".service_form");
			var id = parent.find(".paket-service").val();

			$.ajax({
				type: "post",
				url: url,
				data: {
					id: id
				},
				dataType: "json",
				success: function(data) {
					console.log($(this).val());
					// console.log(data.biaya_satuan_tanpa_registrasi);
					// console.log(data.harga);
				}
			});
		});

		$(document).on("change", ".paket-service", function() {
			url = '<?= site_url(); ?>/transaksi_lain/P_registrasi_layanan_lain/get_info_paket_service';
			var thisRow = $(this);
			var id = thisRow.val();
			var parent = $(this).parents(".service_form");

			$.ajax({
				type: "post",
				url: url,
				data: {
					id: id
				},
				dataType: "json",
				success: function(data) {
					// console.log(data);
					// console.log(thisRow);
					// parent.find(".jumlah-satuan").val(1);
					parent.find(".satuan").val(data.satuan);
					parent.find(".harga-satuan").val(data.harga);
					parent.find(".harga-registrasi").val(data.biaya_registrasi);
					parent.find(".harga-bulan-pertama").val(data.harga + data.biaya_registrasi);
					parent.find(".minimal-langganan").val(data.minimal_langganan);
					// parent.find(".pemasangan").val(data.biaya_pemasangan);
					// parent.find(".harga-bulanan").val(data.harga);
					parent.find(".total").val(data.harga + data.biaya_registrasi);
				}
			});
		});

		$(document).on('change', ".biaya-pemasangan-aktif", function() {
			url = '<?= site_url(); ?>/transaksi_lain/P_registrasi_layanan_lain/get_info_paketservice';
			var parent = $(this).parents(".service_form");
			var id = parent.find(".paket-service").val();
			console.log(id);
			$.ajax({
				type: "post",
				url: url,
				data: {
					id: id
				},
				dataType: "json",
				success: function(data) {
					console.log(data.biaya_pemasangan);
					if (parent.find(".biaya-pemasangan-aktif").is(':checked')) {
						parent.find(".biaya-pemasangan-aktif").val(data.biaya_pemasangan);
						parent.find(".jumlah-periode").val(hasil ? hasil + 1 : 1);
						if (parent.find(".jumlah-periode").val() < parent.find(".minimal-langganan").val()) {
							if (parent.find(".jumlah-periode").val() == 1) {
								parent.find(".status-berlangganan").val('Non Berlangganan');
								parent.find(".harga-satuan").val(data.biaya_satuan_tanpa_registrasi);
								parent.find(".harga-bulan-pertama").val((parseInt(parent.find(".harga-satuan").val())) + (parseInt($(".harga-registrasi").val())) +
									(parseInt(parent.find(".biaya-pemasangan-aktif").val())));
								harga_total = (parseInt(parent.find(".jumlah-satuan").val()?parent.find(".jumlah-satuan").val():0) * (parseInt(parent.find(".harga-satuan").val()))) + (parseInt($(".harga-registrasi").val())) +
									(parseInt(parent.find(".biaya-pemasangan-aktif").val()));
								parent.find(".total").val(harga_total);
							} else {
								parent.find(".status-berlangganan").val('Non Berlangganan');
								parent.find(".harga-satuan").val(data.biaya_satuan_tanpa_registrasi);
								parent.find(".harga-bulan-pertama").val((parseInt(parent.find(".harga-satuan").val())) + (parseInt($(".harga-registrasi").val())) +
									(parseInt(parent.find(".biaya-pemasangan-aktif").val())));
								parent.find(".harga-bulanan").val((parseInt(parent.find(".harga-satuan").val())) + (parseInt($(".harga-registrasi").val())));
								harga_total = (parseInt(parent.find(".harga-bulanan").val()) * (parseInt(parent.find(".jumlah-periode").val()))) + (parseInt(parent.find(".biaya-pemasangan-aktif").val()));
								parent.find(".total").val(harga_total);
							}
						} else if (parent.find(".jumlah-periode").val() >= parent.find(".minimal-langganan").val()) {
							parent.find(".status-berlangganan").val('Berlangganan');
							parent.find(".harga-satuan").val(data.harga);
							parent.find(".harga-bulan-pertama").val((parseInt(parent.find(".harga-satuan").val())) + (parseInt($(".harga-registrasi").val())) + (parseInt(parent.find(".biaya-pemasangan-aktif").val())));
							parent.find(".harga-bulanan").val((parseInt(parent.find(".harga-satuan").val())) + (parseInt($(".harga-registrasi").val())));
							harga_total = (parseInt(parent.find(".harga-bulanan").val()) * (parseInt(parent.find(".jumlah-periode").val()))) + (parseInt(parent.find(".biaya-pemasangan-aktif").val()));
							parent.find(".total").val(harga_total);
						}
						// parent.find(".biaya-pemasangan").attr('disabled', false);
					} else {
						// parent.find(".biaya-pemasangan-aktif").attr('disabled', true);
						parent.find(".biaya-pemasangan-aktif").val('0');
						parent.find(".jumlah-periode").val(hasil ? hasil + 1 : 1);
						if (parent.find(".jumlah-periode").val() < parent.find(".minimal-langganan")) {
							parent.find(".status-berlangganan").val('Non Berlangganan')
							parent.find(".harga-satuan").val(data.biaya_satuan_tanpa_registrasi);
							parent.find(".harga-bulan-pertama").val((parseInt(parent.find(".harga-satuan").val())) + (parseInt($(".harga-registrasi").val())));
							harga_total = (parseInt(parent.find(".jumlah-satuan").val()?parent.find(".jumlah-satuan").val():0) * (parseInt(parent.find(".harga-satuan").val()))) + (parseInt($(".harga-registrasi").val()));
							parent.find(".total").val(harga_total);
						} else if (parent.find(".jumlah-periode").val() >= parent.find(".minimal-langganan").val()) {
							parent.find(".status-berlangganan").val('Berlangganan')
							parent.find(".harga-satuan").val(data.harga);
							parent.find(".harga-bulan-pertama").val((parseInt(parent.find(".harga-satuan").val())) + (parseInt($(".harga-registrasi").val())));
							parent.find(".harga-bulanan").val((parseInt(parent.find(".harga-satuan").val())) * (parseInt(parent.find(".jumlah-satuan").val()?parent.find(".jumlah-satuan").val():0)));
							harga_total = (parseInt(parent.find(".harga-bulanan").val()) * (parseInt(parent.find(".jumlah-periode").val()))) + (parseInt($(".harga-registrasi").val()));
							parent.find(".total").val(harga_total);
						}
					}


				}
			});

		});

		$(document).on("keyup", ".jumlah-satuan", function() {
			url = '<?= site_url(); ?>/transaksi_lain/P_registrasi_layanan_lain/get_info_paketservice';
			var parent = $(this).parents(".service_form");
			var id = parent.find(".paket-service").val();
			console.log(id);
			$.ajax({
				type: "post",
				url: url,
				data: {
					id: id
				},
				dataType: "json",
				success: function(data) {
					console.log(data.biaya_pemasangan);
					if (parent.find(".biaya-pemasangan-aktif").is(':checked')) {
						parent.find(".biaya-pemasangan-aktif").val(data.biaya_pemasangan);
						parent.find(".jumlah-periode").val(hasil ? hasil + 1 : 1);
						if (parent.find(".jumlah-periode").val() < parent.find(".minimal-langganan").val()) {
							if (parent.find(".jumlah-periode").val() == 1) {
								parent.find(".status-berlangganan").val('Non Berlangganan');
								parent.find(".harga-satuan").val(data.biaya_satuan_tanpa_registrasi);
								harga_bulanan_pertama = (parseInt(parent.find(".jumlah-satuan").val()) * (parseInt(parent.find(".harga-satuan").val()))) + (parseInt(parent.find(".harga-registrasi").val())) + (parseInt(parent.find(".biaya-pemasangan-aktif").val()));
								parent.find(".harga-bulan-pertama").val(harga_bulanan_pertama);
								harga_total = (parseInt(parent.find(".harga-bulan-pertama").val()));
								parent.find(".total").val(harga_total);
							} else {
								parent.find(".status-berlangganan").val('Non Berlangganan');
								parent.find(".harga-satuan").val(data.biaya_satuan_tanpa_registrasi);
								harga_bulanan_pertama = (parseInt(parent.find(".jumlah-satuan").val()) * (parseInt(parent.find(".harga-satuan").val()))) + (parseInt(parent.find(".harga-registrasi").val())) + (parseInt(parent.find(".biaya-pemasangan-aktif").val()));
								parent.find(".harga-bulan-pertama").val(harga_bulanan_pertama);
								harga_bulanan = (parseInt(parent.find(".jumlah-satuan").val()) * (parseInt(parent.find(".harga-satuan").val()))) + (parseInt(parent.find(".harga-registrasi").val()));
								parent.find(".harga-bulanan").val(harga_bulanan);
								harga_total = (parseInt(parent.find(".harga-bulanan").val()) * (parseInt(parent.find(".jumlah-periode").val()))) + (parseInt(parent.find(".biaya-pemasangan-aktif").val()));
								parent.find(".total").val(harga_total);
							}
						} else if (parent.find(".jumlah-periode").val() >= parent.find(".minimal-langganan").val()) {
							parent.find(".status-berlangganan").val('Berlangganan');
							parent.find(".harga-satuan").val(data.harga);
							harga_bulanan_pertama = (parseInt(parent.find(".jumlah-satuan").val()) * (parseInt(parent.find(".harga-satuan").val()))) + (parseInt(parent.find(".harga-registrasi").val())) + (parseInt(parent.find(".biaya-pemasangan-aktif").val()));
							parent.find(".harga-bulan-pertama").val(harga_bulanan_pertama);
							harga_bulanan = (parseInt(parent.find(".jumlah-satuan").val()) * (parseInt(parent.find(".harga-satuan").val())));
							parent.find(".harga-bulanan").val(harga_bulanan);
							harga_total = (parseInt(parent.find(".harga-bulanan").val()) * (parseInt(parent.find(".jumlah-periode").val()))) + (parseInt($(".harga-registrasi").val())) + (parseInt(parent.find(".biaya-pemasangan-aktif").val()));
							parent.find(".total").val(harga_total);
						}
					} else {
						parent.find(".biaya-pemasangan-aktif").attr('readonly', true);
						parent.find(".biaya-pemasangan-aktif").val('0');
						parent.find(".jumlah-periode").val(hasil ? hasil + 1 : 1);
						if (parent.find(".jumlah-periode").val() < parent.find(".minimal-langganan").val()) {
							if (parent.find(".jumlah-periode").val() == 1) {
								parent.find(".status-berlangganan").val('Non Berlangganan');
								parent.find(".harga-satuan").val(data.biaya_satuan_tanpa_registrasi);
								harga_bulanan_pertama = (parseInt(parent.find(".jumlah-satuan").val()) * (parseInt(parent.find(".harga-satuan").val()))) + (parseInt(parent.find(".harga-registrasi").val()));
								parent.find(".harga-bulan-pertama").val(harga_bulanan_pertama);
								harga_total = (parseInt(parent.find(".harga-bulan-pertama").val()));
								parent.find(".total").val(harga_total);
							} else {
								parent.find(".status-berlangganan").val('Non Berlangganan');
								parent.find(".harga-satuan").val(data.biaya_satuan_tanpa_registrasi);
								harga_bulanan_pertama = (parseInt(parent.find(".jumlah-satuan").val()) * (parseInt(parent.find(".harga-satuan").val()))) + (parseInt(parent.find(".harga-registrasi").val()));
								parent.find(".harga-bulan-pertama").val(harga_bulanan_pertama);
								harga_bulanan = (parseInt(parent.find(".jumlah-satuan").val()) * (parseInt(parent.find(".harga-satuan").val()))) + (parseInt(parent.find(".harga-registrasi").val()));
								parent.find(".harga-bulanan").val(harga_bulanan);
								harga_total = (parseInt(parent.find(".harga-bulanan").val()) * (parseInt(parent.find(".jumlah-periode").val())));
								parent.find(".total").val(harga_total);
							}
						} else if (parent.find(".jumlah-periode").val() >= parent.find(".minimal-langganan").val()) {
							parent.find(".status-berlangganan").val('Berlangganan');
							parent.find(".harga-satuan").val(data.harga);
							harga_bulanan_pertama = (parseInt(parent.find(".jumlah-satuan").val()) * (parseInt(parent.find(".harga-satuan").val()))) + (parseInt(parent.find(".harga-registrasi").val()));
							parent.find(".harga-bulan-pertama").val(harga_bulanan_pertama);
							harga_bulanan = (parseInt(parent.find(".jumlah-satuan").val()) * (parseInt(parent.find(".harga-satuan").val())));
							parent.find(".harga-bulanan").val(harga_bulanan);
							harga_total = (parseInt(parent.find(".harga-bulanan").val()) * (parseInt(parent.find(".jumlah-periode").val()))) + (parseInt($(".harga-registrasi").val()));
							parent.find(".total").val(harga_total);
						}

					}
				}

			});
			//takut kepakai 
			// harga_bulanan_pertama = (parseInt(parent.find(".jumlah-satuan").val()) * (parseInt(parent.find(".harga-satuan").val()))) + (parseInt(parent.find(".harga-registrasi").val()));
			// parent.find(".harga-bulan-pertama").val(harga_bulanan_pertama);


			// harga_bulanan = (parseInt(parent.find(".jumlah-satuan").val()) * (parseInt(parent.find(".harga-satuan").val())));
			// parent.find(".harga-bulanan").val(harga_bulanan);

			// harga_total = (parseInt(parent.find(".harga-bulan-pertama").val()) + (parseInt(parent.find(".harga-bulanan").val())));
			// parent.find(".total").val(harga_total);
		});
		// $(".service_form").on("keyup", ".jumlah-satuan", function() {
		// 	console.log($(".jumlah-satuan").val());
		// 	harga_bulanan = (parseInt($(".jumlah-satuan").val()) * (parseInt($(".harga-satuan").val())));
		// 	$(".service_form").find(".harga-bulanan").val(harga_bulanan);
		// });
		// $(".service_form").on("keyup", ".jumlah-satuan", function() {
		// 	console.log($(".jumlah-satuan").val());

		// });
		$('.select2').select2();
		$("#unit").change(function() {
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
					// console.log(data);
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
					$("#bangunan_type").val(data.bangunan_type);
					$("#unit_luas_tanah").val(data.luas_tanah);
					$("#unit_luas_bangunan").val(data.luas_bangunan);
					$("#unit_luas_taman").val(data.luas_taman);

				}
			});
		});

	});


	$('.select2').select2();
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
				// console.log(data);
				$("#paket").html("");
				$("#paket").append("<option value='' disabled selected>-- Pilih Paket --</option>");
				data.forEach(v => {
					$("#paket").append('<option value=' + v.id + '>' + v.name + "</option>");
				});
			}
		});
	});
	$("#paket").change(function() {
		url = '<?= site_url(); ?>/transaksi_lain/P_registrasi_layanan_lain/get_harga_paket';
		var id = $("#paket").val();
		// console.log(id);
		$("#tagihan_total").val("");
		$.ajax({
			type: "post",
			url: url,
			data: {
				id: id
			},
			dataType: "json",
			success: function(data) {
				// console.log(data);
				$("#tagihan_total").val(currency(data.harga));
			}
		});
	});
</script>