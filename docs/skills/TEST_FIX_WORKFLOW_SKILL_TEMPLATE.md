# Skill Template - Test Fix Workflow

Este template operacionaliza o fluxo definido em ADR-0002 para uso em sessoes futuras com agente.

## Nome sugerido

`test-fix-workflow`

## Objetivo

Executar correcao orientada pela primeira falha da suite, com loop de validacao e commits segmentados por escopo (`src` e `tests`) em conventional commits.

## Gatilhos de uso

- "Rode `composer test:ci`, corrija a primeira falha e comite por escopo."
- "Aplique o fluxo de correcao de testes do projeto."

## Entradas minimas

- Comando principal: `composer test:ci`
- Regra de commit: `conventional commits`
- Escopos de commit:
  - codigo de dominio em `src/`
  - testes em `tests/`

## Politica de execucao

1. Rodar `composer test:ci`.
2. Se houver falha, capturar somente a primeira falha reportada.
3. Elaborar plano curto para causa raiz.
4. Implementar menor mudanca possivel para resolver a falha.
  - Se existirem varios testes locais com falha e nao comitados, manter apenas o teste alvo no worktree e colocar os demais em `stash` antes do ajuste.
  - Reaplicar o `stash` depois que o teste alvo estiver corrigido e validado.
5. Rodar `composer lint` e `composer test:ci`.
6. Se tudo verde:
   - commit de `src/` com tipo adequado (`feat`, `fix`, `refactor` ou equivalente).
   - commit de `tests/` com tipo `test`.
7. Se passos 4-6 falharem, repetir a partir do passo 1.

## Restricoes

- Nao misturar `src/` e `tests/` no mesmo commit.
- Nao commitar com suite quebrada.
- Nao abrir mais de uma hipotese de correcao por iteracao.

## Modelo de plano de solucao

- Primeira falha:
  - arquivo:
  - linha:
  - mensagem:
- Hipotese raiz:
- Mudanca minima proposta:
- Risco de regressao:
- Validacao:
  - `composer lint`
  - `composer test:ci`

## Modelo de saida esperada

- Falha inicial e causa raiz.
- Plano aplicado.
- Evidencias de validacao (lint + testes).
- Commits gerados:
  - commit `src/` (tipo nao-`test`)
  - commit `tests/` (tipo `test`)

## Exemplos de mensagens conventional commits

- `feat(nfe): add InformacoesNotaFiscal element for v4_00`
- `fix(nfe): correct parser guard for first failing case`
- `refactor(nfe): simplify element validation flow`
- `test(nfe): add regression coverage for first failing scenario`

## Prompt base para invocacao

Use o texto abaixo para iniciar uma sessao:

```text
Execute o fluxo test-fix-workflow:
1) rode composer test:ci,
2) capture a primeira falha,
3) proponha plano curto e execute a correcao,
4) valide com composer lint e composer test:ci,
5) em sucesso, faca commit separado para src (feat/fix/refactor) e tests (test),
6) se falhar, repita desde o passo 1.
```
