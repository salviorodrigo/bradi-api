---
name: test-fix-workflow
description: "Use quando precisar corrigir a primeira falha do composer test:ci com validacao e commits por escopo."
user-invocable: true
---

# Test Fix Workflow

## Quando usar

- Quando a solicitacao mencionar corrigir a primeira falha da suite.
- Quando for preciso seguir o fluxo assistido definido para este repositorio.
- Quando a entrega exigir ciclos curtos de Red → Green → Refactor com validacao completa.
- **NÃO use** se a suite estiver completamente verde (sem falhas) — veja seção "Casos especiais".

## Objetivo

Executar o ciclo XP assistido (Red → Green → Refactor) priorizar a primeira falha observável, aplicar o mínimo de mudança mantendo os princípios de AGENTS.md, validar com lint e testes, e entregar commits separados por escopo funcional (`src/` vs `tests/`) em conventional commits.

## Entradas minimas

- Suite a corrigir: `composer test:ci`
- Validacao: `composer lint` + `composer test:ci`
- Convencao de commit: `conventional commits` (tipos: `feat`, `fix`, `refactor`, `test`)
- Contexto opcional: restricao de dominio, risco observado ou area afetada

## Principios (AGENTS.md)

Antes de implementar, considere:

- **Funcoes pequenas**: 4-20 linhas; dividir se crescer muito.
- **Arquivos pequenos**: <500 linhas; ideal 200-300.
- **SRP**: uma responsabilidade por classe/modulo.
- **Nomes grepaveis**: evitar `data`, `handler`, `manager`, `service`.
- **Tipos explicitos**: toda API publica com tipos claros (PHP 8.4).
- **Guard clauses + early return**: fluxo de controle claro, max 2 niveis de aninhamento.
- **Erros com contexto**: mensagem deve informar valor recebido e formato esperado.

Estes principios devem guiar a correcao minima e evitar regressoes.

## Procedimento

### Fase 1: Diagnostico

1. Rodar `composer test:ci` e capturar a saida completa.
2. Identificar a **primeira falha reportada** (nao a ultima ou a maior).
3. Extrair:
   - `[arquivo]:[linha]` onde o teste falha
   - mensagem de erro exata
   - nome da classe/funcao sob teste

### Fase 2: Planejamento (use template abaixo)

Formular um plano curto com:

- **Falha inicial**: arquivo, linha, mensagem.
- **Causa raiz**: por que o teste falha? classe nao existe? metodo retorna valor errado? validacao quebrada?
- **Hipotese**: qual mudanca minima resolve?
- **Risco de regressao**: quais testes/componentes poderiam quebrar?
- **Validacao esperada**: quais comandos vao confirmar sucesso?

**Template de plano:**

```
## Plano

- Falha: tests/Unit/Domain/Invoices/NFe/v4_00/InformacoesNotaFiscalTest.php:8
  - Mensagem: class_exists('BradiNfeApi\Domain\Invoices\NFe\v4_00\InformacoesNotaFiscal') retornou false
  
- Causa raiz: classe InformacoesNotaFiscal nao existe em src/
  
- Hipotese: criar classe faltante herdando de DFeElement, implementando minimo:
  - FIELD_NAME = 'infNFe'
  - tagValueValidators(), tagAttributesValidators(), tagElementsValidators()
  
- Risco: baixo. Classe nova, sem dependencias. Segue padrao de vizinhos em mesmo diretorio.
  
- Validacao:
  - composer lint (style + tipos)
  - composer test:ci (todas as 1331 suites)
```

### Fase 3: Implementacao minima

4. Implementar **apenas** a mudanca identificada no plano.
5. Respeitar principios de AGENTS.md: nomes grepaveis, tipos explicitos, guard clauses, tamanho de funcao.
6. **Nao** ampliar escopo (ex: nao corrigir 2 falhas diferentes em uma iteracao).
7. Se a correcao exigir arquivo novo, criar em local consistente com convencoes do projeto (ex: em `src/Domain/Invoices/NFe/v4_00/` para NFe v4.00).

### Fase 4: Validacao

8. Rodar `composer lint`:
   - Se falhar: corrigir estilo/tipos antes de prosseguir.
   - Se passar: prosseguir.

9. Rodar `composer test:ci`:
   - **Se tudo verde**: prosseguir para commits.
   - **Se houver falha nova**: registrar. Retornar a Fase 1 com a nova primeira falha.
   - **Se a mesma falha persistir**: reanalisar plano; pode haver premissa errada.

### Fase 5: Commits separados por escopo

10. **Separar obrigatoriamente** `src/` de `tests/`:

   - Se houver mais de um teste local com falha e ainda nao comitado, manter somente o teste alvo no worktree.
   - Antes de ajustar o teste alvo, colocar os outros testes em `stash` para que nao fiquem em stage no momento do commit.
   - Depois que o teste alvo estiver corrigido e validado, reaplicar o `stash` antes de seguir com os commits restantes.

    - Se alterou `src/Domain/` ou `src/Infra/`:
      - **Commit `src`** com tipo `feat`, `fix` ou `refactor`.
      - Exemplo: `feat(nfe): add InformacoesNotaFiscal element for v4_00`
      - Exemplo: `fix(parser): correct guard for nfe document type`
    
    - Se alterou `tests/`:
      - **Commit `tests`** com tipo `test`.
      - Exemplo: `test(nfe): add regression coverage for InformacoesNotaFiscal class`
    
    - Se ambas alteracoes foram necessarias (ex: classe nova + teste de regressao):
      - Commit 1: `src/` com tipo `feat`/`fix`/`refactor`.
      - Commit 2: `tests/` com tipo `test`.

