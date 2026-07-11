# bradi-api

API REST para captura, processamento basico e armazenamento de XMLs de documentos fiscais brasileiros.

## Visao Geral

O projeto tem como objetivo receber arquivos XML fiscais validos e assinados, processar validacoes estruturais iniciais e organizar os dados por CNPJ.

A proposta atual e focada em uso local e em um escopo inicial controlado, com evolucao incremental das regras e capacidades.

## Escopo Inicial (Inception)

Com base na issue de inception:

- Captura dos documentos por upload de arquivos XML validos e assinados.
- Processamento com validacoes basicas de estrutura, como obrigatoriedade de tags e tamanho de campos.
- Sem validacao de regras de negocio de assinatura e emissao no escopo inicial.
- Foco inicial em execucao local.
- Tipos de documentos fiscais suportados no inicio: NFe e NFCe, conforme MOC v7.0 (NFe e NFCe 4.0).

Referencia da inception issue:

- https://github.com/salviorodrigo/bradi-api/issues/2

## Requisitos

- PHP >= 8.5
- Composer

## Instalacao

1. Clonar o repositorio.
2. Instalar dependencias:

   composer install

## Comandos Principais

- Analise de codigo: composer lint
- Corrigir estilo automaticamente: composer lint:fix
- Rodar testes: composer test
- Rodar testes em paralelo (CI): composer test:ci
- Cobertura HTML: composer test:coverage
- Verificar historico: composer history:check

## Estrutura do Projeto

- src/Domain: regras de dominio
- src/Infra: adaptadores e implementacoes de infraestrutura
- tests: testes unitarios e de integracao
- docs/history: historico, decisoes e ADRs

## Orientacoes para Agentes de IA

As contribuicoes automatizadas neste repositorio devem seguir estes principios:

- Entregar mudancas pequenas, seguras e testadas.
- Manter funcoes pequenas, baixo acoplamento e nomes claros.
- Priorizar guard clauses e baixo nivel de aninhamento.
- Toda mudanca de comportamento deve vir acompanhada de testes.
- Antes de concluir: composer lint e composer test.
- Em mudancas amplas: rodar tambem composer test:ci.
- Mudancas relevantes devem atualizar historico em docs/history.

## Licenca

GPL-3.0-only
