# Installation

- run this command:
```bash
git clone https://github.com/loaidev64/sare3_backend.git

cd sare3_backend

composer i

cp .env.example .env

php artisan migrate --seed

php artisan storage:link
```

- everything is good to go.