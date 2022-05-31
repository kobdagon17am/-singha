<nav class="pcoded-navbar" >
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu"><br>
        {{-- {{dd($authdata)}} --}}
        <ul class="pcoded-item pcoded-left-item">
            {{-- หน้าแดชบอร์ด --}}

            @if (in_array("1", $authdata))
            <li class="pcoded" >
                <a href="{{ route('backend.dashboard') }}">
                    <span class="pcoded-micon"><i class="ti-view-grid"></i><b>W</b></span>
                    <span class="pcoded-mtext">หน้าแดชบอร์ด</span>
					<span class="pcoded-mcaret"></span>
                </a>
            </li>
            @endif


            @if (in_array("2", $authdata))
            {{-- จัดการผู้ใช้งานระบบ --}}
            <li class="pcoded">
                <a href="{{ route('backend.admin') }}">
                    <span class="pcoded-micon"><i class="fa fa-user"></i><b>W</b></span>
                    <span class="pcoded-mtext">จัดการผู้ใช้งานระบบ</span>
					<span class="pcoded-mcaret"></span>
                </a>
            </li>
            @endif

            @if (in_array("3", $authdata))
            {{-- จัดการผู้เช่า --}}
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-users"></i><b>W</b></span>
                    <span class="pcoded-mtext">จัดการผู้เช่า</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('backend.partners.type') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">ประเภทผู้เช่า</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.partners.user') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายชื่อผู้เช่า / ผู้ใช้งาน</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.partners.approve') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายชื่อผู้เช่า / รอการอนุมัติ</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                </ul>
            </li>
            @endif
            {{-- จัดการAdmin/Audit --}}
            {{-- <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-users"></i><b>W</b></span>
                    <span class="pcoded-mtext">จัดการAdmin/Audit</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">

                    <li>
                        <a href="{{ url('officers') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายชื่อAdmin / Audit</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                </ul>
            </li> --}}
            @if (in_array("4", $authdata))
            {{-- จัดการตลาด --}}
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-gear"></i><b>W</b></span>
                    <span class="pcoded-mtext">จัดการตลาด</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('backend.market.name') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายชื่อตลาด</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    {{-- <li>
                        <a href="{{ route('backend.market.pictures_event') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รูปภาพ/กิจกรรม</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li> --}}
                    <li>
                        <a href="{{ route('backend.market.addservice') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">บริการเสริม</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('agreement') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">เงื่อนไขการสมัคร</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            @if (in_array("5", $authdata))
            {{-- จัดการการจอง --}}
            <li class="pcoded" >
                <a href="{{ url('backoffice/booking') }}">
                    <span class="pcoded-micon"><i class="ti-layout-grid3"></i><b>W</b></span>
                    <span class="pcoded-mtext">จัดการการจอง</span>
					<span class="pcoded-mcaret"></span>
                </a>
            </li>
            {{-- <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-layout-grid3"></i><b>W</b></span>
                    <span class="pcoded-mtext">จัดการการจอง</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ url('backoffice/booking') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">จัดการจอง</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('backoffice/booking/booking_regular') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">ลูกค้าประจำ / ลูกค้าทั่วไป</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('backoffice/booking/booking_event') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">จอง Booth แทนสมาชิกประเภท Event</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('backoffice/booking/booking_oraganize') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">จอง Booth แทนสมาชิกประเภท Oraganize</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li> --}}
            @endif
            @if (in_array("6", $authdata))
            {{-- จัดการสินค้า --}}
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-cart-plus"></i><b>W</b></span>
                    <span class="pcoded-mtext">จัดการสินค้า</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('backend.product.type') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">ประเภทสินค้า</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.product.category') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">หมวดหมู่สินค้า</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.product') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายการสินค้า</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if (in_array("7", $authdata))
            {{-- จัดการโค้ดส่วนลด --}}
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-product-hunt"></i><b>W</b></span>
                    <span class="pcoded-mtext">จัดการส่วนลด</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('backend.coupon') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายการโค้ดคูปอง</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('backend.promotion') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายการโปรโมชั่น</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li> --}}

                </ul>
            </li>
            @endif
            @if (in_array("9", $authdata))
            {{-- จัดการโค้ดส่วนลด --}}

            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-info"></i><b>W</b></span>
                    <span class="pcoded-mtext">จัดการข้อมูลพื้นฐาน</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ url('/backoffice/province') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">ข้อมูลจังหวัด</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/backoffice/district') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">ข้อมูลเขต</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/backoffice/subdistrict') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายการแขวง</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('backend.promotion') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายการโปรโมชั่น</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li> --}}

                </ul>
            </li>
            @endif
            <div class="pcoded-navigation-label" menu-title-theme="theme1"></div>

            @if (in_array("8", $authdata))
            {{-- ประกาศ/ประชาสัมพันธ์ --}}
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-bullhorn"></i><b>W</b></span>
                    <span class="pcoded-mtext">ประกาศ/ประชาสัมพันธ์</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('backend.publicize.notification') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Notification</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.publicize.news') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">ข่าวสาร</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.publicize.banner') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">แบนเนอร์</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('backend.publicize.contactus') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">ผู้ติดต่อ</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li> --}}
                </ul>
            </li>
            @endif

            {{-- @if (in_array("9", $authdata)) --}}
            {{-- ตรวจสอบตลาด --}}
            {{-- <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-receipt"></i><b>W</b></span>
                    <span class="pcoded-mtext">ตรวจสอบตลาด</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('backend.check.checklist') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">ข้อมูลการตรวจสอบ</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.check.listfine') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายชื่อผู้ค้างจ่ายค่าปรับ</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.check.listtransfer') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายชื่อผู้จ่ายค่าปรับแบบโอน</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.check.listwornout') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายการสินค้าชำรุด</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li> --}}
            {{-- @endif --}}
            @if (in_array("10", $authdata))
            {{-- บัญชี --}}
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-bar-chart-o"></i><b>W</b></span>
                    <span class="pcoded-mtext">บัญชี</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('backend.report.audit.total') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายงานแสดงข้อมูลทั้งหมด</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('backend.report.audit.booking') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายงานทะเบียนคุมใบจอง</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li> --}}
                    <li>
                        <a href="{{ route('backend.report.audit.payment') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายงานการชำระเงิน</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.report.audit.summary') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายงานสรุปยอดขาย</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('backend.report.audit.excel') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Excel to sap</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li> --}}
                    <li>
                        <a href="{{ route('backend.report.audit.type') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายงานประเภทสินค้าที่ขาย</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.report.audit.rentroll') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายงานRentroll</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.report.audit.checkInsale') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายงานการเช็คอินขายสินค้า</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if (in_array("11", $authdata))
            {{-- ออกรายงาน --}}
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-folder-open"></i><b>W</b></span>
                    <span class="pcoded-mtext">ออกรายงาน</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('backend.report.booking') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายงานการจอง</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.report.booth') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายงาน Booth ว่าง</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('backend.report.payment') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายงานชำระเงิน</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li> --}}
                    <li>
                        <a href="{{ route('backend.report.paymentday') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายงานการขายรายวัน</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.report.paymentperson') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายงานการจองบุคคล</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('backend.report.cancel') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">รายงานหลุดการจอง</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li> --}}
                </ul>
            </li>
            @endif

            <div class="pcoded-navigation-label" menu-title-theme="theme1"></div>

            {{-- ออกจากระบบ --}}
            <li class="pcoded">
            <a href="{{ route('backend.admin.logout') }}">
                    <span class="pcoded-micon"><i class="fa fa-sign-out"></i><b>W</b></span>
                    <span class="pcoded-mtext">ออกจากระบบ</span>
					<span class="pcoded-mcaret"></span>
                </a>
            </li>

        </ul>

    </div>
</nav>
