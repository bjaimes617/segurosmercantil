<?php

namespace App\Models\SegurosMercantil;

use Illuminate\Database\Eloquent\Model;

class Tipificacion1Model extends Model
{
    protected $table = 'gt_tipificacion1';
    
    public function RelationTipificacion2(){
        return $this->hasMany(Tipificacion2Model::class,'gt_tipificacion1_id','id');
    }
}
