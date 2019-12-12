<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='UTF-8'>
    <title>Dokumen TVI</title>
    <link href="<?=base_url()?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="/ems/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->

</head>
<style>
    .casabanti {
        font-family: 'casbanti';
    }

    .col-centered {
        float: none;
        margin: 0 auto;
    }

    .f-20 {
        font-size: 20px;
        font-weight: 700;
        line-height: 15px;
    }

    .f-14 {
        font-size: 14px;
        line-height: 10px;
    }

    html {
        margin: 5px 15px;
        padding: 0px;
    }

    .f-15 {
        font-size: 14px;
        line-height: 10px;
    }

    table thead th,
    table tbody tr td,
    table tfoot tr td {
        font-size: 12px;
    }

    .f-12 {
        font-size: 12px;
        line-height: 15px;
    }

    .f-8 {
        font-size: 8px;
        line-height: 10px;
    }

    .lh-18 {
        line-height: 18px;
    }

    .lh-5 {
        line-height: 20px;
    }
    .lh-15 {
        line-height: 15px;
    }
    .lh-8 {
        line-height: 5px;
    }

    #items
    {
        clear: both;
        width: 100%;
        margin: 0;
    }
    .borderless table {
    border-top-style: none;
    border-left-style: none;
    border-right-style: none;
    border-bottom-style: none;
    
}
.superscript{
    font-size: 9px;
    vertical-align: super;
}
body{
        font-weight:bold;
        padding-top:-5px
    }
    .tab {position:absolute;left:250px; }
#tabel{
    text-align: center;
    width:750px;
}
#box1{
    width: 685px;
    font-size: 12px;
    border:solid 1px black;
}
#box2{
    width: 685px;
    font-size: 12px;
}
#box3{
    border:solid 1px black;
    height:100px;
}
}
</style>

