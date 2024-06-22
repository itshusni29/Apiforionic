<!DOCTYPE html>
<html lang="en" class="minimal-theme">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('assets/images/favicon-32x32.png') }}" type="image/png" />
  <link href="{{ asset('skodash/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('skodash/assets/css/bootstrap-extended.css') }}" rel="stylesheet" />
  <link href="{{ asset('skodash/assets/css/style.css') }}" rel="stylesheet" />
  <link href="{{ asset('skodash/assets/css/icons.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link href="{{ asset('skodash/assets/css/pace.min.css') }}" rel="stylesheet" />
  <title>Skodash - Bootstrap 5 Admin Template</title>
</head>
<body>
  <div class="wrapper">
    <main class="authentication-content">
      <div class="container-fluid">
        <div class="authentication-card">
          <div class="card shadow rounded-0 overflow-hidden">
            <div class="row g-0">
              <div class="col-lg-6 bg-login d-flex align-items-center justify-content-center">
                <img src="{{ asset('skodash/assets/images/error/login-img.jpg') }}" class="img-fluid" alt="">
              </div>
              <div class="col-lg-6">
                <div class="card-body p-4 p-sm-5">
                  <h5 class="card-title">Daftar Disini Ya!</h5>
                  <p class="card-text mb-5">Silahkan Daftar Dengan Akun Pribadi Kamu</p>
                  <form class="form-body" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="login-separater text-center mb-4">
                      <span>MASUK DENGAN EMAIL</span>
                      <hr>
                    </div>
                    <div class="row g-3">
                      <div class="col-12 ">
                        <label for="inputName" class="form-label">Nama</label>
                        <div class="ms-auto position-relative">
                          <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-person-circle"></i></div>
                          <input type="text" class="form-control radius-30 ps-5" id="inputName" name="name" placeholder="Enter Name" required>
                        </div>
                      </div>
                      <div class="col-12">
                        <label for="inputEmailAddress" class="form-label">Alamat Email</label>
                        <div class="ms-auto position-relative">
                          <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-envelope-fill"></i></div>
                          <input type="email" class="form-control radius-30 ps-5" id="inputEmailAddress" name="email" placeholder="Email Address" required>
                        </div>
                      </div>
                      <div class="col-12">
                        <label for="inputChoosePassword" class="form-label">Kata Kunci</label>
                        <div class="ms-auto position-relative">
                          <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-lock-fill"></i></div>
                          <input type="password" class="form-control radius-30 ps-5" id="inputChoosePassword" name="password" placeholder="Enter Password" required>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" required>
                          <label class="form-check-label" for="flexSwitchCheckChecked">Setuju dengan Syarat & Ketentuan</label>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="d-grid">
                          <button type="submit" class="btn btn-primary radius-30">BUAT AKUN</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  <script src="{{ asset('skodash/assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('skodashassets/js/pace.min.js') }}"></script>
</body>
</html>
