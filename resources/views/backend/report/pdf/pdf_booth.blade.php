
<!DOCTYPE html>
<html>
    <head>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>รายงาน Booth ว่าง</title>
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

    {{-- <div class="text"><h3>รายงาน Booth ว่าง</h3></div> --}}

    <table style="border-collapse:collapse;" width="100%" border="0">
        <tbody>
            <tr>
                <td class="text-right">รายงาน Booth ว่าง</td>
            </tr>
            <tr>
                <td class="text-right">วันที่ออกรายงาน : {{ date('Y-m-d') }}</td>
            </tr>
            {{-- <tr>
                <td class="text-right">วันที่สืบค้นรายงาน : {{$d_start}} - {{$d_end}}</td>
            </tr> --}}
        </tbody>
    </table>

    <table style="border-collapse:collapse;" width="100%" border="1">
        <thead>
            <tr>
                <th class="text">ลำดับ</th>
                <th class="text">ชื่อ Booth</th>
                <th class="text">ราคา</th>
                <th class="text">ประเภทสินค้า</th>
                {{-- <th class="text">หมวดหมู่</th> --}}
                <th class="text">สถานะ</th>
            </tr>
        </thead>

        {{-- Mock up --}}
        <tbody>
            @foreach ($findempty as $key => $item)


            <tr>
                <td class="text">{{$key+1}}</td>
                <td class="text">{{$item->name}}</td>
                <td class="text">{{$item->price}}</td>
                <td class="text">{{$item->producttype->name}}</td>
                {{-- <td class="text">{{$item->productcategory}}</td> --}}
                <td class="text">ว่าง</td>
            </tr>
            @endforeach
        </tbody>
    </table>


</body>
</html>
