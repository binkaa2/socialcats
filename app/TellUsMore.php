<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TellUsMore extends Model
{
    /**
     * name of table
     * 
     * @var String
     */
    protected $table = 'tell_us_more';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'tum_code','tum_name','user_id'
    ];

    /**
     * @return array
     */

    protected $casts = [
    ];

    /**
     * 
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

}
