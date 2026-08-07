# CHANGELOG

Registro de alteracoes relevantes do projeto.

Guia de uso: consulte `docs/history/README.md`.

## Formato

- Data: YYYY-MM-DD
- Tipo: Added | Changed | Fixed | Removed | Security | Docs | Process
- Escopo: area afetada (Domain, Infra, Tests, Build, etc.)
- Impacto: comportamento, compatibilidade e risco
- Evidencia: testes/comandos executados

---

## 2026-08-07

### Removed

- Escopo: Domain/Xml, Domain/Invoices
- Descricao: Removido o escape de XML (`htmlspecialchars`) de `Attribute::__toString()`, `Element::__toString()` e `DFeAttribute::initializeSourceAttribute()`. Valores de tag e de atributo passam a ser serializados verbatim; escapar/desescapar e responsabilidade dos sanitizadores da borda, nao regra de dominio.
- Arquivos:
  - `src/Domain/Xml/ValueObjects/Attribute.php`
  - `src/Domain/Xml/ValueObjects/Element.php`
  - `src/Domain/Invoices/Templates/DFeAttribute.php`
  - `tests/Unit/Domain/Xml/ValueObjects/AttributeTest.php`
  - `tests/Unit/Domain/Xml/ValueObjects/ElementTest.php`
  - `tests/Unit/Domain/Invoices/Templates/DFeElementTest.php`
- Impacto: corrige escape duplo em dois pontos. Em `DFeAttribute` o valor era escapado na montagem do `Attribute` e novamente na serializacao (`A&B` virava `A&amp;amp;B`); em `Element`/`Attribute` o valor vindo do parsing ja chegava escapado como no XML de origem e era escapado outra vez no round-trip (`A&amp;B` virava `A&amp;amp;B`). Breaking change para quem dependia do escape automatico: a partir daqui o valor cru precisa ser sanitizado antes de chegar ao dominio.
- Evidencia: round-trip `parse -> __toString` passou a devolver o XML de origem byte a byte (`<root ref="A&amp;B"><tag>5&lt;3</tag></root>`); suite completa com 1687 aprovados (2107 assercoes) e `composer lint` sem apontamentos.

### Changed

- Escopo: Tests/Domain
- Descricao: Reescrita da suite unitaria de `Element` com secoes `properties` e `methods`), repondo a cobertura perdida na consolidacao da API publica feita em `a29faed` (`addAttribute`/`addChild`/`insertAt`/`set` -> `add`/`remove`/`replace`). Passam a ter teste direto `__construct()`, `add()`, `remove()`, `replace()` e `isSet()` — os quatro metodos usados por `DFeElement::sync()` para reconciliar o `source` na serializacao —, alem de novos casos de `parse()` para tag autocontida (com e sem espaco final) e tags aninhadas homonimas.
- Arquivos:
  - `tests/Unit/Domain/Xml/ValueObjects/ElementTest.php`
- Impacto: apenas testes; nenhuma alteracao em `src/`. Reduz risco de regressao silenciosa na reconciliacao de filhos e atributos do `DFeElement`.
- Evidencia: `./vendor/bin/pest tests/Unit/Domain/Xml/ValueObjects/ElementTest.php` passou de 23 para 63 testes aprovados (121 assercoes); suite completa com 1669 aprovados e `composer lint` sem apontamentos.

- Escopo: Tests/Domain
- Descricao: Reescrita da suite unitaria de `Attribute` com secoes `properties` e `methods`). Passam a ter teste direto as tres propriedades promovidas (`$name`, `$value`, `$parentTagName`) quanto a tipo, obrigatoriedade e imutabilidade (`readonly`), o contrato do construtor (tres argumentos obrigatorios, valor vazio aceito) e novos casos de `__toString()`: valor vazio, decimal, caracteres nao-ascii preservados, escape combinado e ausencia do nome da tag pai na serializacao.
- Arquivos:
  - `tests/Unit/Domain/Xml/ValueObjects/AttributeTest.php`
- Impacto: apenas testes; nenhuma alteracao em `src/`. Fixa o contrato da camada que escapa valores de atributo antes da serializacao XML.
- Evidencia: `./vendor/bin/pest tests/Unit/Domain/Xml/ValueObjects/AttributeTest.php` passou de 5 para 27 testes aprovados (41 assercoes); suite completa com 1689 aprovados e `composer lint` sem apontamentos.

## 2026-07-29

### Added

- Escopo: Tests/Infra
- Descricao: Criada a suite unitaria dedicada para `XmlStringIterator` cobrindo contrato publico (`loadFrom`, `get`, `list` e propriedades computadas), fluxos de erro com candidato nao carregado e cenarios de regressao para parsing textual de XML.
- Arquivos:
  - `tests/Unit/Infra/Parses/XmlStringIteratorTest.php`
- Impacto: aumenta cobertura de componente critico de parsing e reduz risco de regressao silenciosa em iteracao de tags, atributos e conteudo interno.
- Evidencia: execucao de `./vendor/bin/pest tests/Unit/Infra/Parses/XmlStringIteratorTest.php` com 20 testes aprovados.

### Fixed

- Escopo: Infra/Parses
- Descricao: Corrigidos dois bugs no `XmlStringIterator`: deteccao incorreta de tag autocontida quando havia `/` em valor de atributo e fechamento incorreto em tags aninhadas com mesmo nome; tambem ajustada verificacao de existencia de tag quando encontrada na posicao zero da string.
- Arquivos:
  - `src/Infra/Parses/XmlStringIterator.php`
