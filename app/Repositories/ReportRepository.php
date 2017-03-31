<?php

namespace App\Repositories;

use App\Models\Report;
use Carbon\Carbon;
use App\Repositories\BaseRepository;

class ReportRepository extends BaseRepository
{
    public $tasksByUserValue = [];
    public $tasksByTypesUser = [];
    public $tasksByTypes = [];

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'desc',
        'rules'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Report::class;
    }

    public function toTable($taskArray)
    {
        $tableHtml = '';
        if ($taskArray){

            $tableHtml .= '<table class="table"><thead><tr>';
            foreach($taskArray[0] as $tableHeader=>$notUsed){
                $header = \Lang::has('db.'.$tableHeader) ? trans('db.'.$tableHeader) : $tableHeader;
                $tableHtml .= '<th>'.$header.'</th>';
            }
            $tableHtml .= '</tr></thead>';

            foreach($taskArray as $tableData){
                $tableHtml .= '<tr>';
                foreach($tableData as $tkey=>$tValue){
                    $tableHtml .= '<td>'.$tValue.'</td>';
                }
                $tableHtml .= '</tr>';
            }
            $tableHtml .= '</table>';
        }
        return $tableHtml;
    }

//SELECT sum(tasks.hours) as hours, sum(tasks.price) as price, (SELECT name from users where id=tasks.user_id) as username FROM tasks where deleted_at is null and user_id in () GROUP BY user_id
    public function tasksByUserValue($myTeams,$from,$to){
        $taskTypesUser=[];
        $tasktypecountUser=[];
        $taskdoneUser=[];
        $hoursumUser=[];
        $pricesumUser=[];
//        $uncommentUser=[];
//        $goodUser=[];
//        $badUser=[];

        if ($myTeams){
            $this->tasksByUserValue = \DB::select('SELECT user_id, (SELECT name from users where id=a.user_id) AS username, count(a.id) AS tasktypecount,count(CASE taskstatus_id WHEN 5 THEN 5 END) AS taskdone,  sum(hours) AS hours, sum(price) AS price FROM (SELECT id,taskstatus_id,hours,price,user_id,end_at from tasks where deleted_at is null) a WHERE  a.user_id in ('.implode(',',($myTeams)).')  and a.end_at>=:from and a.end_at<=:to GROUP BY a.user_id  order by hours DESC',['from'=>$from,'to'=>$to]);
//            $this->tasksByUserValue = \DB::select('SELECT user_id, (SELECT name from users where id=a.user_id) AS username, count(a.id) AS tasktypecount,count(CASE taskstatus_id WHEN 5 THEN 5 END) AS taskdone,  sum(hours) AS hoursum, sum(price) AS price, sum(uncomm) AS uncomment, sum(good) AS good, sum(bad) AS bad FROM (SELECT id,taskstatus_id,hours,price,user_id,end_at from tasks where deleted_at is null) a, (SELECT task_id, count(CASE grade WHEN 0 THEN 0 END) AS uncomm, count(CASE grade WHEN 1 THEN 1 END) AS good, count(CASE grade WHEN 2 THEN 2 END) AS bad FROM taskgroups GROUP BY task_id ) b WHERE a.id = b.task_id and a.user_id in ('.implode(',',($myTeams)).')  and a.end_at>=:from and a.end_at<=:to GROUP BY a.user_id',['from'=>$from,'to'=>$to]);

            foreach($this->tasksByUserValue as $tasktypecUser){
                $taskTypesUser[] = $tasktypecUser->username;
                $tasktypecountUser[] = $tasktypecUser->tasktypecount-$tasktypecUser->taskdone;
                $taskdoneUser[]= $tasktypecUser->taskdone;
                $hoursumUser[] = $tasktypecUser->hours;
                $pricesumUser[] = $tasktypecUser->price;
//                $uncommentUser[] = $tasktypecUser->uncomment;
//                $goodUser[] = $tasktypecUser->good;
//                $badUser[] = $tasktypecUser->bad;
            }
        }

        $taskReport = ['taskTypes'=>$taskTypesUser, 'taskCount'=>$tasktypecountUser,'taskdone'=>$taskdoneUser, 'taskHourSum'=>$hoursumUser, 'taskPriceSum'=>$pricesumUser];
        //, 'taskUncommentSum'=>$uncommentUser, 'taskGoodSum'=>$goodUser, 'taskBadSum'=>$badUser
        $taskReport['table'] = $this->toTable($this->tasksByUserValue);
        return $taskReport;
    }

    public function tasksByTypesUser($tasktyleList,$user_id,$from,$to){//  tasktype_id,
        $this->tasksByTypesUser = \DB::select('SELECT name as tasktype, count(name) as tasktypecount, count(CASE taskstatus_id WHEN 5 THEN 5 END) AS taskdone, sum(hours) as hours, sum(price) as price FROM (select a.id,a.user_id,a.tasktype_id,a.taskstatus_id,b.name,a.hours,a.price,a.end_at from tasks a,tasktypes b where a.tasktype_id=b.id and a.deleted_at is null) a where tasktype_id in ('.implode(',',array_keys($tasktyleList)).') and user_id='.$user_id.'  and a.end_at>=:from and a.end_at<=:to GROUP BY tasktype_id  order by hours DESC',['from'=>$from,'to'=>$to]);
//        $this->tasksByTypesUser = \DB::select('SELECT name as tasktype, count(name) as tasktypecount, count(CASE taskstatus_id WHEN 5 THEN 5 END) AS taskdone, sum(hours) as hours, sum(price) as price, sum(uncomm) as uncomment,sum(good) as good, sum(bad) as bad FROM (select a.id,a.user_id,a.tasktype_id,a.taskstatus_id,b.name,a.hours,a.price,a.end_at from tasks a,tasktypes b where a.tasktype_id=b.id and a.deleted_at is null) a,(select task_id,count(case grade when 0 then 0 end )  as uncomm,count(case grade when 1 then 1 end )  as good,count(case grade when 2 then 2 end )  as bad from taskgroups GROUP BY task_id) b where a.id=b.task_id and tasktype_id in ('.implode(',',array_keys($tasktyleList)).') and user_id='.$user_id.'  and a.end_at>=:from and a.end_at<=:to GROUP BY tasktype_id',['from'=>$from,'to'=>$to]);

        $taskTypesUser=[];
        $tasktypecountUser=[];
        $taskdoneUser=[];
        $hoursumUser=[];
//        $pricesumUser=[];
//        $uncommentUser=[];
//        $goodUser=[];
//        $badUser=[];
        foreach($this->tasksByTypesUser as $tasktypecUser){
            $taskTypesUser[] = $tasktypecUser->tasktype;
            $tasktypecountUser[] = $tasktypecUser->tasktypecount-$tasktypecUser->taskdone;
            $taskdoneUser[]= $tasktypecUser->taskdone;
            $hoursumUser[] = $tasktypecUser->hours;
//            $pricesumUser[] = $tasktypecUser->price;
//            $uncommentUser[] = $tasktypecUser->uncomment;
//            $goodUser[] = $tasktypecUser->good;
//            $badUser[] = $tasktypecUser->bad;
        }

        $taskReport = ['taskTypes'=>$taskTypesUser, 'taskCount'=>$tasktypecountUser,'taskdone'=>$taskdoneUser,  'taskHourSum'=>$hoursumUser];
        //, 'taskPriceSum'=>$pricesumUser, 'taskUncommentSum'=>$uncommentUser, 'taskGoodSum'=>$goodUser, 'taskBadSum'=>$badUser

        $taskReport['table'] = $this->toTable($this->tasksByTypesUser);
        return $taskReport;
    }


    public function tasksByTypes($tasktyleList,$from,$to){
        $this->tasksByTypes = \DB::select("SELECT name as tasktype,count(CASE taskstatus_id WHEN 5 THEN 5 END) AS taskdone, count(name) as tasktypecount, sum(hours) as hours, sum(price) as price FROM (select a.id,a.tasktype_id,a.taskstatus_id,b.name,a.hours,a.price,a.end_at from tasks a,tasktypes b where a.tasktype_id=b.id and a.deleted_at is null) a where tasktype_id in (".implode(',',array_keys($tasktyleList)).") and a.end_at>=:from and a.end_at<=:to GROUP BY tasktype_id order by hours DESC",['from'=>$from,'to'=>$to]);
//        $this->tasksByTypes = \DB::select("SELECT name as tasktype,count(CASE taskstatus_id WHEN 5 THEN 5 END) AS taskdone, count(name) as tasktypecount, sum(hours) as hoursum, sum(price) as price, sum(uncomm) as uncomment,sum(good) as good, sum(bad) as bad FROM (select a.id,a.tasktype_id,a.taskstatus_id,b.name,a.hours,a.price,a.end_at from tasks a,tasktypes b where a.tasktype_id=b.id and a.deleted_at is null) a,(select task_id,count(case grade when 0 then 0 end )  as uncomm,count(case grade when 1 then 1 end )  as good,count(case grade when 2 then 2 end )  as bad from taskgroups GROUP BY task_id) b where a.id=b.task_id and tasktype_id in (".implode(',',array_keys($tasktyleList)).") and a.end_at>=:from and a.end_at<=:to GROUP BY tasktype_id",['from'=>$from,'to'=>$to]);
        $taskTypes=[];
        $tasktypecount=[];
        $taskdone=[];
        $hoursum=[];
//        $pricesum=[];
//        $uncomment=[];
//        $good=[];
//        $bad=[];
        foreach($this->tasksByTypes as $tasktypec){
            $taskTypes[] = $tasktypec->tasktype;
            $tasktypecount[] = $tasktypec->tasktypecount-$tasktypec->taskdone;
            $taskdone[] = $tasktypec->taskdone;
            $hoursum[] = $tasktypec->hours;
//            $pricesum[] = $tasktypec->price;
//            $uncomment[] = $tasktypec->uncomment;
//            $good[] = $tasktypec->good;
//            $bad[] = $tasktypec->bad;
        }
        $taskReport = ['taskTypes'=>$taskTypes, 'taskCount'=>$tasktypecount, 'taskdone'=>$taskdone, 'taskHourSum'=>$hoursum];
        //, 'taskPriceSum'=>$pricesum, 'taskUncommentSum'=>$uncomment, 'taskGoodSum'=>$good, 'taskBadSum'=>$bad

        $taskSelectStatisticeHtml = '';
        foreach($tasktyleList as $ttId=>$ttName) {
            $tasktypeSelect = \DB::select("SELECT id,frontend_label from tasktype_eavs WHERE tasktype_id=$ttId AND frontend_input='select' AND is_report = 1 AND deleted_at is null");
            if ($tasktypeSelect){
                $taskSelectStatisticeHtml .= '<h4>'.$ttName.trans('view.reportsStatistics').'</h4>';
                foreach($tasktypeSelect as $attr){//concat(tasktype_eav_values.task_value,'共',count(tasktype_eav_values.id),'个') as selectana
                    $taskSelectStatistice = \DB::select("SELECT tasktype_eav_values.task_value as '".$attr->frontend_label."',count(CASE taskstatus_id WHEN 5 THEN 5 END) AS taskdone, count(tasktype_eav_values.id) as tasktypecount, sum(hours) as hours, sum(price) as price FROM tasktype_eav_values INNER JOIN tasks ON tasks.id = tasktype_eav_values.task_id WHERE task_type_eav_id = ".$attr->id." AND tasktype_eav_values.deleted_at is NULL AND end_at >=:from AND end_at <=:to GROUP BY tasktype_eav_values.task_value",['from'=>$from,'to'=>$to]);
//                    foreach($taskSelectStatistice as $taskValue){
//                        $taskSelectStatisticeHtml .= $taskValue->selectana.',';
//                    }
                    $taskSelectStatisticeHtml .= $this->toTable($taskSelectStatistice);
                }
                $taskSelectStatisticeHtml .= '<br>';
            }
        }
        $taskReport['table'] = $this->toTable($this->tasksByTypes).$taskSelectStatisticeHtml;
        return $taskReport;
    }

    public function monthAnalyic($tasktyleList)
    {
        $subSql = "select b.id,b.name,a.id as taskid,a.title,date_format(a.created_at,'%Y.%m') as create_time,date_format(a.end_at,'%Y.%m') as end_time,a.taskstatus_id from tasks a ,tasktypes b where a.tasktype_id=b.id and b.deleted_at is null and a.deleted_at is null and b.id in (".implode(',',array_keys($tasktyleList)).")";

        $sql = "select * from (select concat(name,'-全部') as tasktype_id,".$this->getMonthSql('create_time')." from (".$subSql." ) abc GROUP BY id UNION ALL  select concat(name,'-计划完成') as tasktype_id,".$this->getMonthSql('end_time')." from (".$subSql." ) abc GROUP BY id UNION ALL  select concat(name,'-已完成') as tasktype_id, ".$this->getMonthSql('create_time')." from (".$subSql." and a.taskstatus_id=5  ) abc GROUP BY id ) as qun ORDER BY tasktype_id asc";
//        dd($sql);
        $monthAnalyicData = \DB::select($sql);
//        $taskReport['table'] = $this->toTable($monthAnalyicData);
        return $this->toTable($monthAnalyicData);
    }

    private function getMonthSql($timeAt)
    {
        $sql='';
        for($i=1;$i>-13;$i--) {
            $month = Carbon::now()->addMonthsNoOverflow($i);
            $sql.= " sum(case ".$timeAt." when '".$month->format('Y.m')."' then 1 else 0 end) '".$month->format('y.m')."' ";
            if ($i<>-12) $sql.=', ';
//            var_dump($i.$month.'--'.$sql.'<br><br>');
        }
        return ($sql);
    }


}