11. Cada commit deve ter:
    - Mensagem clara em conventional commits.
    - Referencia a principio de AGENTS.md se relevante (ex: "respeitando SRP").
    - Sem alteracoes de escopo nao relacionadas (ex: não limpar outro bug no mesmo commit).

### Fase 6: Checklist final antes de concluir

- [ ] `composer lint` passou
- [ ] `composer test:ci` passou (todos os testes)
- [ ] Commits separados em `src/` (tipo feat/fix/refactor) e `tests/` (tipo test)
- [ ] Nenhuma mudanca alem do escopo da primeira falha foi aplicada
- [ ] Mensagens de commit sao claras e seguem conventional commits

## Restricoes

- ❌ Nao misturar `src/` e `tests/` no mesmo commit.
- ❌ Nao concluir com a suite quebrada.
- ❌ Nao abrir mais de uma hipotese de correcao por iteracao.
- ❌ Nao ampliar escopo (ex: corrigir 2 falhas diferentes no mesmo ciclo).
- ❌ Nao ignorar principios de AGENTS.md (funcoes pequenas, tipos explicitos, etc).
- ✅ Priorizar sempre a primeira falha observavel antes de ampliar.

## Casos especiais

### Suite ja esta verde?

Se `composer test:ci` nao reporta falhas:

- Confirmar: rode `composer test:ci` novamente.
- Registrar: todos os testes passam (e.g., "1331 testes passaram").
- Saida: encerrar skill. Nao ha correcao a fazer.
- Proxima acao: identificar nova tarefa ou falha em ambiente diferente.

### Correcao gera nova falha em outro modulo?

- Registrar: qual teste quebrou.
- Nao desistir de commits atuais; eles corrigem a primeira falha corretamente.
- Iniciar **novo ciclo** (Fase 1) com a nova primeira falha.
- Exemplo: corrigir Parser gera falha em Validator → ciclo 1 completa, ciclo 2 comeca com novo teste.

### Lint falha apos correcao?

- Erro comum: newline faltante no final, tipos não inferidos, nomes genericos.
- Corrigir: `composer lint --fix` pode resolver automaticamente.
- Retestar: `composer lint` + `composer test:ci` novamente.
- Nao commitar com lint quebrado.

### Teste falha mas por razao diferente?

- Exemplo: "classe existe mas metodo retorna null".
- Reanalisar causa raiz; plano pode estar incompleto.
- Voltar a Fase 2; expandir hipotese minima se necessario (mas sem abrir novo escopo).

### Pre-commit hook bloqueia commit?

- Verificar output do hook.
- Se estilo/tipo: corrigir com `composer lint --fix`, retestar, repetir commit.
- Se teste: nao commitar; suite nao deve estar quebrada. Voltar a Fase 4.

## Saida esperada

**Relatorio final deve incluir:**

1. Falha inicial diagnosticada:
   - Arquivo, linha, mensagem.
   - Causa raiz identificada.

2. Plano aplicado:
   - Resumo da menor mudanca.
   - Principios respeitados (ex: "funcoes <20 linhas", "nomes grepaveis").
   - Risco de regressao avaliado.

3. Evidencias de validacao:
   - Output de `composer lint` (passou).
   - Output de `composer test:ci` (passou, numero total de testes).

4. Commits gerados:
   - Hash e mensagem do commit `src/` (se houver).
   - Hash e mensagem do commit `tests/` (se houver).

**Exemplo de saida:**

```
## Resultado

Falha: tests/Unit/Domain/Invoices/NFe/v4_00/InformacoesNotaFiscalTest.php:8
- class_exists(...) retornou false

Causa: classe InformacoesNotaFiscal nao existia

Correcao: criada classe herdando de DFeElement, 15 linhas, respeitando SRP

Validacao:
- composer lint: PASSOU
- composer test:ci: 1331 testes PASSARAM

Commits:
- f24b6f2 feat(nfe): add InformacoesNotaFiscal element for v4_00
- e7cb945 test(nfe): add coverage for InformacoesNotaFiscal class existence
```

## Referencias do projeto

- **ADR**: [ADR-0002 - Fluxo Assistido de Correcao de Testes](../../../docs/history/adr/ADR-0002-fluxo-assistido-correcao-testes.md)
- **Diretrizes arquiteturais**: [AGENTS.md](../../../AGENTS.md)
- **Template operacional**: [docs/skills/TEST_FIX_WORKFLOW_SKILL_TEMPLATE.md](../../../docs/skills/TEST_FIX_WORKFLOW_SKILL_TEMPLATE.md)
- **Conventional commits**: https://www.conventionalcommits.org/
- **XP cycle**: Red → Green → Refactor