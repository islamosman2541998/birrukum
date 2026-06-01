<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use ApiResponseTrait;

    // TO DO
    
    public function appintro(){
        $response = [
            "intro" =>"https://namaa.sa/media/images/kaffarat/Artboard1@4x_2.png",
            "video" =>"https://youtu.be/J88c5Df9i0A",
            "video_time" =>"2",
            "show_video" =>"0",
            "footer_ads_url" =>"https://namaa.sa",
            "footer_ads" =>"https://namaa.sa/media/images/2024/footer.png",
            "token" =>"AAAA2IStuMw:APA91bFgHxCs1Sb2zoF0NfDeprLK3RZ3jMUi1AAj-E7gFUesf2hXDsEQSOEAa1dxUQyidnpiSy8YuJKNItdPhasjgJa8jV06EVHZAmhRp0q_LXq1m_XYkl1d7ANVd10PKfpLYBx-pSiG",
            "license_img" =>"https://namaa.sa/media/files/badal/image_41091.png"
        ];
        
        return $this->apiResponse($response);
    }
}
