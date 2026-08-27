<?php
/**
 * Group list component
 */

$pdo = db();
$groups = getGroups($pdo);

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
            <small>Skapad: <?php echo htmlspecialchars($group['created_at']); ?></small><br>
            <small>Medlemmar: <?php echo htmlspecialchars($group['user_count']); ?></small>
        </li>
    <?php } ?>
</ul>