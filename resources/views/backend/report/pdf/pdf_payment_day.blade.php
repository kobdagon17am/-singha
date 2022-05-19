
<!DOCTYPE html>
<html>
    <head>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>รายงานการขายรายวัน</title>
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
                <td class="text-right" colspan="4">วันที่ออกรายงาน : {{ date('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="4" >วันที่สืบค้นรายงาน : {{ date('d/m/Y', strtotime($d_start)) }}</td>
            </tr>
        </tbody>
    </table><br>

    <table style="border-collapse:collapse;" width="100%" border="1">
        <thead>
            <tr>
                <th class="text">ลำดับ</th>
                <th class="text">ชื่อ Booth</th>
                <th class="text">ชื่อลูกค้า</th>
                <th class="text">วันที่ชำระเงิน</th>
                <th class="text">ราคา</th>
                <th class="text">ประเภทสินค้า</th>
                <th class="text">สถานะ</th>


            </tr>
        </thead>

        {{-- Mock up --}}
        <tbody>
            {!!$html!!}
            {{-- @foreach ($booking as $key => $item)

            <tr>
                <th class="text">{{($key+1)}}</th>
                <th class="text">{{($item->boothdetail->name)}}</th>
                <th class="text">{{$item->partners->name}}</th>
                <th class="text"> {{  ($item->booking_payment_date != null)?date("d-m-Y", strtotime($item->booking_payment_date)):''  }}</th>
                <th class="text">{{$item->boothdetail->price}}</th>
                <th class="text">{{$item->boothdetail->producttype->name}}</th>
                <th class="text">{{$item->booking->status->booking_status_name}}</th>


            </tr>
            @endforeach --}}
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
           {{-- {!!$tbodyhtml!!} --}}
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
