## Resumo

Este PR adiciona uma camada de qualidade tecnica e governanca local para reduzir risco na integracao da branch feat/load-nfe-invoices na main.

Principais entregas:
- Adicionado workflow de CI para qualidade com lint e testes paralelos.
- Adicionado script local de validacao de historico de mudancas relevantes.
- Adicionado comando Composer para executar a validacao de historico.
- Ajustado guia de contribuicao para tornar a validacao de historico recomendada (sem bloquear push).
- Atualizado CHANGELOG com rastreabilidade das mudancas de processo.

## Tipo de mudanca

- [ ] feat
- [ ] fix
- [ ] refactor
- [ ] test
- [x] docs
- [x] chore

## Checklist de Qualidade (XP)

- [x] Segui ciclo Red -> Green -> Refactor (quando aplicavel)
- [x] Adicionei/atualizei testes para comportamento novo ou bug corrigido
- [x] Rodei `composer lint`
- [x] Rodei `composer test:ci`

## Checklist de Governanca e Contexto

- [x] Atualizei `docs/history/CHANGELOG.md` para mudanca relevante
- [ ] Se houve decisao arquitetural/processual, atualizei `docs/history/DECISIONS.md`
- [ ] Se houve decisao arquitetural/processual, criei ADR em `docs/history/adr/`
- [x] Mantive comentarios de contexto/proveniencia no codigo alterado

## Risco e Impacto

- Risco: baixo
- Impacto esperado: maior confiabilidade na validacao automatica de qualidade em PR/push e reforco de rastreabilidade documental.
- Plano de rollback: reverter commit a7dd545 para remover workflow/script e retornar ao estado anterior.

## Evidencias

- `composer lint`: sucesso
- `composer test:ci`: 1330 testes passando em paralelo (12 processos)
- `composer history:check`: sucesso
- Validacao YAML dos workflows: sucesso

## ADR Rapido (quando aplicavel)

Nao aplicavel neste PR.
