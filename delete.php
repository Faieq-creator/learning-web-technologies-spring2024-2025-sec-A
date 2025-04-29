<?php
require_once 'functions.php';

$errors = [];
$product = null;
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch product to delete
if ($id > 0) {
    $product = getProductById($id);
    if (!$product) {
        $errors[] = "Product not found.";
    }
} else {
    $errors[] = "Invalid product ID.";
}

// Handle form submission for deleting a product
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($errors)) {
    $data = [
        'id' => $id
    ];

    // Basic validation to ensure ID is not empty (similar to provided code)
    $errors = validateFormData($data);

    if (empty($errors)) {
        if (deleteProduct($id)) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Failed to delete product.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            background-color: #f0f0f0;
        }
        .product-form {
            width: 350px;
            background-color: white;
            border: 2px solid #333;
            padding: 20px;
            margin-top: 50px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .product-form h2 {
            text-align: center;
            color: #333;
        }
        .form-field {
            margin-bottom: 20px;
        }
        .delete-button {
            width: 100%;
            padding: 10px;
            background-color: #ff4444;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .delete-button:hover {
            background-color: #cc0000;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="product-form">
        <h2>Delete Product</h2>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if ($product): ?>
            <div class="form-field">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($product['name']); ?></p>
                <p><strong>Buying Price:</strong> <?php echo htmlspecialchars($product['buying_price']); ?></p>
                <p><strong>Selling Price:</strong> <?php echo htmlspecialchars($product['selling_price']); ?></p>
                <p><strong>Displayable:</strong> <?php echo $product['display'] ? "Yes" : "No"; ?></p>
            </div>
            <form action="" method="POST">
                <button type="submit" class="delete-button">Delete</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>