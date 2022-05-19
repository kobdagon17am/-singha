
<!DOCTYPE html>
<html> 
    <head>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>รายงานชำระเงิน</title>
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

    <div class="text"><h3>รายงานชำระเงิน</h3></div>

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
                <th class="text">Booth</th>
                <th class="text">ลูกค้า</th>
                <th class="text">เบอร์</th>
                <th class="text">วันที่ชำระเงิน</th>
                <th class="text">จำนวนก่อน vat</th>
                <th class="text">ยอดที่ชำระ</th>
                <th class="text">สินค้า</th>
                <th class="text">สถานะ</th>
                <th class="text">หมายเหตุ</th>
                <th class="text">อุปกรณ์เสริม</th>
            </tr>
        </thead>

        {{-- Mock up --}}
        <tbody>
            @for($i=1;$i<=50;$i++)
            <tr>
                <td class="text">{{$i}}</td>
                <td class="text">number_booking{{$i}}</td>
                <td class="text">{{ date('Y-m-d') }}</td>
                <td class="text">Booth{{$i}}</td>
                <td class="text">name customer</td>
                <td class="text">081-1234-123</td>
                <td class="text">{{ date('Y-m-d') }}</td>
                <td class="text">-</td>
                <td class="text">-</td>
                <td class="text">product</td>
                <td class="text">status</td>
                <td class="text">note</td>
                <td class="text">เตาไฟฟ้า</td>
            </tr>
            @endfor
        </tbody>
    </table>

    
</body>
</html>