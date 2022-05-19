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
                                <h4>เงื่อนไขการสมัคร</h4>
                                <p class="text-muted m-b-10">รายละเอียดเงื่อนไข</p>
                                <ul class="breadcrumb-title b-t-default p-t-10">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('backend.dashboard')}}">
                                        <i class="fa fa-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="#!">รายละเอียดเงื่อนไข</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- block -->
                            <div class="card-block">
                            <form class="form-horizontal" action="{{route('agreement.update',1)}}" id="form_update" method="POST" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    {{ method_field('PATCH') }}
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" >เงื่อนไขข้อตกลง :</label>
                                    <div class="col-sm-9">
                                    <textarea type="text" rows="50" class="form-control detail_editer" name="agreement"   placeholder="เงื่อนไขข้อตกลง" autocomplete="off" required >{!!$market->agreement!!}</textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="card-block">

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-right" >การเก็บรวบรวมการใช้และเปิดเผยข้อมูลส่วนบุคคล :</label>
                                        <div class="col-sm-9">
                                        <textarea type="text" rows="50" class="form-control detail_editer" name="policy"  placeholder="เงื่อนไขข้อตกลง" autocomplete="off" required >{!!$market->policy!!}</textarea>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-danger" onclick="location.replace(document.referrer);"><i class="fa fa-history"></i> ยกเลิก</button>
                                        <button type="submit" class="btn btn-primary" id="submit_update"><i class="fa fa-send"></i>  บันทึก</button>
                                    </div>
                                    </form>
                                </div>
                        </div>
                        @include('backend/inc_footer')
                    </div>
                </div>
            </div>
        </div>
    </div>



<input type="hidden" name="marketID" id="marketID" value="{{$market->marketname_id}}" />

@endsection

@section('script')

<script>

    // Submit Add
    $(document).ready(function(){
    $('.detail_editer').summernote({
            toolbar: [
                ['insert', ['picture','link']],
                ['style', ['style']],
                ['fontsize', ['fontsize']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen']],
            ],

            fontNames: [
                'Prompt', 'Poppins', 'Arial Black', 'Lucida Grande', 'Lucida Sans', 'Tahoma',
            ],

            fontSizes: [
                '13','14','16','18', '20', '22','24','36',
            ],

            height:250,
            callbacks: {
                onImageUpload: function(files, editor, welEditable) {
                    console.log(files[0]);
                    sendFile(files[0], editor, welEditable,data_id='#detail_editer');
                },
                onpaste: function (e , editor, welEditable) {
                    setTimeout(function(){
                        if(navigator.userAgent.search("Firefox") >= 0){
                            var checkfirst = 0;
                            $('.note-editable').contents().each(function(){
                                if(this.nodeType === Node.COMMENT_NODE) {
                                    $(this).remove();
                                    checkfirst = 1;
                                }
                            });
                            if(checkfirst == 0){
                            $('.note-editable *').contents().each(function(){
                                    if(this.nodeType === Node.COMMENT_NODE) {
                                        $(this).remove();
                                        checkfirst = 1;
                                    }
                                });
                            }
                        }
                        $('.note-editable *').contents().each(function(){
                            if($(this).get(0).localName == 'span'){
                            $(this).get(0).style['cssText'] = '';
                            }
                        });
                    }, 1000);
                }
            }
        });
    });




</script>



@endsection
