<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QL\QueryList;
use Flash;
use Carbon\Carbon;
use App\Repositories\TaskRepository;
use App\Repositories\Tasktype_eav_valueRepository;

class WebcrawlerController extends Controller
{
    /** @var  TaskRepository */
    private $taskRepository;
    private $taskEavValueRepository;

    public function __construct(TaskRepository $taskRepo,
                                Tasktype_eav_valueRepository $taskEavValueRepo){
        $this->taskRepository = $taskRepo;
        $this->taskEavValueRepository = $taskEavValueRepo;
    }
    //
    public function jdSkuImport()
    {
        $task=$this->taskRepository;
        return view('import.sku',compact('task'));
    }

    public function sku2JD(Request $request)
    {
        $input = $request->all();
        $skus = str_replace("\r\n",",",trim($input['SKU']));
        $skuArray=array_unique(explode(',', $skus));
        $jdSKU=[];
        $errorSKU='';
        foreach($skuArray as $sku){
            $hasSKU=$this->taskEavValueRepository->getEntityFromValue($sku,534);
            if(!$hasSKU){
                $jdSKU[]=$this->getJdPrdFromSKU($sku);
            }else{
                $errorSKU .= $sku.'  ';
            }
        }
        if($errorSKU){
            Flash::error('SKU: '.$errorSKU.trans('view.Duplicate'));
        }
        return view('import.sku',compact('skuArray','jdSKU'));
    }

    public function jdSku2Task(Request $request)
    {
        $input = $request->all();
        $authUser=\Auth::user();
        if(isset($input['jd'])){
            foreach($input['jd'] as $prd){
                if(isset($prd['ready'])){
                    $taskData=[
                        'title' => 'ImportBySKU-JD:'.$prd['sku'],
                        'taskstatus_id' => 1,
                        'tasktype_id' => 2,
                        'hours' => 1,
                        'end_at' => Carbon::now()->toDateTimeString(),
                        'user_id' => $authUser->id,
                        'informed' => $authUser->leader,];
                    $task=$this->taskRepository->create($taskData);
                    $attributes = [534=> $prd["sku"], 536=> $prd["name"], 535=> $prd["brand"], 537=> $prd["image"]];
                    foreach ($attributes as $attKey=>$attValue) {
                        $this->taskEavValueRepository->create(['task_id'=>$task->id,'task_type_eav_id'=>$attKey,'task_value'=>$attValue]);
                    }
                }
            }
        }
        Flash::success('SKU'.trans('view.Import').trans('view.Success'));
        return redirect(route('tasks.index'));
    }

    public function getJdPrdFromSKU($sku)
    {
        $jsonData=[];
        $data=QueryList::get('https://item.jd.com/'.$sku.'.html');
        $jsonData['sku']=$sku;
        $jsonData['name']=$data->find('.sku-name')->text();
        $jsonData['brand']=$data->find('#parameter-brand li a')->text();
        $images=$data->find('#spec-img')->attrs('data-origin')->first();
        $jsonData['image']=$images;//?str_replace('n5/s54x54_jfs','n1/s450x450_jfs',$images[1]):'';
//        echo '<h1>SKU: '.$jsonData['name'].' <br>品牌: '.$jsonData['brand'].'<br></h1>'.'<img src="'.str_replace('n5/s54x54_jfs','n1/s450x450_jfs',$jsonData['image']).'" />';
        return ($jsonData);
    }
}
