#!/usr/bin/env bash

set -euo pipefail

if ! git rev-parse --is-inside-work-tree >/dev/null 2>&1; then
    echo "Repositorio git nao encontrado. Pulando setup do GrumPHP hooks." >&2
    exit 0
fi

# Garante comportamento padrao: hooks em .git/hooks.
git config --local --unset core.hooksPath >/dev/null 2>&1 || true

if [[ ! -x "vendor/bin/grumphp" ]]; then
    echo "GrumPHP nao encontrado em vendor/bin/grumphp. Pulando setup de hooks." >&2
    exit 0
fi

vendor/bin/grumphp git:init -n
