# AGENTS.md

Este arquivo define como agentes de IA devem atuar neste repositório.

## Objetivo

- Entregar mudanças pequenas, seguras e testadas.
- Preservar clareza de domínio (NFe/NFCe) e previsibilidade arquitetural.

## Regras de Implementacao

- Funcoes pequenas: preferir 4-20 linhas, dividir quando crescer.
- Arquivos pequenos: manter abaixo de 500 linhas; ideal 200-300.
- SRP: uma responsabilidade por classe/modulo.
- Nomes grepaveis: evitar nomes genericos como `data`, `handler`, `manager`, `service`.
- Tipos explicitos: toda API publica deve ter tipos claros (PHP 8.4).
- Evitar duplicacao: extrair logica compartilhada.
- Fluxo de controle: preferir guard clauses e early return; no maximo 2 niveis de aninhamento.
- Erros com contexto: mensagens devem informar valor recebido e formato esperado.

## Comentarios e Docblocks

- Escrever contexto e proveniencia (por que existe), nao o obvio (o que o codigo ja mostra).
- Manter comentarios de contexto durante refactors.
- Em logica nao trivial, indicar restricao de negocio, bug historico ou referencia de decisao.

## Testes e Qualidade

- Todo comportamento novo deve ter teste.
- Todo bug corrigido deve receber teste de regressao.
- Antes de concluir tarefa:
  - `composer lint`
  - `composer test`
- Se alterar comportamento em varios modulos, rodar tambem `composer test:ci`.

## Dependencias e Testabilidade

- Injetar dependencias por construtor ou parametro, evitar acoplamento direto.
- Encapsular integracoes externas atras de interfaces/abstracoes do projeto.

## Estrutura e Navegacao

- Seguir convencoes de pastas existentes em `src/Domain`, `src/Infra` e `tests`.
- Preferir caminhos previsiveis e nomes de arquivo orientados ao dominio.

## Historico e Memoria do Projeto

- Mudancas relevantes devem atualizar `docs/history/CHANGELOG.md`.
- Decisoes arquiteturais ou de processo devem atualizar `docs/history/DECISIONS.md` e criar ADR em `docs/history/adr/`.
- Registrar decisoes como fatos verificaveis, com contexto e consequencias.

## Fluxo XP com Agente

- Trabalhar em ciclos curtos: Red -> Green -> Refactor.
- Commits pequenos, com uma intencao por commit.
- Integracao continua: manter lint e testes sempre verdes.
- Se houver duvida de regra de dominio, explicitar premissas antes de codar.
