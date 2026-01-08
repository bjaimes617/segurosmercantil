<?php

namespace App\Models\SegurosMercantil;

use Illuminate\Database\Eloquent\Model;

class ClientesModel extends Model
{
    protected $table = 'gt_clientes';
    
    public function RelationGestionados(){
        return $this->hasMany(ProcesadosModel::class,'clientes_id','id');
    }
    
    public function RelationUsuario(){
        return $this->belongsTo(\App\Models\User::class,'user_id','id');
    }
         
     public function RelationLotes(){
        return $this->belongsTo(LotesModel::class,'lote_id','id');
    }
    
     public function RelationEstatus() {
        return $this->belongsTo(EstatusModel::class,'estatus_id','id');
    }
    
     public function RelationEstado(){
        return $this->belongsTo(EstadosModel::class,'cd_estado_hab','id');
    }
}
