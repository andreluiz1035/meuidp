provider "azurerm" {
  features {}
}

# -----------------------------
# Resource Group
# -----------------------------
resource "azurerm_resource_group" "aci" {
  name     = var.aci_resource_group
  location = var.location
}

# -----------------------------
# ACR existente
# -----------------------------
data "azurerm_container_registry" "acr" {
  name                = var.acr_name
  resource_group_name = var.acr_resource_group
}

# -----------------------------
# Credenciais do ACR (ADMIN ENABLED)
# -----------------------------
locals {
  acr_username = data.azurerm_container_registry.acr.admin_username
  acr_password = data.azurerm_container_registry.acr.admin_password
}

# -----------------------------
# Container Group (ACI)
# -----------------------------
resource "azurerm_container_group" "app" {
  name                = var.aci_name
  location            = azurerm_resource_group.aci.location
  resource_group_name = azurerm_resource_group.aci.name
  os_type             = "Linux"

  ip_address_type = "Public"
  dns_name_label  = var.aci_name

  restart_policy = "Always"

  container {
    name  = "app"

    image = "${data.azurerm_container_registry.acr.login_server}/${var.container_image}"

    cpu    = "0.5"
    memory = "1.0"

    ports {
      port     = 80
      protocol = "TCP"
    }

    # 🔐 Autenticação no ACR
    image_registry_credential {
      server   = data.azurerm_container_registry.acr.login_server
      username = local.acr_username
      password = local.acr_password
    }
  }
}