<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;



class Graph
{
    public function getServerOsJson(){
        $host="";
        $number="";
        $sourceData = DB::table('s_server_info')->select(
            [
                DB::raw('host_os'),
                DB::raw('count(*) as `number`'),
            ]
        )
            ->groupBy('host_os')
            ->orderBy('number','desc')
            ->get();
        foreach($sourceData as $list)
        {
            $host[] = $list->host_os;
            $number[] = intval($list->number);
        }
        $host = json_encode($host);
        $data = array(array("name"=>"服务器操作系统统计图","data"=>$number));
        $data = json_encode($data);
        $serverJson = ['ServerHost'=>$host,'ServerHostData'=>$data];
        return $serverJson;
    }

    public function getServerTypeJson(){
        $sourceData = DB::table('s_server_info')->select(
            [
                DB::raw('host_type as name'),
                DB::raw('count(*) as `y`'),
            ]
        )
            ->groupBy('name')
            ->orderBy('y','desc')
            ->get()->toJson();
       return $sourceData;
    }

    public function getServerAreaJson(){
        $sourceData = DB::table('s_server_info')->select(
            [
                DB::raw('host_address as name'),
                DB::raw('count(*) as `y`'),
            ]
        )
            ->groupBy('name')
            ->orderBy('y','desc')
            ->get()->toJson();
        return $sourceData;
    }

    public function getServerDeptJson(){
        $dept_name="";
        $number="";
        $sourceData = DB::table('s_server_info')->select(
            [
                DB::raw('dept_name'),
                DB::raw('count(*) as `number`'),
            ]
        )
            ->groupBy('dept_name')
            ->orderBy('number','desc')
            ->get();
        foreach($sourceData as $list)
        {
            $dept_name[] = $list->dept_name;
            $number[] = intval($list->number);
        }
        $dept_name = json_encode($dept_name);
        $data = array(array("name"=>"服务器操作系统统计图","data"=>$number));
        $data = json_encode($data);
        $serverJson = ['ServerDept'=>$dept_name,'ServerDeptData'=>$data];
        return $serverJson;
    }



    public function getProductByDeptJson(){
        $department = "";
        $number = "";
        $sourceData = DB::table('v_product_list')->select(
            [
                DB::raw("IFNULL(department,'其他') as `department`"),
                DB::raw("count(*) as `number`")
            ]
        )
            ->groupBy('department')
            ->orderBy('number','desc')
            ->limit(10)
            ->get();
        foreach($sourceData as $list)
        {
            $department[] = $list->department;
            $number[] = intval($list->number);
        }
        $department = json_encode($department);
        $data = array(array("name"=>"事业部运维分类统计图","data"=>$number));
        $data = json_encode($data);
        $ProductDeptJson = ['ProductDept'=>$department,'ProductDeptData'=>$data];
        return $ProductDeptJson;
    }

    //每周端口可用率
    public function getPortUseEnable(){
        // $sql="select name,enable as ratio from z_product_port where YEARWEEK(date_format(createtime,'%Y-%m-%d')) = YEARWEEK(now())-1 ORDER BY enable DESC";
        $sql="select name,enable as ratio from z_product_port where createtime in (SELECT max(createtime) from z_product_port) ORDER BY enable DESC limit 0,10";
        $data = DB::select($sql);
        $name = '';
        $ratio = '';
        foreach ($data  as $list) {
            $name[] = $list->name;
            $ratio[] = floatval($list->ratio);
        }
        $name = json_encode($name); json_encode($ratio);

        $ratio = array(array("name"=>"","data"=>$ratio));
        $ratio = json_encode($ratio);
        return ['PortName'=>$name,'PortData'=>$ratio];
    }

    // 每周磁盘使用率
    public function getDiskEnable(){
        $sql="select host,ratio  from 
                (select hostid,host,round(disk_used/disk_total*100,2) as ratio from 
                z_product_server_value
                where clock='2017-01-02 07:00:00' ) a 
                ORDER BY ratio desc
                limit 0,10";
        $data = DB::select($sql);
        $name = '';
        $ratio = '';
        foreach ($data  as $list) {
            $name[] = $list->host;
            $ratio[] = floatval($list->ratio);
        }
        $name = json_encode($name); json_encode($ratio);

        $ratio = array(array("name"=>"","data"=>$ratio));
        $ratio = json_encode($ratio);
        return ['DiskName'=>$name,'DiskData'=>$ratio];
    }

    // 每周CPU使用率
    public function getCpuEnable(){
        // $sql="select host,cpu_ratio from 
        //         (select hostid,host,cpu_avgvalue as cpu_ratio from z_product_server_value
        //         where clock='2017-01-02 07:00:00'  limit 0,10) a 
        //         ORDER BY cpu_ratio desc";
        $sql="select host,cpu_ratio  from 
            (select hostid,host,cpu_avgvalue as cpu_ratio from z_product_server_value
            where clock='2017-01-02 07:00:00' ORDER BY  cpu_ratio desc limit 0,10) a";
        $data = DB::select($sql);
        $name = '';
        $ratio = '';
        foreach ($data  as $list) {
            $name[] = $list->host;
            $ratio[] = floatval($list->cpu_ratio);
        }
        $name = json_encode($name); json_encode($ratio);

        $ratio = array(array("name"=>"","data"=>$ratio));
        $ratio = json_encode($ratio);
        return ['CpuName'=>$name,'CpuData'=>$ratio];
    }

        // 每周内存使用率
    public function getMemEnable(){
        $sql="select host,memory_ratio from 
            (select hostid,host,memory_avgvalue as memory_ratio from z_product_server_value
            where clock='2017-01-02 07:00:00' ORDER BY  memory_ratio desc limit 0,10) a";
        $data = DB::select($sql);
        $name = '';
        $ratio = '';
        foreach ($data  as $list) {
            $name[] = $list->host;
            $ratio[] = floatval($list->memory_ratio);
        }
        $name = json_encode($name); json_encode($ratio);

        $ratio = array(array("name"=>"","data"=>$ratio));
        $ratio = json_encode($ratio);
        return ['MemName'=>$name,'MemData'=>$ratio];
    }



}
