# Movie Application

A web-based movie application built with PHP and MySQL/PostgreSQL, containerized with Docker, and deployed on Render.

## Features

- Browse and search movies
- User authentication (login/register)
- Add, edit, and delete movies
- Responsive design

## Live Demo

Check out the live demo: [https://movie-app-grof.onrender.com](https://movie-app-grof.onrender.com)

## Prerequisites

- Docker (for local development)
- Docker Compose (for local development)
- PHP 8.1+
- MySQL/PostgreSQL database
- Composer (PHP package manager)

## Local Development Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/roypushpak/movie.git
   cd movie
   ```

2. **Copy environment file**
   ```bash
   cp .env.example .env
   ```
   Update the `.env` file with your database credentials and other settings.

3. **Build and start the containers**
   ```bash
   docker-compose up -d --build
   ```

4. **Install PHP dependencies**
   ```bash
   docker-compose exec app composer install
   ```

5. **Set up the database**
   ```bash
   # Run migrations if you have any
   # docker-compose exec app php migrations/run.php
   ```

6. **Access the application**
   Open http://localhost:8080 in your browser.

## Project Structure

```
movie/
├── app/                 # Application code
│   ├── controllers/     # Controller classes
│   ├── core/           # Core framework files
│   ├── models/         # Database models
│   └── views/          # View templates
├── docker/             # Docker configuration
├── public/             # Publicly accessible files
└── .env.example        # Example environment variables
```

## Environment Variables

Create a `.env` file in the root directory with the following variables:

```
DB_HOST=your_database_host
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
DB_PORT=3306  # or 5432 for PostgreSQL
```

## Deployment

This application is configured for deployment on [Render](https://render.com/). The deployment is automated via the `render.yaml` file.

### Manual Deployment

1. Push your code to a GitHub repository
2. Connect your Render account to the repository
3. Create a new Web Service on Render and select your repository
4. Configure the build command and start command:
   - Build Command: `./build.sh`
   - Start Command: `./start.sh`
5. Add environment variables in the Render dashboard
6. Deploy!

## Technologies Used

- PHP 8.1
- MySQL/PostgreSQL
- Docker
- Apache Web Server
- Bootstrap 5 (for frontend)
- Composer (for dependency management)

## License

This project is open source and available under the [MIT License](LICENSE).

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Support

For support, please open an issue in the GitHub repository.

---

Developed by [Your Name] | [GitHub](https://github.com/roypushpak)
