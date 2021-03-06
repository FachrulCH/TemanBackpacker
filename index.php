<?php
//if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
include_once "_include/db_function.php";
include_once "_include/template.php";
include_once "_include/Exp.php";
include_once "_include/user.php";
include_once "_include/trip.php";

//load data pengalaman terpopuler
$exp        = Exp_list_hot();
$user_count = User_count();
$trip_count = Trip_count();
$exp_count  = Exp_count();
?>
<!doctype html>
<html>
<head>
<?php
        // memanggil fungsi untuk generate meta tag dan include file CSS & JS yg diperlukan
        // memiliki argumen title halaman
        get_meta('Cari teman, Cari petualangan');
?>

    <link rel="stylesheet" type="text/css" href="<?= URLSITUS ?>css/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?= URLSITUS ?>css/slick/slick-theme.css"/>
    <style type="text/css">
        .multiple-items{
            max-width: 350px;
        }
    </style>
</head>
<body>
<section data-role="page" id="home">
<?php
            // Memanggil fungsi untuk generate panel samping
            //get_panel_search();
            get_panel()
?>
<?php
            // Membuat menu header, isinya tombol back dan panel
            // Memiliki argumen variabel jugul header
            get_header_index('TemanBackpacker');
?>
	<article role="main" class="ui-content">
            <div class="kepala"> 
                <div class="welcome"><p>TEMUKAN PETUALANGANMU!</p>
                    <p>Telusuri keindahan nusantara, cari teman seperjalanan, ataupun pengalaman berharga.</p>
                </div>
                <div class="ketengah">
                    <form method="get" action="<?= URLSITUS ?>pencarian/" id="pencarian" data-ajax="false">
                        <div data-role="controlgroup" data-type="horizontal">
                        <input type="text" size="20" placeholder="Nama Kota" name="t_tujuan" id="t_tujuan" data-wrapper-class="controlgroup-textinput ui-btn">
                        <button type="submit" class="ui-btn ui-icon-search ui-btn-icon-left ui-btn-icon-notext" id="b_cari">Cari</button>
                        </div>
                        <div id="hasil"> 
                            <input name="location" type="hidden" value="">
                        </div>
                    </form>
                </div>
            </div>
            
            <hr/>
            <p class="hrfKecil ketengah" style="padding-top: 20px;">
                Selamat Datang di TemanBackpacker, situs untuk menemukan rencana liburan dan teman baru mu, <?= tautan('user/registrasi/', 'Ayo gabung!')?></a>
            </p>
            <p class="ketengah" style="font-size: .6em;">Ada <?= tautan('user/', $user_count['jumlah'] .' Travelers') ?> yang berbagi <?= tautan('trip/', $trip_count['jumlah'] .' rencana perjalanan') ?> , dan <?= tautan('pengalaman/', $exp_count['jumlah'] .' pengalaman perjalanan') ?> loh</p>
            <hr/>
            <div class="ui-grid-b">
                <div class="ui-block-a"><div class="ketengah" style=" background-color: rgb(23, 186, 173); min-height:140px;margin: 5px;">
                        <a href="<?= URLSITUS ?>trip/" data-ajax="false"><p class="judul">Rencanakan liburanmu</p><img src="<?= URLSITUS ?>css/images/calendar_64px.png"/></a></div></div>
                <div class="ui-block-b"><div class="ketengah" style=" background-color: rgb(244, 185, 0); min-height:140px;margin: 5px;">
                        <a href="<?= URLSITUS ?>user/" data-ajax="false"><p class="judul">Temukan teman seperjalanan</p><img src="<?= URLSITUS ?>css/images/pin_64px.png"/></a></div></div>
                <div class="ui-block-c"><div class="ketengah" style=" background-color: rgb(70, 186, 23); min-height:140px;margin: 5px;">
                        <a href="<?= URLSITUS ?>pengalaman/" data-ajax="false"><p class="judul">Berbagi pengalaman</p><img src="<?= URLSITUS ?>css/images/chat_64px.png"/></a></div></div>
            </div><!-- /grid-b -->
            <hr/>
            <br/>
            
            <div class="multiple-items ditengah">
                <div><img data-lazy="<?= URLSITUS ?>_gambar/galeri/fit/masjid-jawa-tengah.jpg"/><div class="caption"><h1>Bersama Lebih Baik</h1>Ayo gabung dengan rencana perjalanan TemanBackpacker, siapa tau kamu bisa ditraktir!</div></div>
                <div><img data-lazy="<?= URLSITUS ?>_gambar/galeri/fit/air-terjun-gitgit-bal.jpg"/><div class="caption"><h1>Jelajahi Nusantara</h1>Temukan tempat liburan kamu, dari Sabang sampai Merauke, dari Miangas sampai Pulau Rote</div></div>
                <div><img data-lazy="<?= URLSITUS ?>_gambar/galeri/fit/anak-band.jpg"/><div class="caption"><h1>Berkenalan</h1>Tambah relasi kamu dengan menemukan teman di lokasi liburan</div></div>
                <div><img data-lazy="<?= URLSITUS ?>_gambar/galeri/fit/badak.jpg"/><div class="caption"><h1>Inspirasi</h1>Telusuri pengalaman liburan TemanBackpacker, temukan tempat baru, mari berpetualang!</div></div>
            </div>
            
	</article><!-- /content -->
<?php
	get_footer();
?>
</section><!-- /page -->
<!-- Peta -->
<script src="http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false"></script>
<script src="<?= URLSITUS ?>js/jquery.geocomplete.min.js"></script>
<!-- End Peta -->
<script type="text/javascript" src="<?= URLSITUS ?>js/slick/slick.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#t_tujuan").geocomplete({
            details: "#hasil"
        });
        $('#t_tujuan').keypress(function (e) {
            if (e.which == 13) {
              setTimeout("$('#b_cari').click();",900);
              //alert('Submit nih');
              return false;    //<---- Add this line
            }
          });
           
           $('.multiple-items').slick({
        mobileFirst: true,
        //infinite: true,
        dots: true,
        dotsClass: 'slick-dots',
        centerMode: true,
        //centerPadding: '60px',
        variableWidth: true,
        lazyLoad: 'ondemand',
        autoplay: true,
        autoplaySpeed: 3500,
        speed: 1000
      });
    });
    
    
</script>
</body>
</html>
<?php //ob_flush(); ?>