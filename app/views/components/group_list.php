<?php

$groups = getGroups();

if (empty($groups)) {
    echo 'Kunde inte hämta grupper.';
    return;
}

?>

<ul>
    <?php foreach ($groups as $group) { ?>
        <li>
            <h3><?php echo htmlspecialchars($group['name']); ?></h3>
            <p><?php echo htmlspecialchars($group['description']); ?></p>
            <small>Skapad: <?php echo htmlspecialchars($group['created_at']); ?></small>
        </li>
    <?php } ?>
</ul>