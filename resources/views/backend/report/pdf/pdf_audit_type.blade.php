
<!DOCTYPE html>
<html>
    <head>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>รายงานประเภทสินค้าที่ขาย</title>
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

    <table style="border-collapse:collapse;" width="100%" border="0">
        <tbody>
            <tr>
                <td class="text-right" colspan="4">ชื่อตลาด {!!$market->name_market!!} </td>
            </tr>
            <tr>
                <td class="text-right" colspan="4">วันที่ออกรายงาน : {{ date('Y-m-d') }}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="4" >วันที่สืบค้นรายงาน : {{$d_start}} - {{$d_end}}</td>
            </tr>
        </tbody>
    </table><br>

    <table style="border-collapse:collapse;" width="100%" border="1">
        <thead>
            <tr>
                <th class="text" >หมายเลขบูธ</th>
                <th class="text" >เลขที่ใบจอง</th>
                <th class="text" >ประเภทสินค้าที่ขาย</th>
                <th class="text" >ชื่อ-ลูกค้า</th>
                <th class="text" >วันที่ชำระเงิน</th>
                <th class="text" >ค่าบริการ</th>
                <th class="text" >สถานะ</th>
            </tr>
        </thead>

        {{-- Mock up --}}
        <tbody>
            {!!$tbodyhtml!!}
        </tbody>
    </table>


</body>
</html>
