<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='UTF-8'>
    <title>Dokumen Liaison Officer</title>
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
    <h4 style="text-align:center;padding-top:50px;font-weight:bold">REGISTRASI LIAISON OFFICER</h4>
    <hr>
    <table style="padding-left:65px;padding-top:5px">
            <td id="box2">
                <p style="margin-left:5px;margin-top:2px"><?=$data_select->kategori_nama?><span class="tab">: <?=$data_select->jenis_nama?> - <?= $data_select->peruntukan_nama?></span></p>
                <p style="margin-left:5px;margin-top:2px">Nomor Registrasi<span class="tab">: <?=$data_select->nomor_registrasi?></span></p>
                <p style="margin-left:5px;margin-top:2px">Project<span class="tab">: <?=$data_select->project?></span></p>
                <p style="margin-left:5px;margin-top:2px">Kawasan - Blok - No. Unit<span class="tab">: <?=$data_select->kawasan; ?> - <?=$data_select->blok; ?> - <?=$data_select->unit; ?></span></p>
                <p style="margin-left:5px;margin-top:2px">Customer<span class="tab">: <?=$data_select->customer?></span></p>
                <p style="margin-left:5px;margin-top:2px">Telp<span class="tab">: <?=$data_select->telepon?></span></p>
                <p style="margin-left:5px;margin-top:2px">No. HP<span class="tab">: <?=$data_select->no_hp?></span></p>
                <p style="margin-left:5px;margin-top:2px">Email<span class="tab">: <?=$data_select->email?>
                </span></p>
            </td>
    </table>
    <table style="padding-left:65px;padding-top:5px">
            <td id="box2">
                <p style="margin-left:5px;margin-top:2px">Nama Paket<span class="tab">: <?=$data_select->nama_paket?></span></p>
                <p style="margin-left:5px;margin-top:2px">Biaya Registrasi<span class="tab">: Rp.<?= number_format($data_select->biaya_registrasi)?></span></p>
                <p style="margin-left:5px;margin-top:2px">Harga Jasa Pengurusan<span class="tab">: Rp.<?=number_format($data_select->harga_jasa)?></span></p>
                <p style="margin-left:5px;margin-top:2px">Prakiraan Biaya<span class="tab">: Rp.<?=number_format($data_select->biaya_prakiraan)?></span></p>
            </td>
    </table>
    <table style="padding-left:65px;padding-top:5px">
            <td id="box2">
                <p style="margin-left:5px;margin-top:2px">Tgl Registrasi<span class="tab">: <?= $data_select->tanggal_document?></span></p>
                <p style="margin-left:5px;margin-top:2px">Tgl Rencana Survei<span class="tab">: <?= $data_select->tanggal_rencana_survei?></span></p>
                <p style="margin-left:5px;margin-top:2px">Tgl Rencana Pasang Instalasi<span class="tab">: <?= $data_select->tanggal_rencana_pemasangan?></span></p>
                <p style="margin-left:5px;margin-top:2px">Tgl Rencana Aktifasi<span class="tab">: <?= $data_select->tanggal_rencana_aktifasi?></span></p>
                <p style="margin-left:5px;margin-top:2px">Total Paket<span class="tab">: Rp.<?=number_format($data_select->total_paket)?></span></p>
                <p style="margin-left:5px;margin-top:2px">Deposit <?=$data_select->kategori_nama?><span class="tab">: Rp.<?=number_format($data_select->deposit_masuk)?></span></p>
                <p style="margin-left:5px;margin-top:2px">Total Yang Harus Dibayar<span class="tab">: Rp.<?=number_format($data_select->total,2,',','.')." ( ".strtoupper($terbilang)." )"; ?></span></p>
            </td>
    </table>
                    <br><br>
    <table style="padding-left:65px;padding-top:5px">
        <tr>
            <td width="50%"></td>
            <!-- <td>br>Mengetahui<br<br><br><br><br><br><?=$this->session->userdata('name')?></td> -->
            <td width="50%" style="padding-left:400px">Jakarta, <?=$tanggal?><br>Customer<br><br><br><br><?=$data_select->customer?></td>
        </tr>
    <table>
    <!-- <div class="col-md-12 col-sm-12 col-lg-12 row" style="padding-top:10px">
        
        <div class="col-md-6 " id = "box2" >
            <p>JAKARTA, <?=$tanggal?></p>
            <p>Mengetahui</p>
            <p class="lh-5 f-15" style="padding-top:65px;"><?=$this->session->userdata('name')?></p>
        </div>
        <div class="col-md-6" id = "box2" style="">
            <p>Menyetujui</p>
            <p class="lh-5 f-15" style="padding-top:65px;"><?=$data_select->customer?></p>
        </div>
    </div> -->
</div>
</body>

</html>