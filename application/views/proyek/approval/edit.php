<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<link href="<?= base_url() ?>vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<script src="<?= base_url() ?>vendors/switchery/dist/switchery.min.js"></script>


<link href="<?= base_url() ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<script src="<?= base_url() ?>vendors/select2/dist/js/select2.min.js"></script>
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
    <div class="row">
        <div class="col-xs-4">

            <label class="control-label col-md-12 col-sm-12 col-xs-12" style="text-align:center">Mengajukan</label>
            <div class="clearfix"></div>

            <span class="chart" data-percent="<?= (($data->dokumen->status_request_id == 1 ? 1 : 0) / 1) * 100 ?>" style="left: 38%;">
                <span class="percent"></span>
            </span>
            <div class="clearfix"></div>
            <label class="control-label col-md-12 col-sm-12 col-xs-12" style="text-align:center"><?= ($data->dokumen->status_request_id == 1 ? 1 : 0) . "/1" ?> Approve</label>

        </div>
        <div class="col-xs-4">
            <label class="control-label col-md-12 col-sm-12 col-xs-12" style="text-align:center">Wewenang</label>
            <div class="clearfix"></div>

            <span class="chart" data-percent="<?= ($data->jumlah_wewenang->wewenang_approve / $data->jumlah_wewenang->wewenang) * 100 ?>" style="left: 38%;">
                <span class="percent"></span>
            </span>
            <div class="clearfix"></div>
            <label class="control-label col-md-12 col-sm-12 col-xs-12" style="text-align:center"><?= $data->jumlah_wewenang->wewenang_approve . "/" . $data->jumlah_wewenang->wewenang ?> Approve</label>
        </div>
        <div class="col-xs-4">
            <label class="control-label col-md-12 col-sm-12 col-xs-12" style="text-align:center">Total</label>
            <div class="clearfix"></div>

            <span class="chart" data-percent="<?= ((($data->dokumen->status_request_id == 1 ? 1 : 0) + $data->jumlah_wewenang->wewenang_approve) / ($data->jumlah_wewenang->wewenang + 1)) * 100 ?>" style="left: 38%;">
                <span class="percent"></span>
            </span>
            <div class="clearfix"></div>
            <label class="control-label col-md-12 col-sm-12 col-xs-12" style="text-align:center"><?= (($data->dokumen->status_request_id == 1 ? 1 : 0) + $data->jumlah_wewenang->wewenang_approve) . "/" . ($data->jumlah_wewenang->wewenang + 1) ?> Approve</label>
        </div>
        <div class="clearfix"></div>
    </div>
    <br>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <ul class="list-unstyled timeline">
            <li>
                <div class="block">
                    <div class="tags">

                        <a class='tag' <?php $max = 0;
                                        if ($data->mengajukan->status_id == 0)
                                            echo ("style='background:rgba(243,156,18,.88)'");
                                        if ($data->mengajukan->status_id == 1)
                                            echo ("style='background:rgba(38,185,154,.88)'");
                                        if ($data->mengajukan->status_id == 2)
                                            echo ("style='background:rgba(231,76,60,.88)'");
                                        if ($data->mengajukan->status_id == 3)
                                            echo ("style='background:rgba(52,152,219,.88)'");
                                        ?>>
                            <?php
                            echo ("<span>Mengajukan</span>");
                            ?>

                        </a>
                    </div>
                    <div class="block_content">
                        <h2 class="title">
                            <a><?= $data->mengajukan->jabatan_name . " : " . $data->mengajukan->status ?></a>
                        </h2>
                        <div class="byline">
                            <?php
                            $tmp = abs(strtotime(substr($data->dokumen->tgl_tambah, 0, 10)) - strtotime(date("Y-m-d")));
                            $years = floor($tmp / (365 * 60 * 60 * 24));
                            $months = floor(($tmp - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                            $days = floor(($tmp - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                            $tmp = $data->mengajukan->batas_waktu - $days;
                            if ($max < $tmp)
                                $max = $tmp;
                            if($data->mengajukan->status_id == 0){
                                if ($tmp <= 0) { } elseif ($tmp < 2) {
                                    echo ("<span> Hingga Jam " . ($tmp * 24) . " </span> ( Generate By <a>System</a> )");
                                } else {
                                    echo ("<span>" . $tmp . " Hari Lagi </span> ( Generate By <a>System</a> )");
                                }
                            }else{
                                $tgl_tambah = $data->dokumen->tgl_tambah;
                                $dateApprove = $data->dokumen->tgl_approve;
                                $dateApproveBatas =date('Y-m-d',strtotime(str_replace("-","/",$tgl_tambah) . "+".($data->mengajukan->batas_waktu+1)." days")); 
                                if($dateApproveBatas<$dateApprove){
                                    $ts1 = strtotime($dateApprove);
                                    $ts2 = strtotime($dateApproveBatas);
                                    $seconds_diff = $ts1 - $ts2;
                                    echo ("<span>  TELAT ".(int)($seconds_diff/60/60/24) ." Hari </span> ( Generate By <a>System</a> )");

                                }
                            }


                            ?>
                        </div>
                        <!-- <div class="byline">
                                    <span>13 hours ago</span> by <a>Jane Smith</a>
                                </div> -->
                        <p class="excerpt">Deskripsi : <?= $data->mengajukan->deskripsi ?> </a>
                        </p>
                    </div>
                </div>
            </li>
            <?php $max = 0;
            foreach ($data->wewenang as $k => $v) :
                ?>
            <li>
                <div class="block">
                    <div class="tags">

                        <a class='tag' <?php
                                            if ($v->status_id == 0)
                                                echo ("style='background:rgba(243,156,18,.88)'");
                                            if ($v->status_id == 1)
                                                echo ("style='background:rgba(38,185,154,.88)'");
                                            if ($v->status_id == 2)
                                                echo ("style='background:rgba(231,76,60,.88)'");
                                            if ($v->status_id == 3)
                                                echo ("style='background:rgba(52,152,219,.88)'");
                                            ?>>
                            <?php
                                echo ("<span>Wewenang</span>");
                                ?>

                        </a>
                    </div>
                    <div class="block_content">
                        <h2 class="title">
                            <a><?= "$v->jabatan_name : $v->status" ?></a>
                        </h2>
                        <div class="byline">
                            <?php
                                $tmp = abs(strtotime(substr($data->dokumen->tgl_tambah, 0, 10)) - strtotime(date("Y-m-d")));
                                $years = floor($tmp / (365 * 60 * 60 * 24));
                                $months = floor(($tmp - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                $days = floor(($tmp - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                $tmp = $v->batas_waktu - $days;
                                if ($max < $tmp)
                                    $max = $tmp;

                                if ($tmp <= 0) { } elseif ($tmp < 2) {
                                    echo ("<span> Hingga Jam " . ($tmp * 24) . " </span> ( Generate By <a>System</a> )");
                                } else {
                                    echo ("<span>" . $tmp . " Hari Lagi </span> ( Generate By <a>System</a> )");
                                }

                                ?>
                        </div>
                        <!-- <div class="byline">
                                    <span>13 hours ago</span> by <a>Jane Smith</a>
                                </div> -->
                        <p class="excerpt">Deskripsi : <?= $v->deskripsi ?> </a>
                        </p>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
            <li>
                <div class="block">
                    <div class="tags">
                        <a class="tag">
                            <span>Status Final</span>
                        </a>
                    </div>
                    <div class="block_content">
                        <h2 class="title">
                            <?php
                            if ($max > 0) {
                                echo ("<a>Open</a>");
                                // if()
                                // echo (" => <a>Approve</a>");
                            } else {
                                echo ("<a>Close</a>");
                                // if()
                                // echo (" => <a>Approve</a>");
                            }
                            ?>

                        </h2>
                        <!-- <div class="byline">
                            <span>13 hours ago</span> by <a>Jane Smith</a>
                        </div> -->
                        <!-- <p class="excerpt">Description</a> -->
                        </p>
                    </div>
                </div>
            </li>
        </ul>

    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="form-horizontal form-label-left">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pt_id">Dokumen</label>
                <div class="col-md-7 col-sm-7 col-xs-10">
                    <input type="text" class="form-control col-md-7 col-xs-12" readonly value="<?= $data->dokumen->dokumen ?>">
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <button class="btn btn-primary col-md-12 col-xs-12"> Lampiran</button>
                </div>

            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pt_id">Kode Dokumen</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" readonly value="<?= $data->dokumen->dokumen_code ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pt_id">Request</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" readonly value="<?= $data->dokumen->request ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pt_id">Nilai Dokumen</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" readonly value="<?= "Rp. " . number_format($data->dokumen->dokumen_nilai) ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pt_id">Tanggal Request</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" readonly value="<?= $data->dokumen->tgl_tambah ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pt_id">Tanggal Closed</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" readonly value="<?= $data->dokumen->tgl_closed ?>">
                </div>
            </div>
            <?php if ($data->mengajukan->hak_approve == 2) : ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pt_id">Deskripsi</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea type="text" class="form-control col-md-7 col-xs-12" name="description"></textarea>
                </div>
            </div>

            <?php else : ?>
            <?php foreach ($data->wewenang as $k => $v) : ?>
            <?php if ($v->jabatan_id == $data->jabatan_id && $v->hak_approve == 1) : ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pt_id">Deskripsi</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea id="deskripsi" type="text" class="form-control col-md-7 col-xs-12" name="description"></textarea>
                </div>
            </div>

            <?php endif; ?>
            <?php endforeach; ?>
            <?php endif; ?>

            <div id="btn-action" class="col-lg-9 col-md-9 col-sm-9 col-lg-offset-3 col-md-offset-3 col-sm-offset-3">
                <div class="form-group" style="margin-top:20px">
                    <div class="center-margin">
                        <?php if ($data->mengajukan->hak_approve == 2) : ?>
                            <a data-toggle="modal" data-target="#modal2" header="Mengajukan" class="btn btn-danger">Cancel</a>
                            <a data-toggle="modal" data-target="#modal" header="Mengajukan" class="btn btn-success">Mengajukan</a>
                        <?php else : ?>
                            <?php foreach ($data->wewenang as $k => $v) : 
                                $tmp = explode(",",$v->jabatan_id);?>    
                                <?php foreach ($tmp as $v2):?>
                                    <?php if ($v2 == $data->jabatan_id && $v->hak_approve == 1) : ?>
                                        <a data-toggle="modal" data-target="#modal2" class="btn btn-danger">Reject</a>
                                        <a data-toggle="modal" data-target="#modal" class="btn btn-success">Approve</a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="x_content">
    <div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false">
        <div class="" style="width:35%;margin:auto">
            <div class="modal-content" style="margin-top:100px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;" id="header-modal">
                        <?php if ($data->mengajukan->hak_approve == 2) : ?>
                            Mengajukan
                        <?php else : ?>
                        <?php foreach ($data->wewenang as $k => $v) : ?>
                            <?php if ($v->jabatan_id == $data->jabatan_id && $v->hak_approve == 1) : ?>
                                Approve
                            <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <span class="grt"></span></h4>
                </div>
                <div class="modal-body">
                    Apakah anda yakin untuk
                    <a id="body-modal">
                        <?php if ($data->mengajukan->hak_approve == 2) : ?>
                            Mengajukan
                        <?php else : ?>
                            <?php foreach ($data->wewenang as $k => $v) : 
                                $tmp = explode(",",$v->jabatan_id);?>    
                                <?php foreach ($tmp as $v2):?>
                                    <?php if ($v2 == $data->jabatan_id && $v->hak_approve == 1) : ?>
                                    Approve
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </a>
                    Dokumen ini ?
                </div>
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="delete_cancel_link">Close</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" 
                        <?php if ($data->mengajukan->hak_approve == 2) : ?> 
                            id="btn-mengajukan">Ajukan</button>
                        <?php else : ?>
                            <?php foreach ($data->wewenang as $k => $v) : 
                                $tmp = explode(",",$v->jabatan_id);?>    
                                <?php foreach ($tmp as $v2):?>
                                    <?php if ($v2 == $data->jabatan_id && $v->hak_approve == 1) : ?>
                                    id="btn-approve">Approve</button>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="x_content">
    <div class="modal fade" id="modal2" data-backdrop="static" data-keyboard="false">
        <div class="" style="width:35%;margin:auto">
            <div class="modal-content" style="margin-top:100px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;" id="header-modal">
                        <?php if ($data->mengajukan->hak_approve == 2) : ?>
                            Cancel
                        <?php else : ?>
                        <?php foreach ($data->wewenang as $k => $v) : ?>
                            <?php if ($v->jabatan_id == $data->jabatan_id && $v->hak_approve == 1) : ?>
                                Reject
                            <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <span class="grt"></span></h4>
                </div>
                <div class="modal-body">
                    Apakah anda yakin untuk
                    <a id="body-modal">
                        <?php if ($data->mengajukan->hak_approve == 2) : ?>
                            Cancel
                        <?php else : ?>
                            <?php foreach ($data->wewenang as $k => $v) : 
                                $tmp = explode(",",$v->jabatan_id);?>    
                                <?php foreach ($tmp as $v2):?>
                                    <?php if ($v2 == $data->jabatan_id && $v->hak_approve == 1) : ?>
                                    Reject
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </a>
                    Dokumen ini ?
                </div>
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="delete_cancel_link">Close</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" 
                        <?php if ($data->mengajukan->hak_approve == 2) : ?> 
                            id="btn-cancel">Cancel</button>
                        <?php else : ?>
                            <?php foreach ($data->wewenang as $k => $v) : 
                                $tmp = explode(",",$v->jabatan_id);?>    
                                <?php foreach ($tmp as $v2):?>
                                    <?php if ($v2 == $data->jabatan_id && $v->hak_approve == 1) : ?>
                                    id="btn-reject">Reject</button>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<script src="<?= base_url() ?>vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>


<script>
    $(function() {
        //selected
        function notif(title, text, type) {
            new PNotify({
                title: title,
                text: text,
                type: type,
                styling: 'bootstrap3'
            });
        }
        $("#btn-mengajukan").click(function() {
            $.ajax({
                type: "POST",
                data: {
                    id: <?= $this->input->get("id") ?>,
                    deskripsi: $("#deskripsi").val()

                },
                url: '<?= site_url() ?>/P_approval/ajax_mengajukan',
                dataType: "json",
                success: function(data) {
                    if (data == 1) {
                        $("#btn-action").hide();
                        notif('Sukses', 'Pembayaran Telah Berhasil', 'success');
                    }
                }
            });

        });
        $("#btn-cancel").click(function() {
            $.ajax({
                type: "POST",
                data: {
                    id: <?= $this->input->get("id") ?>,
                    deskripsi: $("#deskripsi").val()

                },
                url: '<?= site_url() ?>/P_approval/ajax_cancel',
                dataType: "json",
                success: function(data) {
                    if (data == 1) {
                        $("#btn-action").hide();
                        notif('Sukses', 'Pembayaran Telah Berhasil', 'success');
                    }
                }
            });

        });
        $("#btn-approve").click(function() {
            $.ajax({
                type: "POST",
                data: {
                    id: <?= $this->input->get("id") ?>,
                    deskripsi: $("#deskripsi").val()
                },
                url: '<?= site_url() ?>/P_approval/ajax_approve',
                dataType: "json",
                success: function(data) {
                    if (data == 1) {
                        $("#btn-action").hide();
                        notif('Sukses', 'Pembayaran Telah Berhasil', 'success');
                    }
                }
            });

        });
        $("#btn-reject").click(function() {
            $.ajax({
                type: "POST",
                data: {
                    id: <?= $this->input->get("id") ?>,
                    deskripsi: $("#deskripsi").val()
                },
                url: '<?= site_url() ?>/P_approval/ajax_reject',
                dataType: "json",
                success: function(data) {
                    if (data == 1) {
                        $("#btn-action").hide();
                        notif('Sukses', 'Pembayaran Telah Berhasil', 'success');
                    }
                }
            });

        });
        $('.select2').select2();
    });
</script>