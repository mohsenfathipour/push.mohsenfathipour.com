<?php

namespace App\Http\Controllers;

use App\Models\push;
use Illuminate\Http\Request;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class PushController extends Controller
{
    public function store(Request $request)
    {
        push::create([
            'pushdata' => $request->push
        ]);
    }

    public function index()
    {
        return view('admin', ['pushes' => push::latest()->limit(10)->get()]);
    }

    public function send(Request $req, push $push)
    {
        $webPush = new WebPush([
            'VAPID' => [
                'subject' => 'http://localhost',
                'publicKey' => 'BOUHBF1-OSdDD9Ck9oCwtKi7nFA4Qdym-AMTfaSUvo6KS_vJwKe5o5XLd7nitSJeP3HKNTKQYKJ6hyNtvSX8-pQ',
                'privateKey' => 'iiHoSnq8esDropZ4YbIPhllB1jg9Moy6lQiZj5_O6oQ'
            ]
        ]);
        $subscription = Subscription::create(json_decode($push->pushdata, true));
        $response = $webPush->sendOneNotification($subscription, json_encode(['title' => 'new notif', 'body' => $req->text, 'url' => $req->url]));
        if ($response->isSuccess()) {
            echo 'ok';
            } else {
            $response->getReason();
        }
    }
}
