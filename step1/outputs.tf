output "acr_login_server" {
  value = azurerm_container_registry.acr.login_server
}

output "rg_name" {
  value = azurerm_resource_group.main.name
}