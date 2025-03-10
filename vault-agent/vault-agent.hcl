exit_after_auth = false
pid_file = "./pidfile"

auto_auth {
  method "approle" {
    mount_path = "auth/approle"
    config = {
      role_id_file_path = "role_id"
      secret_id_file_path = "secret_id"
    }
  }
}

template {
  source      = "./templates/laravel.env.tpl"
  destination = "/path/to/your/laravel/.env"
  perms       = 0644
}

vault {
  address = "http://127.0.0.1:8200"
}
