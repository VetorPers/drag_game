<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>三峡</title>
    <link rel="stylesheet" href="{{asset('css/question.css')}}">
    <link rel="stylesheet" href="{{asset('css/mloading.css')}}">
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/mloading.js')}}"></script>

</head>

<body>
<header>
    <div class="header-box">
        <audio id="next-q">
            <source src="{{asset('audio/next.mp3')}}"/>
        </audio>

        <div class="cloud-group">
            <div class="cloud cloud-middle">
                <img src="{{asset('img/cloud.png')}}" alt="">
            </div>
            <div class="cloud cloud-small">
                <img src="{{asset('img/cloud.png')}}" alt="">
            </div>
            <div class="cloud cloud-large">
                <img src="{{asset('img/cloud.png')}}" alt="">
            </div>
        </div>
        <div class="bird">
            <img src="{{asset('img/bird.png')}}" alt="">
        </div>
        <div class="sun">
            <img src="{{asset('img/sun.png')}}" alt="">
        </div>
    </div>
</header>

<div class="question-content-box">
    <div class="question-box">

        @foreach($questions as $question)
            <div class="question-content" data-id="{{$question->id}}" data-type="{{$question->type}}">
                <p class="question-sub">{{$question->title}}</p>
                @foreach($question->answers as $k=>$answer)
                    <div class="option" data-rec="{{$k+1}}" data-right="{{$answer->is_right}}"
                         data-aid="{{$answer->id}}"
                         style="background-image: url(/img/{{$imgs[$k]}}.png)">{{$answer->title}}</div>
                @endforeach
            </div>

            <div class="fruit-img" style="background-image: url({{$question->img}})"></div>
        @endforeach

    </div>

    <div class="clearBox"></div>
    <div class="next-page">下一题</div>
</div>

<script>
    var clickCount = 0,
        index = 1;
    $('.fruit-img').first().css('display', 'block');
    //桃子李子
    if ('{{$tree_sign}}' == 1) {
        $('body').css('background', 'url("/img/peach.jpg") no-repeat');
        $('.fruit-img').css({
            top: '230px',
            left: '376px'
        })
    } else {
        $('body').css('background', 'url("/img/lizibg.jpg") no-repeat');
        $('.fruit-img').css({
            top: '600px',
            left: '410px'
        })
    }

    //下一页
    var answerData = [], next = true;
    $('.next-page').click(function () {
        if (!next) {
            return;
        }
        next = false;
        var length = '{{$questions->count()}}';
        var answerIds = [], data = {};
        var currentQuestion = $('.question-box').children('.question-content').first();
        var questionId = $(currentQuestion).attr('data-id');
        var options = $(currentQuestion).children('.option');
        for (var i = 0; i < options.length; i++) {
            var optionSelected = $(options[i]).attr('data-selected');
            var optionId;
            if (optionSelected == 1) {
                optionId = $(options[i]).attr('data-aid');
                answerIds.push(optionId);
            }
        }
        data.question_id = questionId;
        data.answer_ids = answerIds;
        answerData.push(data);

        if (index == length) {
            setTimeout(function () {
                $("body").mLoading();
            }, 800);

            $.post('/pest/storeUserAnswer', {'data': answerData}, function (res) {
                if (res.result) {
                    window.location.href = '/pest/result?id=' + res.id
                }
            })
        } else {
            $('.question-box').children('.question-content').first().animate({
                opacity: 0
            }, 500, 'swing', function () {
                var firstImg = $('.question-box').children('.fruit-img').first();
                $(firstImg).remove();
                firstImg = $('.question-box').children('.fruit-img').first();
                $(firstImg).css('display', 'block');

                $('#next-q')[0].play()
            }).animate({
                'margin-left': "-100%"
            }, 600, 'swing', function () {
                $(this).remove();
                answer = [];
                clickCount = 0;
                next = true;
                if (length == index) {
                    $('.next-page').html('保存');
                }
            });
        }
        index++;
    });

    //框框点击事件
    $('.question-content').on('click', '.option', function () {
        var answerItem = [];
        var currentId = $(this).attr('data-rec');
        question_id = $(this).parent().attr('data-id');
        answerItem.push($(this).attr('data-aid'));

        selectOrCancel(currentId, this)
    });

    function selectOrCancel(index, $this) {
        var arr = ['A', 'B', 'C', 'D']
        if ($($this).attr('data-selected') == 1) {
            $($this).css('background-image', 'url("/img/' + arr[index - 1] + '.png")');
            $($this).attr('data-selected', 0);
        } else {
            $($this).css('background-image', 'url("/img/select' + arr[index - 1] + '.png")');
            $($this).attr('data-selected', 1);
        }
    }
</script>

</body>
</html>
