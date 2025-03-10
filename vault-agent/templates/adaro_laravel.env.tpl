{{ with secret "kv/data/laravel" }}
APP_NAME=Laravel
APP_ENV=production
APP_KEY={{ .Data.data.APP_KEY }}
APP_DEBUG=false
APP_URL={{ .Data.data.APP_URL }}

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE={{ .Data.data.DB_DATABASE }}
DB_USERNAME={{ .Data.data.DB_USERNAME }}
DB_PASSWORD={{ .Data.data.DB_PASSWORD }}

# Tambahkan variabel environment lainnya sesuai kebutuhan aplikasi Anda
{{ end }}
