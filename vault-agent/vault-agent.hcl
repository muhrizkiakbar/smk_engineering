exit_after_auth = false

auto_auth {
  method "approle" {
    mount_path = "auth/approle"
    config = {
      role_id_file_path = "/vault/role_id"
      secret_id_file_path = "/vault/secret_id"
    }
  }
}

template {
  source      = "./vault/templates/adaro_laravel.env"
  destination = "./.env"
  perms       = 0644
}

vault {
  address = "https://vault.telemetry-adaro.id:8200"
}

api_addr = "https://vault.telemetry-adaro.id:8200"
cluster_addr = "https://vault.telemetry-adaro.id:8201"
