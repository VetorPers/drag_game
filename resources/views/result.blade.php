@extends('pest')

@section('content')

    <div class="content-box">

        @if($is_pass)
            <div class="over-box">
                <audio id="winer" autoplay>
                    <source src="{{asset('audio/win.wav')}}"/>
                </audio>

                <div class="score" style="background-image: url(/img/win.png)">
                    {{$score}}
                </div>
                <div class="pass">
                    <img src="/img/pass.png" alt="">
                </div>
            </div>
        @else
            <div class="over-box">
                <audio id="losser" autoplay>
                    <source src="{{asset('audio/loss.mp3')}}"/>
                </audio>

                <div class="score" style="background-image: url(/img/loss.png)">
                </div>
                <div class="pass" onclick="Restart()">
                    <img src="/img/restart.png" alt="">
                </div>
            </div>
        @endif
    </div>

    <script>
        function Restart() {
            location.href = '/'
        }
    </script>

@endsection
