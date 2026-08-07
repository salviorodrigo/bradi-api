#!/usr/bin/env bash

set -euo pipefail

sshd_config_file="/etc/ssh/sshd_config.d/10-devcontainer.conf"

if ! command -v sshd >/dev/null 2>&1; then
    echo "OpenSSH Server ainda nao esta instalado neste container. Reconstrua o dev container para habilitar SSH." >&2
    exit 0
fi

sudo mkdir -p /run/sshd

sudo ssh-keygen -A >/dev/null 2>&1 || true

sudo mkdir -p "$(dirname "${sshd_config_file}")"

sudo tee "${sshd_config_file}" > /dev/null <<'EOF'
Port 2222
ListenAddress 0.0.0.0
PubkeyAuthentication no
PasswordAuthentication yes
PermitEmptyPasswords yes
UsePAM no
KbdInteractiveAuthentication no
ChallengeResponseAuthentication no
PermitRootLogin no
AllowUsers vscode
EOF

# Modo dev local: remove senha do usuario vscode para login sem credencial forte.
sudo passwd -d vscode >/dev/null 2>&1 || true

if pgrep -x sshd >/dev/null 2>&1; then
    sudo pkill -x sshd
fi

sudo /usr/sbin/sshd
