<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Resource;
use File;
use Illuminate\Http\Request;
use Image;
use Validator;

class ResourceController extends Controller
{    
    public function store(Request $request) {
        $is_cke = $request->has('CKEditor');
        $type = $request->has('type') ? strtolower(trim($request->type)) : 'images';     
        $validator = Validator::make($request->all(), [
            'type'   => (!$is_cke ? 'required|' : '') . 'alpha',
            'resize' => 'boolean',
            //'upload' => 'required|image|max:220',
            'upload' => 'required|max:100024|mimes:jpg,jpeg,png,gif,bmp,mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv,mov,ogg,qt',
        ]);
        
        // if ($validator->fails()) return 123;
        if ($validator->fails()) { 
          $result = array();
          $errors = $validator->errors();
          foreach ($errors->all() as $message) {
            $result[] = $message;
          }
          return $result; exit;
        }
       // var_dump($type);die;

        switch ($type) {
            case 'images':
            case 'page':
                $resource = $this->storeImage($request);
                break;
            case 'post':
                $resource = $this->storeImage($request);
                break;
            case 'project':
                $resource = $this->storeImage($request);
                break;
            case 'service':
                $resource = $this->storeImage($request);
                break;
            case 'hoidong':
                $resource = $this->storeImage($request);
                break;
            case 'omember':
                $resource = $this->storeImage($request);
                break;
            case 'setting':
                $resource = $this->storeImage($request);
                break;
                
            case 'video':
                $resource = $this->storeVideo($request);
                break;
            
            default:
                $resource = array();
                break;
        }
        
         // var_dump($resource);

        if ($is_cke) return '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("' . $request->CKEditorFuncNum . '", "' . $resource->thumbnail . '", "");</script>';

        return response()->json([
            'id'   => $resource->id,
            'square' => $resource->thumbnail,
            /*'thumbnail' => $resource->thumbnail,
            'large' => $resource->large,*/
            'full' => $resource->full,
            'type' => $type,
        ]);

   //  	$file = $request->file('upload');
   //  	// $file1 = $file;
   //      $newfilename = $this->rename($file->getClientOriginalName());
   //      // $orginalimage = $this->rename($file1->getClientOriginalName());
   //      $dir_path = public_path("uploads/thumbnail/$type");
   //      // $custom_path = public_path("uploads/$type");
   //      $image_path = public_path("uploads/thumbnail/$type/$newfilename");
   //      // $image_base_path = public_path("uploads/$type/$newfilename");

   //      $image = Image::make($file);
   //      if (!File::exists($dir_path)) File::makeDirectory($dir_path, 0777, true, true);
   //      // if (!File::exists($custom_path)) File::makeDirectory($custom_path, 0777, true, true);

   //      if ($request->has('resize') and $image->width() > config('image.max_size')) {
   //          $image->resize(config('image.max_size'), null, function ($constraint) {
   //              $constraint->aspectRatio();
   //              $constraint->upsize();
   //          });
   //          $image->save($image_path);
   //          // $image->save($image_base_path);
   //      } else {
   //          $file->move($dir_path, $newfilename);
   //          // $file->move($custom_path, $orginalimage);
   //      }

        
   //      $resource = Resource::create([
			// 'type' => $type,
			// 'name' => $newfilename,
   //      ]);
   //       // var_dump($resource);

   //      if ($is_cke) return '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("' . $request->CKEditorFuncNum . '", "' . $resource->thumbnail . '", "");</script>';

   //      return response()->json([
			// 'id'   => $resource->id,
   //          'square' => $resource->thumbnail,
   //          /*'thumbnail' => $resource->thumbnail,
   //          'large' => $resource->large,*/
   //          'full' => $resource->full,
   //      ]);
    }
    protected function storeImage($request) {
        $type = $request->has('type') ? strtolower(trim($request->type)) : 'images';
        $file = $request->file('upload');
        // $file1 = $file;
        $newfilename = $this->rename($file->getClientOriginalName());
        // $orginalimage = $this->rename($file1->getClientOriginalName());
        $dir_path = public_path("uploads/thumbnail/$type");
        // $custom_path = public_path("uploads/$type");
        $image_path = public_path("uploads/thumbnail/$type/$newfilename");
        // $image_base_path = public_path("uploads/$type/$newfilename");

        $image = Image::make($file);
        if (!File::exists($dir_path)) File::makeDirectory($dir_path, 0777, true, true);
        // if (!File::exists($custom_path)) File::makeDirectory($custom_path, 0777, true, true);

        if ($request->has('resize') and $image->width() > config('image.max_size')) {
            $image->resize(config('image.max_size'), null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $image->save($image_path);
            // $image->save($image_base_path);
        } else {
            $file->move($dir_path, $newfilename);
            // $file->move($custom_path, $orginalimage);
        }

        $resource = Resource::create([
            'type' => $type,
            'name' => $newfilename,
        ]);
        return $resource;

    }

    protected function storeVideo($request) {
        $type = $request->has('type') ? strtolower(trim($request->type)) : 'images';
        $file = $request->file('upload');
        // $file1 = $file;
        $newfilename = $this->rename($file->getClientOriginalName());
        // var_dump('newfilename' . $newfilename);
        // $orginalimage = $this->rename($file1->getClientOriginalName());
        $dir_path = public_path("uploads/thumbnail/$type");
        // var_dump('dir_path' . $dir_path);
        // $custom_path = public_path("uploads/$type");
        $image_path = public_path("uploads/thumbnail/$type/$newfilename");
        // var_dump('image_path' . $image_path);
        // $image_base_path = public_path("uploads/$type/$newfilename");
        // exit();
        // $image = Image::make($file);
        if (!File::exists($dir_path)) File::makeDirectory($dir_path, 0777, true, true);
        // if (!File::exists($custom_path)) File::makeDirectory($custom_path, 0777, true, true);
        $file->move($dir_path, $newfilename);
        // $file->move($custom_path, $orginalimage);

        $resource = Resource::create([
            'type' => $type,
            'name' => $newfilename,
        ]);
        return $resource;
    }
    public function destroy($id) {
        $resource = Resource::findOrFail($id);
        $image_path = public_path("uploads/$resource->type/$resource->name");
        File::delete($image_path);
        $resource->delete();
        return response()->json(['status' => 'success', 'message' => trans('admin.message.delete')]);
    }

    private function rename($file) {
        $name = pathinfo($file, PATHINFO_FILENAME);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        return bin2hex(openssl_random_pseudo_bytes(7)) . '-' . strtolower(preg_replace('/\W/', '', $name) . '.' . $ext);
    }
}
