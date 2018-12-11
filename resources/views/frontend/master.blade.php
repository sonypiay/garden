<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('frontend.includes.meta-header')
<title>@yield('headtitle')</title>
</head>
<body>
<div id="app">
@yield('maincontent')
</div>
@if( $request->route()->getName() != 'homepage' AND
$request->route()->getName() != 'loginpage_customer' AND
$request->route()->getName() != 'registerpage_customer' AND
$request->route()->getName() != 'loginpage_vendor' AND
$request->route()->getName() != 'lupapasswordcustomer_page' AND
$request->route()->getName() != 'loginpage' AND
$request->route()->getName() != 'signuppage' AND
$request->route()->getName() != 'lupapasswordcustomer_page' AND
$request->route()->getName() != 'lupapasswordvendor_page'
)
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
@endif
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>
