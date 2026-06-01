<?php

namespace App\Http\Controllers\Api\Badal\Projects;

use App\Charity\Settings\SettingSingleton;
use App\Http\Controllers\Controller;
use App\Http\Resources\Badal\BadalSelectedResource;
use App\Http\Resources\Badal\Donors\Projects\CharityBadalProjectResource;
use App\Models\CharityBadalProject;
use App\Models\CharityProject;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class CharityBadalProjectController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $projects = CharityBadalProject::with('project')->get();

        if (!$projects) {
            return $this->notFoundResponse();
        }
        return $this->apiResponse(CharityBadalProjectResource::collection($projects));
    }

    
    public function getSelectedProjectsBadal()
    {
        $badalsettings = SettingSingleton::getInstance();
        $ids = json_decode( $badalsettings->getBadalData('projects'), true);
        $projects =  CharityProject::with('transNow')->findMany($ids);
       
        return $this->apiResponse(BadalSelectedResource::collection($projects));
    }

    public function getbadalProjects()
    {
        $badalsettings = SettingSingleton::getInstance();
        if (!$badalsettings->getBadalData('status')) {
            $this->error('The Badal is not activated');
        }
        $response = [
            [
                'id'        => 1,
                'tag'       => 'haij',
                'status'    => $badalsettings->getBadalData('haij_status'),
                'text'      => $badalsettings->getBadalData('haij_text'),
                'icon'      => asset($badalsettings->getBadalData('haij_icon')),
                'image'     => asset($badalsettings->getBadalData('haij_image')),
            ],
            [
                'id'        => 2,
                'tag'       => 'umrah',
                'status'    => $badalsettings->getBadalData('umrah_status'),
                'text'      => $badalsettings->getBadalData('umrah_text'),
                'icon'      => asset($badalsettings->getBadalData('umrah_icon')),
                'image'     => asset($badalsettings->getBadalData('umrah_image')),
            ]
        ];

        return $this->apiResponse($response);
    }


    public function getUmrahProject(){
        $umrahProjects = CharityBadalProject::WhereHas('project', function($q){
            $q->active();            
        })->where('badal_type', 'umrah')->get();
        return $this->apiResponse(CharityBadalProjectResource::collection($umrahProjects));
    }

    public function getHajjProject(){
        $hajjProjects = CharityBadalProject::WhereHas('project', function($q){
            $q->active();            
        })->where('badal_type', 'hajj')->get();
        return $this->apiResponse(CharityBadalProjectResource::collection($hajjProjects));
    }
}
