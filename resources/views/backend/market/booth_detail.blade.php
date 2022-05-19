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
                                    <a href="{{ route('backend.market.booth' , array('id'=>$booth->marketname_id)) }}">แบบ
                                        Booth {{$booth->name}}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('backend.market.booth' , array('id'=>$booth->marketname_id)) }}">Zone
                                        {{$id_zone}}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="">จัดการ Booth</a>
                                </li>
                            </ul>
                        </div>

                        <!-- block -->
                        <div class="card-block">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-right">
                                        <div class="form-group">
                                            {{-- <a href="#" class="btn btn-dark" data-toggle="modal"data-target="#modal_copy"><i class="fa fa-plus"></i> Copy ModelBooth</a> --}}
                                            {{-- <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#model_booth" ><i class="fa fa-plus"></i> Create Model Booth</a> --}}
                                            <a href="#" class="btn btn-dark" onclick="add_booth_modal()"><i class="fa fa-plus"></i> Create Model Booth</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dt-responsive table-responsive">
                                <table id="datatables" class="table  table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ชื่อ Booth</th>
                                            {{-- <th class="text-center">Zone</th> --}}
                                            <th class="text-center">ราคา</th>
                                            <th class="text-center">สถานะ</th>
                                            {{-- <th class="text-center">สถานะ</th> --}}
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    @include('backend/inc_footer')
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="id_zone" value="{{$id_zone}}">
<input type="hidden" id="id_booth" value="{{$id_booth}}">

{{-- Model Booth --}}
<div class="modal fade" id="model_booth" role="dialog">
    <form method="POST" id="form_booth">
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
                            <input type="text" class="form-control" name="name" id="name" placeholder="ชื่อแบบ Booth"
                                autocomplete="off" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-right">ราคา:</label>
                        <div class="col-sm-5">
                            <input type="number" class="form-control" name="price" id="price" required>
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
                                <option value="999">เลือกทั้งหมด</option>
                                @foreach($product_category as $product_categorys)
                                <option value="{{$product_categorys->category_id}}">{{$product_categorys->name}}
                                </option>

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

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-right">รูปภาพรายละเอียดบูธ:</label>
                        <div class="col-sm-5">
                            <img src="{{asset('public/assets/backend/img/wait_img.png')}}" id="PreviewImage_e"
                                class="img-fluid img-responsive" style="width:600px;height:200px;">
                            <p class="c-red">รูปภาพรายละเอียดบูธ ขนาดรูปภาพ 400 * 600 px</p>
                            <input type="file" class="form-control" name="booth_detail_image" id="fileimg_gallery_e"
                                onchange="readURL_Edit(this);" autocomplete="off" required="">
                        </div>
                    </div>
                    <input type="hidden" name="zone_id" value="{{$id_zone}}" />
                    <input type="hidden" name="booth_id" value="{{$booth_id->booth_id}}" />
                    <input type="hidden" name="booth_detail_id" id="booth_detail_id" />
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                    <button class="btn btn-primary" id="submit_booth">บันทึก</button>
                    <button class="btn btn-primary" id="submit_add">บันทึก</button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- <!-- Modal Add -->
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
</div> --}}


@endsection

@section('script')

<script>
    $(document).ready(function () {
        var route_URL = "{{ route('backend.market.name') }}"; // URL
        $(".pcoded-submenu>li a[href='" + route_URL + "']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='" + route_URL + "']").parent().parent().parent().addClass(
            "pcoded-trigger");
    });

</script>

