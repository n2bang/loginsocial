<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Twitter;
use File;
use Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // var_dump($tmp); die;
        
        return view('home');
    }

    /**
     * A new tweet use api.
     * @method post
     * @param $request
     */
    public function tweet(Request $request)
    {
        $validator = validator()->make($request->input(), [
            'tweet' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $newTwitte = ['status' => $request->tweet];
        
        /*upload file*/
        // $file = $request->file('image');
        // $fileName = $file->getClientOriginalName();
        // $upload_dir      = 'images';
        // $fileName = \Carbon\Carbon::now()->timestamp . '_' . str_random(10) . '_' . $fileName;
        // $file->move($upload_dir, $fileName);

        /*single image*/
        // $uploaded_media = Twitter::uploadMedia(['media' => File::get($request->file('image'))]);
        // $newTwitte['media_ids'][$uploaded_media->media_id_string] = $uploaded_media->media_id_string;

        /*multiple image*/
        if (!empty($request->images)) {
            foreach ($request->images as $key => $value) {
                $uploaded_media = Twitter::uploadMedia(['media' => File::get($value)]);
                if (!empty($uploaded_media)) {
                    $newTwitte['media_ids'][$uploaded_media->media_id_string] = $uploaded_media->media_id_string;
                }
            }
        }
        Twitter::postTweet($newTwitte);
        return back();
    }
}
