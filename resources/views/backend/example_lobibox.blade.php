@extends('backend/inc_main') {{-- main.blade.php --}}

 @section('title','| All Tags')

@section('stylesheet')
    
    {{-- Use CSS/JS --}}
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/plugin/lobibox/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/plugin/lobibox/dist/css/Lobibox.min.css')}}">

    <script src="{{URL::asset('public/assets/plugin/lobibox/lib/jquery.1.11.min.js')}}"></script>
    <script src="{{URL::asset('public/assets/plugin/lobibox/dist/js/Lobibox.min.js')}}"></script>

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
                                <h4>#</h4>
                                <p class="text-muted m-b-10">#</p>
                                <ul class="breadcrumb-title b-t-default p-t-10">

                                </ul>					
                            </div>
                            
                            <!-- block -->
                            <div class="card-block">

                                <button id="bt_success" class="btn btn-raised btn-success">success<div class="ripple-container"></div></button>
                                <button id="bt_error" class="btn btn-raised btn-danger">Error<div class="ripple-container"></div></button>
                                <button id="bt_warning" class="btn btn-raised btn-warning">Warning<div class="ripple-container"></div></button>
                                <br><br>
                                <button id="bt_success2" class="btn btn-raised btn-success">success2<div class="ripple-container"></div></button>
                                <button id="bt_error2" class="btn btn-raised btn-danger">Error2<div class="ripple-container"></div></button>
                                <button id="bt_warning2" class="btn btn-raised btn-warning">Warning2<div class="ripple-container"></div></button>

                                
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

 
    $(document).on('click',"#bt_success", function(){
        Lobibox.notify("success", {
        size: 'large',
        showClass: 'fadeInDown',
        hideClass: 'fadeUpDown',
        msg: 'Lorem ipsum dolor sit amet against apennine any created, spend loveliest, building stripes.'
        });   
    });
    
    $(document).on('click',"#bt_error", function(){
        Lobibox.notify("error", {
        size: 'large',
        showClass: 'fadeInDown',
        hideClass: 'fadeUpDown',
        msg: 'Lorem ipsum dolor sit amet against apennine any created, spend loveliest, building stripes.'
        });   
    });

    $(document).on('click',"#bt_warning", function(){
        Lobibox.notify("warning", {
        size: 'large',
        showClass: 'fadeInDown',
        hideClass: 'fadeUpDown',
        msg: 'Lorem ipsum dolor sit amet against apennine any created, spend loveliest, building stripes.'
        });   
    });

    $(document).on('click',"#bt_success2", function(){
        Lobibox.notify("success", {
        size: 'mini',
        msg: 'Lorem ipsum dolor sit amet against apennine any created, spend loveliest, building stripes.'
        });
    });

    $(document).on('click',"#bt_error2", function(){
        Lobibox.notify("error", {
        size: 'mini',
        msg: 'Lorem ipsum dolor sit amet against apennine any created, spend loveliest, building stripes.'
        });
    });
    $(document).on('click',"#bt_warning2", function(){
        Lobibox.notify("warning", {
        size: 'mini',
        msg: 'Lorem ipsum dolor sit amet against apennine any created, spend loveliest, building stripes.'
        });
    });

   
    

   

</script>



@endsection                   