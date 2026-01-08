<?php

namespace App\Models\SegurosMercantil;

use Illuminate\Database\Eloquent\Model;
use App\Models\SegurosMercantil\Tipificacion3Model;

class ProcesadosModel extends Model
{
    protected $table = 'gt_procesados';
    
    public function RelationVicidial() {
        return $this->hasone(VicidialRecordsModel::class,'gt_procesados_id','id');
    }
    
    public function RelationCliente() {
        return $this->belongsTo(ClientesModel::class,'clientes_id','id');
    }
    
    public function RelationTipiifcacion1() {
        return $this->belongsTo(Tipificacion1Model::class,'gt_tipificacion1_id','id');
    
    }
    
    public function RelationTipiifcacion2() {
        return $this->belongsTo(Tipificacion2Model::class,'gt_tipificacion2_id','id');
    }

    public function RelationTipificacion3() {
        return $this->belongsTo(Tipificacion3Model::class,'gt_tipificacion3_id','id');
    }
    
    public function RelationEstatus() {
        return $this->belongsTo(EstatusModel::class,'estatus_id','id');
    }
    
}
