---
mode: agent
tools: ['run_in_terminal', 'apply_patch', 'get_errors']
description: Fluxo padrao de correcao da primeira falha de teste com commits segmentados (src/tests).
---

Aplique o fluxo test-fix-workflow neste repositorio:

1. Rode `composer test:ci`.
2. Capture apenas a primeira falha.
3. Elabore plano curto e execute a correcao minima.
4. Valide com `composer lint` e `composer test:ci`.
5. Em sucesso, faca commit separado:
   - `src/` com tipo adequado (`feat`, `fix`, `refactor` etc.).
   - `tests/` com tipo `test`.
6. Se falhar em execucao/validacao, repita desde o passo 1.

Regras:
- Nao misturar `src/` e `tests/` no mesmo commit.
- Nao concluir com suite quebrada.
- Entregar no fim: falha raiz, plano aplicado, evidencias de validacao e hashes dos commits.
