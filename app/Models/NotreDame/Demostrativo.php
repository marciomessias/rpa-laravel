<?php

namespace App\Models\NotreDame;

use App\Models\StringHandle;

class Demostrativo extends StringHandle
{
    private $OperNotreDameFields = [
        'Registro ANS',
        'Nome da Operadora',
        'Código na Operadora',
        'Nome do Contratado',
        'Número do Lote',
        'Número do Protocolo',
        'Data do Protocolo',
        'Código da Glosa do Protocolo',

        'Valor Informado do Protocolo',
        'Valor Processado do Protocolo',
        'Valor Liberado do Protocolo',
        'Valor Glosa do Protocolo',
        'Valor Informado Geral',
        'Valor Processado Geral',
        'Valor Liberado Geral',
        'Valor Glosa Geral',

        'Número da Guia no Prestador',
        'Número da Guia Atribuído pela Operadora',
        'Senha',
        'Nome do Beneficiário',
        'Número da Carteira',
        'Data Inicio do faturamento',
        'Hora Inicio do Faturamento',
        'Data Fim do Faturamento',
        'Código da Glosa da Guia',

        'Valor Informado da Guia',
        'Valor Processado da Guia',
        'Valor Liberado da Guia',
        'Valor Glosa da Guia',

        'Data de realização',
        'Tabela',
        'Código do Procedimento',
        'Descrição',
        'Grau Participação',
        'Valor Informado',
        'Quanti. Executada',
        'Valor Processado',
        'Valor Liberado',
        'Valor Glosa',
        'Código da Glosa',
    ];

    public function extractInfoFromText()
    {
        $arrayData[] = $this->OperNotreDameFields;

        $pages = explode('240.64 -0.72 TD', $this->getString());

        $this->setCurrentStringPage($pages[1]);

        $OperNotreDameValues = [
            $this->getFilteredStringByCoordinates('0.76 -12.92 TD', '105.76 492.00 372.00 26.24 re S'),
            $this->getFilteredStringByCoordinates('0.76 -12.80 TD', '480.88 492.00 146.88 26.24 re S'),
            $this->getFilteredStringByCoordinates('/F2 8.00 Tf', '-0.76 12.04 TD'),
            $this->getFilteredStringByCoordinates('166.56 450.52 TD', '-0.76 11.92 TD'),
            $this->getFilteredStringByCoordinates('3.76 403.48 TD', '-0.76 12.72 TD'),
            $this->getFilteredStringByCoordinates('130.04 404.20 TD', '-0.76 11.56 TD'),
            $this->getFilteredStringByCoordinates('255.56 404.20 TD', '-0.76 11.52 TD'),
            $this->getFilteredStringByCoordinates('-285.16 -45.04 TD', '1.52 492.00 100.52 26.24 re S'),

            $this->getFilteredStringByCoordinates(false, '-106.08 12.04 TD'),
            $this->getFilteredStringByCoordinates('263.36 328.56 TD', '154.68 0.00 TD'),
            $this->getFilteredStringByCoordinates(false, '-419.92 12.04 TD', 1),
            $this->getFilteredStringByCoordinates('159.12 0.00 TD', '-419.92 12.04 TD'),
            $this->getFilteredStringByCoordinates(false, '-106.08 12.80 TD'),
            $this->getFilteredStringByCoordinates('263.36 281.64 TD'),
            $this->getFilteredStringByCoordinates(false, '159.12 0.00 TD'),
            $this->getFilteredStringByCoordinates(false, '-419.88 12.80 TD'),
        ];

        for($n = 3; $n < count($pages); $n++) {

            $this->setCurrentStringPage($pages[$n]);

            $medicalGuideValues = [
                $this->getFilteredStringByCoordinates('/F2 8.00 Tf', '-0.76 11.52 TD'),
                $this->getFilteredStringByCoordinates('279.48 497.32 TD', '-0.76 11.52 TD'),
                $this->getFilteredStringByCoordinates('527.04 499.56 TD', '-0.64 11.48 TD'),
                $this->getFilteredStringByCoordinates('3.76 471.20 TD', '-0.76 11.88 TD'),
                $this->getFilteredStringByCoordinates('527.16 471.12 TD', '-0.64 11.52 TD'),
                $this->getFilteredStringByCoordinates('3.64 442.08 TD', '-0.88 12.64 TD'),
                $this->getFilteredStringByCoordinates('134.56 442.04 TD', '-0.68 12.68 TD'),
                $this->getFilteredStringByCoordinates('265.36 442.04 TD', '-0.76 12.68 TD'),
                $this->getFilteredStringByCoordinates(false, '108.20 -39.64 TD'),

            ];

            // 'Valor Informado da Guia',
            // 'Valor Processado da Guia',
            // 'Valor Liberado da Guia',
            // 'Valor Glosa da Guia'

            // $table = $this->getStringByCoordinates('3.12 402.40 TD', 'endstream');

            // #TableMedicalGuide
            // 'Data de realização',
            // 'Tabela',
            // 'Código do Procedimento',
            // 'Descrição',
            // 'Grau Participação',
            // 'Valor Informado',
            // 'Quanti. Executada',
            // 'Valor Processado',
            // 'Valor Liberado',
            // 'Valor Glosa',
            // 'Código da Glosa',

            // preg_match_all('/\(.*\) Tj/', $table, $extractData);
            // $data = $extractData[0][0];
            // $data = trim(preg_replace('/\(|\) Tj/', '', $data));
            // dd($data);

            // $arraySize = array_search('(23 - Data de ) Tj', $extractData[0]);
            // $qtdRow = $arraySize/10;

            $arrayData[] = array_merge($OperNotreDameValues, $values);

            $this->setArrayData($arrayData);
        }
    }
}
