<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sun Plaza Market</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Orange-Thailand" />
    <meta name="keywords" content="รับทำเว็บไซต์ ออกแบบเว็บไซต์ รับทำ SEO และรับเขียนโปรแกรมโดยทีมงานมืออาชีพ" />
    <meta name="author" content="O.Suraphon"/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Favicon icon -->
    <link rel="icon" href="{{URL::asset('public/assets/img/logo.jpg')}}" type="image/x-icon">
    <!-- Google font-->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/bower_components/bootstrap/css/bootstrap.min.css')}}">
    <!-- themify icon -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/assets/icon/themify-icons/themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/assets/icon/simple-line-icons/css/simple-line-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/assets/icon/ion-icon/css/ionicons.min.css')}}">

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/assets/icon/font-awesome/css/font-awesome.min.css')}}">
    <!-- scrollbar.css -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/assets/css/jquery.mCustomScrollbar.css')}}">
    <!-- Select 2 css -->
    <link rel="stylesheet" href="{{URL::asset('public/assets/bootstrap4/bower_components/select2/css/select2.min.css')}}" />
    <!-- Multi Select css -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/bower_components/multiselect/css/multi-select.css')}}" />
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/assets/css/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/backend/css/style.css')}}"> {{-- backend --}}
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/assets/pages/data-table/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}">
    {{-- upload file --}}
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/assets/pages/jquery.filer/css/jquery.filer.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css')}}">

    {{-- CSS : Plugin --}}
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/plugin/summernote/summernote-lite.css')}}"> {{-- summernote --}}
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/plugin/waitMe-gh-pages/waitMe.css')}}"> {{-- waitMe --}}
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/plugin/waitMe-gh-pages/waitMe.min.css')}}"> {{-- waitMeMain --}}
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/plugin/uploadfile/fileinput.css')}}"> {{-- uploadfile --}}
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/plugin/autocomplete/style.css')}}"> {{-- Auto Complete --}}
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/plugin/autocomplete/jquery-ui.1.10.1.min.css')}}"> {{-- Auto Complete --}}

   <style>
    html{
        overflow-y: scroll;
    }
   </style>

    @yield('stylesheet')

</head>

<style>
body, html {
    padding:0px !important;
}

</style>

<body>

    <!-- Pre-loader start -->
    {{-- <div class="theme-loader">
        <div class="loader-track">
            <div class="loader-bar"></div>
        </div>
    </div> --}}

    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            @include('backend/inc_header')

            <!-- Sidebar inner chat end-->
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    @include('backend.inc_sidebar')

                    @yield('content')

                </div>
            </div>
        </div>
    </div>

    {{-- default --}}
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/jquery/js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/popper.js/js/popper.min.js')}}"></script>
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/bootstrap/js/bootstrap.min.js ')}}"></script>
    <script src="{{URL::asset('public/assets/bootstrap4/assets/pages/widget/excanvas.js ')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/jquery-slimscroll/js/jquery.slimscroll.js')}}  "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/modernizr/js/modernizr.js ')}}"></script>

    <!-- menu js -->
    <script src="{{URL::asset('public/assets/bootstrap4/assets/js/pcoded.min.js')}}"></script>
    <script src="{{URL::asset('public/assets/bootstrap4/assets/js/vertical/vertical-layout.min.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/select2/js/select2.full.min.js')}} "></script>

    {{-- data-table --}}
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/datatables.net/js/jquery.dataTables.min.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/assets/pages/data-table/js/jszip.min.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/assets/pages/data-table/js/pdfmake.min.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/assets/pages/data-table/js/vfs_fonts.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/datatables.net-buttons/js/buttons.print.min.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/datatables.net-buttons/js/buttons.html5.min.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}} "></script>

    {{-- file-upload --}}
    <script src="{{URL::asset('public/assets/bootstrap4/assets/pages/jquery.filer/js/jquery.filer.min.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/assets/pages/filer/custom-filer.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/assets/pages/filer/jquery.fileuploads.init.js')}} "></script>

    {{-- Select2 --}}
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/select2/js/select2.full.min.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/bower_components/multiselect/js/jquery.multi-select.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/assets/js/jquery.quicksearch.js')}} "></script>

    {{-- Custom Js --}}
    <script src="{{URL::asset('public/assets/bootstrap4/assets/pages/advance-elements/select2-custom.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/assets/js/pcoded.min.js')}} "></script>
    <script src="{{URL::asset('public/assets/bootstrap4/assets/js/jquery.mCustomScrollbar.concat.min.js')}} "></script>

    <!-- custom js -->
    <script src="{{URL::asset('public/assets/bootstrap4/assets/pages/dashboard/custom-dashboard.js')}}"></script>
    <script src="{{URL::asset('public/assets/bootstrap4/assets/js/script.js')}} "></script>

    {{-- JS Plugin --}}
    <script type="text/javascript" src="{{URL::asset('public/assets/plugin/bootbox/bootbox.min.js')}} "></script> {{-- bootbox alert --}}
    <script type="text/javascript" src="{{URL::asset('public/assets/plugin/sweetalert/sweetalert.min.js')}} "></script> {{-- sweetalert --}}
    <script type="text/javascript" src="{{URL::asset('public/assets/plugin/summernote/summernote-lite.js')}} "></script> {{-- summernote --}}
    <script type="text/javascript" src="{{URL::asset('public/assets/plugin/waitMe-gh-pages/waitMe.js')}}"></script> {{-- waitMe --}}
    <script type="text/javascript" src="{{URL::asset('public/assets/plugin/waitMe-gh-pages/waitMe.min.js')}}"></script> {{-- waitMeMain --}}
    <script type="text/javascript" src="{{URL::asset('public/assets/plugin/uploadfile/fileinput.js')}}"></script> {{-- uploadfile --}}
    <script type="text/javascript" src="{{URL::asset('public/assets/plugin/autocomplete/jquery-ui.1.12.1.min.js')}} "></script>  {{-- Auto Complete --}}

    {{-- <script type="text/javascript">
         $(document).ready(function(){
            //  style headder
            $('.pcoded-header').attr('header-theme','theme1');
            //  none sidebar
            // $("div").attr("vertical-nav-type", "offcanvas");
        });
    </script>  --}}
    <script>
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });

    </script>
    @yield('script')

</body>

</html>
