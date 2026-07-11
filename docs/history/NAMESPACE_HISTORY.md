# HISTORICO DE NAMESPACE

Registro de alteracoes do namespace raiz e convencoes de namespace do projeto.

## Formato

- Data: YYYY-MM-DD
- Tipo: Added | Changed | Fixed | Deprecated | Removed
- Namespace anterior: valor anterior (ou N/A para baseline)
- Namespace novo: valor novo
- Escopo: src, tests, autoload, autoload-dev
- Motivacao: razao da mudanca
- Evidencia: comando/arquivo que comprova a mudanca

---

## 2026-07-11

### Added

- Namespace anterior: N/A
- Namespace novo: BradiApi\\
- Escopo: autoload e codigo-fonte
- Motivacao: estabelecer baseline historico formal para futuras migracoes de namespace.
- Evidencia:
  - composer.json (autoload.psr-4: BradiApi\\ => src/)
  - composer.json (autoload-dev.psr-4: BradiApi\\Tests\\ => tests/)
  - src/* (declaracoes namespace BradiApi\\...)
