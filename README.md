![Project Screenshot](https://i.ibb.co/HDDPLDk/Screenshot-from-2024-11-14-12-53-18.png)

# Sports Events Task

## About The Task
A Laravel-based sports events web app with real-time updates. The system shows tournaments, seasons, matches, and results with automatic data refresh.

## Tech Stack
- PHP 8.3
- Laravel 11
- MariaDB 10.5
- Javascript (ES-6)
- Docker & Docker Compose

## Prerequisites
- Docker
- Docker Compose

## Installation

1. Clone the repository:
```bash
git clone https://github.com/deadzer0/sports-events-task.git
```

2. Navigate to the project directory:
```bash
cd sports-events-task
```

3. Rename .env.example file to .env:
```bash
cp .env.example .env
```

3. Start the Docker containers:
```bash
docker compose up -d --build
```

This command will:
- Build and start all containers
- Install all dependencies
- Run database migrations
- Run database seeders
- Set up the application

## Access Points
- Web Application: http://localhost:8000
- phpMyAdmin: http://localhost:8081
    - Username: root
    - Password: 123456
- POSTMAN: GET http://localhost:8000/api/v1/sport-data

## Docker Services
The application runs three containers:
- Web Application (Laravel 11)
- MariaDB Database
- phpMyAdmin

## Project Structure
- Laravel backend with database migrations and seeders
- Real-time data updates (1-minute interval)
- Docker containerized environment

## Database Structure
- Tournaments
- Seasons
- Matches
- Teams
- Results

## Additional Information
- The application automatically refreshes data every minute
- All services are connected through a Docker network named 'sports_network'
