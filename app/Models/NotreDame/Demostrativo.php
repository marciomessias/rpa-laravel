<?php

namespace App\Models\NotreDame;

use App\Models\TextToArrayHandle;

class Demostrativo extends TextToArrayHandle
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
        'Número da Guia no Prestador',
        'Número da Guia Atribuído pela Operadora',
        'Senha',
        'Nome do Beneficiário',
        'Número da Carteira',
        'Data Inicio do faturamento',
        'Hora Inicio do Faturamento',
        'Data Fim do Faturamento',
        'Código da Glosa da Guia',
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
        'Valor Informado da Guia',
        'Valor Processado da Guia',
        'Valor Liberado da Guia',
        'Valor Glosa da Guia',
        'Valor Informado do Protocolo',
        'Valor Processado do Protocolo',
        'Valor Liberado do Protocolo',
        'Valor Glosa do Protocolo',
        'Valor Informado Geral',
        'Valor Processado Geral',
        'Valor Liberado Geral',
        'Valor Glosa Geral'
    ];

    public function extractInfoFromText()
    {
        $arrayData[] = $this->OperNotreDameFields;

        $pages = explode('DEMONSTRATIVO DE ANÁLISE DE CONTA', $this->getText());

        array_shift($pages);

        $this->setCurrentTextPage($pages[0]);

        $OperNotreDameValues = [
            $this->getIntervalPartFromText('1 - Registro ANS', '3 - Nome da Operadora'),
            $this->getIntervalPartFromText('3 - Nome da Operadora', '4 - CNPJ da Operadora'),
            $this->getIntervalPartFromText('6 - Código na Operadora', 6, 'inverse'),
            $this->getIntervalPartFromText('6 - Código na Operadora', '7 - Nome do Contratado'),
            $this->getIntervalPartFromText('8 - Código CNES', '9 - Número do Lote'),
            $this->getIntervalPartFromText('9 - Número do Lote', '10 - Nº do Protocolo'),
            $this->getIntervalPartFromText('10 - Nº do Protocolo (Processo)', '11- Data do Protocolo'),
            $this->getIntervalPartFromText('11- Data do Protocolo', '12 - Código da Glosa do Protocolo')
        ];

        array_shift($pages);
        array_shift($pages);

        for($n = 0; $n < count($pages); $n++) {

            $this->setCurrentTextPage($pages[2]);

            $values = [
                $this->getIntervalPartFromText('DADOS DA GUIA', '13 - Número da Guia no Prestador'),
                $this->getIntervalPartFromText('13 - Número da Guia no Prestador', '14 - Número da Guia Atribuido pela Operador'),
                $this->getIntervalPartFromText('14 - Número da Guia Atribuido pela Operadora', '15 - Senha'),
                $this->getIntervalPartFromText('15 - Senha', '16 - Nome do Beneficiário'),
                $this->getIntervalPartFromText('16 - Nome do Beneficiário', '17 - Número da Carteira'),
                $this->getIntervalPartFromText('17 - Número da Carteira', '18 - Data Início do Faturamento'),
                $this->getIntervalPartFromText('20 - Data Fim do Faturamento', '19 - Hora Início do Faturamento'),
                $this->getIntervalPartFromText('18 - Data Início do Faturamento', '20 - Data Fim do Faturamento'),

                #valores em tabelas
                'Código da Glosa do Protocolo',
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

                'Valor Informado da Guia',
                'Valor Processado da Guia',
                'Valor Liberado da Guia',
                'Valor Glosa da Guia',
                'Valor Informado do Protocolo',
                'Valor Processado do Protocolo',
                'Valor Liberado do Protocolo',
                'Valor Glosa do Protocolo',
                'Valor Informado Geral',
                'Valor Processado Geral',
                'Valor Liberado Geral',
                'Valor Glosa Geral'
            ];

            $arrayData[] = array_merge($OperNotreDameValues, $values);

            $this->setArrayData($arrayData);
        }
    }
}
