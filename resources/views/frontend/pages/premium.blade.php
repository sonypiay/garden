<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('vendor/uikit/css/uikit.min.css') }}" media="screen" />
  <link rel="stylesheet" href="{{ asset('vendor/datepicker/dist/datepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/premium.css') }}" media="screen" />
  <script type="text/javascript" src="{{ asset('vendor/jquery/jquery.js') }}"></script>
  <script type="text/javascript" src="{{ asset('vendor/fontawesome/js/all.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('vendor/uikit/js/uikit.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('vendor/uikit/js/uikit-icons.min.js') }}"></script>
  <title>Garden Buana | Premium</title>
</head>
<body>
@include('frontend.includes.navbar-white')
<!--<header class="uk-box-shadow-small uk-navbar navbar">
  <div class="uk-navbar-left">
    <a href="{{ route('homepage') }}" class="uk-navbar-item uk-logo logo">
      <img src="{{ asset('images/logobrand/gplogo-primary-new.png') }}" alt="gardenbuana">
    </a>
  </div>
</header>-->
<div id="app">
  <premiumpage url="{{ url('/') }}" :bankpayment="{{ json_encode( $bankpayment ) }}" />
</div>
<script src="{{ asset('js/app.js') }}"></script>
<footer class="footer">
  <div class="uk-card uk-card-body uk-card-default mainfooter">
    <div class="uk-container">
      <div class="uk-grid-medium" uk-grid>
        <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s">
          <div class="aboutus">
            <div class="footer-aboutus_heading">Tentang Garden Buana</div>
            <div class="footer-aboutus_text">
              Garden Buana merupakan salah satu e-commerce yang menyediakan Jasa Penata Taman Hias (Gardener) yang dibutuhkan untuk menata lahan kosong atau membuat sebuah taman yang indah. Semua orang dapat menjadi bagian dalam Garden Buana dengan menjadi vendor Gardener.
            </div>
          </div>
        </div>
        <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s">
          <ul class="uk-nav footer_links">
            <li><a href="{{ route('aboutus') }}">Tentang Kami</a></li>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Kebijakan Privasi</a></li>
            <li><a href="#">Syarat &amp; Ketentuan</a></li>
          </ul>
        </div>
        <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s">
          <div class="contactus">
            <div class="footer-contact_heading">Kontak Kami</div>
            <div class="footer-contact_text">
              Jl. Raya Meruya Selatan No. 1 Kembangan, Jakarta Barat<br>
              <a href="mailto: cs@example.com">cs@gardenbuana.id</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="uk-card uk-card-body uk-card-small uk-card-default">
    <div class="uk-text-center copyright">
      &copy; {{ date('Y') }}. Made with <span uk-icon="heart"></span> by Garden Buana
    </div>
  </div>
</footer>
</body>
</html>
