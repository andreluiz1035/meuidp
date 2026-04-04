provider "azurerm" {
  features {}
}

# Cria o Resource Group do ACI
resource "azurerm_resource_group" "aci" {
  name     = var.aci_resource_group
  location = var.location
}

# Container Group
resource "azurerm_container_group" "app" {
  name                = var.aci_name
  location            = azurerm_resource_group.aci.location
  resource_group_name = azurerm_resource_group.aci.name
  os_type             = "Linux"

  container {
    name   = "tiririca"
    image  = var.container_image
    cpu    = "0.5"
    memory = "1.0"

    ports {
      port     = 80
      protocol = "TCP"
    }
  }

  ip_address_type = "Public"
  dns_name_label  = "${var.aci_name}-dns"

  image_registry_credential {
    server   = "meuacr123xyz.azurecr.io"
    username = "meuacr123xyz"
    password = "Ca4uq1Y5Bm3xZIKW2xdsH5d4a1qi9pItV2uE9ytxUSww3LsMXa4QJQQJ99CDACZoyfiEqg7NAAACAZCRWaZ3"
  }
}