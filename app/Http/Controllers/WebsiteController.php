<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Http\Resources\WebsiteResource;
use App\Models\Websites;

class WebsiteController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $filter = request()->query('name');

        if(isset($filter)) {
            $Websites = Websites::where('user_id', $user->id)
                ->where('title', 'like', '%'.$filter.'%')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }else {
            $Websites =  Websites::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return WebsiteResource::collection($Websites);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $relativePath = null;
        $relativePathFav = null;

        if (isset($request->logo)) {
            $relativePath = $this->extractUrl($request->logo);
        }

        if (isset($request->favicon)) {
            $relativePathFav = $this->extractUrl($request->favicon);
        }

        $website = Websites::create([
            'title'         => $request->title,
            'channel'       => json_encode($request->channel),
            'url_path'      => $request->urlPath,
            'logo'          => $relativePath,
            'favicon'       => $relativePathFav,
            'header'        => $request->header,
            'page_layout'   => $request->pageLayout,
            'bg_color'      => $request->bgColor,
            'font_color'    => $request->fontColor,
            'autoplay'      => $request->autoplay,
            'volume'        => $request->volume,
            'controls'      => $request->controls,
            'content_title' => $request->contentTitle,
            'share_button'  => $request->showShareBtn,
            'footer_text'   => $request->footer,
            'seo_site_meta' => $request->siteMeta,
            'whash'         => strtolower(Str::random(26)),
            'user_id'       => $user->id,
        ]);

        return response([
            'data'      => new WebsiteResource($website),
            'message' => 'Website created successfully',
            'status' => 'success',
            'status_code' => 201
        ]);
    }

    public function edit(Request $request, $whash)
    {
        $website = Websites::where('whash', $whash)->first();

        return new WebsiteResource($website);
    }

    public function update(Request $request, $id)
    {
        $website = Websites::findOrFail($id);

        $relativePath = null;
        $relativePathFav = null;

        if (isset($request->logo)) {
            // check content type
            $host = $request->getSchemeAndHttpHost();
            if(strpos($request->logo, $host) !== false) {
                $relativePath = str_ireplace($host.'/', '', $request->logo);
            }else {
                $relativePath = $this->extractUrl($request->logo);
            }
        }

        if (isset($request->favicon)) {
            // check content type
            $host = $request->getSchemeAndHttpHost();
            if(strpos($request->favicon, $host) !== false) {
                $relativePathFav = str_ireplace($host.'/', '', $request->favicon);
            }else {
                $relativePathFav = $this->extractUrl($request->favicon);
            }
        }

        $website->update([
            'title'         => $request->title,
            'channel'       => json_encode($request->channel),
            'url_path'      => $request->urlPath,
            'logo'          => $relativePath,
            'favicon'       => $relativePathFav,
            'header'        => $request->header,
            'page_layout'   => $request->pageLayout,
            'bg_color'      => $request->bgColor,
            'font_color'    => $request->fontColor,
            'autoplay'      => $request->autoplay,
            'volume'        => $request->volume,
            'controls'      => $request->controls,
            'content_title' => $request->contentTitle,
            'share_button'  => $request->showShareBtn,
            'footer_text'   => $request->footer,
            'seo_site_meta' => $request->siteMeta,
        ]);

        return response([
            'data'      => new WebsiteResource($website),
            'message'   => 'Website updated successfully',
            'status'    => 'success',
            'status_code' => 200
        ]);
    }

    public function delete($id)
    {
        $website = Websites::findOrFail($id);

        File::delete(public_path().'/'.$website->logo);
        File::delete(public_path().'/'.$website->favicon);

        $website->delete();

        return response([
            'message' => 'Deleted successfully.',
            'status' => 'success',
            'status_code' => 204
        ]);
    }

    public function webContent($urlPath)
    {
        $website = Websites::where('url_path', $urlPath)->first();

        return response([
            'data'      => new WebsiteResource($website),
            'status'    => 'success',
            'status_code' => 200
        ]); 
    }

    // public function websitePlaylist($urlPath)
    // {
        
    // }

    private function extractUrl($file)
    {
        // check if it's a valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $file, $type)) {
            // take out the base64 encoded text without mimetype
            $file = substr($file, strpos($file, ',') +1);
            // get file extension 
            $type = strtolower($type[1]);
            $file = str_replace(' ', '+', $file);
            $file = base64_decode($file);

            if($file === false) {
                throw new Exception("base64_decode failed");
            }
        } else {
            throw new Exception("Did not match data URI with file data");
        }

        $dir = 'website_logos/';
        $fileHash = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $fileHash;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $file);

        return $relativePath;
    }
}
