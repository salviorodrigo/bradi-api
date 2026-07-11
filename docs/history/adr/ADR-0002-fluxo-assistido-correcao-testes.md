# ADR-0002 - Fluxo Assistido de Correcao de Testes e Commits Segmentados

- Status: Accepted
- Data: 2026-07-11
- Dono: Time Bradi NFE API
- Tags: processo, testes, automacao, conventional-commits

## Contexto

O time executa com frequencia um ciclo repetitivo de diagnostico e correcao de testes: rodar suite completa, analisar primeira falha, corrigir, revalidar e commitar por escopo. Sem padrao operacional explicito, o fluxo tende a variar entre sessoes, aumentando retrabalho, risco de perda de contexto e commits misturando alteracoes de dominio e testes.

## Decisao

Padronizar um fluxo assistido com loop de validacao, com os seguintes passos obrigatorios:

1. Rodar `composer test:ci`.
2. Se houver falha, coletar informacoes da primeira falha e definir plano de correcao.
3. Executar o plano.
4. Revalidar com `composer lint` e `composer test:ci`.
5. Em sucesso, commitar alteracoes de `src/` com tipo apropriado (`feat`, `fix`, `refactor` etc.) no padrao conventional commits.
6. Commitar alteracoes de `tests/` separadamente com tipo `test` no padrao conventional commits.
7. Se falhar nos passos de execucao/correcao ou validacao, repetir o ciclo a partir do passo 1.

## Especificacao de automacao (base para skill)

- Gatilho: solicitacao explicita para corrigir falhas de teste seguindo fluxo padrao.
- Entrada minima:
  - Comando de validacao principal (`composer test:ci`).
  - Convencao de commit (`conventional commits`).
- Comportamento:
  - Sempre priorizar a primeira falha reportada.
  - Gerar plano curto e objetivo antes de editar.
  - Aplicar menor mudanca possivel para restaurar verde.
  - Executar validacao completa antes de commitar.
  - Segregar commits por escopo de pasta (`src` e `tests`).
- Saida esperada:
  - Resumo da falha raiz.
  - Plano aplicado.
  - Evidencias de validacao (lint/testes).
  - Hashes e mensagens de commit por escopo.
- Criterios de parada:
  - Sucesso: suite verde e commits segmentados concluidos.
  - Falha controlada: apos repeticoes sem convergencia, registrar bloqueio tecnico com causa e proximo experimento.

## Alternativas consideradas

- Fluxo manual sem padronizacao:
  - Pro: flexibilidade total.
  - Contra: maior variabilidade, menor auditabilidade e mais retrabalho.
- Commit unico com codigo + testes:
  - Pro: menos comandos Git.
  - Contra: pior rastreabilidade e revisao menos objetiva.

## Consequencias

- Positivas:
  - Mais previsibilidade no ciclo Red -> Green -> Refactor.
  - Melhor rastreabilidade de mudancas por escopo.
  - Base concreta para futura skill reutilizavel.
- Negativas:
  - Overhead operacional pequeno para separar commits.
- Riscos e mitigacoes:
  - Risco: ciclo de repeticao sem convergencia.
  - Mitigacao: limitar tentativas por hipotese e registrar bloqueio com proximo passo testavel.

## Plano de rollout

- Fase 1: formalizar ADR e indice de decisoes.
- Fase 2: aplicar o fluxo em sessoes de correcao recorrentes.
- Fase 3: converter esta especificacao em skill operacional com template de prompts.

## Criterios de sucesso

- Correcoes de testes passam a registrar plano + evidencias de validacao.
- Commits de dominio e testes passam a ser separados por convencao.
- Reducao de retrabalho em sessoes subsequentes de correcao.

## Revisao

- Revisitar em: 2026-08-15
- Condicoes para substituir/invalidar esta decisao:
  - Se o fluxo gerar friccao recorrente sem ganho de qualidade.
  - Se automacao oficial substituir este processo por um superior.
