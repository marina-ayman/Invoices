<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\section;
class products extends Model
{
    use HasFactory;

    // protected $fillable=[
    //     'Product_name',
    //     'description',
    //     'section_id'
    // ];

    protected $guarded=[];

    public function section(){
      return  $this->belongsTo(section::class);
    }
}
