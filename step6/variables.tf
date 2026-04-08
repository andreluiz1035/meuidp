variable "aci_name" {
  default = "meuidp123xyz-aci-dns"
}

variable "aci_resource_group" {
  default = "rg-idp"
}

variable "container_image" {
  default = "meuacr123xyz.azurecr.io/idp:latest"
}

variable "location" {
  default = "brazilsouth"
}