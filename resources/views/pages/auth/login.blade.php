<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login Admin</title>
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/app.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap');

    body {
      height: 100vh;
      font-family: 'Poppins', sans-serif;
    }

    .bg-grad {
      background: rgb(37, 95, 190);
      background: linear-gradient(130deg, rgba(37, 95, 190, 1) 0%, rgba(0, 234, 255, 1) 100%);
    }

    .bg-dots-darker {
      background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E")
    }

    .bg-gray-100 {
      --tw-bg-opacity: 1;
      background-color: rgb(243 244 246 / var(--tw-bg-opacity));
    }

    .ps-4\.5 {
      padding-left: 2.25rem;
    }

    .px-2\.5 {
      padding-left: 0.75rem;
      padding-right: 0.75rem;
    }

    .form-with-icon {
      position: relative;
    }

    .form-with-icon>input {
      padding-left: 2.25rem;
    }

    .form-with-icon>.form-icon {
      position: absolute;
      padding-left: 0.75rem;
      padding-right: 0.75rem;
      top: 50% !important;
      transform: translateY(-50%) !important;
    }

    .form-label {
      margin-bottom: 0.1rem;
      font-size: 0.875rem;
    }
    .animate-rotate {
      animation: rotation 1s infinite linear;
      -webkit-animation: rotation 1s infinite linear;
    }
    @keyframes rotation {
      from {
        transform: rotate(0deg);
        -webkit-transform: rotate(0deg);
      }
      to {
        transform: rotate(359deg);
        -webkit-transform: rotate(359deg);
      }
    }
  </style>
</head>

<body>

  <div class="d-flex flex-column h-100 bg-dot-darker bg-gray-100 bg-dots-darker justify-content-center align-items-center">
    <div class="p-2 justify-content-center align-items-center text-white row">
      <h4 class="text-center fw-bold text-dark mb-4">Si<span class="text-primary">Absensi</span></h4>
      <div class="card rounded-4 shadow-sm border-0" style="padding: 2rem;max-width: 28rem">
        <h5 class="text-center mb-3 fw-bold">Login</h5>
        <p class="text-center">Masukkan email dan password untuk login</p>
      
        <livewire:login-form />
      </div>
    </div>

  </div>

  <script>
    var alertMsg = "{{ session('alert') }}";

    if (alertMsg) {
      alert(alertMsg);
    }
  </script>

</body>

</html>