- Impacto: melhora a robustez do parser para XMLs com atributos contendo caminho (`c:/...`) e para estruturas aninhadas homonimas, preservando compatibilidade da API publica.
- Evidencia: regressao validada pela suite de `XmlStringIterator` e pelo teste consumidor `./vendor/bin/pest tests/Unit/Domain/Xml/ValueObjects/ElementTest.php`.

## 2026-07-11

### Docs

- Escopo: Governanca/Projeto
- Descricao: Adicionados o arquivo de licenca do projeto e um historico dedicado para rastrear alteracoes de namespace raiz e convencoes relacionadas.
- Arquivos:
  - `LICENSE`
  - `docs/history/NAMESPACE_HISTORY.md`
- Impacto: melhora a conformidade documental do repositorio e cria rastreabilidade explicita para futuras migracoes de namespace.
- Evidencia: licenca alinhada ao `composer.json` (`GPL-3.0-only`) e baseline inicial do namespace `BradiApi\\` documentado no historico.

### Added

- Escopo: Governanca/Skills
- Descricao: Criada a skill invocavel `test-fix-workflow` em `.github/skills/` e exposto o slash command correspondente com acessos explicitos para leitura, edicao e validacao do fluxo de correcao da primeira falha.
- Arquivos:
  - `.github/skills/test-fix-workflow/SKILL.md`
  - `.github/prompts/test-fix-workflow.prompt.md`
- Impacto: padroniza a invocacao do fluxo assistido diretamente pelo chat e reduz falhas por falta de ferramentas disponiveis durante a execucao.
- Evidencia: validacao estrutural dos arquivos de customizacao e alinhamento ao ADR-0002.

### Changed

- Escopo: Governanca/Skills
- Descricao: Corrigida a configuracao do slash command `test-fix-workflow` para usar aliases de ferramentas suportados e um custom agent dedicado ao fluxo.
- Arquivos:
  - `.github/agents/test-fix-workflow.agent.md`
  - `.github/prompts/test-fix-workflow.prompt.md`
- Impacto: evita perda de acesso a leitura, edicao e execucao durante a invocacao do workflow pelo chat.
- Evidencia: configuracao alinhada a referencia oficial de prompts e agents para `tools: [read, edit, search, execute, todo]`.

### Docs

- Escopo: Governanca/Skills
- Descricao: Adicionado template operacional de skill para fluxo de correcao de testes com loop de validacao e commits segmentados por escopo.
- Arquivos:
  - `docs/skills/TEST_FIX_WORKFLOW_SKILL_TEMPLATE.md`
- Impacto: acelera reuso do processo em sessoes futuras e reduz variabilidade de execucao.
- Evidencia: template derivado de execucao validada e formalizada no ADR-0002.

### Process

- Escopo: Testes/Governanca
- Descricao: Formalizado fluxo assistido para correcao de testes com loop de validacao e commits segmentados por escopo (`src` e `tests`) no padrao conventional commits.
- Arquivos:
  - `docs/history/adr/ADR-0002-fluxo-assistido-correcao-testes.md`
  - `docs/history/DECISIONS.md`
- Impacto: aumenta previsibilidade do ciclo de correcao, melhora rastreabilidade de mudancas e prepara base para futura skill de automacao.
- Evidencia: execucao de referencia em 2026-07-11 com `composer lint` e `composer test:ci` verdes, e commits separados por escopo.

### Changed

- Escopo: Build
- Descricao: Devcontainer passou a refletir `.gitconfig` e chaves SSH do host dentro do container para manter identidade Git e autenticacao por SSH em pull/push/clone.
- Arquivos:
  - `.devcontainer/devcontainer.json`
  - `.devcontainer/setup-git-credentials.sh`
- Impacto: reduz setup manual apos rebuild e evita falhas de permissao do OpenSSH ao sincronizar as credenciais do host para o usuario remoto do container.
- Evidencia: validacao local prevista com `jq` no JSON do devcontainer e `bash -n` no script de sincronizacao.

### Process

- Escopo: Governanca
- Descricao: Adicionado check local de historico via script para validar mudanca relevante de codigo sem atualizacao de CHANGELOG/ADR.
- Arquivos:
  - `scripts/check-history.sh`
  - `composer.json`
  - `CONTRIBUTING.md`
  - `.github/workflows/quality-checks.yml`
- Impacto: reduz risco de merge sem rastreabilidade de historico e alinha validacao manual local ao gate de PR.
- Evidencia: `composer history:check`, pipeline de CI para `composer lint` e `composer test:ci` em PR/push.

## 2026-07-10

### Added

- Escopo: Governanca
- Descricao: Criados arquivos base de diretrizes e historico para trabalho com XP + agentes de IA.
- Arquivos:
  - `AGENTS.md`
  - `docs/PROJECT_GUIDELINES.md`
  - `docs/history/CHANGELOG.md`
  - `docs/history/DECISIONS.md`
  - `docs/history/adr/ADR-0000-template.md`
  - `docs/history/adr/ADR-0001-governanca-xp-agentes.md`
- Impacto: padroniza processo de desenvolvimento, decisao e rastreabilidade.
- Evidencia: definicao documental inicial (sem mudanca de runtime).
