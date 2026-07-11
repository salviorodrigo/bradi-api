---
name: test-fix-workflow
description: 'Executa a skill test-fix-workflow com os acessos necessarios para diagnosticar, corrigir, validar e commitar a primeira falha da suite.'
argument-hint: 'Contexto opcional sobre a falha ou area afetada'
agent: 'test-fix-workflow'
tools: [read, edit, search, execute, todo]
---

Siga a skill [test-fix-workflow](../skills/test-fix-workflow/SKILL.md) neste repositorio.

Execute o fluxo completo:

1. Rode `composer test:ci`.
2. Capture apenas a primeira falha.
3. Elabore um plano curto e execute a correcao minima.
4. Valide com `composer lint` e `composer test:ci`.
5. Em sucesso, faca commit separado para `src/` com tipo adequado e para `tests/` com tipo `test`.
6. Se a execucao ou validacao falhar, reinicie desde o passo 1.

Na resposta final, entregue:

- falha raiz
- plano aplicado
- evidencias de validacao
- hashes e mensagens dos commits