<?php

namespace App\Http\Controllers\Publicize;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Default
use Session;
use Response;
use Auth;
use Image;
use Yajra\Datatables\Datatables;

// Model
use App\Model\News;
use App\Model\NewsGallery;


class NewsController extends Controller
{
   
    // New
    public function news(){
        return view('backend/publicize/news');
    }

    public function news_create(){
        return view('backend/publicize/news_create');
    }

    public function datatable(){
        // Query Status
        $date_status = request('status_val');
        if($date_status == 'T'){
            $news = News::all();
        }elseif($date_status == 'Y'){
            $news = News::where('status','Y')->get();
        }elseif($date_status == 'N'){
            $news = News::where('status','N')->get();
        }else{
            $news = News::all();
        }
        $sQuery	 = Datatables::of($news)
        // ===================================================

        // รูปภาพปก
        ->editColumn('colum_image',function($data){
            if($data->image != NULL){
                $path_image = asset('storage/uploadfile/news_title/'.$data->image);
                $image = "<img src='".$path_image."' style='height:125px; width:125px;'>";
            }else{
                $path_image = asset('public/assets/backend/img/wait_img.png');
                $image = "<img src='".$path_image."' style='height:125px; width:125px;'>";
            }
            return $image;
        })

        // หัวข้อ
        ->editColumn('colum_title',function($data){
            return $data->title;
        })
        // วันเริ่ม
        ->editColumn('colum_date_start',function($data){
            return $data->date_start;
        })
        // วันสิ้นสุด
        ->editColumn('colum_date_end',function($data){
            return $data->date_end;
        })

        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "Y"){
                $status_t = '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>';
            }else{
                $status_t = '<font color="red"><p title="ยกเลิก"><i class="fa fa-times-circle"></i> ยกเลิก</p></font>';
            }
            return $status_t;
        })

        // จัดการ
        ->editColumn('colum_manage',function($data){

            if($data->status == "Y"){
                $statusAD = '<a href="#!" class="dropdown-item waves-effect waves-light" onclick="status('.$data->news_id. ',' ."'$data->v'".')" ><i class="fa fa-times"></i>&nbsp;&nbsp;ยกเลิกใช้งาน</button></a>';
            }else{
                $statusAD = '<a href="#!" class="dropdown-item waves-effect waves-light" onclick="status('.$data->news_id. ',' ."'$data->title'".')" ><i class="fa fa-check"></i>&nbsp;&nbsp;เปิดใช้งาน</button></a>'; 
            }

            return  '<div class="btn-group dropdown-split-inverse">
                        <button type="button" class="btn btn-inverse" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">จัดการ <i class="ti-angle-down"></i></button>
                        <div class="dropdown-menu"> 
                            <a href="'.route("backend.publicize.news.edit" , array("id"=>$data->news_id)).'" class="dropdown-item waves-effect waves-light" ><i class="fa fa-edit"></i> แก้ไข</a>   
                            <a href="'.route("backend.publicize.news.gallery" , array("id"=>$data->news_id)).'" class="dropdown-item waves-effect waves-light" ><i class="fa fa-image"></i> รูปภาพเพิ่มเติม</a>   
                            '.$statusAD.'
                            <a href="#!" class="dropdown-item waves-effect waves-light" onclick="deletedata('.$data->news_id. ',' ."'$data->title'".')" ><i class="fa fa-trash-o"></i> &nbsp;ลบ</button></a>
                        </div>
                    </div>';
        });


        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request){
        
        // รูปภาพปก
        $path = "storage/uploadfile/news_title/";
        if(!empty($request->file('fileimg'))){
            $image  = $request->file('fileimg');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $new_imgs = date('dmYHis').'CZ.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());     
            $image_resize->save($path.$new_imgs);	
        }else{
            $new_imgs = null;   
        }


        $news = new News;
        $news->title = $request->title;
        $news->date_start = $request->date_start;
        $news->date_end = $request->date_end;
        $news->detail = $request->detail_editer;
        $news->image = $new_imgs; // รูปภาพปก
        $news->status = "Y";
        $news->save();

        // รูปภาพเพิ่มเติม
        $path_s = "storage/uploadfile/news_gallery/";
        if(!empty($request->file('fileimg_gallery'))){
            foreach ($request->file('fileimg_gallery') as $key => $media) {
                if(!empty($media)){
                    $type         = explode('.',$media->getClientOriginalName());
                    $size         = sizeof($type);
                    $new_img      = $media->getClientOriginalName();
                    $new_imgs_s     = date('dmYHis').$key.'imgs.'.$type[$size-1];
                    $image_resize = Image::make($media->getRealPath());         
                    $image_resize->save($path_s.$new_imgs_s);
                    
                    $gallery = new NewsGallery;
                    $gallery->news_id = $news->news_id;
                    $gallery->image  = $new_imgs_s;
                    $gallery->status = "Y";
                    $gallery->save();
                }
            } 			
        }


        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function edit($id){
        $news = News::find($id);
        return view('backend/publicize/news_edit',['news'=>$news]);
    }

    public function update(Request $request){

        // รูปภาพปก
        $path = "storage/uploadfile/news_title/";
        if(!empty($request->file('fileimg'))){
            $image  = $request->file('fileimg');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $new_imgs = date('dmYHis').'img.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());     
            $image_resize->save($path.$new_imgs);	
            $oldpic = 'storage/uploadfile/news_title/'.$request->fileold;
            if(is_file($oldpic)){
                unlink($oldpic);					
            }
        }else{
            $new_imgs = $request->fileold;
        }

        $news = News::find($request->id);
        $news->title = $request->title;
        $news->date_start = $request->date_start;
        $news->date_end = $request->date_end;
        $news->detail = $request->detail_editer;
        $news->image = $new_imgs; // รูปภาพปก
        $news->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function status(Request $request){
        $news = News::find($request->id);
        if($news->status == "Y"){
            $news->status = "N";
            $news->save(); 
            $data['response'] = true;
            $data['title'] = "ยกเลิกใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }else{
            $news->status = "Y";
            $news->save(); 
            $data['response'] = true;
            $data['title'] = "เปิดใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว'; 
        }
        return Response::json($data);
    }

    public function delete(Request $request){

        $news = News::find($request->id);
        $fileold = "storage/uploadfile/news_title/".$news->image;
		if(is_file($fileold)){
            unlink($fileold);
		}	
        $news->delete();

        $gallery = NewsGallery::where('news_id',$request->id)->get();
        if(!empty($gallery)){
            foreach($gallery as $gallerys){
                $fileold_g = 'storage/uploadfile/news_gallery/'.$gallerys->image;
                if(is_file($fileold_g)){
                    unlink($fileold_g);
                }
            }
        }
        NewsGallery::where('news_id',$request->id)->delete();


        $data['response'] = true;
        $data['title'] = "ลบข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว'; 
        return Response::json($data);
    }

    public function editer(Request $request){
        $path = "storage/uploadfile/news_editor/";
        $newname = '';
        if($_FILES['image']['name'] != ''){
            $newname = '';
            $cuttype = explode('.',$_FILES['image']['name']);
            $siezetype = sizeof($cuttype);
            $namenew = date('dmYHis').'edt.'.$cuttype[$siezetype-1];
            copy($_FILES['image']['tmp_name'],$path.$namenew);
        }
        $img = asset('storage/uploadfile/news_editor/'.$namenew);
        return response()->json($img);
    }

    // ==================== รูปภาพเพิ่มเติม ====================
    public function gallery($id){
        $news = News::where('news_id',$id)->first();
        return view('backend/publicize/news_gallery',['news'=>$news]);
    }

    public function gallery_add(Request $request){
        $path = "storage/uploadfile/news_gallery/";
        if(!empty($request->file('fileimg_gallery'))){
            foreach ($request->file('fileimg_gallery') as $key => $media) {
                if(!empty($media)){
                    $type         = explode('.',$media->getClientOriginalName());
                    $size         = sizeof($type);
                    $new_img      = $media->getClientOriginalName();
                    $new_imgs     = date('dmYHis').$key.'imgs.'.$type[$size-1];
                    $image_resize = Image::make($media->getRealPath());         
                    $image_resize->save($path.$new_imgs);
                    
                    $gallery = new NewsGallery;
                    $gallery->news_id = $request->id;
                    $gallery->image  = $new_imgs;
                    $gallery->status = "Y";
                    $gallery->save();
                }
            } 			
        }

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function gallery_status(Request $request){
        $gallery = NewsGallery::find($request->id);
        if($gallery->status == "Y"){
            $gallery->status = "N";
            $gallery->save(); 
            $data['response'] = true;
            $data['title'] = "ยกเลิกใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }else{
            $gallery->status = "Y";
            $gallery->save(); 
            $data['response'] = true;
            $data['title'] = "เปิดใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว'; 
        }
        return Response::json($data);
    }

    public function gallery_delete(Request $request){
        $gallery = NewsGallery::find($request->id);
        $oldpic = 'storage/uploadfile/news_gallery/'.$gallery->image;
        if(is_file($oldpic)){
            unlink($oldpic);					
        }
        $gallery->delete();
        $data['response'] = true;
        $data['title'] = "ลบข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function gallery_edit(Request $request){
        $gallery = NewsGallery::find($request->id);
        return Response::json($gallery);
    }

    public function gallery_update(Request $request){
        $path = "storage/uploadfile/news_gallery/";
        if(!empty($request->file('image_file'))){
            $image  = $request->file('image_file');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $new_imgs = date('dmYHis').'img.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());     
            $image_resize->save($path.$new_imgs);	

            $oldpic = 'storage/uploadfile/news_gallery/'.$request->fileold;
            if(is_file($oldpic)){
                unlink($oldpic);					
            }
        }else{
            $new_imgs = $request->fileold;
        }

        $gallery = NewsGallery::find($request->id);
        $gallery->image  = $new_imgs;
        $gallery->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }
    
}
