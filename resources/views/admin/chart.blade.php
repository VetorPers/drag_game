<div class="box">

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
                        <th scope="row">0~6</th>
                        <td class="td1">{{ $all[0] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">6~7</th>
                        <td class="td2">{{ $all[1] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">7~8</th>
                        <td class="td3">{{ $all[2] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">>=8</th>
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
                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
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
                '0~6',
                '6~7',
                '7~8',
                '>=8'
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
            $.post('/admin/charts', {'grade_id': $(this).val()}, function (res) {
                allChart.data.datasets[0].data = res.data
                allChart.update()
            })
        })
    });
</script>
