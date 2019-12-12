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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Unit</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <select class="form-control select2" name="unit" id="unit" required>
                        <option value="" disabled selected>Pilih Unit (Kawasan-Blok/No. unit)</option>
                        <?php foreach ($dataUnit as $v):?>
                        <option value=<?=$v->id?>><?="$v->kawasan-$v->blok/$v->unit"?></option>    
                        <?php endforeach;?>
                        
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Range Harga Sewa</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <select class="form-control select2" name="range_harga" id="range_harga" required>
                        <option value="" disabled selected>Pilih Range Harga Sewa</option>
                        <?php foreach ($dataRangeHargaSewa as $v):?>
                        <option value=<?=$v->id?>><?="$v->code - $v->name"?></option>    
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Mulai<br>Boleh di Sewakan</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <input class="form-control datetimepicker" name="tgl" id="tgl" placeholder="Masukkan Tanggal Mulai Boleh di Sewakan">
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
                var unit        = $("#unit").val()||$("#unit").attr('disabled');
                var range_harga = $("#range_harga").val()||$("#range_harga").attr('disabled');
                var tgl         = $("#tgl").val()||$("#tgl").attr('disabled');
                // var description = $("#description").val()||$("#description").attr('disabled');

                if(unit && range_harga && tgl){
                    $.ajax({
                        type: "GET",
                        data: $("#form").serialize(),
                        url: "<?= site_url() ?>/Transaksi_lain/P_unit_sewa/ajax_save",
                        dataType: "json",
                        success: function(data) {
                            if (data == 1){
                                notif('Sukses', 'Data Berhasil di Tambah', 'success');
                            }else if(data == 0){
                                notif('Gagal', 'Data Double', 'danger');
                            }
                        }
                    });
                }else{
                    notif('Gagal', "Ada Form belum di isi", 'danger');
                }
            });
        });
    </script>