# ADR-0001 - Governanca XP com Agentes de IA

- Status: Accepted
- Data: 2026-07-10
- Dono: Time Bradi NFE API
- Tags: processo, qualidade, testes, documentacao

## Contexto

O projeto precisa operar com alta iteracao usando agentes de IA sem perder controle tecnico. Sem diretrizes explicitas, agentes tendem a gerar mudancas maiores, com menor rastreabilidade de decisoes e risco de regressao.

## Decisao

Adotar um baseline de governanca com:

- Diretrizes operacionais para agente em `AGENTS.md`.
- Diretrizes gerais de time em `docs/PROJECT_GUIDELINES.md`.
- Historico de alteracoes em `docs/history/CHANGELOG.md`.
- Historico de decisoes com ADRs em `docs/history/DECISIONS.md` e `docs/history/adr/`.

## Alternativas consideradas

- Sem documentacao formal:
  - Pro: menor overhead inicial.
  - Contra: perda de contexto, inconsistencia de padrao e retrabalho.
- Documentacao extensa em um unico arquivo:
  - Pro: centralizacao.
  - Contra: pior navegacao e maior custo de manutencao.

## Consequencias

- Positivas:
  - Mais previsibilidade para desenvolvimento humano + agente.
  - Melhor rastreabilidade de mudancas e motivacoes.
  - Facilita onboarding e revisoes.
- Negativas:
  - Exige disciplina para manter historico atualizado.

## Plano de rollout

- Fase 1: publicar baseline documental (este ADR).
- Fase 2: exigir atualizacao de changelog/decisions em mudancas relevantes.
- Fase 3: revisar eficacia apos 2 sprints.

## Criterios de sucesso

- Toda mudanca relevante registra impacto no changelog.
- Toda decisao estrutural gera ADR.
- Reducao de ambiguidades em PRs e menor retrabalho por falta de contexto.

## Revisao

- Revisitar em: 2026-08-21
- Condicao de revisao antecipada: aumento de friccao operacional sem ganho de qualidade.
