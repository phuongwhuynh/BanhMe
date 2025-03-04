<div class="order-header">Menu List</div>
<?php if (!empty($menuItems)):?>
    <table>
        <tr><th>Image</th><th>Name</th><th>Price(VND)</th></tr>
        <?php foreach ($menuItems as $item): ?>
            <tr>
                <td><?=$item['image_path'] ?></td>
                <td><?=htmlspecialchars($item['name']) ?></td>
                <td><?=$item['price'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No menu items found</p>
<?php endif; ?>