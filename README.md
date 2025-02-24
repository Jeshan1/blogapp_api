# BlogApp API

BlogApp API is a backend service for managing blog posts, users, and donations using Stripe. It is built with Laravel and supports authentication, CRUD operations for posts, and real-time notifications using Pusher.

## Features
- User authentication (Register, Login, Logout)
- Blog post management (Create, Read, Update, Delete)
- Stripe integration for donations
- Real-time notifications with Pusher
- Media management using Spatie Media Library
- Role and permission management

## Installation
### Prerequisites
Ensure you have the following installed on your system:
- PHP (>= 8.1)
- Composer
- Laravel
- PostgreSQL/MySQL (Database)
- Redis (for queues, optional)
- Pusher (for real-time events, optional)

### Steps
1. **Clone the repository**
   ```bash
   git clone https://github.com/Jeshan1/blogapp_api.git
   cd blogapp_api
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Copy the environment file**
   ```bash
   cp .env.example .env
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Set up the database**
   - Update `.env` file with your database credentials
   - Run migrations:
     ```bash
     php artisan migrate
     ```

6. **Seed the database (optional)**
   ```bash
   php artisan db:seed
   ```

7. **Configure Stripe**
   - Set your Stripe API keys in `.env`:
     ```env
     STRIPE_KEY=your_stripe_key
     STRIPE_SECRET=your_stripe_secret
     ```

8. **Configure Pusher (for real-time updates)**
   - Add Pusher credentials to `.env`:
     ```env
     PUSHER_APP_ID=your_pusher_app_id
     PUSHER_APP_KEY=your_pusher_key
     PUSHER_APP_SECRET=your_pusher_secret
     PUSHER_APP_CLUSTER=your_pusher_cluster
     ```

9. **Run the server**
   ```bash
   php artisan serve
   ```
   The API will be available at `http://127.0.0.1:8000`.

## API Endpoints
| Method  | Endpoint             | Description          |
|---------|----------------------|----------------------|
| POST    | `/api/register`      | Register a user     |
| POST    | `/api/login`         | Login a user        |
| GET     | `/api/posts`         | Get all posts       |
| POST    | `/api/posts`         | Create a new post   |
| GET     | `/api/posts/{id}`    | Get a single post   |
| PUT     | `/api/posts/{id}`    | Update a post       |
| DELETE  | `/api/posts/{id}`    | Delete a post       |
| POST    | `/api/donate`        | Make a donation    |

## Contribution
1. Fork the repository
2. Create a feature branch (`git checkout -b feature-branch`)
3. Commit changes (`git commit -m 'Add new feature'`)
4. Push to the branch (`git push origin feature-branch`)
5. Open a pull request

## License
This project is licensed under the MIT License.

---
Feel free to contribute and make improvements!

