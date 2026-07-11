#!/usr/bin/env bash

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

BASE_REF="${1:-origin/main}"
HEAD_REF="${2:-HEAD}"

if ! git rev-parse --verify "$BASE_REF" >/dev/null 2>&1; then
    if git rev-parse --verify main >/dev/null 2>&1; then
        BASE_REF="main"
    else
        BASE_REF="HEAD~1"
    fi
fi

if ! git rev-parse --verify "$HEAD_REF" >/dev/null 2>&1; then
    echo "Erro: referencia de destino invalida: $HEAD_REF"
    exit 1
fi

CHANGED_FILES="$(git diff --name-only "$BASE_REF" "$HEAD_REF")"

if [[ -z "$CHANGED_FILES" ]]; then
    echo "Nenhuma mudanca detectada entre $BASE_REF e $HEAD_REF."
    exit 0
fi

echo "Mudancas detectadas entre $BASE_REF e $HEAD_REF:"
echo "$CHANGED_FILES"

CODE_RELEVANT="false"
HISTORY_UPDATED="false"

if echo "$CHANGED_FILES" | grep -Eq '^(src/|tests/|composer\.json|composer\.lock|phpunit\.xml|grumphp\.yml)'; then
    CODE_RELEVANT="true"
fi

if echo "$CHANGED_FILES" | grep -Eq '^(docs/history/CHANGELOG\.md|docs/history/adr/ADR-[0-9]{4}.*\.md)'; then
    HISTORY_UPDATED="true"
fi

if [[ "$CODE_RELEVANT" == "true" && "$HISTORY_UPDATED" != "true" ]]; then
    echo "Erro: houve mudanca relevante de codigo sem atualizacao de historico."
    echo "Atualize docs/history/CHANGELOG.md e, quando aplicavel, crie um ADR em docs/history/adr/."
    exit 1
fi

echo "Check de historico aprovado."
