<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Perpustakaan Digital</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
:root{--primary:#038666;--primary-dark:#1B4322;--dark:#081C15;--light:#EBF2FA}body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;scroll-behavior:smooth}.navbar{transition:all .3s;padding:1rem 0}.navbar.scrolled{background:#fff!important;box-shadow:0 2px 10px rgba(0,0,0,.1)}.navbar.scrolled .nav-link,.navbar.scrolled .navbar-brand{color:var(--dark)!important}.hero{min-height:100vh;background:linear-gradient(135deg,#038666 0%,#1B4322 100%);color:#fff;display:flex;align-items:center;padding-top:80px}.stat-card{background:#fff;border-radius:12px;padding:2rem;text-align:center;box-shadow:0 4px 6px rgba(0,0,0,.1);transition:transform .3s;margin-bottom:1.5rem}.stat-card:hover{transform:translateY(-5px)}.stat-icon{width:60px;height:60px;background:var(--primary);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:1.5rem;color:#fff}.stat-number{font-size:2.5rem;font-weight:700;color:var(--primary);margin:0}.feature-card{text-align:center;padding:2rem;transition:all .3s}.feature-card:hover{background:var(--light);border-radius:12px}.feature-icon{width:80px;height:80px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;font-size:2rem;color:#fff}.book-card{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 6px rgba(0,0,0,.1);transition:all .3s;margin-bottom:2rem}.book-card:hover{transform:translateY(-5px);box-shadow:0 8px 15px rgba(0,0,0,.15)}.book-cover{width:100%;height:250px;background:linear-gradient(135deg,#038666 0%,#1B4322 100%);display:flex;align-items:center;justify-content:center;font-size:3rem;color:#fff}.book-info{padding:1.5rem}.btn-cta{background:#fff;color:var(--primary);padding:.875rem 2.5rem;border-radius:50px;font-weight:600;font-size:1.125rem;transition:all .3s}.btn-cta:hover{background:var(--primary);color:#fff;transform:scale(1.05)}footer{background:var(--dark);color:#fff;padding:3rem 0 1rem}
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top" style="background:transparent">
<div class="container">
<a class="navbar-brand text-white fw-bold fs-4" href="#home"><i class="bi bi-book-fill me-2"></i>Perpustakaan Digital</a>
<button class="navbar-toggler border-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav mx-auto">
<li class="nav-item"><a class="nav-link text-white px-3" href="#home">Home</a></li>
<li class="nav-item"><a class="nav-link text-white px-3" href="#fitur">Fitur</a></li>
<li class="nav-item"><a class="nav-link text-white px-3" href="#tentang">Tentang</a></li>
<li class="nav-item"><a class="nav-link text-white px-3" href="#statistik">Statistik</a></li>
</ul>
<div>
<a class="btn btn-outline-light me-2" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i>Login</a>
<a class="btn btn-outline-light" href="{{ route('register') }}"><i class="bi bi-person-plus me-1"></i>Daftar Sekarang</a>
</div>
</div>
</div>
</nav>
<section class="hero" id="home">
<div class="container">
<div class="row align-items-center">
<div class="col-lg-7">
<h1 class="display-3 fw-bold mb-4">Sistem Informasi Perpustakaan Digital</h1>
<p class="lead mb-4">Kelola koleksi buku, anggota, dan peminjaman dalam satu tempat</p>
<a href="{{ route('katalog') }}" class="btn btn-cta"><i class="bi bi-book me-2"></i>Lihat Koleksi</a>
</div>
<div class="col-lg-5 text-center d-none d-lg-block"><i class="bi bi-bookshelf" style="font-size:12rem;opacity:.2"></i></div>
</div>
</div>
</section>
<section class="py-5 bg-light" id="statistik" style="margin-top:-80px;position:relative;z-index:2">
<div class="container"><div class="row">
<div class="col-md-3 col-sm-6"><div class="stat-card"><div class="stat-icon"><i class="bi bi-book"></i></div><h2 class="stat-number">{{ $totalBuku }}</h2><p class="text-muted mb-0">Total Buku</p></div></div>
<div class="col-md-3 col-sm-6"><div class="stat-card"><div class="stat-icon" style="background:#10B981"><i class="bi bi-people"></i></div><h2 class="stat-number">{{ $totalAnggota }}</h2><p class="text-muted mb-0">Anggota Aktif</p></div></div>
<div class="col-md-3 col-sm-6"><div class="stat-card"><div class="stat-icon" style="background:#F59E0B"><i class="bi bi-arrow-repeat"></i></div><h2 class="stat-number">{{ $bukuDipinjam }}</h2><p class="text-muted mb-0">Sedang Dipinjam</p></div></div>
<div class="col-md-3 col-sm-6"><div class="stat-card"><div class="stat-icon" style="background:#10B981"><i class="bi bi-check-circle"></i></div><h2 class="stat-number">{{ $bukuTersedia }}</h2><p class="text-muted mb-0">Buku Tersedia</p></div></div>
</div></div>
</section>
<section class="py-5" id="fitur">
<div class="container">
<div class="text-center mb-5"><h2 class="display-5 fw-bold mb-3">Fitur Unggulan</h2><p class="text-muted fs-5">Kelola perpustakaan dengan fitur lengkap dan mudah digunakan</p></div>
<div class="row">
<div class="col-md-4"><div class="feature-card"><div class="feature-icon"><i class="bi bi-journal-bookmark"></i></div><h4 class="fw-bold mb-3">Manajemen Buku</h4><p class="text-muted">Kelola koleksi buku dengan mudah. Tambah, edit, hapus, dan cari buku berdasarkan judul atau pengarang.</p></div></div>
<div class="col-md-4"><div class="feature-card"><div class="feature-icon"><i class="bi bi-person-badge"></i></div><h4 class="fw-bold mb-3">Manajemen Anggota</h4><p class="text-muted">Data anggota terorganisir dengan baik. Kelola informasi anggota dan status keanggotaan dengan efisien.</p></div></div>
<div class="col-md-4"><div class="feature-card"><div class="feature-icon"><i class="bi bi-arrow-left-right"></i></div><h4 class="fw-bold mb-3">Peminjaman</h4><p class="text-muted">Catat peminjaman dan pengembalian buku. Sistem otomatis mengelola stok buku tersedia.</p></div></div>
</div>
</div>
<section class="py-5 bg-light" id="koleksi">
<div class="container">
<div class="text-center mb-5"><h2 class="display-5 fw-bold mb-3">Koleksi Terbaru</h2><p class="text-muted fs-5">Jelajahi buku-buku terbaru di perpustakaan kami</p></div>
<div class="row">
@forelse($bukuTerbaru as $buku)
<div class="col-md-4"><div class="book-card"><div class="book-cover"><i class="bi bi-book"></i></div><div class="book-info"><h5 class="fw-bold mb-2">{{ $buku->judul }}</h5><p class="text-muted mb-1"><i class="bi bi-person me-1"></i>{{ $buku->pengarang }}</p><p class="text-muted mb-2"><i class="bi bi-calendar me-1"></i>{{ $buku->tahun_terbit }}</p><span class="badge {{ ($buku->stok_fisik > 0 || $buku->stok_digital > 0) ? 'bg-success' : 'bg-secondary' }}">{{ ($buku->stok_fisik > 0 || $buku->stok_digital > 0) ? 'Tersedia' : 'Kosong' }}</span></div></div></div>
@empty
<div class="col-12 text-center py-5"><i class="bi bi-inbox" style="font-size:4rem;color:#9CA3AF"></i><p class="text-muted mt-3">Belum ada koleksi buku</p></div>
@endforelse
</div>
</div>
</section>
<section class="py-5" id="tentang">
<div class="container"><div class="row align-items-center">
<div class="col-lg-6 mb-4 mb-lg-0">
<h2 class="display-5 fw-bold mb-4">Tentang Perpustakaan</h2>
<p class="lead mb-4">Sistem informasi perpustakaan digital yang modern dan efisien untuk mengelola seluruh operasional perpustakaan.</p>
<div class="mb-3"><h5 class="fw-bold"><i class="bi bi-clock me-2"></i>Jam Operasional</h5><p class="text-muted mb-1">Senin - Jumat: 08:00 - 16:00 WIB</p><p class="text-muted">Sabtu: 08:00 - 12:00 WIB</p></div>
<div class="mb-3"><h5 class="fw-bold"><i class="bi bi-geo-alt me-2"></i>Alamat</h5><p class="text-muted">Jl. Perpustakaan No. 123, Jakarta, Indonesia</p></div>
</div>
<div class="col-lg-6 text-center"><i class="bi bi-building" style="font-size:12rem;color:var(--primary);opacity:.1"></i></div>
</div></div>
</section>
<footer>
<div class="container"><div class="row">
<div class="col-md-4 mb-4"><h5 class="fw-bold mb-3"><i class="bi bi-book-fill me-2"></i>Perpustakaan Digital</h5><p class="text-white-50">Sistem informasi perpustakaan modern untuk pengelolaan koleksi buku, anggota, dan peminjaman.</p></div>
<div class="col-md-4 mb-4"><h5 class="fw-bold mb-3">Menu</h5><div class="d-flex flex-column gap-2"><a href="#home" class="text-white-50 text-decoration-none">Home</a><a href="#fitur" class="text-white-50 text-decoration-none">Fitur</a><a href="#tentang" class="text-white-50 text-decoration-none">Tentang</a><a href="#statistik" class="text-white-50 text-decoration-none">Statistik</a></div></div>
<div class="col-md-4 mb-4"><h5 class="fw-bold mb-3">Kontak</h5><div class="d-flex flex-column gap-2 text-white-50"><div><i class="bi bi-envelope me-2"></i>perpustakaan@example.com</div><div><i class="bi bi-telephone me-2"></i>+62 123 4567 890</div><div><i class="bi bi-geo-alt me-2"></i>Jakarta, Indonesia</div></div></div>
</div><hr style="border-color:rgba(255,255,255,.1)"><div class="text-center text-white-50 py-3"><p class="mb-0">&copy; 2026 Perpustakaan Digital. Built with Laravel 11 & Bootstrap 5.</p></div></div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>window.addEventListener('scroll',function(){const n=document.querySelector('.navbar');window.scrollY>50?n.classList.add('scrolled'):n.classList.remove('scrolled')});document.querySelectorAll('a[href^="#"]').forEach(a=>{a.addEventListener('click',function(e){e.preventDefault();const t=document.querySelector(this.getAttribute('href'));t&&t.scrollIntoView({behavior:'smooth',block:'start'})})});</script>
</body>
</html>

</section>

