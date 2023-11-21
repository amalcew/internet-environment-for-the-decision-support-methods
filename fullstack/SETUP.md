## Setup
1. clone project in wsl (containers are much faster than on windows)
2. create `.env` and copy `.env.example` content there
2. `docker run --rm \
   -u "$(id -u):$(id -g)" \
   -v "$(pwd):/var/www/html" \
   -w /var/www/html \
   laravelsail/php82-composer:latest \
   composer install --ignore-platform-reqs`
3. `vendor/bin/sail up` (run `bash vendor/bin/sail up` (or `sh`) if there is a problem)
5. Run migrations `vendor/bin/sail artisan migrate:fresh` //fresh drops old tables. You need to run this only once to create tables in pgsql
6. You should see app on 127.0.0.1:3000

Starting app:
`vendor/bin/sail up` 

## Troubleshooting
There can be problem with permissions so give ./vendor 777
If you get error in `sail up -d` "sth is not a directory" go to `cd vendor/laravel/sail/database` and run `rm -rf pgsql`

Error - Error response from daemon: failed to create shim: OCI runtime create failed: container_linux.go:380: starting container process caused: process_linux.go:545: container init caused: rootfs_linux.go:75: mounting "/run/desktop/mnt
/host/wsl/docker-desktop-bind-mounts/Ubuntu/74c07ac95825536cbef3faa8aa10ab226c92cc219c8d03eb697d872067e094f2" to rootfs at "/docker-entrypoint-initdb.d/10-create-testing-database.sql" caused: mount through procfd: no such file o
r directory: unknown
go to `cd vendor/laravel/sail/database` and run `rm -rf pgsql`

