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

## 2026-08-11

### Added

- Escopo: Domain/Xml, Domain/Invoices, Tests
- Descricao: `DFeElement` passa a respeitar a sequencia de tags declarada pela classe concreta em `CHILD_ELEMENTS_ON_SEQUENCE` e `CHILD_ATTRIBUTES_ON_SEQUENCE` (nomes de tag/atributo, no estilo de `RequiredTagsValidator`). Na saida, `sync()` ordena o `Element` de origem via o novo `Element::sort()`, fachada sobre `ElementList::sortByNames()` e `AttributeList::sortByNames()`. Na entrada, `validateRootTag()` recusa tags filhas fora de ordem via o novo `TagsSequenceValidator`, resolvendo o TODO que existia no metodo. A constante `CHILD_ELEMENTS__ON_SEQUENCE` foi renomeada (underscore duplo era typo, sem consumidor).
- Arquivos:
  - `src/Domain/Invoices/Validators/TagsSequenceValidator.php`
  - `tests/Unit/Domain/Invoices/Validators/TagsSequenceValidatorTest.php`
  - `src/Domain/Xml/ValueObjects/Element.php`
  - `src/Domain/Xml/ValueObjects/ElementList.php`
  - `src/Domain/Xml/ValueObjects/AttributeList.php`
  - `src/Domain/Invoices/Templates/DFeElement.php`
  - `tests/Unit/Domain/Xml/ValueObjects/ElementTest.php`
  - `tests/Doubles/Domain/Invoices/NFe/FakeDFeSequenceGroup.php`
  - `tests/Doubles/Domain/Invoices/NFe/FakeOtherDFeAttribute.php`
  - `tests/Unit/Domain/Xml/ValueObjects/ElementListTest.php`
  - `tests/Unit/Domain/Xml/ValueObjects/AttributeListTest.php`
  - `tests/Unit/Domain/Invoices/Templates/DFeElementTest.php`
- Impacto: o layout do DFe declara cada grupo como `xs:sequence`, entao a ordem das tags e parte do contrato com a SEFAZ. Antes, uma tag atribuida apos o parse (ex.: um `xFant` opcional) era anexada no fim e gerava XML fora de sequencia. Breaking change no parse: XML com tags fora de ordem passa a devolver `Result` de falha em vez de ser aceito. A ordenacao e estavel (irmas homonimas como `det` preservam a ordem de leitura) e tags fora da sequencia nao sao perdidas nem recusadas, apenas vao para o fim - rejeita-las e papel de `AllowedTagsValidator`. Atributos sao ordenados na saida, mas nao validados, por a ordem nao ser significativa no XML. Constante vazia (padrao) nao altera nada, e nenhuma classe NFe declara sequencia ainda.
- Evidencia: `composer test:ci` com 1786 aprovados (2246 assercoes) e `composer lint` sem apontamentos; com a ordenacao desativada, 4 dos 5 testes de `child sequence` falham (o quinto e a regressao de "sem sequencia declarada").

### Removed

- Escopo: Tests
- Descricao: Removido o double `FakeValidationService`, orfao desde `91558f1` (`refactor(ValidationService): remove interface implementation and adjust method signatures`) e sem nenhuma referencia no repositorio.
- Arquivos:
  - `tests/Doubles/Domain/Common/FakeValidationService.php`
- Impacto: nenhum em comportamento. O double sobrescrevia `addValidator()`, `verify()` e `reset()` para sempre devolver sucesso; manter uma implementacao alternativa de `ValidationService` sem consumidor so criava risco de ela divergir do contrato real sem ninguem perceber.
- Evidencia: `grep -rn FakeValidationService` sem ocorrencias fora do proprio arquivo; `composer test` com 2270 aprovados (3146 assercoes) apos a remocao.

### Removed

- Escopo: Build, Tests, Docs
- Descricao: Removida a dependencia `mockery/mockery` de `require-dev` (e a transitiva `hamcrest/hamcrest-php`), nunca usada por nenhum teste. A decisao de manter doubles manuais em `tests/Doubles/` foi formalizada em ADR-0003.
- Arquivos:
  - `composer.json`
  - `docs/history/adr/ADR-0003-doubles-manuais-sem-mockery.md`
  - `docs/history/DECISIONS.md`
- Impacto: nenhum em comportamento; a suite nunca chamou `Mockery::mock()`. Mockery nao seria utilizavel aqui mesmo se quisessemos: nao gera property hooks do PHP 8.4+, entao nao consegue implementar os protocolos do dominio (`XmlIterator` declara seis propriedades virtuais e o mock falha com fatal error de metodos abstratos), e nao sobrescreve constantes de classe nem propriedades tipadas, que sao o mecanismo pelo qual `DFeElement` descobre filhos via reflexao. Reintroduzir a biblioteca exige `composer require --dev mockery/mockery` e revisitar a ADR.
- Evidencia: `composer why mockery/mockery` apontava apenas o proprio projeto; `grep -rn Mockery` sem ocorrencias fora de `vendor/`; `composer test` com 2270 aprovados (3146 assercoes) apos a remocao.

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
- Descricao: Reescrita e padronizacao das suites unitarias de `Element`, `Attribute`, `AttributeList` e `ElementList` (secoes `properties` e `methods`), com reposicao de cobertura do contrato publico atual, reforco dos cenarios de reconciliacao usados por `DFeElement::sync()` e ajustes pontuais de consistencia em testes/docblocks.
- Arquivos:
  - `tests/Unit/Domain/Xml/ValueObjects/ElementTest.php`
  - `tests/Unit/Domain/Xml/ValueObjects/AttributeTest.php`
  - `tests/Unit/Domain/Xml/ValueObjects/AttributeListTest.php`
  - `tests/Unit/Domain/Xml/ValueObjects/ElementListTest.php`
  - `src/Domain/Xml/ValueObjects/AttributeList.php`
  - `src/Domain/Xml/ValueObjects/ElementList.php`
- Impacto: reduz risco de regressao no pacote `Domain/Xml/ValueObjects`; em `src/`, apenas correcao de docblocks de `$records` (`@param` -> `@var`), sem mudanca de comportamento.
- Evidencia: suites atualizadas com aumento de cobertura (`ElementTest` 63, `AttributeTest` 27, `AttributeListTest` 21, `ElementListTest` 27), com `composer lint` e suite completa verdes.

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
