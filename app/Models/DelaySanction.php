<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DelaySanction extends Model
{
    // protected $fillable = ['staff_id','delay_type_id','date'];


    public function scopeWhereDelaySanction($query, $value)

    {


        return $query->where([
            'delay_type_id' => $value['delay'],
            'part_id' => $value['delay_part'],
            'iteration' => $value['iteration'],
            'sanction_discount_id' => $value['discount_type'],
            'discount' => $value['discount']
        ]);
    }

    public function absence_sanction()
    {
        return $this->belongsToMany(AbsenceSanction::class);
    }

    public function attendance()
    {
        return $this->belongsToMany(Attendance::class);
    }

    public function staff_sanction()
    {
        return $this->morphMany(StaffSanction::class, 'sanctionable');
    }

}
