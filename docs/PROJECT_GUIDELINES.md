# Diretrizes Gerais do Projeto

Este documento descreve acordos de trabalho para desenvolvimento humano + agente de IA.

## Principios

- Qualidade antes de velocidade aparente.
- Mudancas pequenas e reversiveis.
- Feedback rapido por testes automatizados.
- Clareza de dominio acima de clever code.

## Modo de Trabalho (XP + Agile Vibe)

- Pair programming humano-agente:
  - humano define objetivo, limites e criterio de aceite
  - agente implementa em passos curtos
  - humano valida comportamento e diff
- TDD preferencial: Red -> Green -> Refactor.
- Refatoracao continua com seguranca de testes.
- Entregas incrementais com commits pequenos.

## Definition of Done

Uma tarefa so termina quando:

- criterio de aceite foi atendido
- testes novos/corrigidos foram adicionados quando necessario
- `composer lint` e `composer test` estao verdes
- documentacao de contexto foi atualizada (quando aplicavel)
- historico foi atualizado (CHANGELOG/DECISIONS/ADR quando aplicavel)

## Convencoes de Codigo

- Funcoes pequenas, foco unico e sem aninhamento profundo.
- Responsabilidade unica por modulo/classe.
- Nomes especificos e distintivos para facilitar busca lexical (`rg`).
- Preferir erros com contexto util.
- Comentarios devem registrar intencao, restricoes e proveniencia.

## Convencoes de Teste

- Teste de unidade para regra de dominio.
- Teste de regressao para bug corrigido.
- Dublagem por fakes nomeados em `tests/Doubles` quando pertinente.
- Evitar teste fragil acoplado a detalhes de implementacao.

## Comandos Oficiais

- Lint: `composer lint`
- Lint (fix): `composer lint:fix`
- Teste local: `composer test`
- Teste paralelo CI-like: `composer test:ci`
- Cobertura: `composer test:coverage`

## Governanca de Decisoes e Alteracoes

- Alteracoes de comportamento relevante: registrar em `docs/history/CHANGELOG.md`.
- Decisao estrutural/processual: registrar em `docs/history/DECISIONS.md` e ADR em `docs/history/adr/`.
- Toda decisao deve incluir contexto, escolha, consequencias e plano de revisao.

## Contribuicao e PR

- Siga o fluxo em `CONTRIBUTING.md` para branch, validacoes locais e abertura de PR.
- Use o template de PR em `.github/pull_request_template.md`.
- O CI valida checklist e historico via `.github/workflows/pr-governance-checks.yml`.
