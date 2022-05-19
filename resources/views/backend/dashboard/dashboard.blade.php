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
                            <h4>หน้าแดชบอร์ด</h4>
                            <p class="text-muted m-b-10">รายละเอียดข้อมูลหน้าแดชบอร์ด</p>
                                <ul class="breadcrumb-title b-t-default p-t-10"></ul>
                            </div>

                            <!-- block -->
                            <div class="card-block">

                                <div class="row">
                                    <div class="col-md-6 col-xl-3">
                                        <div class="card bg-c-green order-card">
                                            <div class="card-block">
                                                <h6 class="m-b-20">รายชื่อผู้ใช้งานระบบ</h6>
                                                <h2 class="text-right"><i class="fa fa-user f-left"></i><span>0</span></h2>
                                                <p class="m-b-0"><a href="#"><u style="color:white;">คลิกดูรายละเอียด</u></a><span class="f-right">&nbsp;</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-3">
                                        <div class="card bg-c-green order-card">
                                            <div class="card-block">
                                                <h6 class="m-b-20">รายชื่อตลาด</h6>
                                                <h2 class="text-right"><i class="fa fa-cube f-left"></i><span>0</span></h2>
                                                <p class="m-b-0"><a href="#"><u style="color:white;">คลิกดูรายละเอียด</u></a><span class="f-right">&nbsp;</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-3">
                                        <div class="card bg-c-green order-card">
                                            <div class="card-block">
                                                <h6 class="m-b-20">รายชื่อผู้เช่า</h6>
                                                <h2 class="text-right"><i class="fa fa-users f-left"></i><span>0</span></h2>
                                                <p class="m-b-0">ผู้เช่าที่รออนุมัติ<span class="f-right">0</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-3">
                                        <div class="card bg-c-green order-card">
                                            <div class="card-block">
                                                <h6 class="m-b-20">รายชื่อสินค้า</h6>
                                                <h2 class="text-right"><i class="fa fa-cart-plus f-left"></i><span>0</span></h2>
                                                <p class="m-b-0"><a href="#"><u style="color:white;">คลิกดูรายละเอียด</u></a><span class="f-right">&nbsp;</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6 col-xl-3">
                                        <div class="card bg-c-pink order-card">
                                            <div class="card-block">
                                                <h6 class="m-b-20">รายการโค้ดส่วนลด</h6>
                                                <h2 class="text-right"><i class="fa fa-product-hunt f-left"></i><span>0</span></h2>
                                                <p class="m-b-0"><a href="#"><u style="color:white;">คลิกดูรายละเอียด</u></a><span class="f-right">&nbsp;</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6 col-xl-3">
                                        <div class="card bg-c-pink order-card">
                                            <div class="card-block">
                                                <h6 class="m-b-20">รายการโปรโมชั่น</h6>
                                                <h2 class="text-right"><i class="fa fa-product-hunt f-left"></i><span>0</span></h2>
                                                <p class="m-b-0"><a href="#"><u style="color:white;">คลิกดูรายละเอียด</u></a><span class="f-right">&nbsp;</span></p>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6 col-xl-3">
                                        <div class="card bg-c-yellow order-card">
                                            <div class="card-block">
                                                <h6 class="m-b-20">รายการข่าวสาร</h6>
                                                <h2 class="text-right"><i class="fa fa-bullhorn f-left"></i><span>0</span></h2>
                                                <p class="m-b-0"><a href="#"><u style="color:white;">คลิกดูรายละเอียด</u></a><span class="f-right">&nbsp;</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6 col-xl-3">
                                        <div class="card bg-c-yellow order-card">
                                            <div class="card-block">
                                                <h6 class="m-b-20">รายการผู้ติดต่อ</h6>
                                                <h2 class="text-right"><i class="fa fa-bullhorn f-left"></i><span>0</span></h2>
                                                <p class="m-b-0"><a href="#"><u style="color:white;">คลิกดูรายละเอียด</u></a><span class="f-right">&nbsp;</span></p>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6 col-xl-3">
                                        <div class="card bg-c-blue order-card">
                                            <div class="card-block">
                                                <h6 class="m-b-20">จำนวนบูธ</h6>
                                                <h2 class="text-right"><i class="ti-layout-grid3 f-left"></i><span>0</span></h2>
                                                <p class="m-b-0">บูธที่จอง/ชำระแล้ว<span class="f-right">0</span></p>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-3">
                                        <div class="card bg-c-pink order-card">
                                            <div class="card-block">
                                                <h6 class="m-b-20">จำนวนผู้ชำระแล้ว</h6>
                                                <h2 class="text-right"><i class="fa fa-paypal f-left"></i><span>0</span></h2>
                                                <p class="m-b-0">ผู้ที่ยังไม่ชำระ<span class="f-right">0</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="row">


                                </div> --}}
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
    $(document).ready(function(){
        var route_URL = "{{ route('backend.dashboard') }}"; // URL
        $(".pcoded-left-item>li a[href='"+route_URL+"']").parent().addClass("active");
    });
</script>


<script>


</script>



@endsection
