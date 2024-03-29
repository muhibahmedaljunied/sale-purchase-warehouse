<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ExtraSanction extends Model
{
    protected $fillable = ['staff_id','extra_type_id','start_time','end_time'];


    public function scopeWhereExtraSanction($query, $value)

    {
        return $query->where([
            'extra_type_id' => $value['extra'],
            'iteration' => $value['iteration'],
            'part_id' => $value['extra_part'], 
            'sanction_discount_id' => $value['discount_type'],
        ]);

                                                        
                                                            
    }


    // public function extra()
    // {
    //     return $this->hasMany(Extra::class);
    // }

    public function extra_detail()
    {
        return $this->hasMany(ExtraDetail::class);
    }



    public function staff_sanction()
    {
        return $this->morphMany(StaffSanction::class, 'sanctionable');
    }
  

}
