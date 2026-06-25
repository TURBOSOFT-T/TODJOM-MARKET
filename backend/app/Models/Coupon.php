<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable=['code','type','value','status', 'user_id'];

    public static function findByCode($code){
        return self::where('code',$code)->first();
    }
   /*  public function discount($total){
        if($this->type=="fixed"){
            return $this->value;
        }
        elseif($this->type=="percent"){
            return ($this->value /100)*$total;
        }
        else{
            return 0;
        }
    }
 */
    public function users()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

  /*   public function isValid()
    {
        return $this->expires_at === null || $this->expires_at->isFuture();
    } */
}
