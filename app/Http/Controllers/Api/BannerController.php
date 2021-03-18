<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    function save(Request $request) {
        if ($this->image_validatior($request)) {
            $banner_image = $request->banner_image;
            $imageInfo = explode(";base64,", $banner_image);
            $image = str_replace(' ', '+', $imageInfo[1]);
            Storage::disk('local')->put('banner.jpg', base64_decode($image));
            $banner = Banner::updateOrCreate(
                ['banner_img' => 'banner.jpg', 'banner_description' => $request->banner_description, 'user_id' => $request->user()->user_id],
                ['banner_id' => $request->banner_id]
            );
            if ($banner->wasChanged()) {
                return ["status" => 200, "message" => "Banner berhasil disimpan"];
            } else {
                return ["status" => 400, "message" => "Gagal upload banner"];
            }
        }
    }

    function delete(Request $request) {
        $banner = Banner::find($request->banner_id);
        $banner->delete();
        return ["status" => 200, "message" => "Banner berhasil dihapus"];
    }

    function get() {
        $banner = Banner::all()->first();
        $banner->banner_img = 'data:image/jpeg;base64,'.base64_encode(Storage::get('banner.jpg'));
        return $banner;
    }

    function show() {

    }

    function image_validatior($request) {
        $validator_message = [
            'required' => 'Field :attribute wajib diisi'
        ];
        $validator_custom_attribute = [
            'banner_image' => 'Banner'
        ];
        $validator = Validator::make($request->all(), [
            'banner_image' => [
                'required',
                'image'
            ]
        ], $validator_message, $validator_custom_attribute);
        if ($validator->fails()) {
            return ["status" => 500, "message" => $validator->errors()];
        } else {
            return true;
        }
    }
}
