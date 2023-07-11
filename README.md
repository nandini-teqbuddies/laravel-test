## Laravel Test

### Prerequisite

-   Php 8.2
-   Composer version 2
-   Stop local mysql or apache to make 3306 and 80 port available

### Setup

1.

```bash
git clone https://github.com/nandini-teqbuddies/laravel-test.git
```

2.

```bash
cd laravel-test
```

3.

```bash
cp .env.example .env
```

4.

```bash
composer install
```

5.

```bash
php artisan migrate --seed
```

6.

```bash
php artisan sail:install
```

7.

```bash
./vendor/bin/sail build
```

8.

```bash
./vendor/bin/sail up -d
```

9. 
```bash
./vendor/bin/sail npm run dev
```

10. Visit [http://localhost](http://localhost)