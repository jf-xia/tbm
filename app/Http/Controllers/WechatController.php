<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

class WechatController extends Controller
{
    //
    public $wechat;

    /**
     * WechatController constructor.
     * @param $wechat
     */
    public function __construct(Application $wechat)
    {
        $this->wechat = $wechat;
    }

    public function server()
    {
        $server = $this->wechat->server;
        $server->setMessageHandler(function($message){
            return "欢迎关注 Jack Task System！";
        });

        return $server->serve()->send();
    }

    public function users()
    {
        $users = $this->wechat->user->lists();
        return $users;
    }

    public function materials()
    {
        $materials = $this->wechat->material->lists(2);
        return $materials;
    }


}

