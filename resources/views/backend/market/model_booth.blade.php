@extends('backend/inc_main') {{-- main.blade.php --}}

 @section('title','| All Tags')

@section('stylesheet')
     
@endsection 

@section('content')
 
    <?php 
        $page_topic = "แบบ Booth";
        $page_detail = "รายละเอียดข้อมูลแบบ Booth"; 
    ?>
	
    {{-- content --}}
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">				
                    <div class="page-body">
                        <div class="card tabs-card">					
                            {{-- header --}}
                            <div class="card-header">
                            <h4>{{$page_topic}}</h4>
                            <p class="text-muted m-b-10">{{$page_detail}}</p>
                                <ul class="breadcrumb-title b-t-default p-t-10"></ul>					
                            </div>
                            
                            <!-- block -->
                            <div class="card-block">
                                
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
                                                <td width="20%" class="text-center">data5</td>
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


@endsection 

@section('script')

<script>
    $(document).ready(function(){
        var route_URL = "{{ route('backend.market.booth') }}"; // URL 
        $(".pcoded-submenu>li a[href='"+route_URL+"']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='"+route_URL+"']").parent().parent().parent().addClass("pcoded-trigger");
    });
</script>


<script>

   
</script>



@endsection                   