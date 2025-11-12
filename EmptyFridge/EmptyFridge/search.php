<?php
$apiKey = "SPOONACULAR_KEY"; // use your API key here !!! 
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "emptyfridge";

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}


if (!empty($_POST['ingredients'])) {
    $ingredients = htmlspecialchars($_POST['ingredients']);


    $stmt = $conn->prepare("INSERT INTO searches (ingredients, search_time) VALUES (?, NOW())");
    $stmt->bind_param("s", $ingredients);
    $stmt->execute();


    $url = "https://api.spoonacular.com/recipes/findByIngredients?ingredients=" . urlencode($ingredients) . "&number=6&apiKey=" . $apiKey;

    $response = @file_get_contents($url);
    if ($response === FALSE) {
        echo "<p>⚠️ Could not fetch recipes. Check your API key or internet connection.</p>";
    } else {
        $recipes = json_decode($response, true);

        echo "<h1>🍳 Recipes you can make with: <em>$ingredients</em></h1>";
        echo "<div class='recipes'>";

        if (empty($recipes)) {
            echo "<p>No recipes found. Try different ingredients!</p>";
        } else {
            foreach ($recipes as $r) {
                echo "<div class='card'>";
                echo "<img src='" . $r['image'] . "' alt='" . $r['title'] . "'>";
                echo "<h3>" . $r['title'] . "</h3>";
                echo "<a href='https://spoonacular.com/recipes/" . strtolower(str_replace(' ', '-', $r['title'])) . "-" . $r['id'] . "' target='_blank'>View Recipe</a>";
                echo "</div>";
            }
        }

        echo "</div>";
    }
} else {
    echo "<p>No ingredients entered. Please go back and try again.</p>";
}

$conn->close();
?>


<style>
body {
  background: linear-gradient(135deg, #4a00e0, #8e2de2);
  color: white;
  font-family: 'Poppins', sans-serif;
  text-align: center;
  padding: 40px;
}

h1 {
  margin-bottom: 40px;
}

.recipes {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 25px;
  max-width: 1000px;
  margin: 0 auto;
}

.card {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 15px;
  padding: 20px;
  backdrop-filter: blur(10px);
  transition: 0.3s ease;
  box-shadow: 0 0 15px rgba(255,255,255,0.2);
}

.card:hover {
  transform: scale(1.05);
  box-shadow: 0 0 25px rgba(255,255,255,0.4);
}

.card img {
  width: 100%;
  border-radius: 10px;
  margin-bottom: 15px;
}

.card a {
  display: inline-block;
  margin-top: 10px;
  padding: 10px 15px;
  border-radius: 30px;
  background: linear-gradient(90deg, #ff6a00, #ee0979);
  color: white;
  text-decoration: none;
  font-weight: bold;
}

.card a:hover {
  opacity: 0.85;
}
</style>
