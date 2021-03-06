<?php

namespace App\Http\Controllers;

use App\Picture;
use Illuminate\Http\Request;
use App\Gallery;
use Illuminate\Support\Str;
class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Gallery $gallery)
    {
        return redirect()->route('galleries.show', $gallery);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Gallery $gallery)
    {
        $client = new \Aws\S3\S3Client([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
        ]);
        $bucket = env('AWS_BUCKET');
        
        // Set some defaults for form input fields
        $formInputs = ['acl' => 'private', 'key'=>'dn/pictures/'. Str::random(40)];
        
        // Construct an array of conditions for policy
        $options = [
            ['acl' => 'private'],
            ['bucket' => $bucket],
            ['starts-with', '$key', 'dn/pictures/'],
        ];
        
        // Optional: configure expiration time string
        $expires = '+2 hours';
        
        $postObject = new \Aws\S3\PostObjectV4(
            $client,
            $bucket,
            $formInputs,
            $options,
            $expires
        );
        
        $formAttributes = $postObject->getFormAttributes();
        $formInputs = $postObject->getFormInputs();
        
        return view('pictures.create', compact('gallery','formInputs','formAttributes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Gallery $gallery)
    {
        $picture = new Picture($request->all());
        $picture->gallery_id = $gallery->id;
        //$picture->path = $request->path->store('pictures', 's3');
        $picture->save();
        return redirect()->route('galleries.show', $gallery);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery, Picture $picture, Request $request)
    {

        if(Str::startsWith($request->header('Accept'), 'image')){
            //return response()->file(\Storage::disk('s3')->getAdapter()->getPathPrefix().$picture->path);
            return redirect(\Storage::disk('s3')->temporaryUrl(
                $picture->path, now()->addMinutes(5)
            ));
        }else{
            return view('pictures.show', compact('gallery','picture'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function edit(Picture $picture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Picture $picture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Picture $picture)
    {
        //
    }
}
