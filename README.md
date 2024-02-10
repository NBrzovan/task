Unzip the provided file.

Navigate to the project directory in your terminal.

Run composer install to install dependencies.

Duplicate the .env.example file and rename it to .env. Update the database configuration in the .env file with your MySQL database credentials.

Run php artisan key:generate to generate an application key.

Run php artisan migrate --seed to run database migrations and seed the database with sample data.

Start the development server using php artisan serve.

Access the application in your web browser at http://localhost:8000.

For deployment to a production server:

Update the .env file with your production database credentials and other necessary configurations.

Set the application environment to production with php artisan config:cache, php artisan config:clear, and php artisan route:cache.

Point your web server's document root to the public directory of the project.

Configure any additional server settings as needed for your deployment environment.

Usage
Upon accessing the application, you will be presented with a list of tasks.
Use the "Create Task" button to add new tasks.
Click on a task to edit or delete it.
Drag and drop tasks to reorder them. Priority will automatically update based on the new order.
Use the project dropdown to filter tasks by project.