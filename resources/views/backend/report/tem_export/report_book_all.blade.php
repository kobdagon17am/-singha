
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
                <th class="text" rowspan="2">รายการ</th>
                @for ($i = 0; $i < 12; $i++)
                <th class="text" colspan="4">เดือน {{$i+1}}</th>
                @endfor
            </tr>
            <tr>
                @for ($i = 0; $i < 12; $i++)
                <th class="text" >Plaza 1</th>
                <th class="text" >Plaza 2</th>
                <th class="text" >TOTAL</th>
                <th class="text" >%</th>
                @endfor
            </tr>

        </thead>

        {{-- Mock up --}}
        <tbody>

            <tr>
                <td class="text">อัตราค่าเช่าถัวเฉลี่ย(ARR)</td>
                @for ($i = 0; $i < 12; $i++)
                <td class="text">-</td>
                <td class="text">-</td>
                <td class="text">-</td>
                <td class="text">-</td>
                @endfor
            </tr>
            <tr>
                <td class="text">อัตราลูกค้าเช่าพื้นที่(OCC%)</td>
                @for ($i = 0; $i < 12; $i++)
                <td class="text">-</td>
                <td class="text">-</td>
                <td class="text">-</td>
                <td class="text">-</td>
                @endfor
            </tr>
            <tr>
                <td class="text">พื้นที่สำหรับขายลูกค้า</td>
                @for ($i = 0; $i < 12; $i++)
                <td class="text">-</td>
                <td class="text">-</td>
                <td class="text">-</td>
                <td class="text">-</td>
                @endfor
            </tr>
            <tr>
                <td class="text">พื้นที่ขายได้</td>
                @for ($i = 0; $i < 12; $i++)
                <td class="text">-</td>
                <td class="text">-</td>
                <td class="text">-</td>
                <td class="text">-</td>
                @endfor
            </tr>
            <tr>
                <td class="text">พื้นที่ว่าง</td>
                @for ($i = 0; $i < 12; $i++)
                <td class="text">-</td>
                <td class="text">-</td>
                <td class="text">-</td>
                <td class="text">-</td>
                @endfor
            </tr>
            <tr>
                <td class="text">จำนวนลูกค้าเช่าพื้นที่</td>
                @for ($i = 0; $i < 12; $i++)
                <td class="text">-</td>
                <td class="text">-</td>
                <td class="text">-</td>
                <td class="text">-</td>
                @endfor
            </tr>
        </tbody>
    </table>


</body>
</html>
