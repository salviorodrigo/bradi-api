# ADR-0003 - Doubles Manuais em `tests/Doubles` no Lugar de Mockery

- Status: Accepted
- Data: 2026-08-11
- Dono: Time Bradi NFE API
- Tags: testes, dependencias, php-8.5

## Contexto

O projeto declarava `mockery/mockery` em `require-dev` desde o inicio, mas nenhum teste jamais chamou `Mockery::mock()`: toda a suite usa doubles manuais em `tests/Doubles/`. A pergunta recorrente e se esses doubles poderiam ser trocados por mocks, reduzindo codigo de teste.

A avaliacao foi feita arquivo a arquivo e a resposta e nao, por duas razoes independentes e verificadas na pratica.

**1. Os doubles `DFe*` nao sao colaboradores - sao o proprio SUT.**
`FakeDFeElement`, `FakeOtherDFeElement`, `FakeDFeGroupWithAttribute`, `FakeDFeSequenceGroup`, `FakeDFeElementCollection`, `FakeDFeAttribute` e `FakeOtherDFeAttribute` sao as implementacoes concretas minimas das classes abstratas `DFeElement`, `DFeAttribute` e `DFeElementCollection`. O comportamento sob teste e dirigido por estrutura estatica que um mock nao consegue produzir:

- Constantes de classe (`FIELD_NAME`, `CHILD_ELEMENTS_ON_SEQUENCE`, `CHILD_ATTRIBUTES_ON_SEQUENCE`, `BASE_CLASS`). Mockery nao sobrescreve constantes: `Mockery::mock(DFeElement::class)` gera a classe, mas `FIELD_NAME` continua `null` e o guard clause do construtor rejeita a instancia.
- Propriedades publicas tipadas. `DFeElement::listChildElements()` descobre os filhos por `ReflectionClass::getProperties()`, lendo o tipo declarado de cada propriedade. Mock tem propriedades dinamicas, sem tipo declarado - a reflexao nao enxergaria nenhum filho.
- Construtor `final`, que o Mockery pula por padrao, deixando `fieldURI` e `validationService` nao inicializados.

Os doubles invalidos de proposito (`FakeDFeElementWithoutFieldName`, `FakeDFeElementWithEmptyFieldName`, `FakeDFeAttributeWithoutFieldName`) existem justamente para serem subclasses reais que disparam o guard clause; um mock nao reproduz esse cenario.

**2. Mockery nao suporta property hooks do PHP 8.4+.**
`FakeXmlIterator` era o unico candidato plausivel: implementa a interface `XmlIterator` e e usado em um unico ponto. A conversao falha com fatal error, porque a interface declara seis propriedades virtuais (`$candidate {get;}`, `$name {get;}`, `$value {get;}`, `$textContent {get;}`, `$attributes {get;}`, `$children {get;}`) e o gerador de mocks da 1.6.12 nao emite hooks:

```
Fatal error: Class Mockery_0_..._XmlIterator contains 6 abstract methods and must
therefore be declared abstract ... (XmlIterator::$candidate::get, $name::get, ...)
```

Como os protocolos do dominio (`src/Domain/**/Protocols`) usam property hooks por padrao, essa limitacao atinge qualquer interface que se queira mockar aqui, nao apenas `XmlIterator`.

## Decisao

1. Manter os doubles manuais em `tests/Doubles/` como o mecanismo unico de test double do projeto.
2. Remover `mockery/mockery` de `require-dev`. Uma dependencia com zero chamadas e que nao consegue mockar os protocolos do dominio e apenas peso de instalacao e sugestao enganosa de que mocks sao uma opcao disponivel.
3. Duplicatas estruturais entre doubles sao aceitas: cada um representa um contrato de tag/atributo distinto e a duplicacao e superficial (metodos de validador vazios).

## Alternativas consideradas

- Manter Mockery instalado "para quando der":
  - Pro: disponivel sem novo `composer require`.
  - Contra: dependencia morta que ninguem exercita; a suite nao detecta se ela quebrar numa atualizacao de PHP.
- Aguardar suporte a property hooks no Mockery e migrar `FakeXmlIterator`:
  - Pro: um double a menos no futuro.
  - Contra: economiza um unico arquivo de ~40 linhas usado em um unico teste; nao justifica a dependencia.
- Trocar por PHPUnit `createMock()`:
  - Pro: ja vem com o Pest, sem dependencia extra.
  - Contra: o gerador do PHPUnit tambem nao cobre os casos acima (constantes, propriedades tipadas lidas por reflexao); resolveria no maximo `FakeXmlIterator`.

## Consequencias

- Positivas:
  - `require-dev` passa a refletir o que a suite realmente usa.
  - Elimina a duvida recorrente "por que nao usamos mocks aqui?", agora respondida por escrito.
  - Doubles reais exercitam construtor, tipos e constantes de verdade - mais proximos de producao que um mock.
- Negativas:
  - Stubar um colaborador novo exige escrever uma classe, nao uma linha de `->allows()`.
  - Mais arquivos em `tests/Doubles/`.
- Riscos e mitigacoes:
  - Risco: doubles saem de sincronia com o contrato real (foi o que aconteceu com `FakeValidationService`, orfao desde `91558f1` e removido em 2026-08-11).
  - Mitigacao: doubles que implementam protocolo quebram na assinatura quando o contrato muda; doubles orfaos devem ser removidos junto com o ultimo consumidor.

## Plano de rollout

- Passo 1: remover `mockery/mockery` de `composer.json` e atualizar `composer.lock`.
- Passo 2: revalidar com `composer lint` e `composer test`.
- Passo 3: registrar a decisao em `DECISIONS.md` e `CHANGELOG.md`.

## Criterios de sucesso

- Suite verde sem Mockery instalado.
- Nenhuma ocorrencia de `Mockery` fora de `vendor/`.

## Revisao

- Revisitar em: 2027-02-11
- Condicoes para substituir/invalidar esta decisao:
  - Mockery (ou outro framework) passar a gerar property hooks, e surgir um numero relevante de colaboradores baseados em protocolo a stubar.
  - Os protocolos do dominio deixarem de usar property hooks.
  - `tests/Doubles/` crescer a ponto de a manutencao dos doubles custar mais que a dependencia.
