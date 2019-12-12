<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- select2 -->
<link href="<?= base_url() ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<script src="<?= base_url() ?>vendors/select2/dist/js/select2.min.js"></script>
<!-- flat -->
<link href="<?= base_url() ?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
<!-- date time picker -->
<script type="text/javascript" src="<?= base_url(); ?>vendors/moment/min/moment.min.js"></script>
<link href="<?= base_url(); ?>vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script type="text/javascript" src="<?= base_url(); ?>vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!-- Switchery -->
<script src="<?= base_url() ?>vendors/switchery/dist/switchery.min.js"></script>

<!DOCTYPE html>
<div style="float:right">
    <h2>
        <button class="btn btn-warning" onClick="window.location.href = '<?= substr(current_url(), 0, strrpos(current_url(), "/")) ?>'">
            <i class="fa fa-arrow-left"></i>
            Back
        </button>
        <button class="btn btn-success" onClick="window.location.reload()">
            <i class="fa fa-repeat"></i>
            Refresh
        </button>
    </h2>
</div>
<div class="clearfix"></div>
</div>
<div class="x_content">
    <br>
    <form id="form" class="form-horizontal form-label-left" autocomplete="off">
        <div class="com-lg-12 col-md-12 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Unit</label>
                <div class="col-md-10 col-sm-10 col-xs-12">
                    <select class="form-control select2" name="gol_diskon" id="gol_diskon" required>
                        <option value="" disabled selected>Pilih Unit (Kawasan-Blok/No. unit)</option>
                        <?php foreach ($dataUnit as $v) : ?>
                            <option value=<?= $v->id ?>><?= "$v->kawasan-$v->blok/$v->unit" ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <h4 id="label_transaksi" hidden="" style="display: block;">Perkiraan dan Info Unit</h4>
        <div class="clearfix"></div>
        <div class="com-lg-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Mulai <br>Boleh di Sewakan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Pilih Unit (DD/MM/YYYY)" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Luas Bangunan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Pilih Unit" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Luas Kavling</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Pilih Unit" readonly>
                </div>
            </div>
        </div>
        <div class="com-lg-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Harga Unit</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Pilih Unit" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nilai Down Payment (DP)</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Pilih Unit" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nilai Secure Deposit (SD)</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Pilih Unit" readonly>
                </div>
            </div>

        </div>

        <div class="clearfix"></div>
        <h4 id="label_transaksi" hidden="" style="display: block;">Customer Registrasi</h4>
        <div class="clearfix"></div>


        <div class="com-lg-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="" class="form-control select2">
                        <option value="0" disabled selected> Pilih Customer</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <input class="form-control btn btn-primary" value="Daftar">
                </div>

            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan Nama" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Handphone</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan No. Handphone" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan Email" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">PT</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan PT" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jabatan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan Jabatan" readonly>
                </div>
            </div>
        </div>
        <div class="com-lg-8 col-md-8 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-1 col-sm-1 col-xs-12" style="width:12.2%">Penyewa</label>
                <div class="col-md-10 col-sm-10 col-xs-12" style="width:87.5%">
                    <select id="" class="form-control select2">
                        <option value="" disabled selected> Pilih Penyewa (Perusahaan/Perorangan)</option>
                        <option value="0"> Perusahaan</option>
                        <option value="1"> Perorangan</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="com-lg-4 col-md-4 col-xs-12">

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan Nama">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan Alamat">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama NPWP</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan Nama NPWP">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. NPWP</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan No. NPWP">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat NPWP</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan Alamat NPWP">
                </div>
            </div>
            

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">PKP</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <select id="" class="form-control select2">
                        <option value="" disabled selected> Pilih PKP/Tidak PKP</option>
                        <option value="0"> PKP</option>
                        <option value="1"> Tidak PKP</option>
                    </select>                
                </div>
            </div>
        </div>
        <div class="com-lg-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NIK KTP</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan NIK KTP">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat KTP</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan Alamat KTP">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telp/Fax</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan No. Telp/Fax">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Handphone</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan No. Handphone">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan Email">
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <h4 id="label_transaksi" hidden="" style="display: block;">Form Registrasi</h4>
        <div class="clearfix"></div>

        <div class="com-lg-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipe Tagihan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <select id="" class="form-control select2">
                        <option value="" disabled selected> Pilih Tipe Tagihan</option>
                        <option value="1">Sewa tagih</option>
                        <option value="2">Join Operation (JO)</option>
                        <option value="3">Join Ventury(JV)</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Rencana Lama Sewa<br> (Bulan)</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan Rencana Lama Sewa, tiap berapa bulan 1 kali tagihan">
                </div>
            </div>
            <!-- <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nilai Tagihan</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input class="form-control" placeholder="Masukkan Nilai Tagihan">
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <select class="form-control select2">
                        <option>Rupiah</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nilai Bagi Hasil</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input class="form-control" placeholder="Masukkan Nilai Bagi Hasil">
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <select class="form-control select2">
                        <option value="0">Rupiah</option>
                        <option value="1">Persen</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pajak ?</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <select id="" class="form-control select2">
                        <option value="" disabled selected> Pilih Tidak/Ya</option>
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>
            </div> -->
        </div>
        <div class="com-lg-6 col-md-6 col-xs-12">
            <!-- <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Term Down Payment (DP)</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan Jumlah Term Payment">
                </div>
            </div>  
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nilai Down Payment (DP)</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan Telpon">
                </div>
            </div>     
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nilai Secure Deposit (SD)</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Masukkan Telpon">
                </div>
            </div> -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea class="form-control" placeholder="Masukkan Nama"></textarea>
                </div>
            </div>

        </div>

        <div class="clearfix"></div>
        <div class="form-group">
            <div class="center-margin">
                <button class="btn btn-primary" type="reset">Reset</button>
                <a id="submit" type="submit" class="btn btn-success">Submit</a>
            </div>
        </div>
    </form>


    <script>
        function notif(title, text, type) {
            new PNotify({
                title: title,
                text: text,
                type: type,
                styling: 'bootstrap3'
            });
        }
        $(function() {
            $('.datetimepicker').datetimepicker({
                viewMode: 'years',
                format: 'DD/MM/YYYY'
            });
            $('.select2').select2();


            $("#submit").click(function() {
                var gol_diskon = $("#gol_diskon").val() || $("#gol_diskon").attr('disabled');
                var purpose_use = $("#purpose_use").val() || $("#purpose_use").attr('disabled');
                var service = $("#service").val() || $("#service").attr('disabled');
                var paket_service = $("#paket_service").val() || $("#paket_service").attr('disabled');
                var flag_berlaku = $("#flag_berlaku").val() || $("#flag_berlaku").attr('disabled');
                var periode_awal = $("#periode_awal").val() || $("#periode_awal").attr('disabled');
                var periode_akhir = $("#periode_akhir").val() || $("#periode_akhir").attr('disabled');
                var lama_awal = $("#lama_awal").val() || $("#lama_awal").attr('disabled');
                var lama_akhir = $("#lama_akhir").val() || $("#lama_akhir").attr('disabled');
                var minimal_bulan = $("#minimal_bulan").val() || $("#minimal_bulan").attr('disabled');
                var parameter = $("#parameter").val() || $("#parameter").attr('disabled');
                var nilai = $("#nilai").val() || $("#nilai").attr('disabled');
                // var description = $("#description").val()||$("#description").attr('disabled');

                if (gol_diskon && purpose_use && service && paket_service && flag_berlaku && periode_awal && periode_akhir && lama_awal && lama_akhir && minimal_bulan && parameter && nilai && description) {
                    $.ajax({
                        type: "GET",
                        data: $("#form").serialize(),
                        url: "<?= site_url() ?>/P_master_diskon/ajax_save",
                        dataType: "json",
                        success: function(data) {
                            if (data.status)
                                notif('Sukses', data.message, 'success');
                            else
                                notif('Gagal', data.message, 'danger');
                        }
                    });
                } else {
                    notif('Gagal', "Ada Form belum di isi", 'danger');
                }
            });
        });
    </script>