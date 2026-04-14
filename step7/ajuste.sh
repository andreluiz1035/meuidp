#!/bin/bash

echo "=============================="
echo "STEP 7 - Inject IDP IP into hosts"
echo "=============================="

# ------------------------------
# 1. Get IDP IP
# ------------------------------
IDP_IP=$(az container show \
  -g rg-aci \
  -n meuidp123xyz \
  --query ipAddress.ip \
  -o tsv)

echo "IDP IP encontrado: $IDP_IP"

# ------------------------------
# 2. App container name
# ------------------------------
APP_NAME="meuapp123xyz"
IDP_HOST="meuidp123xyz-aci-dns-dns.brazilsouth.azurecontainer.io"

# ------------------------------
# 3. Inject into /etc/hosts
# ------------------------------
echo "Injetando no /etc/hosts do container..."

az container exec \
  -g rg-aci \
  -n $APP_NAME \
  --container-name app \
  --exec-command "/bin/sh -c 'echo \"$IDP_IP $IDP_HOST\" >> /etc/hosts'"

echo "=============================="
echo "Concluído Step 7"
echo "IDP $IDP_HOST apontando para $IDP_IP no container do app"
echo "=============================="






