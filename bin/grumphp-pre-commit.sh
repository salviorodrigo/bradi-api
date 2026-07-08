#!/usr/bin/env sh

set -eu

# Lista apenas arquivos PHP em stage (add/copy/modify/rename).
STAGED_PHP_FILES=$(git diff --cached --name-only --diff-filter=ACMR -- '*.php' || true)

# Se nao houver PHP em stage, nao ha o que validar neste hook.
if [ -z "$STAGED_PHP_FILES" ]; then
    exit 0
fi

# Aplica fixes de estilo apenas no que esta em stage e volta para o index.
./vendor/bin/duster fix $STAGED_PHP_FILES
git add $STAGED_PHP_FILES

# Roda os testes apenas no conjunto "dirty" do Pest.
composer test -- --dirty