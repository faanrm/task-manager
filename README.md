# Task Management API

A RESTful API built with Laravel for managing tasks

## Features

- List all tasks
- Create new tasks
- Update existing tasks
- Delete tasks


## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/task-management-api.git
cd task-manager
```

2. Install dependencies:
```bash
composer install
```

3. Create and configure the environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure your database connection in the `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=
```

6. Run migrations:
```bash
php artisan migrate
```

7. (Optional) Seed database with sample tasks:
```bash
php artisan db:seed --class=TaskSeeder
```

## Running the Application

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`.

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET    | /api/v1/tasks | Get all tasks |
| POST   | /api/v1/tasks | Create a new task |
| GET    | /api/v1/tasks/{id} | Get a specific task |
| PUT/PATCH | /api/v1/tasks/{id} | Update a task |
| DELETE | /api/v1/tasks/{id} | Delete a task |

## Request/Response Examples

### Get All Tasks

**Request:**
```
GET /api/v1/tasks
```

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "title": "Complete project documentation",
            "description": "Write comprehensive README with API endpoints",
            "completed": false,
            "created_at": "2025-04-28T10:30:00.000000Z",
            "updated_at": "2025-04-28T10:30:00.000000Z"
        },
        {
            "id": 2,
            "title": "Implement unit tests",
            "description": "Create tests for repository and service layer",
            "completed": true,
            "created_at": "2025-04-28T10:35:00.000000Z",
            "updated_at": "2025-04-28T11:20:00.000000Z"
        }
    ],
    "message": "Tasks retrieved successfully"
}
```

### Create Task

**Request:**
```
POST /api/v1/tasks
Content-Type: application/json

{
    "title": "New task title",
    "description": "Task description",
    "completed": false
}
```

**Response:**
```json
{
    "data": {
        "id": 3,
        "title": "New task title",
        "description": "Task description",
        "completed": false,
        "created_at": "2025-04-28T12:00:00.000000Z",
        "updated_at": "2025-04-28T12:00:00.000000Z"
    },
    "message": "Task created successfully"
}
```

### Get Single Task

**Request:**
```
GET /api/v1/tasks/3
```

**Response:**
```json
{
    "data": {
        "id": 3,
        "title": "New task title",
        "description": "Task description",
        "completed": false,
        "created_at": "2025-04-28T12:00:00.000000Z",
        "updated_at": "2025-04-28T12:00:00.000000Z"
    },
    "message": "Task retrieved successfully"
}
```

### Update Task

**Request:**
```
PUT /api/v1/tasks/3
Content-Type: application/json

{
    "title": "Updated task title",
    "completed": true
}
```

**Response:**
```json
{
    "data": {
        "id": 3,
        "title": "Updated task title",
        "description": "Task description",
        "completed": true,
        "created_at": "2025-04-28T12:00:00.000000Z",
        "updated_at": "2025-04-28T12:10:00.000000Z"
    },
    "message": "Task updated successfully"
}
```

### Delete Task

**Request:**
```
DELETE /api/v1/tasks/3
```

**Response:**
```json
{
    "message": "Task deleted successfully"
}
```

## Validation Rules

- **Title**: Required, string, max 255 characters
- **Description**: Optional, string
- **Completed**: Optional, boolean

## Testing

Run the tests with:

```bash
php artisan test
```
