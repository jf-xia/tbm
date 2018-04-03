<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QL\QueryList;

class WebcrawlerController extends Controller
{
    //
    public function jdsku($sku)
    {
        $jsonData=[];
        $data=QueryList::get('https://item.jd.com/'.$sku.'.html');
        $jsonData['name']=$data->find('.sku-name')->text();
        $jsonData['brand']=$data->find('#parameter-brand li a')->text();
        $images=$data->find('.product-intro')->find('img')->attrs('src')->toArray();
        $jsonData['image']=$images?str_replace('n5/s54x54_jfs','n1/s450x450_jfs',$images[1]):'';
//        return ($jsonData);
        echo '<h1>SKU: '.$jsonData['name'].' <br>品牌: '.$jsonData['brand'].'<br></h1>'.'<img src="'.str_replace('n5/s54x54_jfs','n1/s450x450_jfs',$jsonData['image']).'" />';
//        foreach($images as $img){
////            echo $img;
//            echo '<img src="'.str_replace('n5/s54x54_jfs','n1/s450x450_jfs',$img[0]).'" />';
//        }
    }
}
