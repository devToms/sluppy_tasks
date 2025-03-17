
# Project Setup Instructions

To set up and run the project, follow these steps:

1. **Navigate to the project directory:**

   Open your terminal and navigate to the project folder. Use the following command:
   
   ```bash
   cd path/to/project
   ```

2. **Start the Docker containers:**

   Run the following command to start the Docker containers in detached mode:
   
   ```bash
   docker-compose up -d
   ```

3. **Install Composer dependencies:**

   Run the following command to install the necessary PHP dependencies via Composer:
   
   ```bash
   docker exec -it php composer install
   ```

4. **Run database migrations:**

   Execute the command to activate all database migrations:
   
   ```bash
   docker exec -it php php artisan migrate
   ```

   This will ensure your database schema is up to date.

Once these steps are completed, your environment should be set up and ready to use.