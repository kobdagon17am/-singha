
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
            <tr>
                <td class="text-right">วันที่ออกรายงาน : {{ date('Y-m-d') }}</td>
            </tr>
            <tr>
                <td class="text-right">วันที่สืบค้นรายงาน : {{$d_start}} - {{$d_end}}</td>
            </tr>
        </tbody>
    </table><br>

    <table style="border-collapse:collapse;" width="100%" border="1">
        <thead>
            <tr>
                <th class="text">ลำดับ</th>
                <th class="text">เลขที่ใบจอง</th>
                <th class="text">วันที่จัดงาน</th>
                <th class="text">ลูกค้า</th> 
                <th class="text">จำนวนเงินก่อน VAT</th> 
                <th class="text">สถานะ</th> 
                <th class="text">หมายเหตุ</th> 
            </tr>
        </thead>

        {{-- Mock up --}}
        <tbody>
            @for($i=1;$i<=50;$i++)
            <tr>
                <td class="text">{{$i}}</td>
                <td class="text">number_booking{{$i}}</td>
                <td class="text">-</td>
                <td class="text">-</td>
                <td class="text">-</td>
                <td class="text">-</td>
                <td class="text">-</td>
            </tr>
            @endfor
        </tbody>
    </table>

    
</body>
</html>