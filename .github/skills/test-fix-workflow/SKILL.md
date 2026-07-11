---
name: test-fix-workflow
description: 'Corrige a primeira falha da suite de testes com loop de validacao e commits separados por escopo. Use quando pedir para rodar composer test:ci, capturar a primeira falha, aplicar a menor correcao possivel, validar com lint e testes e commitar src e tests separadamente.'
argument-hint: 'Contexto opcional da falha ou do objetivo'
user-invocable: true
---

# Test Fix Workflow

## Quando usar

- Quando a solicitacao mencionar corrigir a primeira falha da suite.
- Quando for preciso seguir o fluxo assistido definido para este repositorio.
- Quando a entrega exigir validacao completa e commits separados por escopo em `src/` e `tests/`.

## Entradas minimas

- Comando principal: `composer test:ci`
- Validacao final: `composer lint` e `composer test:ci`
- Convencao de commit: `conventional commits`

## Procedimento

1. Rodar `composer test:ci`.
2. Capturar somente a primeira falha reportada.
3. Formular um plano curto com:
   - arquivo e linha da primeira falha, quando disponivel
   - hipotese raiz
   - menor mudanca possivel
4. Implementar a correcao minima.
5. Validar com `composer lint` e `composer test:ci`.
6. Se tudo estiver verde, criar commits separados:
   - `src/` com tipo adequado (`feat`, `fix`, `refactor` ou equivalente)
   - `tests/` com tipo `test`
7. Se a execucao ou validacao falhar, reiniciar a partir do passo 1 com base na nova primeira falha.

## Restricoes

- Nao misturar alteracoes de `src/` e `tests/` no mesmo commit.
- Nao concluir com a suite quebrada.
- Nao abrir mais de uma hipotese de correcao por iteracao.
- Priorizar sempre a primeira falha observavel antes de ampliar escopo.

## Saida esperada

- Falha inicial e causa raiz.
- Plano aplicado.
- Evidencias de validacao.
- Hashes e mensagens dos commits por escopo.

## Referencias do projeto

- Processo baseado em [ADR-0002](../../../docs/history/adr/ADR-0002-fluxo-assistido-correcao-testes.md).
- Template operacional relacionado em [docs/skills/TEST_FIX_WORKFLOW_SKILL_TEMPLATE.md](../../../docs/skills/TEST_FIX_WORKFLOW_SKILL_TEMPLATE.md).