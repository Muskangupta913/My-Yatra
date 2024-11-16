<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME')}}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .container{
            margin-top: 150px;
        }
        .container .col-md-3{
            text-align: center;
        }
        .container .col-md-3 img{
         width: 50px;
            display: block;
            text-align: center;
            margin: 20px auto;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3 text-center m-auto">
                <div class="card card-body text-center">
                     <img src="{{ asset("assets/img/correct.png")}}" alt="">
                     <h4>Email Verified</h4>
                     <p>{{$msg}}</p>
                     <a href="/" class="btn btn-primary px-5 py-3">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>