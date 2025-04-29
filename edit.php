<?php
require_once 'functions.php';

$errors = [];
$product = null;
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch product to edit
if ($id > 0) {
    $product = getProductById($id);
    if (!$product) {
        $errors[] = "Product not found.";
    }
} else {
    $errors[] = "Invalid product ID.";
}<?php
require_once 'functions.php';

$errors = [];
$product = null;
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch product to edit
if ($id > 0) {
    $product = getProductById($id);
    if (!$product) {
        $errors[] = "Product not found.";
    }
} else {
    $errors[] = "Invalid product ID.";
}

$name = $product['name'] ?? '';
$buying_price = $product['buying_price'] ?? '';
$selling_price = $product['selling_price'] ?? '';
$display = isset($product['display']) && $product['display'] == 1;

// Handle form submission for editing a product
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($errors)) {
    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'buying_price' => trim($_POST['buying_price'] ?? ''),
        'selling_price' => trim($_POST['selling_price'] ?? ''),
        'display' => isset($_POST['display']) ? 1 : 0
    ];

    $errors = validateProductData($data);

    if (empty($errors)) {
        if (updateProduct($id, $data)) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Failed to update product.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
        .form-field label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-field input[type="text"] {
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
    </style>
</head>
<body>
    <div class="product-form">
        <h2>Edit Product</h2>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-field">
                <label for="product-name">Product Name</label>
                <input type="text" id="product-name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="form-field">
                <label for="buying-price">Buying Price</label>
                <input type="text" id="buying-price" name="buying_price" value="<?php echo htmlspecialchars($buying_price); ?>" required>
            </div>
            <div class="form-field">
                <label for="selling-price">Selling Price</label>
                <input type="text" id="selling-price" name="selling_price" value="<?php echo htmlspecialchars($selling_price); ?>" required>
            </div>
            <div class="form-field">
                <input type="checkbox" id="display-product" name="display" <?php if ($display) echo "checked"; ?>>
                <label for="display-product" style="display:inline;">Show on Display</label>
            </div>
            <button type="submit" class="save-button">Save</button>
        </form>
    </div>
</body>
</html>

$name = $product['name'] ?? '';
$buying_price = $product['buying_price'] ?? '';
$selling_price = $product['selling_price'] ?? '';
$display = isset($product['display']) && $product['display'] == 1;

// Handle form submission for editing a product
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($errors)) {
    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'buying_price' => trim($_POST['buying_price'] ?? ''),
        'selling_price' => trim($_POST['selling_price'] ?? ''),
        'display' => isset($_POST['display']) ? 1 : 0
    ];

    $errors = validateProductData($data);

    if (empty($errors)) {
        if (updateProduct($id, $data)) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Failed to update product.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
        .form-field label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-field input[type="text"] {
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
    </style>
</head>
<body>
    <div class="product-form">
        <h2>Edit Product</h2>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-field">
                <label for="product-name">Product Name</label>
                <input type="text" id="product-name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="form-field">
                <label for="buying-price">Buying Price</label>
                <input type="text" id="buying-price" name="buying_price" value="<?php echo htmlspecialchars($buying_price); ?>" required>
            </div>
            <div class="form-field">
                <label for="selling-price">Selling Price</label>
                <input type="text" id="selling-price" name="selling_price" value="<?php echo htmlspecialchars($selling_price); ?>" required>
            </div>
            <div class="form-field">
                <input type="checkbox" id="display-product" name="display" <?php if ($display) echo "checked"; ?>>
                <label for="display-product" style="display:inline;">Show on Display</label>
            </div>
            <button type="submit" class="save-button">Save</button>
        </form>
    </div>
</body>
</html>