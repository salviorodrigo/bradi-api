# ADR Rapido para PR

Use este bloco durante a abertura do PR quando houver decisao arquitetural ou processual.

```md
## ADR (rascunho)

- Status: Proposed
- Contexto: qual problema/risco motivou a decisao?
- Decisao: qual escolha foi feita?
- Alternativas consideradas: quais opcoes foram rejeitadas e por que?
- Consequencias: impactos positivos, trade-offs e riscos.
- Revisitar em: YYYY-MM-DD
```

Depois, transforme o rascunho em ADR formal usando o template:

- `docs/history/adr/ADR-0000-template.md`

E atualize:

- `docs/history/DECISIONS.md`
- `docs/history/CHANGELOG.md` (quando aplicavel)