<?php

namespace App\Models\Read;

use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use Smalot\PdfParser\Config;

class PdfFile
{
    private $pdfTotext;

    private $fields = [];

    private $values = [];

    public function getFields()
    {
        return $this->fields;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function setPdfToText()
    {
        $this->pdfTotext = (new Parser())->parseFile(Storage::path('public/Leitura PDF.pdf'))->getText();
    }

    private function getValueFromIntervalString($start, $end, $direction = false)
    {
        $strlenStart = strlen($start);
        $strposStart = strpos($this->pdfTotext, $start);

        if (is_numeric($end)) {            
            if ($direction == 'inverse') {
                $substrStart = trim(substr($this->pdfTotext, $strposStart - $end));
                $substrString = trim(substr($substrStart, 0, $end));
            } else {
                $substrStart = trim(substr($this->pdfTotext, $strposStart + $strlenStart, 100));
                $substrString = trim(substr($substrStart, 0, $end));
            }
        } else {
            $substrStart = trim(substr($this->pdfTotext, $strposStart + $strlenStart));
            $strposEnd = strpos($substrStart, $end);
            $substrString = trim(substr($substrStart, 0, $strposEnd));
        }

        return $substrString;
    }

    public function buildFieldsAndValues()
    {
        $this->fields[] = 'Registro ANS';
        $this->values[] = $this->getValueFromIntervalString('1 - Registro ANS', '3 - Nome da Operadora');

        $this->fields[] = 'Nome da Operadora';
        $this->values[] = $this->getValueFromIntervalString('3 - Nome da Operadora', '4 - CNPJ da Operadora');

        $this->fields[] = 'Código na Operadora';
        $this->values[] = $this->getValueFromIntervalString('6 - Código na Operadora', 6, 'inverse');

        $this->fields[] = 'Nome do Contratado';
        $this->values[] = $this->getValueFromIntervalString('6 - Código na Operadora', '7 - Nome do Contratado');

        $this->fields[] = 'Número do Lote';
        $this->values[] = $this->getValueFromIntervalString('8 - Código CNES', '9 - Número do Lote');

        $this->fields[] = 'Número do Protocolo';
        $this->values[] = $this->getValueFromIntervalString('9 - Número do Lote', '10 - Nº do Protocolo');

        $this->fields[] = 'Data do Protocolo';
        $this->values[] = $this->getValueFromIntervalString('10 - Nº do Protocolo (Processo)', '11- Data do Protocolo');

        $this->fields[] = 'Código da Glosa do Protocolo';
        $this->values[] = $this->getValueFromIntervalString('11- Data do Protocolo', '12 - Código da Glosa do Protocolo');

        // 'Número da Guia no Prestador',
        // 'Número da Guia Atribuído pela Operadora',
        // 'Senha',
        // 'Nome do Beneficiário',
        // 'Número da Carteira',
        // 'Data Inicio do faturamento',
        // 'Hora Inicio do Faturamento',
        // 'Data Fim do Faturamento',
        // 'Código da Glosa da Guia',
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
        // 'Valor Informado da Guia',
        // 'Valor Processado da Guia',
        // 'Valor Liberado da Guia',
        // 'Valor Glosa da Guia',
        // 'Valor Informado do Protocolo',
        // 'Valor Processado do Protocolo',
        // 'Valor Liberado do Protocolo',
        // 'Valor Glosa do Protocolo',
        // 'Valor Informado Geral',
        // 'Valor Processado Geral',
        // 'Valor Liberado Geral',
        // 'Valor Glosa Geral'

    }
}
