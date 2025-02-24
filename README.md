# rich-text-editor

This project consists of a Laravel backend API and a Vue.js frontend application for managing posts with rich text content.

## Project Structure

- `backend/` - Laravel API application
- `frontend/` - Vue.js frontend application
- `docker-compose.yml` - Docker composition file
- `Makefile` - Utility commands for Docker operations

## Requirements

- Docker
- Docker Compose

## Setup and Installation

1. Clone the repository
2. Navigate to the project directory
3. Start the containers:
   ```bash
   make up
   ```
4. Run database migrations:
   ```bash
   make migrate
   ```
5. Seed the database:
   ```bash
   make seed
   ```

## Available Make Commands

- `make up` - Start all containers
- `make down` - Stop all containers
- `make build` - Build all containers
- `make rebuild` - Rebuild all containers from scratch
- `make logs` - View container logs
- `make shell-backend` - Access backend container shell
- `make shell-frontend` - Access frontend container shell
- `make migrate` - Run database migrations
- `make seed` - Run database seeders

## Accessing the Application

- Frontend: http://localhost:3000
- Backend API: http://localhost:8000
- phpMyAdmin: http://localhost:8080
  - Server: db
  - Username: root
  - Password: root_password

## Features

1. Post Management
   - Create, read, update, and delete posts
   - Rich text editing with VueQuill
   - PDF export of posts

2. Status Management
   - Predefined post statuses (draft, published, protected)

3. Frontend Features
   - Modern UI with Vuetify
   - Real-time rich text editing
   - PDF download functionality

