# Guia de Contribuicao

Este documento define o fluxo oficial para contribuir no projeto.

## Objetivo

- Manter velocidade com seguranca tecnica.
- Garantir rastreabilidade de mudancas e decisoes.
- Padronizar trabalho humano + agente de IA.

## Fluxo de trabalho

1. Crie uma branch curta e orientada a intencao.
2. Desenvolva em ciclos pequenos (Red -> Green -> Refactor).
3. Rode validacoes locais antes de commit.
4. Abra PR preenchendo o template completo.
5. Resolva feedback mantendo historico de decisao quando aplicavel.

## Validacoes locais obrigatorias

- composer lint
- composer test

Se a mudanca afetar multiplos modulos ou risco mais alto:

- composer test:ci

Validacao recomendada para governanca de historico:

- composer history:check

## Convencao de commit

Formato:

- tipo(escopo): descricao

Tipos aceitos:

- feat
- fix
- docs
- style
- refactor
- perf
- test
- build
- ci
- chore
- revert

## Regras de historico

Atualize o historico quando houver mudanca relevante:

- CHANGELOG: alteracoes de comportamento, processo, risco, compatibilidade.
- ADR + DECISIONS: decisoes arquiteturais ou processuais com trade-offs.

Guia detalhado:

- docs/history/README.md

## Regras para PR

Ao abrir PR:

- Marque ao menos um tipo de mudanca.
- Preencha checklist de qualidade e governanca.
- Informe risco, impacto e plano de rollback.
- Inclua evidencias resumidas (lint/testes).

Automacao em CI valida:

- Checklist do corpo do PR.
- Atualizacao de historico para mudancas relevantes de codigo.

Workflow:

- .github/workflows/pr-governance-checks.yml

## Criterios de Done

Uma contribuicao so esta pronta quando:

- comportamento e criterio de aceite foram atendidos
- testes relevantes foram adicionados/atualizados
- lint e testes estao verdes
- historico e decisao foram registrados quando aplicavel

## Referencias

- AGENTS.md
- docs/PROJECT_GUIDELINES.md
- docs/history/CHANGELOG.md
- docs/history/DECISIONS.md
- docs/history/adr/ADR-0000-template.md
