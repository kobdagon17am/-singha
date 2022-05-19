
<!DOCTYPE html>
<html>
    <head>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>รายงานการจอง</title>
<style>
	body {
		font-family: "thaisarabun";
        /* font-size:14px; */
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

    td {
        padding: 0;
    }
</style>
</head>

<body>

    {{-- <div class="text"><h3>รายงานการจอง</h3></div> --}}

    {{-- <table style="border-collapse:collapse;" width="100%" border="0">
        <tbody>
            <tr>
                <td class="text-right">วันที่ออกรายงาน : {{ date('Y-m-d') }}</td>
            </tr>
            <tr>
                <td class="text-right">วันที่สืบค้นรายงาน : {{$d_start}} - {{$d_end}}</td>
            </tr>
        </tbody>
    </table><br> --}}

    <table style="border-collapse:collapse;" width="100%" border="1">
        <thead>
            <tr >
                <th class="text" rowspan="2" style="background-color:#ACD8E5" >บูธ</th>
                <th class="text" rowspan="2" style="background-color:#ACD8E5" >ราคาบูธ</th>
                <th class="text" colspan="30" align="center" style="background-color:#ACD8E5" >เดือน{{$month}}</th>
            </tr>
            <tr>
                @for ($i = 0; $i < 31; $i++)


                <th class="text" style="background-color:#ACD8E5" >วันที่ {{($i+1)}}</th>

                @endfor
            </tr>

        </thead>

        {{-- Mock up --}}
        <tbody>
            {!!$html!!}
        </tbody>
    </table>


</body>
</html>