<body class="container2" style="padding-bottom:-120px">
<div>
    <?php if($data_select->jenis_paket_tv_id !=null){?>
    <h4 style="text-align:center;padding-top:50px;font-weight:bold">REGISTRASI TV</h4>
    <?php }elseif($data_select->jenis_paket_internet_id != null){?>
    <h4 style="text-align:center;padding-top:50px;font-weight:bold">REGISTRASI INTERNET</h4>
    <?php }elseif($data_select->jenis_paket_tvi_id != null){?>
    <h4 style="text-align:center;padding-top:50px;font-weight:bold">REGISTRASI TV DAN INTERNET</h4>
    <?php }?>
    <hr>
    <table style="padding-left:65px;padding-top:5px">
            <td id="box2">
                <p style="margin-left:5px;margin-top:2px">Nomor Registrasi<span class="tab">: <?=$data_select->nomor_registrasi; ?></span></p>
                <p style="margin-left:5px;margin-top:2px">Project<span class="tab">: <?=$data_select->project; ?></span></p>
                <p style="margin-left:5px;margin-top:2px">Kawasan - Blok - No. Unit<span class="tab">: <?=$data_select->kawasan; ?> - <?=$data_select->blok; ?> - <?=$data_select->unit; ?></span></p>
                <p style="margin-left:5px;margin-top:2px">Customer<span class="tab">: <?=$data_select->customer; ?></span></p>
                <p style="margin-left:5px;margin-top:2px">Telp<span class="tab">: <?=$data_select->telepon; ?></span></p>
                <p style="margin-left:5px;margin-top:2px">No. HP<span class="tab">: <?=$data_select->no_hp; ?></span></p>
                <p style="margin-left:5px;margin-top:2px">Email<span class="tab">: 
                    <?php
                    if($data_select->email == null){
                        echo "-";
                    }else{
                        $data_select->email;
                    } 
                    ?>
                    </span></p>
                <p style="margin-left:5px;margin-top:2px">Jenis Pemasangan<span class="tab">:
                    <?php 
                    if($data_select->jenis_pemasangan=='1'){
                        echo "Pemasangan Baru";
                    }elseif($data_select->jenis_pemasangan=='0'){
                        echo "Registrasi ulang";
                    }
                    ?>
                </span></p>
                <p style="margin-left:5px;margin-top:2px">Jenis Pembayaran<span class="tab">: 
                    <?php
                    if($data_select->jenis_bayar == '1'){
                        echo "Pra Bayar";
                    }elseif($data_select->jenis_bayar == '0'){
                        echo "Pasca Bayar";
                    }
                    ?>
                </span></p>
                <!-- <p style="margin-left:5px;margin-top:2px">NAMA <span class="tab">: <?= $dataUnit->customer_name?></span></p> -->
                <!-- <p style="margin-left:5px;margin-top:2px">NO. Registrasi <span class="tab">: <?= $no_regis ?></span></p> -->
                <!-- <p style="margin-left:5px;margin-top:2px">ALAMAT <span class="tab">: <?= $dataUnit->kawasan_name .' Blok '. $dataUnit->blok_name .' No. '. $dataUnit->no_unit?></span></p> -->
            </td>
    </table>
    <!-- <table class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row" style="padding-left:70px;text-align:center" border="1">
        <thead>
            <tr>
                <th><p style="text-align:center;height:8px;width:656px">PEMASANGAN PAKET</th>
            </tr>
        </thead>
    </table> -->
    <table style="padding-left:65px;padding-top:5px">
            <td id="box2">
                <?php if($data_select->jenis_paket_tv_id !=null){?>
                <p style="margin-left:5px;margin-top:2px">Jenis Paket<span class="tab">: TV</span></p>
                <p style="margin-left:5px;margin-top:2px">Nama Paket<span class="tab">: <?= $data_select->jenis_paket_tv?></span></p>
                <p style="margin-left:5px;margin-top:2px">Jumlah Channel<span class="tab">: <?= $data_select->jml_channel?></span></p>
                <p style="margin-left:5px;margin-top:2px">Harga Paket<span class="tab">: Rp.<?= number_format($data_select->harga_paket_tv,2,',','.')?></span></p>
                <p style="margin-left:5px;margin-top:2px">Biaya Pemasangan<span class="tab">: Rp.<?= number_format($data_select->pemasangan_tv,2,',','.')?></span></p>
                <p style="margin-left:5px;margin-top:2px">Biaya Admin<span class="tab">:
                <?php if($data_select->registrasi_tv == null){?>
                    0
                <?php }else{ ?>
                Rp.<?= number_format($data_select->registrasi_tv,2,',','.')?>
                <?php }?>
                </span></p>
                <?php }elseif($data_select->jenis_paket_internet_id !=null){?>
                <p style="margin-left:5px;margin-top:2px">Jenis Paket<span class="tab">: Internet</span></p>
                <p style="margin-left:5px;margin-top:2px">Nama Paket<span class="tab">: <?= $data_select->jenis_paket_internet?></span></p>
                <p style="margin-left:5px;margin-top:2px">Kecepatan Bandwidth<span class="tab">: <?= number_format($data_select->bandwidth_internet)?> Kbps</span></p>
                <p style="margin-left:5px;margin-top:2px">Harga Paket<span class="tab">: Rp.<?= number_format($data_select->harga_paket_internet,2,',','.')?></span></p>
                <p style="margin-left:5px;margin-top:2px">Biaya Pemasangan<span class="tab">: Rp.<?= number_format($data_select->pemasangan_internet,2,',','.')?></span></p>
                <p style="margin-left:5px;margin-top:2px">Biaya Admin<span class="tab">: 
                <?php if($data_select->registrasi_internet == null){?>
                    0
                <?php }else{ ?>
                    Rp.<?= number_format($data_select->registrasi_internet,2,',','.')?>
                <?php }?></span></p>
                <?php }elseif($data_select->jenis_paket_tvi_id != null){?>
                <p style="margin-left:5px;margin-top:2px">Jenis Paket<span class="tab">: TV dan Internet</span></p>
                <p style="margin-left:5px;margin-top:2px">Nama Paket<span class="tab">: <?= $data_select->jenis_paket_tvi?></span></p>
                <p style="margin-left:5px;margin-top:2px">Jumlah Channel<span class="tab">: <?= $data_select->jml_channel_tvi?></span></p>
                <p style="margin-left:5px;margin-top:2px">Kecepatan Bandwidth<span class="tab">: <?= number_format($data_select->bandwidth_tvi)?> Kbps</span></p>
                <p style="margin-left:5px;margin-top:2px">Harga Paket<span class="tab">: Rp.<?= number_format($data_select->harga_paket_tvi,2,',','.')?></span></p>
                <p style="margin-left:5px;margin-top:2px">Biaya Pemasangan<span class="tab">: Rp.<?= number_format($data_select->pemasangan_tvi,2,',','.')?></span></p>
                <p style="margin-left:5px;margin-top:2px">Biaya Admin<span class="tab">:
                <?php if($data_select->registrasi_tvi == null){?>
                    0
                <?php }else{ ?>
                    Rp.<?= number_format($data_select->registrasi_tvi,2,',','.')?>
                <?php }?>
                </span></p>
                <?php }?>
            </td>
    </table>
    <!-- <table class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row" style="padding-left:70px;text-align:center" border="1">
        <thead>
            <tr>
                <th><p style="text-align:center;height:8px;width:656px">TRANSAKSI</th>
            </tr>
        </thead>
    </table> -->
    <table style="padding-left:65px;padding-top:5px">
            <td id="box2">
                <p style="margin-left:5px;margin-top:2px">Tgl Registrasi<span class="tab">: <?=$data_select->tanggal_document; ?></span></p>
                <p style="margin-left:5px;margin-top:2px">Tgl Rencana Survei<span class="tab">: <?=$data_select->tanggal_rencana_survei; ?></span></p>
                <p style="margin-left:5px;margin-top:2px">Tgl Rencana Pasang Instalasi<span class="tab">: <?=$data_select->tanggal_rencana_pemasangan; ?></span></p>
                <p style="margin-left:5px;margin-top:2px">Tgl Rencana Aktifasi<span class="tab">: <?=$data_select->tanggal_rencana_aktifasi; ?></span></p>
                <p style="margin-left:5px;margin-top:2px">Total Paket<span class="tab">: Rp.<?=number_format($data_select->total,2,',','.'); ?></span></p>
                <?php if($data_select->diskon != null){?>
                <p style="margin-left:5px;margin-top:2px">Nilai Diskon<span class="tab">: Rp.<?=number_format($data_select->diskon,2,',','.'); ?></span></p>
                <?php }?>
                <p style="margin-left:5px;margin-top:2px">Total Yang Harus Dibayar<span class="tab">: Rp.<?=number_format($data_select->total,2,',','.')." ( ".strtoupper($terbilang)." )"; ?></span></p>
            </td>
    </table>

    <div class="col-md-12 col-sm-12 col-lg-12 row" style="padding-top:10px">
        
        <div class="col-md-5 col-sm-5 col-lg-5" id = "box2" style="padding-left:550px">
            <p>JAKARTA, <?=$tanggal?></p>
            <p style="padding-top:65px;">( <?=$data_select->customer; ?> )</p>
            <!-- <p class="lh-5 f-15">BOGOR, <?=$tanggal?></p> -->
            <!-- <p class="lh-5 f-15" style="padding-top:50px;"><?=$this->session->userdata('name')?></p> -->
        </div>
    </div>
</div>
</body>

</html>