<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Setup Instructions

1. Clone the repository
2. Install Docker and Docker Compose from docker's official site
   - You can download Docker Desktop in mac and windows.
   - Docker Compose is included in Docker Desktop.
   - Verify installation: `docker --version` `docker compose version`
3. Open Docker Desktop to run docker daemon.
   - In linux you can run `sudo systemctl start docker`
5. Create .env file and copy .env.example to it.
6. In the project directory run `docker-compose build`
7. Run `docker-compose up -d`
8. Run `docker ps` , you should see 3 containers running.
9. Run `docker-compose exec app composer install`
10. Run `docker-compose exec app php artisan key:generate`
11. Run `docker compose exec app php artisan passport:install`
    - `Would you like to run all pending database migrations?` type `yes`
    - `Would you like to create the "personal access" and "password grant" clients?` type `yes`
12. Run `docker-compose exec app php artisan db:seed` 

## Connect To DB Tool

1. Use mysql connection
2. Host is 127.0.0.1
3. Get Username, Password and Database name from .env file
4. Port is 3306


## API Documentation

### Authentication

* Register
  - POST /api/register
  - Payload: { first\_name, last\_name, email, password }
  - Registers a new user.
* Login
  - POST /api/login
  - Payload: { email, password }
  - Logs in a user and returns an authentication token.
* Logout
  - POST /api/logout (authentication is required)
  - Revokes the current user's authentication token.

### Attributes

* Get all attributes
  - GET /api/attributes (authentication is required)
  - Fetches all attributes
* Create attribute
  - POST /api/attributes (authentication is required)
  - Payload: {name, type}
  - type should be in (text, date, number, select)
  - Creates a new attribute
* Update attribute
  - PUT api/attributes/{id} (authentication is required)
  - Payload: { id, name, type }
  - Updates the specified attributes's information.

### Projects

* Get all projects
  - GET /api/projects (authentication is required)
  - Fetches all projects, with optional filtering.
* Get project
  - GET /api/projects/{id} (authentication is required)
  - Fetches the details of the specified project.
* Create project
  - POST /api/projects (authentication is required)
  - Payload: { name, status, attributes }
  - status should be in (NotStarted, InProgress, Completed, Canceled)
  - attributes is optional field, but if it exists, then attribute's id and value are required
  - Creates a new project
* Update project
  - PUT api/projects/{id} (authentication is required)
  - Payload: { id, name, status, attributes}
  - Updates the specified project's information.
* Delete project
  - DELETE /api/projects/{id} (authentication is required)
  - Deletes the specified project.

### Timesheets

* Get all timesheets
  - GET /api/timesheets (authentication is required)
  - Fetches all timesheets
* Get timesheet
  - GET /api/timesheets/{id} (authentication is required)
  - Fetches the details of the specified timesheet.
* Create timesheet
  - POST /api/timesheets (authentication is required)
  - Payload: {project\_id, user\_id, task\_name, date, hours}
  - Creates a new timesheet
* Update timesheet
  - PUT api/timesheets/{id} (authentication is required)
  - Payload: { id, project\_id, user\_id, task\_name, date, hours }
  - Updates the specified timesheet's information.
* Delete timesheet
  - DELETE /api/timesheets/{id} (authentication is required)
  - Deletes the specified timesheet.

  ### Users

* Get all users
  - GET /api/users (authentication is required)
  - Fetches all users
* Get user
  - GET /api/user/{id} (authentication is required)
  - Fetches the details of the specified user.
* Create user
  - POST /api/users (authentication is required)
  - Payload: { first\_name, last\_name, email, password }
  - Creates a new user
* Update user
  - PUT api/users/{id} (authentication is required)
  - Payload: { id, first\_name, last\_name, email, password }
  - Updates the specified user's information.
* Delete user
  - DELETE /api/users/{id} (authentication is required)
  - Deletes the specified user.
 

## Project Filtering

For the Get all projects endpoints, you can add query parameters to filter the results:

- Filter with dynamic or regular attributes, for example:
  GET /api/projects?filters[name]=ProjectA&filters[department]=IT

## Authentication

To access all endpoints (except register and login), you need to get Bearer token from register or login endpoints then include this token in the Authorization header of your requests.

## Postman Collection

Use astudio-assessment.postman_collection.json file in project root to import the postman collection.