<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
   /**
    * Fields that can be mass assigned.
    *
    * @var array
    */
   protected $fillable = ['image_name','image_url'];
}
