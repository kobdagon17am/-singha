<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<style>
    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: normal;
        src: url('assets/fonts/THSarabunNew.ttf') format('truetype');
    }

    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: bold;
        src: url('assets/fonts/THSarabunNew Bold.ttf') format('truetype');
    }

    body {
        font-family: 'THSarabunNew';
        font-size: 18px;
    }

    .page-break {
        page-break-after: always;
    }

</style>

<body>
    <?php 
        $date = explode('-',$data['date']);
        $month = ['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฏาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
    ?>
    <table class="table">
            <tr>
                <td colspan="5" align="center">รายงานการเช็คอินขายสินค้า </td>
            </tr>
            <tr>
                <td colspan="5" align="center">{{ $data['market']->name_market }}</td>
            </tr>
            <tr>
                <td colspan="5" align="center">ข้อมูล ณ วันที่ {{ $date[2] }} เดือน {{ $month[$date[1]] }} พ.ศ. {{$date[0]+543}}</td>
            </tr>
            <tr>
                <td scope="col" align="center">Booth No.</td>
                <td scope="col" align="center">ชื่อลูกค้า</td>
                <td scope="col" align="center">สินค้าที่ขาย</td>
                <td scope="col" align="center">เช็คอิน</td>
                <td scope="col" align="center">หมายเหตุ</td>
            </tr>
       
            @foreach($data['booth'] as $i => $booth)
            <tr>
                <td align="center">{{ $booth->name }}</td>
                <td>{{ $data['partner'][$i] != null ? $data['partner'][$i]['partner']:'ว่าง' }}</td>
                <td>{{ $data['partner'][$i] != null ? $data['partner'][$i]['product']:'' }}</td>
                <td align="center">{!! $data['checkIn'][$i] == "Y" ? 'check in':'' !!}</td>
                <td></td>
            </tr>
            @endforeach
        
    </table>
</body>

</html>
