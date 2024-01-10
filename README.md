# Coffee-Blend-Website
The website “Coffee Blend” aims to provide a delightful coffee experience, showcasing a range of coffee blends
## Technologies:
This web page was made with the following technologies:
<ul>
  <li>HTML5</li>
<li>CSS3</li>
<li>Javascript + AJAX Library</li>
<li>PHP</li>
<li>SQL</li>
  
## To provide directions for setting up the database for your project, you can follow these steps:
  
### Step 1: Create a new database

1. Open phpMyAdmin.
2. Create a new database named `coffee`.

### Step 2: Import the SQL Dump

1. Go to the "Import" tab in phpMyAdmin for the `coffee` database.
2. Choose the SQL file provided above.
3. Click "Go" to import the database structure and data.

### Step 3: Update Database Configuration

Update your PHP project connection file with the database connection details.

### Step 4: Use the Database in Your Project

Now that your database is set up and the connection is established, you can start using it in your PHP project. You can perform CRUD (Create, Read, Update, Delete) operations on tables like `customers`, `feedback`, `lookupitems`, `lookups`, `menu`, and `orders`.

Remember to secure your database credentials and sanitize user inputs to prevent SQL injection.

With these steps, PHP project should be able to interact with the database you've set up.