<script>
    // Booth
    function add_booth_modal() {
        $('#model_booth').modal('show');
        $('#submit_booth').hide();
        $('#form_booth')[0].reset();

    }

    // Booth
    $('#submit_booth').click(function (e) {
        name = $('#name').val();
        price = $('#price').val();
        if (name != "" && price != "") {
            e.preventDefault();
            update();
            // $('#form_booth').submit();
        }
    });

    // // Add
    $('#submit_add').click(function (e) {
        // amount = $('#amount_booth_a').val();
        // price = $('#price_start_a').val();
        // if(amount != "" && price != ""){
        //     e.preventDefault();
        //     $('#form_add').submit();
        // }
        name = $('#name').val();
        price = $('#price').val();
        if (name != "" && price != "") {
            e.preventDefault();
            add();
            // $('#form_booth').submit();
        }
    });

    $(document).ready(function () {
        //Datable
        var oTable = $("#datatables").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthChange: true,

            ajax: {
                url: "{{ route('api.market.boothdetail.datatable') }}",
                type: "POST",

                data: function (d) {
                    return $.extend({}, d, {
                        "id_booth": $('#id_booth').val(),
                        "id_zone": $('#id_zone').val(),
                    });
                },
            },

            columns: [{
                    'className': "text-center",
                    data: 'name',
                    name: 'name'
                },
                // { 'className': "text-center", data: 'colum_zone', name: 'colum_zone' },
                {
                    'className': "text-center",
                    data: 'price',
                    name: 'price'
                },
                {
                    'className': "text-center",
                    data: 'status',
                    name: 'status'
                },
                {
                    'className': "text-center",
                    data: 'manage',
                    name: 'manage'
                },
                // { 'className': "text-center", data: 'colum_status', name: 'colum_status' },
                // { 'className': "text-center", data: 'colum_manage', name: 'colum_manage' },
            ],
            order: [
                [0, 'asc']
            ],
            rowCallback: function (row, data, index) {
                // rowCallback
            }
        });

        // Form Booth

    });

    // Form Update
    function update() {
        // e.preventDefault();

        var formData =  new FormData($('#form_booth')[0]);

        console.log(formData);
        $.ajax({
            url: "{{ route('api.market.boothdetail.update') }}",
            data: formData,
            type: "POST",
            async: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#model_booth').modal('hide') // modal add hide
                if (data.response == true) {
                    swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "ยืนยัน",
                    }).then((value) => {
                        // window.location.reload();
                        $('#datatables').DataTable().ajax.reload();
                    });
                }
            }
        });
    }

    // Form Add
    function add() {
        // e.preventDefault();
        var formData =  new FormData($('#form_booth')[0]);
        console.log(formData);
        $.ajax({
            url: "{{ route('api.market.boothdetail.add') }}",
            data: formData,
            type: "POST",
            async: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#modal_add').modal('hide') // modal add hide
                if (data.response == true) {
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
    }
    $(document).on('click', ".model-data", function () {
        $('#submit_booth').show();
        $('#submit_add').hide();
        var id = $(this).attr('data-id');
        $('#product_type').val("");
        $('#product_categorys').val("");
        $.ajax({
            url: "{{ route('api.market.boothdetail.edit') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'id': id
            },
            type: "POST",
            async: false,
            success: function (data) {
                $('#booth_detail_id').val(data.booth_detail_id);
                $('#name').val(data.name);
                $('#price').val(data.price);
                $('#status').val(data.status).trigger('change');
                $('#product_type').val(data.product_type).trigger('change');
                $('#product_categorys').val(data.product_category).trigger('change');
                if (data.product_category == "999") {
                     $('#product_categorys').val(999).trigger('change');
                }
                console.log(data);

                if (data.booth_detail_image_w != null) {
                    image_src = "{{asset('storage/uploadfile/boothdetail')}}/" + data
                        .booth_detail_image_w;
                } else {
                    image_src = "{{asset('public/assets/backend/img/wait_img.png')}}";
                }
                $('#id').val(data.pictures_id); // id
                $('#PreviewImage_e').attr('src', image_src); // image
                $('#fileold').val(data.booth_detail_image_w); // image value old

            }
        });
    });


    $('#product_type').click(function () {
        id = $('#product_type').val();
        $.ajax({
            url: "{{ route('api.product.querycategory') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'id': id
            },
            type: "POST",
            success: function (data) {
                $('#product_categorys').html('');
                $('#product_categorys').append('<option value="999">เลือกทั้งหมด</option>');
                $.each(data, function (key, item) {
                    $('#product_categorys').append('<option value="' + item.category_id +
                        '">' + item.name + '</option>');
                });

            }
        });
    });
    // Preview Image Edit
    function readURL_Edit(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#PreviewImage_e').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>



@endsection
