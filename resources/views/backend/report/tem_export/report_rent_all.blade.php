
<!DOCTYPE html>
<html>
    <head>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>รายงานทะเบียนคุมจอง</title>
<style>
	body {
		font-family: "thaisarabun";

	}
	.line-height {
		line-height:5px;
	}
	.text{
		text-align:center;
		font-size:20px;
	}
	.text-left{
		text-align:left;
		font-size:20px;
	}
	.text-right{
		text-align:right;
		font-size:20px;
	}
</style>
</head>

<body>

    <div class="text"><h3>รายงานทะเบียนคุมจอง</h3></div>

    <table style="border-collapse:collapse;" width="100%" border="0">
        <tbody>
            {{-- <tr>
                <td class="text-right">วันที่ออกรายงาน : {{ date('Y-m-d') }}</td>
            </tr>
            <tr>
                <td class="text-right">วันที่สืบค้นรายงาน : {{$d_start}} - {{$d_end}}</td>
            </tr> --}}
        </tbody>
    </table><br>

    <table style="border-collapse:collapse;" width="100%" border="1" >
        <thead>
            <tr>
                <th class="text" rowspan="2">บูธ</th>
                <th class="text" rowspan="2">อัตราค่าบริการ</th>
                <th class="text" colspan="30">เดือน นี้</th>

            </tr>
            <tr>
                @for ($i = 0; $i < 30; $i++)
                <th class="text" >Plaza 1</th>
                @endfor
            </tr>

        </thead>

        {{-- Mock up --}}
        <tbody>

            @foreach ($bootall as $boot)
            <tr>

            <th class="text" >{{$boot->name}}</th>
            <th class="text" >{{$boot->price}}</th>
            </tr>
            @endforeach
        </tbody>
    </table>


</body>
</html>
