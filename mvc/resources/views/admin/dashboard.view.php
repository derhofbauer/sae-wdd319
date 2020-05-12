<h1>Dashboard</h1>

<div class="card">
    <div class="card-header">
        Open Orders (<?php echo count($openOrders); ?>)
    </div>
    <ul class="list-group list-group-flush">
        <?php foreach ($openOrders as $openOrder): ?>
            <li class="list-group-item">
                <a href="orders/<?php echo $openOrder->id; ?>/edit">
                    <?php printf('#%d: %s', $openOrder->id, $openOrder->crdate); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="card-columns">
    <div class="card">
        <div class="card-header">
            Number Of Users
        </div>
        <ul class="list-group list-group-flush">
            <?php
            /**
             * Ich persönlich finde, dass der Controller dafür zuständig ist, Daten aus der Datenbank auszulesen
             * und zu verarbeiten, während der View dann dafür zuständig ist die aufbereiteten Daten anzuzeigen.
             * Es ist also bis zu einem gewissen Grad geschmackssache, wo ihr Logik wie die Folgende unterbringt.
             */

            foreach ($numberOfUsers as $numberOfUsersData) {
                if ($numberOfUsersData['is_admin'] === 1) {
                    $label = 'Admins';
                } else {
                    $label = 'Customers';
                }
                $value = $numberOfUsersData['numberofusers'];

                echo "<li class=\"list-group-item\">$value $label</li>";
            }
            ?>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            Products (<?php echo count($products); ?>)
        </div>
        <ul class="list-group list-group-flush">
            <?php foreach ($products as $product): ?>
                <li class="list-group-item">
                    <a href="products/<?php echo $product->id; ?>/edit">
                        <?php echo $product->name; ?>
                    </a>
                    <?php echo $product->getPrice(); ?>
                    <span>
                    Stock: <?php echo $product->stock; ?>
                </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            Shipment Stats
        </div>
        <ul class="list-group list-group-flush">
            <?php foreach ($productStats as $productStat): ?>
                <li class="list-group-item">
                    <?php echo $productStat['label']; ?>: <?php echo $productStat['count']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
