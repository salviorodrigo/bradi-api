<?php

declare(strict_types=1);

namespace BradiNfeApi\Tests\Datasets;

use BradiNfeApi\Tests\Datasets\Protocols\Dataset;

class DFes extends Dataset
{
    public array $dataset = [
        'dfes' => [
            'nfe' => [
                'element_tags' => [
                    'dest' => [
                        'valid' => [
                            'empty' => '',
                            'only_required' => [
                                'CNPJ' => '<dest><CNPJ>04840356000194</CNPJ><indIEDest>1</indIEDest></dest>',

                                'CPF' => '<dest><CPF>67422533048</CPF><indIEDest>1</indIEDest></dest>',
                            ],
                        ],

                        'invalid' => [
                            'missing_required' => [
                                'CNPJ_and_CPF' => '<dest><indIEDest>1</indIEDest></dest>',

                                'indIEDest' => '<dest><CNPJ>04840356000194</CNPJ></dest>',
                            ],
                        ],
                    ],
                    'emit' => [
                        'valid' => [
                            'only_required' => [
                                'CNPJ' => '<emit><CNPJ>04840356000194</CNPJ><xNome>DIAS e DIAS TENTANDO S/A</xNome><enderEmit><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><xBairro>CENTRO</xBairro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><UF>SP</UF><CEP>05653070</CEP></enderEmit><IE>123456789011</IE><CRT>1</CRT></emit>',

                                'CPF' => '<emit><CPF>67422533048</CPF><xNome>DIAS e DIAS TENTANDO S/A</xNome><enderEmit><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><xBairro>CENTRO</xBairro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><UF>SP</UF><CEP>05653070</CEP></enderEmit><IE>123456789011</IE><CRT>1</CRT></emit>',
                            ],
                        ],
                        'invalid' => [
                            'empty' => '',
                            'missing_required' => [
                                'CNPJ_and_CPF' => '<emit><xNome>DIAS e DIAS TENTANDO S/A</xNome><enderEmit><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><xBairro>CENTRO</xBairro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><UF>SP</UF><CEP>01300000</CEP></enderEmit><IE>123456789011</IE><CRT>1</CRT></emit>',

                                'xNome' => '<emit><CNPJ>04840356000194</CNPJ><enderEmit><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><xBairro>CENTRO</xBairro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><UF>SP</UF><CEP>01300000</CEP></enderEmit><IE>123456789011</IE><CRT>1</CRT></emit>',

                                'enderEmit' => '<emit><CNPJ>04840356000194</CNPJ><xNome>DIAS e DIAS TENTANDO S/A</xNome><IE>123456789011</IE><CRT>1</CRT></emit>',

                                'IE' => '<emit><CNPJ>04840356000194</CNPJ><xNome>DIAS e DIAS TENTANDO S/A</xNome><enderEmit><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><xBairro>CENTRO</xBairro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><UF>SP</UF><CEP>01300000</CEP></enderEmit><CRT>1</CRT></emit>',

                                'CRT' => '<emit><CNPJ>04840356000194</CNPJ><xNome>DIAS e DIAS TENTANDO S/A</xNome><enderEmit><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><xBairro>CENTRO</xBairro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><UF>SP</UF><CEP>01300000</CEP></enderEmit><IE>123456789011</IE></emit>',
                            ],
                        ],
                    ],
                    'enderDest' => [
                        'valid' => [
                            'empty' => '',
                            'only_required' => '<enderDest><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><xBairro>CENTRO</xBairro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><UF>SP</UF><CEP>05653070</CEP></enderDest>',
                        ],
                        'invalid' => [
                            'missing_required' => [
                                'xLgr' => '<enderDest><nro>10</nro><xBairro>CENTRO</xBairro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><UF>SP</UF><CEP>05653070</CEP></enderDest>',

                                'nro' => '<enderDest><xLgr>AV PRINCIPAL</xLgr><xBairro>CENTRO</xBairro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><UF>SP</UF><CEP>05653070</CEP></enderDest>',

                                'xBairro' => '<enderDest><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><UF>SP</UF><CEP>05653070</CEP></enderDest>',

                                'cMun' => '<enderDest><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><xBairro>CENTRO</xBairro><xMun>SAO PAULO</xMun><UF>SP</UF><CEP>05653070</CEP></enderDest>',

                                'xMun' => '<enderDest><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><xBairro>CENTRO</xBairro><cMun>3550308</cMun><UF>SP</UF><CEP>05653070</CEP></enderDest>',

                                'UF' => '<enderDest><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><xBairro>CENTRO</xBairro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><CEP>05653070</CEP></enderDest>',

                                'CEP' => '<enderDest><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><xBairro>CENTRO</xBairro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><UF>SP</UF></enderDest>',
                            ],
                        ],
                    ],
                    'enderEmit' => [
                        'valid' => [
                            'only_required' => '<enderEmit><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><xBairro>CENTRO</xBairro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><UF>SP</UF><CEP>01300000</CEP></enderEmit>',
                        ],

                        'invalid' => [
                            'empty' => '',
                            'missing_required' => [
                                'xLgr' => '<enderEmit><nro>10</nro><xBairro>CENTRO</xBairro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><UF>SP</UF><CEP>01300000</CEP></enderEmit>',

                                'nro' => '<enderEmit><xLgr>AV PRINCIPAL</xLgr><xBairro>CENTRO</xBairro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><UF>SP</UF><CEP>01300000</CEP></enderEmit>',

                                'xBairro' => '<enderEmit><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><UF>SP</UF><CEP>01300000</CEP></enderEmit>',

                                'cMun' => '<enderEmit><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><xBairro>CENTRO</xBairro><xMun>SAO PAULO</xMun><UF>SP</UF><CEP>01300000</CEP></enderEmit>',

                                'xMun' => '<enderEmit><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><xBairro>CENTRO</xBairro><cMun>3550308</cMun><UF>SP</UF><CEP>01300000</CEP></enderEmit>',

                                'UF' => '<enderEmit><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><xBairro>CENTRO</xBairro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><CEP>01300000</CEP></enderEmit>',

                                'CEP' => '<enderEmit><xLgr>AV PRINCIPAL</xLgr><nro>10</nro><xBairro>CENTRO</xBairro><cMun>3550308</cMun><xMun>SAO PAULO</xMun><UF>SP</UF></enderEmit>',
                            ],
                        ],
                    ],
                    'ide' => [
                        'valid' => [
                            'only_required' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',
                        ],

                        'invalid' => [
                            'empty' => '',
                            'missing_required' => [
                                'cUF' => '<ide><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'cNF' => '<ide><cUF>35</cUF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'natOp' => '<ide><cUF>35</cUF><cNF>13256487</cNF><mod>55</mod><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'mod' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'serie' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'nNF' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'dhEmi' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>123456</nNF><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'tpNF' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'idDest' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'cMunFG' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'tpImp' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'tpEmis' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'cDV' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'tpAmb' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'finNFe' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'indFinal' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indPres>1</indPres><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'indPres' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><procEmi>1</procEmi><verProc>1A</verProc></ide>',

                                'procEmi' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><verProc>1A</verProc></ide>',

                                'verProc' => '<ide><cUF>35</cUF><cNF>13256487</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>123456</nNF><dhEmi>2026-03-01T14:30:00-03:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>1</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>1</procEmi></ide>',
                            ],
                        ],
                    ],
                ],
                'value_tags' => [
                    'cEAN' => [
                        'valid' => [
                            'without_gtin' => 'SEM GTIN',
                            'gtin_8' => '12345670',
                            'gtin_12' => '123456789012',
                            'gtin_13' => '1234567890123',
                            'gtin_14' => '12345678901234',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'without_gtin_lowercase' => 'sem gtin',
                            'alphanumeric' => 'ABC123456789',
                            'length_7' => '1234567',
                            'length_9' => '123456789',
                            'length_11' => '12345678901',
                            'length_15' => '123456789012345',
                            'leading_spaces' => ' 1234567890123',
                            'trailing_spaces' => '1234567890123 ',
                            'middle_spaces' => '123 4567890123',
                        ],
                    ],
                    'CEP' => [
                        'valid' => [
                            'standard' => '12345678',
                            'empty' => '',
                        ],
                        'invalid' => [
                            'too_short' => '1234567',
                            'too_long' => '123456789',
                            'masked' => '12.345-678',
                            'leading_space' => ' 12345678',
                            'trailing_space' => '12345678 ',
                            'middle_space' => '123 45678',
                            'alphanumeric' => '12A4567B',
                        ],
                    ],
                    'CEST' => [
                        'valid' => [
                            'standard' => '0100100',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'too_short' => '010010',
                            'too_long' => '01001001',
                            'masked' => '01.001-00',
                            'leading_space' => ' 0100100',
                            'trailing_space' => '0100100 ',
                            'middle_space' => '010 0100',
                            'alphanumeric' => '01A00100',
                        ],
                    ],
                    'CFOP' => [
                        'valid' => [
                            'intrastate' => '5102',
                            'interstate' => '6102',
                            'exterior' => '7102',
                            'purchase' => '1102',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'too_short' => '510',
                            'too_long' => '51021',
                            'masked' => '5.102',
                            'leading_space' => ' 5102',
                            'trailing_space' => '5102 ',
                            'middle_space' => '51 02',
                            'alphanumeric' => '51A0',
                        ],
                    ],
                    'cMun' => [
                        'valid' => [
                            'sao_paulo_city' => '3550308',
                            'alta_floresta_ro' => '1100015',
                            'exterior' => '9999999',
                            'empty' => '',
                        ],
                        'invalid' => [
                            'too_short' => '355030',
                            'too_long' => '35503088',
                            'masked' => '355.030-8',
                            'alphanumeric' => '355A308',
                            'leading_space' => ' 3550308',
                            'trailing_space' => '3550308 ',
                            'middle_space' => '355 308',
                            'invalid_check_digit' => '3304555',
                        ],
                    ],
                    'cMunFG' => [
                        'valid' => [
                            'sao_paulo_city' => '3550308',
                            'alta_floresta_ro' => '1100015',
                            'exterior' => '9999999',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'too_short' => '355030',
                            'too_long' => '35503088',
                            'masked' => '355.030-8',
                            'alphanumeric' => '355A308',
                            'leading_space' => ' 3550308',
                            'trailing_space' => '3550308 ',
                            'middle_space' => '355 308',
                            'invalid_check_digit' => '3304555',
                        ],
                    ],
                    'cNF' => [
                        'valid' => [
                            'standard' => '40285167',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'too_short' => '4028516',
                            'too_long' => '402851678',
                            'masked' => '40.285.167',
                            'leading_space' => ' 40285167',
                            'trailing_space' => '40285167 ',
                            'middle_space' => '402 85167',
                            'alphanumeric' => '4028516A',
                            'repeated_digits' => [
                                'zeros' => '00000000',
                                'ones' => '11111111',
                                'twos' => '22222222',
                                'threes' => '33333333',
                                'fours' => '44444444',
                                'fives' => '55555555',
                                'sixes' => '66666666',
                                'sevens' => '77777777',
                                'eights' => '88888888',
                                'nines' => '99999999',
                            ],
                            'sequential_digits' => [
                                'starts_zero' => '01234567',
                                'starts_one' => '12345678',
                                'starts_two' => '23456789',
                            ],
                        ],
                    ],
                    'CNPJ' => [
                        'valid' => [
                            'empty' => '',
                            'standard' => '42247198000152',
                        ],
                        'invalid' => [
                            'too_long' => '422471980001521',
                            'too_short' => '4224719800015',
                            'leading_space' => ' 42247198000152',
                            'trailing_space' => '42247198000152 ',
                            'middle_space' => '4224719800 0152',
                            'masked' => '42.247.198/0001-52',
                            'alphanumeric' => '4224719800015A',
                            'repeated_digits' => [
                                'zeros' => '00000000000000',
                                'ones' => '11111111111111',
                                'twos' => '22222222222222',
                                'threes' => '33333333333333',
                                'fours' => '44444444444444',
                                'fives' => '55555555555555',
                                'sixes' => '66666666666666',
                                'sevens' => '77777777777777',
                                'eights' => '88888888888888',
                                'nines' => '99999999999999',
                            ],
                        ],
                    ],
                    'cPais' => [
                        'valid' => [
                            'standard' => '1058',
                            'empty' => '',
                        ],
                        'invalid' => [
                            'too_long' => '10589',
                            'too_short' => '105',
                            'leading_space' => ' 1058',
                            'trailing_space' => '1058 ',
                            'middle_space' => '10 58',
                            'masked' => '1.058',
                            'alphanumeric' => '10A8',
                        ],
                    ],
                    'CPF' => [
                        'valid' => [
                            'empty' => '',
                            'standard' => '01505280001',
                        ],
                        'invalid' => [
                            'too_long' => '015052800012',
                            'too_short' => '0150528000',
                            'leading_space' => ' 01505280001',
                            'trailing_space' => '01505280001 ',
                            'middle_space' => '01505 280001',
                            'masked' => '015.052.800-01',
                            'alphanumeric' => '0150A280001',
                            'repeated_digits' => [
                                'zeros' => '00000000000',
                                'ones' => '11111111111',
                                'twos' => '22222222222',
                                'threes' => '33333333333',
                                'fours' => '44444444444',
                                'fives' => '55555555555',
                                'sixes' => '66666666666',
                                'sevens' => '77777777777',
                                'eights' => '88888888888',
                                'nines' => '99999999999',
                            ],
                        ],
                    ],
                    'cProd' => [
                        'valid' => [
                            'min_length' => 'A',
                            'max_length' => 'STRING WITH SIXTY CHARACTERS STRING WITH SIXTY CHARACTERS AB',
                            'middle_space' => 'SKU 123',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'too_long' => 'STRING WITH SIXTY ONE CHARACTERS STRING WITH SIXTY ONE ABCDEF',
                            'leading_space' => ' SKU123',
                            'trailing_space' => 'SKU123 ',
                        ],
                    ],
                    'cUF' => [
                        'valid' => [
                            'RO' => '11',
                            'AC' => '12',
                            'AM' => '13',
                            'RR' => '14',
                            'PA' => '15',
                            'AP' => '16',
                            'TO' => '17',
                            'MA' => '21',
                            'PI' => '22',
                            'CE' => '23',
                            'RN' => '24',
                            'PB' => '25',
                            'PE' => '26',
                            'AL' => '27',
                            'SE' => '28',
                            'BA' => '29',
                            'MG' => '31',
                            'ES' => '32',
                            'RJ' => '33',
                            'SP' => '35',
                            'PR' => '41',
                            'SC' => '42',
                            'RS' => '43',
                            'MS' => '50',
                            'MT' => '51',
                            'GO' => '52',
                            'DF' => '53',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'too_long' => '111',
                            'too_short' => '1',
                            'leading_space' => ' 11',
                            'trailing_space' => '11 ',
                            'middle_space' => '1 1',
                            'alphanumeric' => '1A',
                            'non_existent' => [
                                'ten' => '10',
                                'eighteen' => '18',
                                'twenty' => '20',
                                'thirty' => '30',
                                'thirty_six' => '36',
                                'forty' => '40',
                                'forty_four' => '44',
                                'forty_nine' => '49',
                                'fifty_four' => '54',
                            ],
                        ],
                    ],
                    'dhEmi' => [
                        'valid' => [
                            'standard' => '2026-03-01T14:30:00-03:00',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'leading_space' => ' 2026-03-01T14:30:00-03:00',
                            'trailing_space' => '2026-03-01T14:30:00-03:00 ',
                            'missing_time_zone' => '2026-03-01T14:30:00',
                            'missing_seconds' => '2026-03-01T14:30-03:00',
                            'missing_time' => '2026-03-01',
                            'invalid_format' => '03/01/2026 14:30:00-03:00',
                        ],
                    ],
                    'dhSaiEnt' => [
                        'valid' => [
                            'empty' => '',
                            'standard' => '2026-03-01T14:30:00-03:00',
                        ],
                        'invalid' => [
                            'leading_space' => ' 2026-03-01T14:30:00-03:00',
                            'trailing_space' => '2026-03-01T14:30:00-03:00 ',
                            'missing_time_zone' => '2026-03-01T14:30:00',
                            'missing_seconds' => '2026-03-01T14:30-03:00',
                            'missing_time' => '2026-03-01',
                            'invalid_format' => '03/01/2026 14:30:00-03:00',
                        ],
                    ],
                    'finNFe' => [
                        'valid' => [
                            'normal' => '1',
                            'complementary' => '2',
                            'adjustment' => '3',
                            'return' => '4',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'leading_space' => ' 1',
                            'trailing_space' => '1 ',
                            'alphabetic' => 'A',
                            'out_of_range' => [
                                'zero' => '0',
                                'five' => '5',
                            ],
                        ],
                    ],
                    'fone' => [
                        'valid' => [
                            'empty' => '',
                            'min_length' => '123456',
                            'max_length' => '55456789012345',
                        ],
                        'invalid' => [
                            'leading_space' => ' 123456',
                            'trailing_space' => '123456 ',
                            'alphabetic' => 'A123456',
                            'too_sort' => '12345',
                            'too_long' => '554567890123456',
                            'masked' => '(55) 4567-8901',
                        ],
                    ],
                    'IE' => [
                        'valid' => [
                            'min_length' => '12',
                            'max_length' => '55456789012345',
                            'empty' => '',
                            'leading_zeros' => '00001234567890',
                        ],
                        'invalid' => [
                            'leading_space' => ' 12',
                            'trailing_space' => '12 ',
                            'alphabetic' => 'A12',
                            'too_sort' => '1',
                            'too_long' => '554567890123456',
                            'masked' => '55.456.789.012.345',
                        ],
                    ],
                    'idDest' => [
                        'valid' => [
                            'intrastate' => '1',
                            'interstate' => '2',
                            'exterior' => '3',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'leading_space' => ' 1',
                            'trailing_space' => '1 ',
                            'alphabetic' => 'A',
                            'out_of_range' => [
                                'zero' => '0',
                                'four' => '4',
                            ],
                            'too_long' => '12',
                        ],
                    ],
                    'indFinal' => [
                        'valid' => [
                            'normal' => '0',
                            'final_consumer' => '1',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'leading_space' => ' 1',
                            'trailing_space' => '1 ',
                            'alphabetic' => 'A',
                            'out_of_range' => [
                                'negative_one' => '-1',
                                'two' => '2',
                            ],
                            'too_long' => '12',
                        ],
                    ],
                    'orig' => [
                        'valid' => [
                            'nacional' => '0',
                            'estrangeira_importacao_direta' => '1',
                            'estrangeira_mercado_interno' => '2',
                            'nacional_importacao_superior_40' => '3',
                            'nacional_processo_produtivo_basico' => '4',
                            'nacional_importacao_ate_40' => '5',
                            'estrangeira_importacao_sem_similar' => '6',
                            'estrangeira_mercado_sem_similar' => '7',
                            'nacional_importacao_superior_70' => '8',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'leading_space' => ' 1',
                            'trailing_space' => '1 ',
                            'alphabetic' => 'A',
                            'out_of_range' => [
                                'negative_one' => '-1',
                                'nine' => '9',
                            ],
                            'too_long' => '10',
                        ],
                    ],
                    'indIEDest' => [
                        'valid' => [
                            'contributor' => '1',
                            'exempt_contributor' => '2',
                            'non_contributor' => '9',
                            'empty' => '',
                        ],
                        'invalid' => [
                            'leading_space' => ' 1',
                            'trailing_space' => '1 ',
                            'alphabetic' => 'A',
                            'out_of_range' => [
                                'zero' => '0',
                                'three' => '3',
                                'eight' => '8',
                                'ten' => '10',
                            ],
                            'too_long' => '12',
                        ],
                    ],
                    'mod' => [
                        'valid' => [
                            'nfe' => '55',
                            'nfce' => '65',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'leading_space' => ' 55',
                            'trailing_space' => '55 ',
                            'middle_space' => '5 5',
                            'alphabetic' => '5A',
                            'out_of_range' => [
                                'fifty_four' => '54',
                                'fifty_six' => '56',
                                'sixty_four' => '64',
                                'sixty_six' => '66',
                            ],
                            'too_long' => '055',
                            'too_short' => '5',
                        ],
                    ],
                    'natOp' => [
                        'valid' => [
                            'min_length' => 'A',
                            'max_length' => 'STRING WITH SIXTY CHARACTERS STRING WITH SIXTY CHARACTERS AB',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'leading_space' => ' STANDARD',
                            'trailing_space' => 'STANDARD ',
                            'nested_middle_space' => 'STANDARD  STANDARD',
                            'too_long' => 'STRING WITH SIXTY ONE CHARACTERS STRING WITH SIXTY ONE ABCDEF',
                        ],
                    ],
                    'NCM' => [
                        'valid' => [
                            'standard' => '01012100',
                            'service_or_no_product' => '00',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'out_of_range' => [
                                'zero_one' => '01',
                                'ten' => '10',
                            ],
                            'too_long' => [
                                'three_digits' => '100',
                                'nine_digits' => '123456789',
                            ],
                            'too_short' => [
                                'one_digit' => '0',
                                'seven_digits' => '1234567',
                            ],
                            'leading_space' => ' 01012100',
                            'trailing_space' => '01012100 ',
                            'middle_space' => '010 12100',
                            'with_mask_format' => '0101.21.00',
                            'alphabetic_chars' => 'ABC12345',
                        ],
                    ],
                    'nNF' => [
                        'valid' => [
                            'min' => '1',
                            'standard' => '123456',
                            'max' => '999999999',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'zero' => '0',
                            'too_long' => '1000000000',
                            'alphabetic_chars' => '123A5',
                            'masked' => '1.123-45',
                            'leading_space' => ' 123',
                            'trailing_space' => '123 ',
                            'middle_space' => '1 23',
                        ],
                    ],
                    'nro' => [
                        'valid' => [
                            'standard_number' => '123',
                            'alphanumeric_number' => '100-A',
                            'no_number_literal' => '10',
                            'minimum_size' => '1',
                            'maximum_size' => 'STRING WITH SIXTY CHARACTERS STRING WITH SIXTY CHARACTERS AB',
                            'internal_spaces' => 'KM 45 BLOCO B',
                            'empty' => '',
                        ],
                        'invalid' => [
                            'too_long_size' => 'STRING WITH SIXTY ONE CHARACTERS STRING WITH SIXTY ONE ABCDEF',
                            'leading_space' => ' 123',
                            'trailing_space' => '123 ',
                            'nested_spaces' => '12  34',
                        ],
                    ],
                    'qCom' => [
                        'valid' => [
                            'standard' => '10',
                            'partial' => '125.4567',
                            'min' => '0.0001',
                            'max' => '99999999999.9999',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'leading_zeros' => '010',
                            'thousands_separator' => '1,000.001',
                            'comma_decimal' => '10,50',
                            'too_many_decimals' => '10.12345',
                            'too_many_digits' => '123456789012',
                            'alphabetic_chars' => '10UN',
                            'leading_space' => ' 10',
                            'trailing_space' => '10 ',
                            'middle_space' => '1 000',
                        ],
                    ],
                    'serie' => [
                        'valid' => [
                            'min_to_cnpj' => '0',
                            'max_to_cnpj' => '889',
                            'min_to_cpf' => '890',
                            'max_to_cpf' => '969',
                        ],
                        'invalid' => [
                            'to_long' => '1000',
                            'empty' => '',
                            'alphabetic_chars' => 'A1',
                            'out_of_range' => '970',
                            'leading_space' => ' 1',
                            'trailing_space' => '1 ',
                            'middle_space' => '1 0',
                        ],
                    ],
                    'tpAmb' => [
                        'valid' => [
                            'production' => '1',
                            'homologation' => '2',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'out_of_range' => [
                                'zero' => '0',
                                'three' => '3',
                            ],
                            'alphabetic' => 'P',
                            'leading_space' => ' 1',
                            'trailing_space' => '2 ',
                            'too_long' => '01',
                        ],
                    ],
                    'tpEmis' => [
                        'valid' => [
                            'normal' => '1',
                            'fs_ia' => '2',
                            'scan' => '3',
                            'epec' => '4',
                            'fs_da' => '5',
                            'svc_an' => '6',
                            'svc_rs' => '7',
                            'offline_nfce' => '9',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'out_of_range' => [
                                'zero' => '0',
                                'eight' => '8',
                            ],
                            'alphabetic_char' => 'A',
                            'leading_space' => ' 1',
                            'trailing_space' => '1 ',
                            'too_long' => '10',
                        ],
                    ],
                    'tpNF' => [
                        'valid' => [
                            'entry' => '0',
                            'exit' => '1',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'out_of_range' => [
                                'two' => '2',
                            ],
                            'alphabetic_char' => 'A',
                            'leading_space' => ' 1',
                            'trailing_space' => '1 ',
                            'too_long' => '01',
                        ],
                    ],
                    'uCom' => [
                        'valid' => [
                            'standard' => [
                                'unit' => 'UN',
                                'weight' => 'KG',
                                'box' => 'CAIXA',
                            ],
                        ],
                        'invalid' => [
                            'empty' => '',
                            'too_long' => 'UNIDADE',
                            'leading_space' => ' L',
                            'trailing_space' => 'L ',
                        ],
                    ],
                    'UF' => [
                        'valid' => [
                            'sp' => 'SP',
                            'rj' => 'RJ',
                            'mg' => 'MG',
                            'es' => 'ES',
                            'rn' => 'RN',
                            'pb' => 'PB',
                            'pe' => 'PE',
                            'ba' => 'BA',
                            'al' => 'AL',
                            'se' => 'SE',
                            'ce' => 'CE',
                            'ma' => 'MA',
                            'pi' => 'PI',
                            'rs' => 'RS',
                            'pr' => 'PR',
                            'sc' => 'SC',
                            'df' => 'DF',
                            'go' => 'GO',
                            'mt' => 'MT',
                            'ms' => 'MS',
                            'to' => 'TO',
                            'ro' => 'RO',
                            'ac' => 'AC',
                            'am' => 'AM',
                            'rr' => 'RR',
                            'ap' => 'AP',
                            'pa' => 'PA',
                            'exterior' => 'EX',
                            'empty' => '',
                        ],
                        'invalid' => [
                            'lower_case' => [
                                'sp' => 'sp',
                                'rj' => 'rj',
                                'mg' => 'mg',
                                'es' => 'es',
                                'rn' => 'rn',
                                'pb' => 'pb',
                                'pe' => 'pe',
                                'ba' => 'ba',
                                'al' => 'al',
                                'se' => 'se',
                                'ce' => 'ce',
                                'ma' => 'ma',
                                'pi' => 'pi',
                                'rs' => 'rs',
                                'pr' => 'pr',
                                'sc' => 'sc',
                                'df' => 'df',
                                'go' => 'go',
                                'mt' => 'mt',
                                'ms' => 'ms',
                                'to' => 'to',
                                'ro' => 'ro',
                                'ac' => 'ac',
                                'am' => 'am',
                                'rr' => 'rr',
                                'ap' => 'ap',
                                'pa' => 'pa',
                                'exterior' => 'ex',
                            ],
                            'too_long' => 'AMZ',
                            'too_short' => 'A',
                            'leading_space' => ' AM',
                            'trailing_space' => 'AM ',
                            'middle_space' => 'A M',
                        ],
                    ],
                    'vProd' => [
                        'valid' => [
                            'standard' => '10',
                            'with_cents' => '125.45',
                            'min' => '0.01',
                            'max' => '9999999999999.99',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'leading_zeros' => '010',
                            'thousands_separator' => '1,000.01',
                            'comma_decimal' => '10,50',
                            'too_many_decimals' => '10.123',
                            'too_many_digits' => '10000000000000',
                            'alphabetic_chars' => '10A',
                            'leading_space' => ' 10',
                            'trailing_space' => '10 ',
                            'middle_space' => '1 000',
                            'negative' => '-10',
                        ],
                    ],
                    'vUnCom' => [
                        'valid' => [
                            'standard' => '10',
                            'with_cents' => '125.1234',
                            'min' => '0.0000000001',
                            'max' => '99999999999.999999999',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'leading_zeros' => '010',
                            'thousands_separator' => '1,000.01',
                            'comma_decimal' => '10,50',
                            'too_many_decimals' => '10.12345678901',
                            'too_many_digits' => '9999999999999',
                            'alphabetic_chars' => '10A',
                            'leading_space' => ' 10',
                            'trailing_space' => '10 ',
                            'middle_space' => '1 000',
                            'negative' => '-10',
                        ],
                    ],
                    'xBairro' => [
                        'valid' => [
                            'empty' => '',
                            'min_length' => 'AB',
                            'max_length' => 'STRING WITH SIXTY CHARACTERS STRING WITH SIXTY CHARACTERS AB',
                        ],
                        'invalid' => [
                            'too_long' => 'STRING WITH SIXTY ONE CHARACTERS STRING WITH SIXTY ONE ABCDEF',
                            'too_short' => 'A',
                            'leading_space' => ' NEIGHBORHOOD',
                            'trailing_space' => 'NEIGHBORHOOD ',
                            'nested_spaces' => 'NEIGHBORHOOD WITH  SPACES',
                        ],
                    ],
                    'xCpl' => [
                        'valid' => [
                            'empty' => '',
                            'min_length' => 'A',
                            'max_length' => 'STRING WITH SIXTY CHARACTERS STRING WITH SIXTY CHARACTERS AB',
                        ],
                        'invalid' => [
                            'too_long' => 'STRING WITH SIXTY ONE CHARACTERS STRING WITH SIXTY ONE ABCDEF',
                            'leading_space' => ' COMPLEMENT',
                            'trailing_space' => 'COMPLEMENT ',
                            'nested_spaces' => 'COMPLEMENT WITH  SPACES',
                        ],
                    ],
                    'xFant' => [
                        'valid' => [
                            'empty' => '',
                            'min_length' => 'A',
                            'max_length' => 'STRING WITH SIXTY CHARACTERS STRING WITH SIXTY CHARACTERS AB',
                        ],
                        'invalid' => [
                            'too_long' => 'STRING WITH SIXTY ONE CHARACTERS STRING WITH SIXTY ONE ABCDEF',
                            'leading_space' => ' FANTASY',
                            'trailing_space' => 'FANTASY ',
                            'nested_spaces' => 'FANTASY WITH  SPACES',
                        ],
                    ],
                    'xLgr' => [
                        'valid' => [
                            'empty' => '',
                            'min_length' => 'AB',
                            'max_length' => 'STRING WITH SIXTY CHARACTERS STRING WITH SIXTY CHARACTERS AB',
                        ],
                        'invalid' => [
                            'too_short' => 'A',
                            'too_long' => 'STRING WITH SIXTY ONE CHARACTERS STRING WITH SIXTY ONE ABCDEF',
                            'leading_space' => ' STREET',
                            'trailing_space' => 'STREET ',
                            'nested_spaces' => 'STREET WITH  SPACES',
                        ],
                    ],
                    'xMun' => [
                        'valid' => [
                            'empty' => '',
                            'min_length' => 'AB',
                            'max_length' => 'STRING WITH SIXTY CHARACTERS STRING WITH SIXTY CHARACTERS AB',
                        ],
                        'invalid' => [
                            'too_short' => 'A',
                            'too_long' => 'STRING WITH SIXTY ONE CHARACTERS STRING WITH SIXTY ONE ABCDEF',
                            'leading_space' => ' CITY',
                            'trailing_space' => 'CITY ',
                            'nested_spaces' => 'CITY WITH  SPACES',
                        ],
                    ],
                    'xNome' => [
                        'valid' => [
                            'empty' => '',
                            'min_length' => 'AB',
                            'max_length' => 'STRING WITH SIXTY CHARACTERS STRING WITH SIXTY CHARACTERS AB',
                        ],
                        'invalid' => [
                            'too_short' => 'A',
                            'too_long' => 'STRING WITH SIXTY ONE CHARACTERS STRING WITH SIXTY ONE ABCDEF',
                            'leading_space' => ' NAME',
                            'trailing_space' => 'NAME ',
                            'nested_spaces' => 'NAME WITH  SPACES',
                        ],
                    ],
                    'xPais' => [
                        'valid' => [
                            'empty' => '',
                            'min_length' => 'AB',
                            'max_length' => 'STRING WITH SIXTY CHARACTERS STRING WITH SIXTY CHARACTERS AB',
                        ],
                        'invalid' => [
                            'too_short' => 'A',
                            'too_long' => 'STRING WITH SIXTY ONE CHARACTERS STRING WITH SIXTY ONE ABCDEF',
                            'leading_space' => ' NAME',
                            'trailing_space' => 'NAME ',
                            'nested_spaces' => 'NAME WITH  SPACES',
                        ],
                    ],
                    'xProd' => [
                        'valid' => [
                            'min_length' => 'A',
                            'max_length' => 'STRING WITH A HUNDRED TWENTY CHARACTERS STRING WITH A HUNDRED TWENTY CHARACTERS STRING WITH A HUNDRED TWENTY CHARS ABCDE',
                        ],
                        'invalid' => [
                            'empty' => '',
                            'too_long' => 'STRING WITH A HUNDRED TWENTY ONE CHARACTERS STRING WITH A HUNDRED TWENTY ONE CHARACTERS STRING WITH A HUNDRED TWENTY ABCD',
                            'leading_space' => ' NAME',
                            'trailing_space' => 'NAME ',
                            'nested_spaces' => 'NAME WITH  SPACES',
                        ],
                    ],
                ],
            ],
        ],
    ];

    public static function getDataset(): array
    {
        return (new self)->dataset;
    }
}
