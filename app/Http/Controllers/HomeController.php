<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Twitter;
use File;
use Storage;
use Session;

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
        $suggestions = $request->session()->get('suggestions') ? $request->session()->get('suggestions') : array();
        if (empty($suggestions)) {
            $suggestions = Twitter::getSuggestions();
            $request->session()->put('suggestions', $suggestions);
            $request->session()->save();
        }
        $suggestions = $request->session()->get('suggestions');
        $follow_users = array();
        if (!empty($suggestions)) {
            $count_s = count($suggestions);
            $random_n = mt_rand(0, $count_s);
            $slug = $suggestions[$random_n]->slug;
            $obj_follow_users = Twitter::getSuggesteds($slug);
            $follow_users = is_object($obj_follow_users) ? $obj_follow_users->users : array();
        }
        return view('home', compact('follow_users'));
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

    /**
     * A new retweet use api.
     * @method post
     * @param $request
     */
    public function retweet(Request $request)
    {
        $validator = validator()->make($request->input(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if ($request->status == 1) {
            try {
                Twitter::postUnRt($request->id);
                echo 2;exit;
            } catch (Exception $e) {
                // echo 'Message: ' .$e->getMessage();
                echo 0;exit;
            }
        } else {
            try {
                Twitter::postRt($request->id);
                echo 1;exit;
            } catch (Exception $e) {
                // echo 'Message: ' .$e->getMessage();
                echo 0;exit;
            }
        }
    }

    /**
     * Follow and Unfollow.
     * @method post
     * @param $request
     */
    public function follow(Request $request)
    {
        $validator = validator()->make($request->input(), [
            'screen_name' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $params = ['user_id' => $request->user_id, 'screen_name' => $request->screen_name];
        try {
            Twitter::postFollow($params);
            echo 1;exit;
        } catch (Exception $e) {
            // echo 'Message: ' . $e->getMessage();
            echo 0;exit;
        }
    }
}
