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
                                <h4>รายการสินค้า</h4>
                                <p class="text-muted m-b-10">รายละเอียดข้อมูลรายการสินค้า</p>
                                <ul class="breadcrumb-title b-t-default p-t-10">

                                </ul>
                            </div>

                            <!-- block -->
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <div class="form-group">
                                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> เพิ่มข้อมูลรายการสินค้า</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="dt-responsive table-responsive">
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">colum1</th>
                                                <th class="text-center">colum2</th>
                                                <th class="text-center">colum3</th>
                                                <th class="text-center">colum4</th>
                                                <th class="text-center">colum5</th>
                                            </tr>
                                        </thead>

                                        {{-- mouk up --}}
                                        <tbody>
                                            @for($i=0; $i<3; $i++)
                                            <tr>
                                                <td>data1</td>
                                                <td>data2</td>
                                                <td>data3</td>
                                                <td width="20%">data4</td>
                                                <td width="20%" class="text-center">
                                                    <button type="button" class="btn-dark model-data" data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไข</button>
                                                    <button type="button" class="btn-dark"  aria-hidden="true"><i class="fa fa-edit"></i> เปิด/ปิด</button>
                                                </td>
                                            </tr>
                                            @endfor
                                        </tbody>
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

    <!-- Modal Add -->
    <div class="modal fade" id="modal_add" role="dialog" >
        <form  method="POST" id="form_add">
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="reload_add">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">เพิ่ม</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">



                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        <button class="btn btn-primary" id="submit_add">บันทึก</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modal_edit" role="dialog">
        <form method="POST"  id="form_edit">
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="reload_edit">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">แก้ไข</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                     </div>

                     <div class="modal-body">



                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        <button class="btn btn-primary" id="submit_edit">บันทึก</button>
                    </div>
                 </div>
            </div>
        </form>
    </div>

@endsection

@section('script')
<script src="{{asset('/resources/js/app.js')}}"></script>
<script>
    $(document).ready(function(){
        $(".pcoded-submenu>li a[href='{{ route('') }}']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='{{ route('') }}']").parent().parent().parent().addClass("pcoded-trigger");
    });
</script>


<script>


</script>



@endsection
