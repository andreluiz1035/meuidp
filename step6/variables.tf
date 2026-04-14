variable "aci_name" {
  description = "Nome do Container Group (ACI)"
  default     = "meuidp123xyz-aci-dns"
}

variable "aci_resource_group" {
  description = "Resource Group onde o ACI será criado"
  default     = "rg-idp"
}

variable "acr_name" {
  description = "Nome do Azure Container Registry"
  default     = "meuacr123xyz"
}

variable "acr_resource_group" {
  description = "Resource Group onde está o ACR"
  default     = "rg-acr"
}

variable "container_image" {
  description = "Nome da imagem no ACR (SEM o domínio)"
  default     = "idp:latest"
}

variable "location" {
  description = "Região do Azure"
  default     = "brazilsouth"
}