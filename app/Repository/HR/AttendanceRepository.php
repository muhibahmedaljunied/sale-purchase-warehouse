<?php

namespace App\Repository\HR;

use App\Models\Advance;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\HRRepositoryInterface;

use DB;

class AttendanceRepository implements DetailRepositoryInterface
{

    public function init_details(...$list_data)
    {



        $data = $list_data['data'];
        $id = $list_data['id'];
        $value = $list_data['value'];

   

   

        $Details = new AttendanceDetail();
        $Details->attendance_id = $id;
        $Details->period_id = $data['period'];
        // $Details->attendance_status = $data['attendance_status'][$value];

        if ($data['attendance_in_out'] == 1) {
            $Details->check_in = $data['time_in'][$value];
        } else {
            $Details->check_out = $data['time_out'][$value];
            
            $Details->duration = $data['duration'][$value];
            $Details->delay = $data['delay'][$value];
            $Details->leave = $data['leave'][$value];
            $Details->extra = $data['extra'][$value];
        }



        $Details->save();
  
    
    }

    // public function add(...$list_data){

    //     $request = $list_data['request'];
    //     $value = $list_data['value'];

    //     $attendance = new Attendance();
    //     $attendance->staff_id =  $request['staff'][$value];
    //     $attendance->attendance_date = $request['attendance_date'][$value];
    //     $attendance->attendance_status = $request['attendance_status'][$value];
    //     $attendance->save();
    // }
}