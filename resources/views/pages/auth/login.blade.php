<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login Admin</title>
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/app.css">
  <style>
    body {
      height: 100vh;

    }
    .bg-grad {
      background: rgb(37,95,190);
background: linear-gradient(130deg, rgba(37,95,190,1) 0%, rgba(0,234,255,1) 100%);
    }
  </style>
</head>

<body>

  <div class="row h-100">
    <div class="col p-5 d-flex justify-content-center align-items-center text-white bg-grad">
      <div class="card p-5 rounded-3 shadow">
        <h4 class="text-center mb-4 fw-bold">Login</h4>
        <p>Masukkan email dan password untuk login</p>
        <form action="/login" method="post" class="d-flex flex-column">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" placeholder="Email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" placeholder="Password" name="password" required>
          </div>
    
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
        @if (session()->has('error'))
      <div class="text-danger">
        {{ session('error') }}
      </div>
    @endif
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
