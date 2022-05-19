@extends('backend/inc_main') {{-- main.blade.php --}}

 @section('title','| All Tags')

@section('stylesheet')

@endsection

@section('content')

<style>
    .modal-lg {
        max-width: 700px !important;
    }
</style>

    {{-- content --}}
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="card tabs-card">
                            {{-- header --}}
                            <div class="card-header">
                            <h4>จัดการ Booth</h4>
                            <p class="text-muted m-b-10">รายละเอียดข้อมูลจัดการ Booth</p>
                                <ul class="breadcrumb-title b-t-default p-t-10">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('backend.dashboard') }}">
                                        <i class="fa fa-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('backend.market.name') }}">รายชื่อตลาด</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('backend.market.name') }}">{{$booth->market->name_market}}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('backend.market.booth' , array('id'=>$booth->marketname_id)) }}">แบบ Booth {{$booth->name}}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="">จัดการ Booth</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- block -->
                            <div class="card-block">
                                <div class="form-group text-right row">
                                    <div class="col-sm-12">
                                        <button class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> เพิ่ม Booth</button>
                                    </div>
                                </div>

                                <div class="form-group text-right row">
                                    <div class="col-sm-12">
                                        <button class="btn btn-out-dashed btn-primary btn-square">ประเภทอาหาร</button>
                                        <button class="btn btn-out-dashed btn-success btn-square">อาหารสำเร็จ ผลไม้ ขนม  </button>
                                        <button class="btn btn-out-dashed btn-info btn-square">ไม่ใช่อาหาร</button>
                                        <button class="btn btn-out-dashed btn-warning btn-danger">ปิดการใช้งาน</button>
                                        <button class="btn btn-out-dashed btn-warning btn-square">ยังไม่ได้เลือกประเภท</button>
                                    </div>
                                </div>

                                <?php $bt_status = ""; ?>

                                <div class="card-block remove-label">
                                    @foreach($booth_detail as $booths)
                                        <?php
                                            if($booths->product_type == 0) {
                                                $bt_status = "btn-warning btn-square";
                                            }
                                            if($booths->product_type == 1) {
                                                $bt_status = "btn-primary btn-square";
                                            }
                                            if($booths->product_type == 2) {
                                                $bt_status = "btn-info btn-square";
                                            }
                                            if($booths->product_type == 3) {
                                                $bt_status = "btn-success btn-square";
                                            }
                                            if($booths->status == "N") {
                                                $bt_status = "btn-warning btn-danger";
                                            }

                                        ?>

                                        <a href="#" style="margin-bottom:15px;margin-right:5px" class="btnlock btn btn-out-dashed {{$bt_status}} waves-effect md-trigger model-data" data-id="{{$booths->booth_detail_id}}" data-toggle="modal" data-target="#model_booth" >
                                            <p>{{$booths->name}}</p>
                                            {{-- @if($booths->product_category != 0)
                                                <p>{{$booths->productcategory->name}}</p>
                                            @else
                                                <p>-</p>
                                            @endif --}}
                                        </a>
                                    @endforeach
                                </div>
                                <div class="text-right">
                                    <button type="button" class="btn btn-dark" onclick="location.replace(document.referrer);"><i class="fa fa-history"></i> ย้อนกลับ</button>
                                </div>
                            </div>
                        </div>
                        @include('backend/inc_footer')
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- Model Booth --}}
    <div class="modal fade" id="model_booth" role="dialog">
        <form method="POST"  id="form_booth">
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="reload_booth">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">Booth</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                     </div>

                     <div class="modal-body" id="body_model_booth">

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อ Booth:</label>
                                <div class="col-sm-5">
                                 <input type="text" class="form-control" name="name" id="name" placeholder="ชื่อแบบ Booth" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ราคา:</label>
                                <div class="col-sm-5">
                                 <input type="number" class="form-control" name="price" id="price"  required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ประเภทสินค้า:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="product_type" id="product_type" required>
                                    <option value="0">เลือกประเภทสินค้า</option>
                                   @foreach($product_type as $product_types)
                                        <option value="{{$product_types->type_id}}">{{$product_types->name}}</option>
                                   @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">หมวดหมู่สินค้า:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="product_categorys" id="product_categorys" required>
                                    <option value="0">เลือกหมวดหมู่สินค้า</option>
                                    @foreach($product_category as $product_categorys)
                                        <option value="{{$product_categorys->category_id}}">{{$product_categorys->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">สถานะ:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="status" id="status" required>
                                    <option value="Y">ใช้งาน</option>
                                    <option value="N">ปิดใช้งาน</option>
                                </select>
                            </div>
                        </div>

                        <input  type="hidden" name="booth_detail_id" id="booth_detail_id" />

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        <button class="btn btn-primary" id="submit_booth">บันทึก</button>
                    </div>
                 </div>
            </div>
        </form>
    </div>

     <!-- Modal Add -->
    <div class="modal fade" id="modal_add" role="dialog" >
        <form  method="POST" id="form_add">
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="reload_add">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">Create Booth</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body" id="body_modal_add">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">จำนวน Booth:</label>
                                <div class="col-sm-5">
                                 <input type="number" class="form-control" name="amount_booth" id="amount_booth_a" placeholder="จำนวน Booth" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ราคาเริ่มต้น:</label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" name="price_start" id="price_start_a" placeholder="ราคาเริ่มต้น" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="booth_id" value="{{$booth_id->booth_id}}" />

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        <button class="btn btn-primary" id="submit_add">บันทึก</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


@endsection

@section('script')

<script>
    $(document).ready(function(){
        var route_URL = "{{ route('backend.market.name') }}"; // URL
        $(".pcoded-submenu>li a[href='"+route_URL+"']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='"+route_URL+"']").parent().parent().parent().addClass("pcoded-trigger");
    });
</script>

<script>

    // Booth
    $('#submit_booth').click(function(e){
        name = $('#name').val();
        price = $('#price').val();
        if(name != "" && price != ""){
            e.preventDefault();
            $('#form_booth').submit();
        }
    });

    // Add
    $('#submit_add').click(function(e){
        amount = $('#amount_booth_a').val();
        price = $('#price_start_a').val();
        if(amount != "" && price != ""){
            e.preventDefault();
            $('#form_add').submit();
        }
    });

    $(document).ready(function(){

        // Form Booth
        $('#form_booth').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
               url: "{{ route('api.market.boothdetail.update') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){
                    $('#model_booth').modal('hide') // modal add hide
                    if(data.response == true){
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "ยืนยัน",
                        }).then((value) => {
                            window.location.reload();
                        });
                    }
                }
            });
        });

        // Form Add
        $('#form_add').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
               url: "{{ route('api.market.boothdetail.add') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){
                    $('#modal_add').modal('hide') // modal add hide
                    if(data.response == true){
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "ยืนยัน",
                        }).then((value) => {
                            window.location.reload();
                        });
                    }
                }
            });
        });
    });

    $(document).on('click', ".model-data", function() {
        var id = $(this).attr('data-id');
        $('#product_type').val("");
        $('#product_categorys').val("");
        $.ajax({
            url: "{{ route('api.market.boothdetail.edit') }}",
            data: {"_token": "{{ csrf_token() }}", 'id': id},
            type: "POST",
            async: false,
            success:function(data){
                $('#booth_detail_id').val(data.booth_detail_id);
                $('#name').val(data.name);
                $('#price').val(data.price);
                $('#status').val(data.status).trigger('change');
                $('#product_type').val(data.product_type).trigger('change');
                $('#product_categorys').val(data.product_category).trigger('change');
                console.log(data);
            }
        });
    });


    $('#product_type').click(function(){
        id = $('#product_type').val();
        $.ajax({
            url:  "{{ route('api.product.querycategory') }}",
            data: {"_token": "{{ csrf_token() }}", 'id': id},
            type: "POST",
            success:function(data){
                $('#product_categorys').html('');
                $.each(data,function(key,item){
                    $('#product_categorys').append('<option value="'+item.category_id+'">'+item.name+'</option>');
                });
            }
        });
    });

</script>



@endsection
