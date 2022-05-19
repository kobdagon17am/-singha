<?php


Route::group(['middleware' => 'auth:admin'], function() {

    // #### Dashboard | หน้าแดชบอร์ด
    Route::get('/','DashboardController@dashboard');
    Route::get('/backoffice/dashboard','DashboardController@dashboard')->name('backend.dashboard');

    // #### Admin | จัดการผู้ใช้งานเข้าระบบ
    Route::get('/backoffice/admin','AdminController@admin')->name('backend.admin');
    Route::get('/backoffice/admin-create','AdminController@admin_create')->name('backend.admin.create');
    Route::post('admins/datatable','AdminController@datatable')->name('api.admins.datatable');
    Route::post('admins/store','AdminController@store')->name('api.admins.store');
    Route::post('admins/edit','AdminController@edit')->name('api.admins.edit');
    Route::post('admins/update','AdminController@update')->name('api.admins.update');
    Route::post('admins/status','AdminController@status')->name('api.admins.status');
    Route::post('admins/permission','AdminController@permission')->name('api.admins.permission');

    // #### Partners | จัดการผู้เช่า
    // ประเภท
    Route::get('/backoffice/partners/type','Partners\PartnersTypeController@partners_type')->name('backend.partners.type');
    Route::get('partners/type/datatable','Partners\PartnersTypeController@datatable')->name('api.partners.type.datatable');
    Route::post('partners/type/add','Partners\PartnersTypeController@add')->name('api.partners.type.add');
    Route::post('partners/type/edit','Partners\PartnersTypeController@edit')->name('api.partners.type.edit');
    Route::post('partners/type/update','Partners\PartnersTypeController@update')->name('api.partners.type.update');

    // ผู้ใช้งาน
    Route::get('/backoffice/partners/user','Partners\PartnersController@partners_user')->name('backend.partners.user');
    Route::post('partners/datatable','Partners\PartnersController@datatable')->name('api.partners.datatable');
    Route::post('partners/add','Partners\PartnersController@add')->name('api.partners.add');
    Route::post('partners/edit','Partners\PartnersController@edit')->name('api.partners.edit');
    Route::post('partners/update','Partners\PartnersController@update')->name('api.partners.update');
    Route::post('partners/searchcategory','Partners\PartnersController@searchcategory')->name('api.partners.searchcategory');
    Route::post('partners/searchproduct','Partners\PartnersController@searchproduct')->name('api.partners.searchproduct');
    Route::post('partners/updateproducttype','Partners\PartnersController@updateproducttype')->name('api.partners.updateproducttype');
    Route::post('partners/addproducttype','Partners\PartnersController@addproducttype')->name('api.partners.addproducttype');
    Route::post('partners/deleteproducttype','Partners\PartnersController@deleteproducttype')->name('api.partners.deleteproducttype');
    Route::post('partners/status','Partners\PartnersController@status')->name('api.partners.status');
    Route::post('partners/changepassword','Partners\PartnersController@changepassword')->name('api.partners.changepassword');
    Route::post('partners/selectdistrict','Partners\PartnersController@selectdistrict')->name('api.partners.selectdistrict');
    Route::post('partners/selectsubdistrict','Partners\PartnersController@selectsubdistrict')->name('api.partners.selectsubdistrict');
    // รอการอนุมัติ
    Route::get('/backoffice/partners/approve','Partners\PartnersApproveController@partners_approve')->name('backend.partners.approve');
    Route::get('partners/approve/datatable','Partners\PartnersApproveController@datatable')->name('api.partners.approve.datatable');
    Route::post('partners/approve/view','Partners\PartnersApproveController@view')->name('api.partners.approve.view');
    Route::post('partners/approve/status','Partners\PartnersApproveController@status')->name('api.partners.approve.status');
    Route::post('partners/approve/delete','Partners\PartnersApproveController@delete')->name('api.partners.approve.delete');

    // #### Market | จัดการตลาด
    // รายชื่อตลาด
    Route::get('/backoffice/market/name','Market\MarketNameController@markat_name')->name('backend.market.name');
    Route::get('/backoffice/market/name-create','Market\MarketNameController@market_create')->name('backend.market.name.create');
    Route::get('/backoffice/market/name-edit/{id}','Market\MarketNameController@market_edit')->name('backend.market.name.edit');
    Route::get('market/name/datatable','Market\MarketNameController@datatable')->name('api.market.name.datatable');
    Route::post('market/name/add','Market\MarketNameController@add')->name('api.market.name.add');
    Route::post('market/name/edit','Market\MarketNameController@edit')->name('api.market.name.edit');
    Route::post('market/name/update','Market\MarketNameController@update')->name('api.market.name.update');
    Route::post('market/name/status','Market\MarketNameController@status')->name('api.market.name.status');
    Route::post('market/name/editer','Market\MarketNameController@editer')->name('api.market.name.editer');
    Route::resource('agreement','Market\AgreementController');
    // วันหยุด
    Route::get('/backoffice/market/calendar-manage/{id}','Market\CalendarManageController@calendar_manage')->name('backend.market.calendar.manage');
    Route::get('market/calendar/datatable','Market\CalendarManageController@datatable')->name('api.market.calendar.datatable');
    Route::post('market/calendar/add','Market\CalendarManageController@add')->name('api.market.calendar.add');
    Route::post('market/calendar/edit','Market\CalendarManageController@edit')->name('api.market.calendar.edit');
    Route::post('market/calendar/update','Market\CalendarManageController@update')->name('api.market.calendar.update');
    Route::post('market/calendar/delete','Market\CalendarManageController@delete')->name('api.market.calendar.delete');
    // ปฏิทินวันหยุด
    Route::get('/backoffice/market/calendar-holiday/{id}','Market\CalendarHolidayController@calander_holiday')->name('backend.market.calendar.holiday');
    // บริการเสริม
    Route::get('/backoffice/market/addservice','Market\ServiceController@addservice')->name('backend.market.addservice');
    Route::get('market/service/datatable','Market\ServiceController@datatable')->name('api.market.service.datatable');
    Route::post('market/service/add','Market\ServiceController@add')->name('api.market.service.add');
    Route::post('market/service/edit','Market\ServiceController@edit')->name('api.market.service.edit');
    Route::post('market/service/update','Market\ServiceController@update')->name('api.market.service.update');
    Route::post('market/service/status','Market\ServiceController@status')->name('api.market.service.status');
    // รูปภาพตลาดกิจกรรม
    Route::get('/backoffice/market/pictures_event','Market\PicturesController@pictures_event')->name('backend.market.pictures_event');
    Route::get('market/pictures/datatable','Market\PicturesController@datatable')->name('api.market.pictures.datatable');
    Route::post('market/pictures/add','Market\PicturesController@add')->name('api.market.pictures.add');
    Route::post('market/pictures/edit','Market\PicturesController@edit')->name('api.market.pictures.edit');
    Route::post('market/pictures/update','Market\PicturesController@update')->name('api.market.pictures.update');
    Route::post('market/pictures/status','Market\PicturesController@status')->name('api.market.pictures.status');
    // Floor
    Route::get('/backoffice/market/floor/{id}','Market\FloorController@floor')->name('backend.market.floor');
    Route::get('market/floor/datatable','Market\FloorController@datatable')->name('api.market.floor.datatable');
    Route::post('market/floor/add','Market\FloorController@add')->name('api.market.floor.add');
    Route::post('market/floor/edit','Market\FloorController@edit')->name('api.market.floor.edit');
    Route::post('market/floor/update','Market\FloorController@update')->name('api.market.floor.update');
    Route::post('market/floor/status','Market\FloorController@status')->name('api.market.floor.status');
    // Zone
    Route::get('/backoffice/market/zone/{id}','Market\ZoneController@zone')->name('backend.market.zone');
    Route::get('market/zone/datatable','Market\ZoneController@datatable')->name('api.market.zone.datatable');
    Route::post('market/zone/add','Market\ZoneController@add')->name('api.market.zone.add');
    Route::post('market/zone/edit','Market\ZoneController@edit')->name('api.market.zone.edit');
    Route::post('market/zone/update','Market\ZoneController@update')->name('api.market.zone.update');
    Route::post('market/zone/status','Market\ZoneController@status')->name('api.market.zone.status');
    Route::post('market/zone/delete','Market\ZoneController@delete')->name('api.market.zone.delete');

    // Booth
    Route::get('/backoffice/market/booth/{id}','Market\BoothControoler@booth')->name('backend.market.booth');
    Route::get('market/booth/datatable','Market\BoothControoler@datatable')->name('api.market.booth.datatable');
    Route::post('market/booth/add','Market\BoothControoler@add')->name('api.market.booth.add');
    Route::post('market/booth/edit','Market\BoothControoler@edit')->name('api.market.booth.edit');
    Route::post('market/booth/update','Market\BoothControoler@update')->name('api.market.booth.update');
    Route::post('market/booth/copy','Market\BoothControoler@copy')->name('api.market.booth.copy');

    // Booth Zone
    Route::resource('boothzone', 'Market\BoothZoneControoler');
    Route::get('market/boothzone/datatable','Market\BoothZoneControoler@datatable')->name('api.market.boothzone.datatable');

    // Booth Detail
    Route::post('backoffice/boothdetail/datatable','Market\BoothDetailControoler@datatable')->name('api.market.boothdetail.datatable');
    Route::get('/backoffice/market/booth-detail/{idz}/{idb}','Market\BoothDetailControoler@boot_detail')->name('backend.market.boothdetail');
    Route::post('market/boothdetail/add','Market\BoothDetailControoler@add')->name('api.market.boothdetail.add');
    Route::post('market/boothdetail/edit','Market\BoothDetailControoler@edit')->name('api.market.boothdetail.edit');
    Route::post('market/boothdetail/update','Market\BoothDetailControoler@update')->name('api.market.boothdetail.update');

    // #### Booking | จัดการการจอง
    Route::get('backoffice/booking/booking_regular', 'BookingController@booking_regular');
    Route::get('backoffice/booking/booking_event', 'BookingController@booking_event');
    Route::get('backoffice/booking/booking_oraganize', 'BookingController@booking_oraganize');
    Route::resource('backoffice/booking', 'BookingController');
    Route::post('backoffice/booking/sentnotification','BookingController@notification')->name('api.booking.sentnotification');
    Route::post('backoffice/booking/sentnotification_overdue','BookingController@notification_overdue')->name('api.booking.sentnotification_overdue');

    Route::post('backoffice/booking/selectmarket','BookingController@selectmarket')->name('api.booking.selectmarket');
    Route::post('backoffice/booking/searchcustomer','BookingController@serach_customer')->name('api.booking.searchcustomer');
    Route::post('backoffice/booking/searchuser','BookingController@searchuser')->name('api.booking.searchuser');
    Route::post('backoffice/booking/databooking','BookingController@databooking')->name('api.booking.databooking');
    Route::post('backoffice/booking/submitconfirmbook','BookingController@submitconfirmbook')->name('api.booking.submitconfirmbook');
    Route::get('backoffice/sentfines','BookingController@sentfines');
    Route::post('backoffice/market/datatable','BookingController@datatable_market')->name('api.booking.market.datatable');
    Route::post('backoffice/booking/datatable_regular','BookingController@datatable_regular')->name('api.booking.datatable_regular');
    Route::post('backoffice/booking/datatable_booking','BookingController@datatable_booking')->name('api.booking.datatable_booking');
    // #### Product | จัดการสินค้า
    // รายการสินค้า
    Route::get('/backoffice/product','Product\ProductController@product')->name('backend.product');
    Route::get('product/datatable','Product\ProductController@datatable')->name('api.product.datatable');
    Route::post('product/add','Product\ProductController@add')->name('api.product.add');
    Route::post('product/edit','Product\ProductController@edit')->name('api.product.edit');
    Route::post('product/update','Product\ProductController@update')->name('api.product.update');
    Route::post('product/status','Product\ProductController@status')->name('api.product.status');
    Route::post('product/query_category','Product\ProductController@query_category')->name('api.product.querycategory');
    // หมวดหมู่สินค้า
    Route::get('/backoffice/product-category','Product\ProductCategoryController@product_category')->name('backend.product.category');
    Route::get('product/category/datatable','Product\ProductCategoryController@datatable')->name('api.product.category.datatable');
    Route::post('product/category/add','Product\ProductCategoryController@add')->name('api.product.category.add');
    Route::post('product/category/edit','Product\ProductCategoryController@edit')->name('api.product.category.edit');
    Route::post('product/category/update','Product\ProductCategoryController@update')->name('api.product.category.update');
    Route::post('product/category/status','Product\ProductCategoryController@status')->name('api.product.category.status');
    // ประเภทสินค้า
    Route::get('/backoffice/product-type','Product\ProductTypeController@product_type')->name('backend.product.type');
    Route::get('product/type/datatable','Product\ProductTypeController@dadatable')->name('api.product.type.datatable');
    Route::post('product/type/add','Product\ProductTypeController@add')->name('api.product.type.add');
    Route::post('product/type/edit','Product\ProductTypeController@edit')->name('api.product.type.edit');
    Route::post('product/type/update','Product\ProductTypeController@update')->name('api.product.type.update');
    Route::post('product/type/status','Product\ProductTypeController@status')->name('api.product.type.status');

    // #### Discount | จัดการส่วนลด
    // รายการโค้ดคูปอง
    Route::get('/backoffice/coupon','CouponController@coupon')->name('backend.coupon');
    Route::get('coupon/datatable','CouponController@datatable')->name('api.coupon.datatable');
    Route::get('coupon/datatable_person','CouponController@datatable_person')->name('api.coupon.datatable_person');
    Route::get('coupon/datatable_public','CouponController@datatable_public')->name('api.coupon.datatable_public');
    Route::post('coupon/add','CouponController@add')->name('api.coupon.add');
    Route::post('coupon/edit','CouponController@edit')->name('api.coupon.edit');
    Route::post('coupon/update','CouponController@update')->name('api.coupon.update');
    Route::post('coupon/cancel','CouponController@cancel')->name('api.coupon.cancel');
    Route::post('coupon/confirm','CouponController@confirm')->name('api.coupon.confirm');
    Route::post('coupon/delete_sendcode','CouponController@delete_sendcode')->name('api.coupon.delete_sendcode');
    Route::post('coupon/search_partners','CouponController@search_partners')->name('api.coupon.search_partners');
    Route::post('coupon/add_person','CouponController@add_person')->name('api.coupon.add_person');
    Route::post('coupon/sendcode_person','CouponController@sendcode_person')->name('api.coupon.sendcode_person');
    Route::post('coupon/sendcode_all','CouponController@sendcode_all')->name('api.coupon.sendcode_all');
    // รายการโปรโมชั่น
    Route::get('/backoffice/promotion','PromotionController@promotion')->name('backend.promotion');
    Route::get('promotion/datatable','PromotionController@datatable')->name('api.promotion.datatable');
    Route::post('promotion/add','PromotionController@add')->name('api.promotion.add');
    Route::post('promotion/edit','PromotionController@edit')->name('api.promotion.edit');
    Route::post('promotion/update','PromotionController@update')->name('api.promotion.update');
    Route::post('promotion/cancel','PromotionController@cancel')->name('api.promotion.cancel');
    Route::post('promotion/confirm','PromotionController@confirm')->name('api.promotion.confirm');

    // #### Publicize | ประกาศประชาสัมพันธ์
    // notification
    Route::get('/backoffice/publicize/notification','Publicize\NotificationController@notification')->name('backend.publicize.notification');
    Route::get('publicize/notification/datatable','Publicize\NotificationController@datatable')->name('api.publicize.notification.datatable');
    Route::post('publicize/notification/add','Publicize\NotificationController@add')->name('api.publicize.notification.add');
    Route::post('publicize/notification/edit','Publicize\NotificationController@edit')->name('api.publicize.notification.edit');
    Route::post('publicize/notification/update','Publicize\NotificationController@update')->name('api.publicize.notification.update');
    Route::post('publicize/notification/status','Publicize\NotificationController@status')->name('api.publicize.notification.status');
    // ข่าวสาร
    Route::get('/backoffice/publicize/news','Publicize\NewsController@news')->name('backend.publicize.news');
    Route::get('/backoffice/publicize/news_create','Publicize\NewsController@news_create')->name('backend.publicize.news.create');
    Route::get('/backoffice/publicize/news_edit/{id}','Publicize\NewsController@edit')->name('backend.publicize.news.edit');
    Route::get('/backoffice/publicize/news_gallery/{id}','Publicize\NewsController@gallery')->name('backend.publicize.news.gallery');
    Route::get('publicize/news/datatable','Publicize\NewsController@datatable')->name('api.publicize.news.datatable');
    Route::post('publicize/news/add','Publicize\NewsController@add')->name('api.publicize.news.add');
    Route::post('publicize/news/update','Publicize\NewsController@update')->name('api.publicize.news.update');
    Route::post('publicize/news/status','Publicize\NewsController@status')->name('api.publicize.news.status');
    Route::post('publicize/news/delete','Publicize\NewsController@delete')->name('api.publicize.news.delete');
    Route::post('publicize/news/editer','Publicize\NewsController@editer')->name('api.publicize.news.editer');
    Route::post('publicize/news/gallery_add','Publicize\NewsController@gallery_add')->name('api.publicize.news.gallery_add');
    Route::post('publicize/news/gallery_status','Publicize\NewsController@gallery_status')->name('api.publicize.news.gallery_status');
    Route::post('publicize/news/gallery_delete','Publicize\NewsController@gallery_delete')->name('api.publicize.news.gallery_delete');
    Route::post('publicize/news/gallery_edit','Publicize\NewsController@gallery_edit')->name('api.publicize.news.gallery_edit');
    Route::post('publicize/news/gallery_update','Publicize\NewsController@gallery_update')->name('api.publicize.news.gallery_update');
    // แบนเนอร์
    Route::get('/backoffice/publicize/banner','Publicize\BannerController@banner')->name('backend.publicize.banner');
    Route::get('publicize/banner/datatable','Publicize\BannerController@datatable')->name('api.publicize.banner.datatable');
    Route::post('publicize/banner/add','Publicize\BannerController@add')->name('api.publicize.banner.add');
    Route::post('publicize/banner/edit','Publicize\BannerController@edit')->name('api.publicize.banner.edit');
    Route::post('publicize/banner/update','Publicize\BannerController@update')->name('api.publicize.banner.update');
    Route::post('publicize/banner/status','Publicize\BannerController@status')->name('api.publicize.banner.status');
    Route::post('publicize/banner/delete','Publicize\BannerController@delete')->name('api.publicize.banner.delete');
    // ผู้ติดต่อ
    Route::get('/backoffice/publicize/contactus','Publicize\ContactController@contactus')->name('backend.publicize.contactus');
    Route::get('publicize/contact/datatable','Publicize\ContactController@datatable')->name('api.publicize.contact.datatable');
    Route::post('publicize/contact/add','Publicize\ContactController@add')->name('api.publicize.contact.add');
    Route::post('publicize/contact/delete','Publicize\ContactController@delete')->name('api.publicize.contact.delete');

    // #### Checklist | ตรวจสอบตลาด
    Route::get('/backoffice/check/checklist','ChecklistController@checklist')->name('backend.check.checklist'); // ข้อมูลการตรวจสอบ
    Route::get('/backoffice/check/listfine','ChecklistController@list_fine')->name('backend.check.listfine'); // รายชื่อผู้ค้างจ่ายค่าปรับ
    Route::get('/backoffice/check/listtransfer','ChecklistController@list_transfer')->name('backend.check.listtransfer'); // รายชื่อผู้จ่ายค่าปรับแบบโอน
    Route::get('/backoffice/check/listwornout','ChecklistController@list_wornout')->name('backend.check.listwornout'); // รายการสินค้าชำรุด
    Route::get('/checklist/datatable','ChecklistController@checklist_datatable')->name('api.checklist.datatable'); // ข้อมูลการตรวจสอบ
    Route::get('/listfine/datatable','ChecklistController@list_fine_datatable')->name('api.listfine.datatable'); // รายชื่อผู้ค้างจ่ายค่าปรับ
    Route::get('/listtransfer/datatable','ChecklistController@list_transfer_datatable')->name('api.listtransfer.datatable'); // รายชื่อผู้จ่ายค่าปรับแบบโอน
    Route::get('/listwornout/datatable','ChecklistController@list_wornout_datatable')->name('api.listwornout.datatable'); // รายการสินค้าชำรุด

    // #### Audit | บัญชี
    Route::get('/backoffice/report/audit/total','ReportController@report_audit_total')->name('backend.report.audit.total'); // รายงานแสดงข้อมูลทั้งหมด
    Route::get('/backoffice/report/audit/booking','ReportController@report_audit_booking')->name('backend.report.audit.booking'); // รายงานทะเบียนคุมใบจอง
    Route::get('/backoffice/report/audit/payment','ReportController@report_audit_payment')->name('backend.report.audit.payment'); // รายงานการชำระเงิน
    Route::get('/backoffice/report/audit/summary','ReportController@report_audit_summary')->name('backend.report.audit.summary'); // รายงานสรุปยอดขาย
    Route::get('/backoffice/report/audit/excel','ReportController@report_audit_excel')->name('backend.report.audit.excel'); // Excel to sap
    Route::get('/backoffice/report/audit/type','ReportController@report_audit_type')->name('backend.report.audit.type'); // รายงานประเภทสินค้าที่ขาย
    Route::get('/backoffice/report/audit/rentroll','ReportController@report_audit_rentroll')->name('backend.report.audit.rentroll'); // รายงานประเภทสินค้าที่ขาย
    Route::post('/pdf/report/audit_total','ReportController@report_audit_total_pdf')->name('pdf.report.audit_total'); // รายงานแสดงข้อมูลทั้งหมด
    Route::post('/pdf/report/audit_booking','ReportController@report_audit_booking_pdf')->name('pdf.report.audit_booking'); // รายงานทะเบียนคุมจอง
    Route::post('/pdf/report/audit_payment','ReportController@report_audit_payment_pdf')->name('pdf.report.audit_payment'); // รายงานการชำระเงิน
    Route::post('/pdf/report/audit_summary','ReportController@report_audit_summary_pdf')->name('pdf.report.audit_summary'); // รายงานสรุปยอดขาย
    Route::post('/pdf/report/audit_type','ReportController@report_audit_type_pdf')->name('pdf.report.audit_type'); // รายงานประเภทสินค้าที่ขาย
    Route::post('/pdf/report/audit_rentroll','ReportController@report_audit_rentroll_pdf')->name('pdf.report.audit_rentroll'); // รายงานประเภทสินค้าที่ขาย

    // #### Report | ออกรายงาน
    Route::get('/backoffice/report/booking','ReportController@report_booking')->name('backend.report.booking'); // รายงานการจอง
    Route::get('/backoffice/report/booth','ReportController@report_booth')->name('backend.report.booth'); // รายงาน Booth ว่าง
    Route::get('/backoffice/report/payment','ReportController@report_payment')->name('backend.report.payment'); // รายงานชำระเงิน
    Route::get('/backoffice/report/paymentday','ReportController@report_payment_day')->name('backend.report.paymentday'); // รายงานการขายรายวัน
    Route::get('/backoffice/report/paymentperson','ReportController@report_payment_person')->name('backend.report.paymentperson'); // รายงานการจองบุคคล
    Route::get('/backoffice/report/cancel','ReportController@report_cancel')->name('backend.report.cancel'); // รายงานหลุดการจอง
    Route::post('/pdf/report/booking','ReportController@report_booking_pdf')->name('pdf.report.booking'); // รายงานการจอง
    Route::post('/pdf/report/booth','ReportController@report_booth_pdf')->name('pdf.report.booth'); // รายงาน Booth ว่าง
    Route::post('/pdf/report/payment','ReportController@report_payment_pdf')->name('pdf.report.payment'); // รายงานชำระเงิน
    Route::post('/pdf/report/payment_day','ReportController@report_payment_day_pdf')->name('pdf.report.payment_day'); // รายงานชำระเงิน
    Route::post('/pdf/report/payment_person','ReportController@report_payment_person_pdf')->name('pdf.report.payment_person'); // รายงานการจองบุคคล
    Route::post('/pdf/report/cancel','ReportController@report_cancel_pdf')->name('pdf.report.cancel'); // รายงานหลุดการจอง

    Route::get('/backoffice/report/bookingall_exprot','ReportController@report_booking_exprot');
    Route::get('/backoffice/report/rent_exprot','ReportController@report_rent_exprot');

    Route::resource('officers', 'Officers\OfficersController');
    Route::post('backoffice/officers/datatable','Officers\OfficersController@datatable')->name('api.officers.datatable');
    Route::post('officers/edit','Officers\OfficersController@edit')->name('api.officers.edit');

    // TEST
    Route::get('/example_lobibox', function () { return view('backend/example_lobibox'); });
    Route::get('exporttext', 'BookingController@exporttext');
    Route::get('file-import-export', 'BookingController@databooking');
    Route::post('file-import', 'BookingController@fileImport')->name('file-import');
    Route::post('file-import-more', 'BookingController@fileImportmore')->name('file-import-more');
    Route::post('file-import-discount', 'BookingController@fileImportDiscount')->name('file-import-discount');

    Route::get('file-export', 'UserController@fileExport')->name('file-export');

     // Dopa
    Route::get('/backoffice/province', 'DopaController@province');
    Route::post('addprovince','DopaController@addprovince');
    Route::post('showprovince','DopaController@showprovince');
    Route::post('editprovince','DopaController@editprovince');
    Route::post('deleteprovince','DopaController@deleteprovince');
    Route::post('data/backoffice/province','DopaController@dataprovince')->name('api.province.datatable');

    Route::get('/backoffice/district', 'DopaController@district');
    Route::post('adddistrict','DopaController@adddistrict');
    Route::post('showdistrict','DopaController@showdistrict');
    Route::post('editdistrict','DopaController@editdistrict');
    Route::post('deletedistrict','DopaController@deletedistrict');
    Route::post('data/backoffice/district','DopaController@datadistrict')->name('api.district.datatable');

    Route::get('/backoffice/subdistrict', 'DopaController@subdistrict');
    Route::post('addsubdistrict','DopaController@addsubdistrict');
    Route::post('showsubdistrict','DopaController@showsubdistrict');
    Route::post('editsubdistrict','DopaController@editsubdistrict');
    Route::post('deletesubdistrict','DopaController@deletesubdistrict');
    Route::post('data/backoffice/subdistrict','DopaController@datasubdistrict')->name('api.subdistrict.datatable');

});

    // Login & Logout
    Auth::routes();
    Route::post('/backoffice/admin/login','Auth\AdminLoginController@login')->name('backend.admin.login');
    Route::get('/backoffice/admin/login','Auth\AdminLoginController@showLoginForm')->name('backend.login');
    Route::get('/backoffice/admin/logout','Auth\AdminLoginController@logout')->name('backend.admin.logout');

    // Clear Cache
    Route::get('/clc', function() {
        Artisan::call('cache:clear');
        // Artisan::call('optimize');
        // Artisan::call('route:cache');
        // Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('config:cache');
    });

