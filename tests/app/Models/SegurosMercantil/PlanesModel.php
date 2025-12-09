<?php

namespace App\Models\SegurosMercantil;

use Illuminate\Database\Eloquent\Model;

class PlanesModel extends Model
{
      protected $table = 'gt_planes';
      
      public function RelationSumasSeguradas(){              
        return $this->belongsTo(SumaAseguradaModel::class,'id','gt_planes_id');          
      }
      
      public function RelationGestionados(){              
        return $this->hasmany(ProcesadosModel::class,'plan_id','id');          
      }
}
