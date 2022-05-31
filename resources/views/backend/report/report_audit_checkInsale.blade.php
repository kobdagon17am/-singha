@extends('backend/inc_main') {{-- main.blade.php --}}

@section('title','| All Tags')

@section('stylesheet')

@endsection

@section('content')

{{-- content --}}
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card tabs-card">
                        {{-- header --}}
                        <div class="card-header">
                            <h4>รายงานการเช็คอินขายสินค้า</h4>
                            <p class="text-muted m-b-10">รายละเอียดข้อมูลรายงานการเช็คอินขายสินค้า</p>
                            <ul class="breadcrumb-title b-t-default p-t-10"></ul>
                        </div>

                        <!-- block -->
                        <div class="card-block">
                            {!! csrf_field() !!}
                            <div class="card-block" id="reload">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <form action="" method="post">
                                                @csrf
                                                <div class="form-group">

                                                    <div class="form-group row">
                                                        <label
                                                            class="col-sm-2 col-form-label text-right">ชื่อตลาด:</label>
                                                        <div class="col-sm-7">
                                                            <select class="form-control" name="market_id" id="market_id"
                                                                required>
                                                                <option value="">เลือกตลาด</option>
                                                                @foreach ($market as $item)
                                                                <option value="{{$item->marketname_id}}" @if($item->marketname_id == $mkId) selected @endif>
                                                                    {{$item->name_market}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary"><i
                                                                class="fa fa-search"></i> ค้นหา</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12">
                                        <hr>
                                        @if(count($report)>0)
                                        <form action="" method='post'>
                                            @csrf
                                            <input type="hidden" name="excel" value="{{$mkId}}">
                                            <button class='btn btn-success'>Excel</button>
                                        </form>
                                        <table class="table">
                                            <caption>รายงานการเช็คอินขายสินค้า</caption>
                                            <thead>
                                                <tr>
                                                    <th scope="col">Booth No.</th>
                                                    <th scope="col">ชื่อลูกค้า</th>
                                                    <th scope="col">สินค้าที่ขาย</th>
                                                    <th scope="col">เช็คอิน</th>
                                                    <th scope="col">หมายเหตุ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($report['booth'] as $i => $booth)
                                                <tr>
                                                    <td>{{ $booth->name }}</td>
                                                    <td>{{ $report['partner'][$i] != null ? $report['partner'][$i]['partner']:'ว่าง' }}</td>
                                                    <td>{{ $report['partner'][$i] != null ? $report['partner'][$i]['product']:'' }}</td>
                                                    <td>{!! $report['checkIn'][$i] == "Y" ? 'check in':'' !!}</td>
                                                    <td></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('backend/inc_footer')
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')

<script>
    $(document).ready(function () {
        var route_URL = "{{ route('backend.report.audit.checkInsale') }}"; // URL
        $(".pcoded-submenu>li a[href='" + route_URL + "']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='" + route_URL + "']").parent().parent().parent().addClass(
            "pcoded-trigger");
    });

</script>


@endsection
