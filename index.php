<?php
require_once 'functions.php';

$errors = [];
$name = $buying_price = $selling_price = "";
$display = false;

// Handle form submission for adding a product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'buying_price' => trim($_POST['buying_price'] ?? ''),
        'selling_price' => trim($_POST['selling_price'] ?? ''),
        'display' => isset($_POST['display']) ? 1 : 0
    ];

    $errors = validateProductData($data);

    if (empty($errors)) {
        if (insertProduct($data)) {
            $name = $buying_price = $selling_price = "";
            $display = false;
            echo "<p style='color: green; text-align: center;'>Product added successfully!</p>";
        } else {
            $errors[] = "Failed to add product.";
        }
    }
}

// Fetch products to display
$products = getDisplayableProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border: 2px solid #333;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .product-form h2, .product-table h2 {
            text-align: center;
            color: #333;
        }
        .form-field {
            margin-bottom: 20px;
        }
        .form-field label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-field input[type="text"], .form-field input[type="search"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-field input[type="checkbox"] {
            margin-right: 8px;
        }
        .save-button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .save-button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-links a {
            margin-right: 10px;
            text-decoration: none;
        }
        .action-links a.edit {
            color: blue;
        }
        .action-links a.delete {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Add Product Form -->
        <div class="product-form">
            <h2>Add a Product</h2>
            <?php if (!empty($errors)): ?>
                <div class="error">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form action="" method="POST">
                <input type="hidden" name="action" value="add">
                <div class="form-field">
                    <label for="product-name">Product Name</label>
                    <input type="text" id="product-name" name="name" placeholder="Enter product name" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                <div class="form-field">
                    <label for="buying-price">Buying Price</label>
                    <input type="text" id="buying-price" name="buying_price" placeholder="Enter buying price" value="<?php echo htmlspecialchars($buying_price); ?>" required>
                </div>
                <div class="form-field">
                    <label for="selling-price">Selling Price</label>
                    <input type="text" id="selling-price" name="selling_price" placeholder="Enter selling price" value="<?php echo htmlspecialchars($selling_price); ?>" required>
                </div>
                <div class="form-field">
                    <input type="checkbox" id="display-product" name="display" <?php if ($display) echo "checked"; ?>>
                    <label for="display-product" style="display:inline;">Show on Display</label>
                </div>
                <button type="submit" class="save-button">Save Product</button>
            </form>
        </div>

        <!-- Search Feature -->
        <div class="product-table">
            <h2>Search Products</h2>
            <div class="form-field">
                <input type="search" id="search-input" placeholder="Search By Name" onkeyup="searchProducts()">
            </div>
            <table id="product-table">
                <thead>
                    <tr>
                        <th>NAME</th>
                        <th>PROFIT</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="product-table-body">
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo number_format($product['selling_price'] - $product['buying_price'], 2); ?></td>
                            <td class="action-links">
                                <a href="edit.php?id=<?php echo $product['id']; ?>" class="edit">edit</a>
                                <a href="delete.php?id=<?php echo $product['id']; ?>" class="delete">delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function searchProducts() {
            const searchTerm = document.getElementById('search-input').value;
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'search.php?term=' + encodeURIComponent(searchTerm), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById('product-table-body').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>