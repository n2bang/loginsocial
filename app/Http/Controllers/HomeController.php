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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
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

        //public_path();
        $file = $request->file('image');
        $fileName = $file->getClientOriginalName();
        $upload_dir      = 'images';
        $finalPath = \Carbon\Carbon::now()->timestamp . '_' . str_random(10) . '_' . $fileName;
        $file->move($upload_dir, $finalPath);


        if (!empty($request->media)) {
            foreach ($request->media as $key => $value) {
                var_dump($value->getRealPath());die;
                $uploaded_media = Twitter::uploadMedia(['media' => File::get($value->getrealpath())]);
                if (!empty($uploaded_media)) {
                    $newTwitte['media_ids'][$uploaded_media->media_ids_string] = $uploaded_media->media_ids_string;
                }
            }
        }
        Twitter::postTweet($newTwitte);
        return back();
    }
}
