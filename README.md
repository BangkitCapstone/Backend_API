# Capstone Project Backend API Documentation

This documentation outlines the endpoints and features of the Capstone Project Backend API. The API supports user authentication, profile management, image classification uploads, and history management.

## Installation and Setup

### Requirements
- PHP >= 8.2
- Composer
- Laravel Framework >= 11.x
- Google Cloud SDK (for deployment)

### Installation Steps

1. Clone the Repository:
   ```bash
   git clone https://github.com/your-repository/capstone-api.git
   cd capstone-api
   ```

2. Install Dependencies:
   ```bash
   composer install
   ```

3. Configure Environment Variables:
   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update `.env` with your database, Google Cloud, and application credentials.

4. Generate Application Key:
   ```bash
   php artisan key:generate
   ```

5. Run Database Migrations:
   ```bash
   php artisan migrate
   ```

6. Start the Development Server:
   ```bash
   php artisan serve
   ```
   The application will be available at `http://localhost:8000`.

### Deployment to Google Cloud
1. Authenticate Google Cloud SDK:
   ```bash
   gcloud auth login
   ```

2. Deploy the Application:
   ```bash
   gcloud app deploy
   ```

3. Access the Application:
   The application will be available at the URL provided by Google Cloud.

---

## Using the API via Postman

### Setting Up Postman
1. Download and install [Postman](https://www.postman.com/downloads/).
2. Create a new Postman collection for the API.
3. Add the base URL for the API:
   ```
   https://backend-api-dot-capstone-project-441614.et.r.appspot.com
   ```

### Authentication

#### Login User
**Endpoint:** `POST /api/login`

**Request Body:**
```json
{
    "email": "user@example.com",
    "password": "password123"
}
```

**Response:**
```json
{
    "message": "User logged in successfully",
    "user": {
        "id": 2,
        "username": "test1",
        "email": "test@gmail.com",
        "profile_picture": null
    }
}
```

#### Register User
**Endpoint:** `POST /api/register`

**Request Body:**
```json
{
    "username": "exampleuser",
    "email": "user@example.com",
    "password": "password123"
}
```

**Response:**
```json
{
    "message": "User has been successfully created",
    "user": {
        "id": 1,
        "username": "exampleuser",
        "email": "user@example.com",
        "profile_picture": null
    }
}
```

### Profile Management

#### Change Password
**Endpoint:** `POST /api/users/change-password`

**Request Body:**
```json
{
    "user_id": 2,
    "old_password": "oldpassword",
    "new_password": "newpassword123"
}
```

**Response:**
Success:
```json
{
    "status": "success",
    "message": "User update password successfully"
}
```
Failure:
```json
{
    "status": "fail",
    "error_code": "INVALID_CREDENTIALS",
    "message": "Update password fail! wrong password!"
}
```

#### Update Profile
**Endpoint:** `POST /api/users/profile`

**Request Body (Example):**
```json
{
    "user_id": 2,
    "new_username": "newusername",
    "new_email": "newemail@example.com"
}
```

**Response:**
```json
{
    "status": "success",
    "message": "User data updated successfully",
    "result": {
        "username": "newusername",
        "email": "newemail@example.com",
        "profile_picture": "example_URL"
    }
}
```

### Image Upload and Classification

#### Upload Image for Classification
**Endpoint:** `POST /api/histories/user/upload`

**Request Body:**
- `user_id` (integer, required)
- `image` (file, required, max 5 MB, types: jpg, jpeg, png)
- `currDate` (string, required, format: TIMESTAMP, e.g., `2024-12-10 11:51:56`)

**Response:**
```json
{
    "status": "success",
    "message": "Image has been uploaded",
    "result": {
        "history_id": 16,
        "user_id": "2",
        "classification_id": 14, 
        "classification_name": "Late Blight",
        "healing_steps": "For late blight, remove and destroy infected plants to prevent the spread. Use fungicides with active ingredients like chlorothalonil or copper sulfate. Avoid wet foliage and promote good drainage.",
        "classification_code": 2
    }
}
```

### History Management

#### Retrieve All Upload Histories for a User
**Endpoint:** `POST /api/histories/user/all`

**Request Body:**
```json
{
    "user_id": 2
}
```

**Response:**
```json
{
    "data": [
        {
            "history_id": 1,
            "image_path": "example_URL",
            "date": "2024-12-09 17:45:30",
            "classification_name": "Tomato Mosaic Virus"
        },
        {
            "history_id": 2,
            "image_path": "example_URL",
            "date": "2024-12-09 17:45:30",
            "classification_name": "Late Blight"
        }
    ]
}
```

#### Retrieve Details of a Single Upload History
**Endpoint:** `POST /api/histories/user/single`

**Request Body:**
```json
{
    "user_id": 2,
    "history_id": 16
}
```

**Response:**
```json
{
    "data": {
        "history_id": 16,
        "image_path":"example_URL",
        "date": "2024-12-09 17:45:30",
        "classification_name": "Late Blight",
        "healing_steps": "For late blight, remove and destroy infected plants to prevent the spread. Use fungicides with active ingredients like chlorothalonil or copper sulfate. Avoid wet foliage and promote good drainage."
    }
}
```

---

**Note:** Ensure the proper format of input requests and adhere to file size and type constraints to avoid errors.
