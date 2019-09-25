<div class="box">
    <audio id="refreshi" autoplay>
        <source src="{{asset('audio/refreshi.mp3')}}"/>
    </audio>

    <div class="box-header with-border">
        <div class="col-md-3">
            <label class="col-sm-5 control-label text-center">总答题次数: </label>
            <label class="">{{ $total }}</label>
        </div>
        <div class="col-md-3">
            <label class="col-sm-5 control-label text-center">今日答题次数: </label>
            <label class="">{{ $today }}</label>
        </div>
    </div>

    <div class="box-body">
        <div class="col-md-4">
            <div class="col-md-offset-1" style="margin-top: 30%">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>分数段</th>
                        <th>数量(次)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">0~60</th>
                        <td class="td1">{{ $all[0] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">60~70</th>
                        <td class="td2">{{ $all[1] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">70~80</th>
                        <td class="td3">{{ $all[2] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">>=80</th>
                        <td class="td4">{{ $all[3] }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <div class="col-md-12">
                <div style="position: relative; height:70vh; width:50vw">
                    <canvas id="all-chart" height="400" width="400"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <select class="grades-select js-states form-control" name="state">
                <option></option>
                <option value="0">全部</option>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}"
                            @if($grade->id==$grade_id)
                                selected
                            @endif
                    >{{ $grade->name }}</option>
                @endforeach
            </select>

            <div class="media" style="margin-top: 200%">
                <div class="media-body">
                    <h4 class="media-heading">Tips:</h4>
                    <div class="small" style="margin-top: 5%">
                        <ul class="list-unstyled">
                            <li><p>选择班级查看班级内分数分布图。</p></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(function () {
        $('.grades-select').select2({
            placeholder: "选择班级",
            allowClear: true
        });

        var data = {
            datasets: [{
                data: [$('.td1').text(), $('.td2').text(), $('.td3').text(), $('.td4').text()],
                backgroundColor: [
                    '#ff6384',
                    '#ff9f40',
                    '#ffcd56',
                    '#4bc0c0'
                ]
            }],

            labels: [
                '0~60',
                '60~70',
                '70~80',
                '>=80'
            ]
        };

        var allChart = new Chart($('#all-chart'), {
            type: 'doughnut',
            data: data,
            options: {
                maintainAspectRatio: false,
                title: {
                    display: true,
                    text: '成绩分布(人)'
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 20
                    }
                }
            }
        });

        $('.grades-select').change(function () {
            // $.post('/admin/charts', {'grade_id': $(this).val()}, function (res) {
            //     allChart.data.datasets[0].data = res.data
            //     allChart.update()
            // })
            location.href = '/admin?grade_id=' + $(this).val();
        });

        function forceSafariPlayAudio() {
            audioEl.load(); // iOS 9   还需要额外的 load 一下, 否则直接 play 无效
            audioEl.play(); // iOS 7/8 仅需要 play 一下
        }

        var audioEl = $('#refreshi')[0];

        // 可以自动播放时正确的事件顺序是
        audioEl.addEventListener('play', function () {
            // 当 audio 能够播放后, 移除这个事件
            window.removeEventListener('touchstart', forceSafariPlayAudio, false);
        }, false);

        // 由于 iOS Safari 限制不允许 audio autoplay, 必须用户主动交互(例如 click)后才能播放 audio,
        // 因此我们通过一个用户交互事件来主动 play 一下 audio.
        window.addEventListener('touchstart', forceSafariPlayAudio, false);

        // 自动刷新页面
        var maxTime = 3; // seconds
        var time = maxTime;
        $('body').on('keydown mousemove touchmove', function (e) {
            time = maxTime;
        });
        var intervalId = setInterval(function () {
            time--;
            if (time <= 0) {
                location.reload()
            }
        }, 1000)
    });
</script>
