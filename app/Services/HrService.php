<?php

namespace App\Services;
use App\Models\StoreProduct;
use App\Models\Stock;
use Illuminate\Http\Request;
use DB;

class HrService
{

    function add(...$list_data)
    {
        $attendance_id  = 0 ;
        $request = $list_data['request'];
        $value = $list_data['value'];
        $type = $list_data['type'];
        
        switch ($type) {

     
            case 'extra':

                $temporale = new Extra();
                $temporale->staff_id = $request['staff'][$value];
                $temporale->extra_type_id = $request['extra_type'][$value];
                $temporale->date = $request['date'][$value];
                $temporale->start_time = $request['start_time'][$value];
                $temporale->end_time = $request['end_time'][$value];
                $temporale->number_hours = $request['duration'][$value][0];
                break;

            case 'attendance':
                $attendance = new Attendance();
                $attendance->staff_id =  $request['staff'][$value];
                $attendance->attendance_date = $request['attendance_date'][$value];
                $attendance->attendance_status = $request['attendance_status'][$value];
                break;
            case 'discount':
                $temporale = new Discount();
                $temporale->staff_id = $request['staff'][$value];
                $temporale->discount_type_id = $request['discount_type'][$value];
                $temporale->quantity = $request['qty'][$value];
                $temporale->date = $request['date'][$value];
                break;

            case 'allowance':
                $temporale = new Allowance();
                $temporale->staff_id = $request['staff'][$value];
                $temporale->status = $request['allowance_status'][$value];
                $temporale->allowance_type_id = $request['allowance_type'][$value];
                $temporale->qty = $request['qty'][$value];
                // $temporale->date = $request['date'][$value];
                break;
            case 'advance':
                $temporale = new Advance();
                $temporale->staff_id = $request['staff'][$value];
                // $temporale->extra_type_id = $request->post('extra_type')[$value];
                $temporale->date = $request['date'][$value];
                $temporale->quantity = $request['qty'][$value];
                break;
            case 'leave':
                $temporale = new Vacation();
                $temporale->staff_id = $request['staff'][$value];
                $temporale->vacation_type_id = $request['leave_type'][$value];
                $temporale->start_date = $request['start_date'][$value];
                $temporale->end_date = $request['end_date'][$value];
                $temporale->total_days = $request['days'][$value];
                // $temporale->total_days = $request->post('days')[$value];
                // return $request['days'][$value];
                break;
            case 'absence_sanction':
                $temporale = new AbsenceSanction();
                $temporale->staff_id = $request['staff'][$value];
                $temporale->absence_type_id = $request['absence'][$value];
                $temporale->iteration = $request['iteration'][$value];
                $temporale->sanction_discount_id = $request['discount_type'][$value];
                $temporale->discount = $request['discount'][$value];
                $temporale->sanctions = $request['sanction'][$value];
                // $temporale->total_days = $request->post('days')[$value];
                break; 
            case 'delay_sanction':
                $temporale = new DelaySanction();
                $temporale->staff_id = $request['staff'][$value];
                $temporale->delay_type_id = $request['delay'][$value];
                $temporale->delay_part_id = $request['delay_part'][$value];
                $temporale->iteration = $request['iteration'][$value];
                $temporale->sanction_discount_id = $request['discount_type'][$value];
                $temporale->discount = $request['discount'][$value];
                $temporale->sanctions = $request['sanction'][$value];
                break;    
            case 'extra_sanction':
                $temporale = new ExtraSanction();
                $temporale->staff_id = $request['staff'][$value];
                $temporale->extra_type_id = $request['extra'][$value];
                $temporale->extra_part_id = $request['extra_part'][$value];

                $temporale->iteration = $request['iteration'][$value];
                $temporale->sanction_discount_id = $request['discount_type'][$value];
                $temporale->sanctions = $request['sanction'][$value];
                // $temporale->total_days = $request->post('days')[$value];
                break;  
            case 'leave_sanction':
                $temporale = new LeaveSanction();
                $temporale->staff_id = $request['staff'][$value];
                $temporale->leave_type_id = $request['leave'][$value];
                $temporale->leave_part_id = $request['leave_part'][$value];
                $temporale->iteration = $request['iteration'][$value];
                $temporale->sanction_discount_id = $request['discount_type'][$value];
                $temporale->discount = $request['discount'][$value];
                $temporale->sanctions = $request['sanction'][$value];
                // $temporale->total_days = $request->post('days')[$value];
                break;              
        }


        $temporale->save();
        return $temporale->id;
    }
   

}