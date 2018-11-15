<nav class="uk-card uk-card-body uk-card-default uk-card-small navcustsetting">
  <ul class="uk-nav uk-nav-default">
    @php $membersince = new DateTime( $myaccount->customer_registered ) @endphp
    <li class="uk-nav-header membersince">Anggota sejak: {{ $membersince->format('M d, Y') }}</li>
    <li><a href="{{ route('editprofile_page') }}">Rincian Akun</a></li>
    <li><a href="#">Ganti Password</a></li>
    <li><a href="#">Alamat Email</a></li>
    <li><a href="#">Nomor Telepon</a></li>
    <li><a href="#">Rekening Bank</a></li>
  </ul>
</nav>
