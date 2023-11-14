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
5. Run migrations `vendor/bin/sail artisan migrate:fresh` //fresh drops old tables 
6. You should see app on 127.0.0.1:3000

## Troubleshooting
There can be problem with permissions so give ./vendor 777
If you get error in `sail up -d` "sth is not a directory" go to `cd vendor/laravel/sail/database` and run `rm -rf pgsql`

Error - Error response from daemon: failed to create shim: OCI runtime create failed: container_linux.go:380: starting container process caused: process_linux.go:545: container init caused: rootfs_linux.go:75: mounting "/run/desktop/mnt
/host/wsl/docker-desktop-bind-mounts/Ubuntu/74c07ac95825536cbef3faa8aa10ab226c92cc219c8d03eb697d872067e094f2" to rootfs at "/docker-entrypoint-initdb.d/10-create-testing-database.sql" caused: mount through procfd: no such file o
r directory: unknown
go to `cd vendor/laravel/sail/database` and run `rm -rf pgsql`
Old instruction
2. `docker compose up -d` if failed run - `docker run --rm --interactive --tty -v $(pwd):/app composer install` (this should complete pull)
4. `sudo docker exec -it filament-features-testing-laravel.test-1 /bin/bash`
5. go to /etc/php/8.2/cli/php.ini (sth like that)
6. install editor e.g. vim (apt-get update apt-get install vim)
7. uncomment (delete ';') "extension: intl". This is around the half of the file
8. cd to your project in container
9. run `composer install`
10. exit container
11. `docker compose down`
