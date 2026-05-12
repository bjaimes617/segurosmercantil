<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\SegurosMercantil\EstadosModel;
use App\Models\SegurosMercantil\BancosModel;

class DataClientesProcess implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithChunkReading, WithCustomCsvSettings
{
    /**
     * @return \Illuminate\Support\Collection  
     */

    private $data;
    private $estados;
    private $bancos;

    public function __construct($data)
    {
        $this->data = $data;
        $this->estados = EstadosModel::pluck('estado', 'id')->toArray();
        $this->bancos = BancosModel::where('active', 1)->pluck('banco', 'codigo')->toArray();
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'utf_8',
            'delimiter' => ';',
            "Content-type" => "text/csv; charset=utf_8",
            'use_bom' => true,
        ];
    }

    public function startRow(): int
    {
        return 2;
    }

    public function collection()
    {
        $this->data->each(function ($data) {
            $this->map($data);
        });
        return $this->data;
    }

    public function headings(): array
    {
        $columns = [
            'N_CEDULA',
            'RFM',
            'ESTADO',
            'BANCO',
        ];
        return $columns;
    }

    public function prepareRows($data): array
    {
        return array_map(function ($change) {

            $change->estado = $change->cd_estado_hab !== null && isset($this->estados[$change->cd_estado_hab])
                ? $this->estados[$change->cd_estado_hab]
                : null;

            $cod = substr($change->num_cuenta_asociar_inst_bancario_sinencriptar, 0, 4);

            $change->banco = $cod !== null && isset($this->bancos[$cod])
                ? $this->bancos[$cod]
                : null;

            return $change;
        }, $data);
    }

    public function map($data): array
    {
        $columns = [
            'N_CEDULA'  => $data->n_cedula,
            'RFM'       => $data->rfm,
            'ESTADO'    => $data->estado,
            'BANCO'     => $data->banco
        ];
        return $columns;
    }
}
