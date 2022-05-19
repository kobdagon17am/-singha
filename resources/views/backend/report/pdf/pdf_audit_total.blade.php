
<!DOCTYPE html>
<html>
    <head>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>รายงานแสดงข้อมูลทั้งหมด</title>
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
                <th class="text">ลำดับ</th>
                <th class="text">เลขที่ใบจอง</th>
                <th class="text">วันในสัปดาห์</th>
                <th class="text">ชื่อบูท</th>
                <th class="text">วันที่จัดงาน</th>
                <th class="text">ชื่อลูกค้า</th>
                <th class="text">วันที่ชำระเงิน</th>
                <th class="text">ค่าบริการ Booth</th>
                <th class="text">ค่าบริการอื่นๆ</th>
                <th class="text">ส่วนลด</th>
                <th class="text">ค่าบริการก่อนVAT</th>
                <th class="text">VAT 7%</th>
                <th class="text">จำนวนเงินรวม</th>
                <th class="text">ภาษีหัก ณ ที่จ่าย</th>
                <th class="text">ยอดที่ต้องชำระเงิน</th>
                <th class="text">สถานะการใช้งาน</th>
                <th class="text">สถานะการจอง</th>
                <th class="text">หมายเหตุ</th>

            </tr>
        </thead>

        {{-- Mock up --}}
        <tbody>

            {{-- @foreach ($transactions as $item)
            <tr class="text"  >
            <th  class="text">{{$item->trans_id}}</th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"> </th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
        </tr>
            @endforeach --}}
           {!!$tbodyhtml!!}
        {{-- <tr class="text"  >
            <th  class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"> </th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text">{{$sumgrand_total}}</th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
        </tr> --}}
        </tbody>
    </table>


</body>
</html>
