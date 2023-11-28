<?php

// Check if productId is received in the request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['productId'])) {
        // Remove all instances of the product from the session cart based on the received product ID
        $productId = $data['productId'];
        
        // Loop through the cart and remove all instances of the specified product
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item->produkt_id == $productId) {
                unset($_SESSION['cart'][$key]);
            }
        }
        
        echo json_encode(['success' => true]);
        exit;
    }
}

// If the product removal failed or the request was invalid
http_response_code(400); // Set appropriate HTTP status code
echo json_encode(['success' => false, 'message' => 'Failed to remove the item']);