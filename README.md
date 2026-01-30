![Framewerq for PHP logo with a manicured hand icon](docs/FramewerqLogo.png "Framewerq for PHP")

My personal boilerplate for building quick PHP apps with SCSS support.

* Designed to work on Apache 2.4 with PHP 8.2 and 8.3
* Frequently used with MAMP on macOS with Apple Silicon and Ubuntu Server 24 LTS

## To use
- Be sure to copy `./env.template.json` to `./app/env.json`
- Add the contents of `./apache2_defaults` to your virtual host file
- The `sass.sh` script will run a watchful sass compiler
  - You may need to set this script as executable with `chmod 755 ./sass.sh`
  - This expects sass to be installed and in available under the `sass` command in the terminal

## Future plans
- Error handling for database connection and environment variable file
- Basic authentication

## Databases
- Framewerq currently is designed to use a single MySQL database with two tables:
  - `registry` where each row is a "registry entry"
  - `users` where each row is a username/password for logging in

Schemas for these tables are located in the `schemas` directory.

## Environment file
A `env.json` file is expected in the `./app/` directory. The `env.json` file follows this template:

```
{
  "environment": "dev or prod",
  "hostname": "",
  "sql_cert": "/absolute/path/to/.crt",
  "sql_uri": "",
  "sql_port": "",
  "sql_user": "",
  "sql_password": "",
  "sql_db": ""
}
```

Notes:
- The `sql_cert` may not be applicable to your MySQL setup and could be removed, although the `./app/resources/db.php` file will need to be edited
- Currently `hostname` and `environment` aren't really being used for anything

---

Developed by Alexandria 'Hannah' I. Patellis, starting in 2024

[hannahap.com](https://hannahap.com)