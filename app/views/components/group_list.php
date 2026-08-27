<?php
/**
 * Group list component
 */

$groups = getGroups();

if (empty($groups)) {
    echo 'Kunde inte hämta grupper.';
    return;
}

?>

<ul>
    <?php foreach ($groups as $group) { ?>
        <li>
            <h3>
              <a href="?p=group&amp;gid=<?php echo urlencode($group['id']); ?>">
                <?php echo htmlspecialchars($group['name']); ?>
              </a>
            </h3>
            <p><?php echo htmlspecialchars($group['description']); ?></p>
            <small>Skapad: <?php echo htmlspecialchars($group['created_at']); ?></small>
        </li>
    <?php } ?>
</ul>