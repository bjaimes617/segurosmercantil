<?php

namespace App\Models\SegurosMercantil;

use Illuminate\Database\Eloquent\Model;
use App\Models\SegurosMercantil\Tipificacion2Model;

class Tipificacion3Model extends Model
{
    protected $table = "gt_tipificacion3";

    protected $primaryKey = "id";

    public $timestamps = true;

    public function relationTipificacion2(){

        return $this->belongsTo(Tipificacion2Model::class, 'gt_tipificacion2_id','id');
    }
}