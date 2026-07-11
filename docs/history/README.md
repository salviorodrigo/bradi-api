# Guia Rapido de Historico

Este guia explica quando registrar em CHANGELOG e quando abrir ADR.

## Objetivo

- Reduzir duvidas sobre governanca documental.
- Garantir rastreabilidade de alteracoes e decisoes.

## Qual arquivo atualizar?

- Atualize `CHANGELOG.md` quando houver alteracao relevante de comportamento, risco, processo ou documentacao.
- Atualize `DECISIONS.md` e crie ADR em `adr/` quando houver decisao arquitetural ou processual que pode impactar mudancas futuras.

## Regra pratica (matriz)

- Mudou comportamento visivel do sistema?
  - Sim: CHANGELOG.
- Corrigiu bug com risco de regressao?
  - Sim: CHANGELOG (tipo Fixed) e referenciar teste de regressao.
- Mudou padrao tecnico do projeto?
  - Sim: ADR + DECISIONS; e CHANGELOG se afetar fluxo do time.
- Escolheu uma abordagem com trade-offs (e alternativas)?
  - Sim: ADR + DECISIONS.
- Foi apenas ajuste local sem impacto relevante?
  - Nao: sem atualizacao obrigatoria de historico.

## Exemplos rapidos

### Exemplo 1 - Apenas CHANGELOG

Caso: ajuste em validacao de CPF que corrige falso positivo.

- Registrar em `CHANGELOG.md`:
  - Tipo: Fixed
  - Escopo: Domain/Common
  - Impacto: corrige validacao incorreta sem quebra de API
  - Evidencia: `composer test` com novo teste de regressao

### Exemplo 2 - CHANGELOG + ADR

Caso: adocao de nova estrategia de parsing XML em toda camada `Infra`.

- Registrar em `CHANGELOG.md`:
  - Tipo: Changed
  - Escopo: Infra/Parses
  - Impacto: altera fluxo interno de parsing
- Criar ADR em `adr/`:
  - Contexto do problema
  - Decisao tomada
  - Alternativas recusadas
  - Consequencias e riscos
- Atualizar `DECISIONS.md` com status da nova ADR

### Exemplo 3 - Apenas ADR + DECISIONS

Caso: padrao de commit e regra de rollout para trabalho com agente, sem mudar runtime.

- Criar ADR de processo em `adr/`
- Atualizar indice em `DECISIONS.md`
- CHANGELOG opcional (recomendado se alterar rotina do time)

## Fluxo sugerido no PR

1. Validar se houve mudanca relevante.
2. Se sim, atualizar CHANGELOG.
3. Se houve decisao estrutural/processual, abrir ADR e atualizar DECISIONS.
4. Referenciar links de historico no corpo do PR.

## Checklist final do autor

- Atualizei `CHANGELOG.md` quando aplicavel.
- Criei ADR e atualizei `DECISIONS.md` quando aplicavel.
- Inclui impacto e evidencia (lint/testes) no registro.