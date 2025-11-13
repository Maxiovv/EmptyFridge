#EmptyFridge

This project demonstrates a simple PHP application that connects to a database and fetches recipes from the Spoonacular API based on ingredients provided by the user.

## How the project works

1. **Database connection**  
   The PHP script first connects to the database and checks if the form is not empty.  
   If data is provided, it executes an SQL query:  
   ```sql
   INSERT INTO searches (ingredients, search_time) VALUES (?, NOW())
2. **Creating the API URL**
Then, the script builds a URL for the Spoonacular API:

`$url = "https://api.spoonacular.com/recipes/findByIngredients?ingredients=" . urlencode($ingredients) . "&number=6&apiKey=" . $apiKey;`
This URL fetches 6 recipes based on the ingredients entered by the user.

3.**Fetching data from the API**
   `$response = @file_get_contents($url);`
The $response variable now contains the JSON data returned by the API.

4.**Decoding JSON to PHP**

`$recipes = json_decode($response, true);`
This line converts the JSON data into a PHP array, making it easier to work with in the code.

5.**Look**

Echo with $r to display content and some CSS to get it good look.
