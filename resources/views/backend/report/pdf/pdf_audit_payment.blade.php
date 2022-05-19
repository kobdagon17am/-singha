
<!DOCTYPE html>
<html>
    <head>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>รายงานการชำระเงิน</title>
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

    {{-- <div class="text">รายงานการชำระเงิน</div> --}}

    <table style="border-collapse:collapse;" width="100%" border="0">
        <tbody>
            <tr>
                <td class="text-right" colspan="4">ชื่อตลาด {!!$market->name_market!!} </td>
            </tr>
            <tr>
                <td class="text-right" colspan="4">วันที่ออกรายงาน : {{date('d/m/Y')}}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="4" >วันที่สืบค้นรายงาน : {{date('d/m/Y', strtotime($d_start))}} - {{date('d/m/Y', strtotime($d_end))}}</td>
            </tr>
        </tbody>
    </table><br>

    <table  width="100%" border = "1">
        <thead>
            <tr style="background-color:#4aba53">
                <th class="text" >ลำดับ</th>
                <th class="text">เลขที่ใบจอง</th>
                <th class="text">ประเภทสมาชิก</th>
                <th class="text">ชื่อบูธ</th>
                <th class="text">วันที่จัดงาน</th>
                <th class="text">ลูกค้า</th>
                <th class="text">วันที่ชำระเงิน</th>
                <th class="text">ค่าบริการ</th>
                <th class="text">ส่วนลด</th>
                <th class="text">จำนวนเงินก่อน VAT</th>
                <th class="text">VAT 7%</th>
                <th class="text">ภาษีหัก ณ ที่จ่าย</th>
                <th class="text">ยอดที่ชำระ</th>
                <th class="text">ค่าธรรมเนียม</th>
                <th class="text">ยอดรวมที่ชำระ</th>
                <th class="text">สถานะ</th>
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
        <tr class="text"  >
            <th  class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"></th>
            <th class="text"> </th>
            <th class="text"></th>
            <th class="text">{{number_format($after_total,2,".","")}}</th>
            <th class="text">{{number_format($discount_total,2,".","")}}</th>
            <th class="text">{{number_format($beforevat_total,2,".","")}}</th>
            <th class="text">{{number_format($vat_total,2,".","")}}</th>
            <th class="text"></th>
            <th class="text">{{number_format($amount_total,2,".","")}}</th>
            <th class="text">{{number_format($service_charge_total,2,".","")}}</th>
            <th class="text">{{number_format($amount_total,2,".","")}}</th>
            <th class="text"></th>
            <th class="text"></th>
        </tr>
        </tbody>
    </table>


</body>
</html>
