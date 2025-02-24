# BlogApp API

BlogApp API is a backend service for managing admin panel and client side interface. It is built with Laravel and supports authentication, CRUD operations for blogs,categories,contacts and comments, and broadcasting email using jobs and queue.

## Features
- User authentication (Register, Login, Logout,reset password)
- Blog post management (Create, Read, Update, Delete)
- Category Management(Create,Read,Update,Delete)
- Blog analytics Management
- Contact and Comments management
- Media management using Spatie Media Library
- Role and permission management
- Specific Blog download by converting pdf
- Like,Dislike and Views Management
- Searching Blog Management etc.
- Single Sign On with google management

## Installation
### Prerequisites
Ensure you have the following installed on your system:
- PHP (>= 8.1)
- Composer
- Laravel
- PostgreSQL/MySQL (Database)
  

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


9. **Run the server**
   ```bash
   php artisan serve
   ```
   The API will be available at `http://127.0.0.1:8000`.


## Contribution
1. Fork the repository
2. Create a feature branch (`git checkout -b feature-branch`)
3. Commit changes (`git commit -m 'Add new feature'`)
4. Push to the branch (`git push origin feature-branch`)
5. Open a pull request

## License
This project is licensed under Myself😁.

---
Feel free to contribute and make improvements!

