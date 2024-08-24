## M-Place: Your Gateway to Great Finds

M-Place is a website designed as a platform for buying and selling goods online. M-Place allows users to browse various products, make purchases, and easily manage product sales and inventory. The platform has two main roles: seller, who can use the site to conduct sales transactions, and user, who can only make purchases. The project was developed using Laravel v10 and Tailwind CSS. 
You can also view the API documentation through the file located in the main project.

## How to use?
Here’s how you can run this project:
- Clone this project. You can use http or ssh.
- Open or go into the cloned project.
- Run the command **composer install**.
- Run the command **npm install**.
- Create a database first if you don't have one yet.
- Create a **.env** file in the main project. This file is used to declare the database and other environment settings.
- Enter and configure the database you'll use in the .env file.
- Generate a new key by running the command **php artisan key:generate**.
- Migrate the tables with the seeder using the command **php artisan migrate --seed**.
- Once done, run the command **php artisan serve** to run the project on a local server.
- Also, run the command **npm run dev** to run npm because this project uses npm packages and Tailwind CSS.
- Make sure php artisan and npm are running together.
- The website should now be up and running and can be accessed through a web browser.

## API
The API documentation can be viewed in the JSON file within this project. 
