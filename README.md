<p align="center"><a href="https://viltstack.dev/" target="_blank"><img src="https://github.com/vuejs/art/blob/master/logo.png" width="120" alt="vuejs Logo"><img alt="Inertia Icon" width="120" src="https://viltstack.dev/assets/img/vilt/inertia.webp"><img src="https://github.com/laravel/art/blob/master/laravel-logo.png" width="120" alt="Laravel Logo"><img alt="Tailwind Icon" width="120" src="https://viltstack.dev/assets/img/vilt/tw.webp"></a></p>

# Music

Fullstack music website using <a href="https://github.com/vuejs/core" target="blank">Vue.js</a>, <a href="https://github.com/inertiajs/inertia" target="blank">Inertia.js</a>, <a href="https://github.com/laravel/laravel" target="blank">Laravel</a> (<a href="https://github.com/laravel/jetstream" target="blank">Jetstream</a> Starter Kit), <a href="https://github.com/tailwindlabs/tailwindcss" target="_blank">Tailwind CSS</a>.

## Install Dependencies

### Frontend:

```bash
npm install
```

### Backend:

```bash
composer install
```

## Run Project

### Frontend:

```bash
npm run dev
```

### Backend:

```bash
php artisan serve
```

Visit [localhost:8000](localhost:8000) to access the application.

## Environment Configuration

1. Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

2. Generate an application key:

```bash
php artisan key:generate
```
   

3. Update your database, mail configuration in the `.env` file.

## Database Migration

Run the following command to migrate the database:

```bash
php artisan migrate
```

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request for any enhancements or bug fixes.

## License

This project is licensed under the MIT License. See the LICENSE file for details.

## Acknowledgments

+ Thanks to the creators of Vue.js, Inertia.js, Laravel, Jetstream, and Tailwind CSS for their amazing frameworks and tools that made this project possible.
