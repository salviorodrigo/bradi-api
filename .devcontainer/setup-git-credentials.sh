#!/usr/bin/env bash

set -euo pipefail

host_ssh_dir="/tmp/host-ssh"
target_ssh_dir="${HOME}/.ssh"
gitconfig_path="${HOME}/.gitconfig"

if [[ ! -f "${gitconfig_path}" ]]; then
    echo "Git config nao encontrado em ${gitconfig_path}. Verifique o mount do devcontainer." >&2
    exit 1
fi

if [[ ! -d "${host_ssh_dir}" ]]; then
    echo "Diretorio SSH do host nao encontrado em ${host_ssh_dir}. Verifique o mount do devcontainer." >&2
    exit 1
fi

mkdir -p "${target_ssh_dir}"
chmod 700 "${target_ssh_dir}"

find "${target_ssh_dir}" -mindepth 1 -maxdepth 1 -exec rm -rf {} +
cp -a "${host_ssh_dir}/." "${target_ssh_dir}/"

find "${target_ssh_dir}" -type d -exec chmod 700 {} +

if [[ -f "${target_ssh_dir}/config" ]]; then
    chmod 600 "${target_ssh_dir}/config"
fi

if [[ -f "${target_ssh_dir}/known_hosts" ]]; then
    chmod 644 "${target_ssh_dir}/known_hosts"
fi

while IFS= read -r private_key; do
    chmod 600 "${private_key}"
done < <(find "${target_ssh_dir}" -type f \( -name "id_*" ! -name "*.pub" \))

while IFS= read -r public_key; do
    chmod 644 "${public_key}"
done < <(find "${target_ssh_dir}" -type f -name "*.pub")

git config --global --get user.name >/dev/null 2>&1 || echo "Aviso: user.name nao definido em ${gitconfig_path}." >&2
git config --global --get user.email >/dev/null 2>&1 || echo "Aviso: user.email nao definido em ${gitconfig_path}." >&2