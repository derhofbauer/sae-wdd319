<h2>Cart</h2>

<?php
/**
 * Wir haben das productTable Partial ausgelagert, damit wir es an mehreren Stellen verwenden können. In diesem Partial
 * werden $products verlangt und die Konfigurationsvariable $isCart unterstützt, die definiert, ob das Partial im Cart
 * Kontext oder in einem anderen Kontext verwendet wird. Im Cart Kontext werden Produkt Buttons zum hinzufügen und
 * entfernen ausgegeben, die in der Order Ansicht im Admin Panel nicht ausgegeben werden.
 */

/**
 * Alias definieren, weil das productTable Partial intern eine $products Variable verlangt und keine $cartContent
 * Variable.
 */
$products = $cartContent;

/**
 * Dem productTable Partial mitteilen, dass es sich aktuell um einen Cart View handelt.
 */
$isCart = true;

/**
 * Partial laden.
 */
require_once __DIR__ . '/partials/productTable.php';

?>
