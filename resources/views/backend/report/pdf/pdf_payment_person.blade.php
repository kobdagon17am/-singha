
<!DOCTYPE html>
<html>
    <head>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>รายงานการจองบุคคล</title>
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
                <td class="text-right" colspan="4">รายงานการจองบุคคล</td>
            </tr>
            <tr>
                <td class="text-right" colspan="4">วันที่ออกรายงาน : {{date('d/m/Y')}}</td>
            </tr>

        </tbody>
    </table><br>


    <table style="border-collapse:collapse;" width="100%" border="1">
        <thead>
            <tr>
                <th class="text">ลำดับ</th>
                <th class="text">เลขที่ใบจอง</th>
                <th class="text">ชื่อผู้จอง</th>
                <th class="text">ชื่อ Booth</th>
                <th class="text">วันที่ขาย</th>
            </tr>
        </thead>

        {{-- Mock up --}}
        <tbody>
            @foreach ($bookings as $key => $item)


            <tr>
                <td class="text">{{($key+1)}}</td>
                <td class="text">{{$item->booking_id}}</td>
                <td class="text">{{@$item->partners->name}}</td>
                <td class="text">{{@$item->boothdetail->name}}</td>
                <td class="text">{{date('d-m-Y',strtotime($item->booking_detail_date))}}</td>

            </tr>
            @endforeach
        </tbody>
    </table>


</body>
</html>
