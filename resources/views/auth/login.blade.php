<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIAKAD - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"></head>

    <link rel="stylesheet" href="{{ asset('/css/login.css') }}">
    
    <style>
        /* .card-login {
            width: 500px;
            margin-top: 100px
        } */

    </style>
<body>
    <div class="container p-0">
        <div class="login-box">
            <div class="signin">
                <h2 class="mb-5">SIAKAD</h2>
                <form action="{{ url('/') }}" method="POST">
                    @csrf
                    <div class="textbox">
                        <input type="text" placeholder="NIDN/NPM" name="email" id="email" required>
                    </div>
                    <div class="textbox">
                        <input type="password" placeholder="Password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn">Masuk</button>
                </form>
            </div>
            <div class="welcome">
                <h2>SISTEM INFORMASI AKADEMIK</h2>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>