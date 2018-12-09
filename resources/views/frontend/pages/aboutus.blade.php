<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('vendor/uikit/css/uikit.min.css') }}" media="screen" />
  <link rel="stylesheet" href="{{ asset('vendor/datepicker/dist/datepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/aboutus.css') }}" media="screen" />
  <script type="text/javascript" src="{{ asset('vendor/jquery/jquery.js') }}"></script>
  <script type="text/javascript" src="{{ asset('vendor/fontawesome/js/all.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('vendor/uikit/js/uikit.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('vendor/uikit/js/uikit-icons.min.js') }}"></script>
  <title>Garden Buana - Tentang Kami</title>
</head>
<body>
<header class="uk-box-shadow-small uk-navbar navbar">
  <div class="uk-navbar-center">
    <a href="{{ route('homepage') }}" class="uk-navbar-item uk-logo logo">
      <img src="{{ asset('images/logobrand/gplogo-primary.png') }}" alt="gardenbuana">
    </a>
  </div>
</header>
<div class="uk-card uk-card-body uk-card-default contentabout_us uk-margin-top">
  <div class="contentabout_heading">
    Garden Buana
    <div class="hr"></div>
  </div>
  <div class="contentabout_subheading">
    Salah satu e-commerce yang menyediakan Jasa Penata Taman Hias (Gardener) yang dibutuhkan untuk menata lahan kosong atau membuat sebuah taman yang indah. Semua orang dapat menjadi bagian dalam Garden Buana dengan menjadi vendor Gardener.
  </div>
</div>
<div class="uk-card uk-card-body uk-card-default contentabout_visimisi uk-margin-top">
  <div class="uk-grid-collapse uk-grid-match" uk-grid>
    <div class="uk-width-1-2">
      <div class="uk-tile uk-tile-default contentabout_logo">
        <img src="{{ asset('images/logobrand/gplogo-white.png') }}" alt="gardenbuana-white">
      </div>
    </div>
    <div class="uk-width-1-2">
      <div class="uk-tile uk-tile-default uk-box-shadow-large contentvisimisi">
        <div class="uk-position-center">
          <div class="uk-margin">
            <div class="contentvisi_heading">
              Visi <div class="hr"></div>
            </div>
            <div class="contentvisi_subheading">
              Menjadi e-commerce terbesar di Indonesia di bidang lingkungan hijau
            </div>
          </div>
          <hr>
          <div class="uk-margin">
            <div class="contentmisi_heading">
              Misi <div class="hr"></div>
            </div>
            <div class="contentmisi_subheading">
              Memberdayakan UKM bidang pertamanan yang ada di seluruh penjuru Indonesia
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="uk-card uk-card-body uk-card-default ourteam">
  <div class="uk-container">
    <div class="uk-card-title ourteam-heading">Team Kami</div>
    <div class="uk-grid-medium uk-flex-center uk-grid-match" uk-grid>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s">
        <div class="uk-card uk-card-default ourteam-box">
          <div class="uk-card-media-top ourteam-box-header">
            <img src="{{ asset('images/teams/sony.jpg') }}" alt="">
          </div>
          <div class="uk-card-body uk-card-small ourteam-box-body">
            <div class="ourteam-box-title">Ana Velayati</div>
            <div class="ourteam-box-division">System Analyst</div>
          </div>
        </div>
      </div>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s">
        <div class="uk-card uk-card-default ourteam-box">
          <div class="uk-card-media-top ourteam-box-header">
            <img src="{{ asset('images/teams/sony.jpg') }}" alt="">
          </div>
          <div class="uk-card-body uk-card-small ourteam-box-body">
            <div class="ourteam-box-title">Chairul Umam</div>
            <div class="ourteam-box-division">Project Manager</div>
          </div>
        </div>
      </div>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s">
        <div class="uk-card uk-card-default ourteam-box">
          <div class="uk-card-media-top ourteam-box-header">
            <img src="{{ asset('images/teams/sony.jpg') }}" alt="">
          </div>
          <div class="uk-card-body uk-card-small ourteam-box-body">
            <div class="ourteam-box-title">Sony Darmawan</div>
            <div class="ourteam-box-division">Senior Web Programmer</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<footer class="footer">
  <div class="uk-card uk-card-body uk-card-small uk-card-default">
    <div class="uk-container">
      <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s">
          <div class="copyright">
            &copy; {{ date('Y') }}. Made with <span uk-icon="heart"></span> by Garden Buana
          </div>
        </div>
        <div class="uk-width-expand">
          <div class="uk-align-right footer_links">
            <a href="{{ route('aboutus') }}">Tentang Kami</a>
            <a href="#">Bergabung sebagai Vendor</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
</body>
</html>
