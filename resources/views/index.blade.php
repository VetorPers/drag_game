@extends('pest')

@section('content')
    <div class="content-box">

        <div class="login-group">
            <div class="btn btn-play"></div>
        </div>
    </div>

    <script>
        $('.btn-play').click(function () {
            setTimeout(function () {
                $("body").mLoading();
            }, 800);
            window.location.href = "/pest/questions/{{rand(1,2)}}"
        })
    </script>
@endsection


