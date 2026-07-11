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

## 2026-07-11

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
