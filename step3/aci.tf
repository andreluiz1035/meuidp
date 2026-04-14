provider "azurerm" {
  features {}
}


#  Managed Identity

  identity {
    type = "SystemAssigned"
  }

sleep 1800

# Permissão para o ACI puxar imagem do ACR
resource "azurerm_role_assignment" "acr_pull" {
  principal_id         = azurerm_container_group.app.identity[0].principal_id
  role_definition_name = "AcrPull"
  scope                = data.azurerm_container_registry.acr.id
}

1800

# Resource Group do ACI
resource "azurerm_resource_group" "aci" {
  name     = var.aci_resource_group
  location = var.location
}

# Referência ao ACR existente
data "azurerm_container_registry" "acr" {
  name                = var.acr_name
  resource_group_name = var.acr_resource_group
}

# Container Group (ACI)
resource "azurerm_container_group" "app" {
  name                = var.aci_name
  location            = azurerm_resource_group.aci.location
  resource_group_name = azurerm_resource_group.aci.name
  os_type             = "Linux"

  ip_address_type = "Public"
  dns_name_label  = var.aci_name

  #  Reinício automático (resolve timing do ACR)
  restart_policy = "Always"

  

  container {
    name   = "app"

    image  = "${data.azurerm_container_registry.acr.login_server}/${var.container_image}"

    cpu    = "0.5"
    memory = "1.0"

    ports {
      port     = 80
      protocol = "TCP"
    }
  }
}

