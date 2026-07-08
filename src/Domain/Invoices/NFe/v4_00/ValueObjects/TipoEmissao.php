<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        26
 * ID       B2
 * Campo    tpEmis
 * Desc     Tipo de Emissão da NF-e
 * Tam      1
 * OBS:
 * 1=Emissão normal (não em contingência);
 * 2=Contingência FS-IA, com impressão do DANFE em Formulário de
 * Segurança - Impressor Autônomo;
 * 3=Contingência SCAN (Sistema de Contingência do Ambiente Nacional); *Desativado * NT 2015/002
 * 4=Contingência EPEC (Evento Prévio da Emissão em Contingência);
 * 5=Contingência FS-DA, com impressão do DANFE em Formulário de
 * Segurança - Documento Auxiliar;
 * 6=Contingência SVC-AN (SEFAZ Virtual de Contingência do AN);
 * 7=Contingência SVC-RS (SEFAZ Virtual de Contingência do RS);
 * 9=Contingência off-line da NFC-e;
 * Observação: Para a NFC-e somente é válida a opção de
 * contingência: 9-Contingência Off-Line e, a critério da
 * UF, opção 4-Contingência EPEC. (NT 2015/002)
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Invoices\NFe\Validators\IsTipoEmissaoValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class TipoEmissao extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'tpEmis';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator,
            new StringLengthValidator(1),
            new IsTipoEmissaoValidator,
        ];
    }
}
