<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', '')</title>
  <!-- Bootstrap CSS -->
  
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> --}}
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">


  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- My CSS -->
  <link rel="stylesheet" href="/css/main.css">
  
</head>

<body>
  <!-- JQuery -->
<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
  
  <script src="/js/jquery-3.7.1.min.js"></script>
  
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script src=" https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js "></script>
  <!-- My JS -->
  <script src="/js/main.js"></script>


  <div class="d-flex flex-row vh-100" id="body-wrapper">
    @include('partials.sidebar')

    <div id="main" class="flex-grow-1 overflow-y-auto">
      @include('partials.navbar')
      <div class="content-wrapper p-3">
        
        @if(session('alert-success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('alert-success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('alert-error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('alert-error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @yield('content')
      </div>


    </div>
  </div>

  @if(session('toast-success'))
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="10000">
      <div class="toast-header">
        <i class='bx bxs-check-square text-success fs-6 me-1' ></i>
        <strong class="me-auto text-success">Sukses</strong>

        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        {{ session('toast-success') }}
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#successToast').toast('show');
    });
  </script>
  @endif

  @if(session('toast-error'))
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="10000">
      <div class="toast-header">
        <i class='bx bxs-error text-danger fs-6 me-1'></i>
        <strong class="me-auto text-danger">Kesalahan</strong>

        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        {{ session('toast-error') }}
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#errorToast').toast('show');
    });
  </script>
  @endif


  <!-- Bootstrap JS -->
  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> --}}
  <script src="/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  <script src="/js/main.js"></script>
  <script>
    lucide.createIcons();

    $("[lucide-size]").each(function () {
      $(this).css("height", $(this).attr("lucide-size") + "px");
      $(this).css("width", $(this).attr("lucide-size") + "px");
    })
  </script>
</body>

</html>