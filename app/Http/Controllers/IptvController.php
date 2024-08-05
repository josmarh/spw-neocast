<?php

namespace App\Http\Controllers;

use App\Models\IptvCategory;
use App\Models\IptvChannel;
use App\Http\Resources\IptvCategoryResource;
use App\Http\Resources\IptvChannelResource;
use App\Services\IptvService;
use Illuminate\Http\Request;

class IptvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = $request->query('category');

        if($category){
            $channels = IptvChannel::join('iptv_streams','iptv_streams.channel','=','iptv_channels.channel_id')
                ->where('iptv_channels.categories','like','%'.$category.'%')
                ->paginate(20)
                ->withQueryString();
        }else{
            $channels = IptvChannel::join('iptv_streams','iptv_streams.channel','=','iptv_channels.channel_id')
                ->paginate(20);
        }
        return IptvChannelResource::collection($channels);
    }

    public function getIptvCategory()
    {
        return IptvCategoryResource::collection(IptvCategory::whereNotIn('category',['XXX','Undefined'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
