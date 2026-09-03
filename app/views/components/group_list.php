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

<ul class="no-list-style group-list">
    <?php foreach ($groups as $group) { ?>
        <li>
            <h3>
              <a href="?p=group&amp;gid=<?php echo urlencode($group['id']); ?>">
                <?php echo htmlspecialchars($group['name']); ?>
              </a>
            </h3>
            <p><?php echo htmlspecialchars($group['description']); ?></p>
            <ul class="no-list-style group-meta">
                <li>
                    <label>Senaste aktivitet:</label>
                    <span><?php echo formatTimeAgo(htmlspecialchars($group['last_activity'])); ?></span>
                </li>
                <li>
                    <label>Medlemmar:</label>
                    <span><?php echo htmlspecialchars($group['user_count']); ?></span>
                </li>
            </ul>
            <?php if (getGroupRole($pdo, $group['id'])) { ?>
                <br><small>Din roll: <?php echo htmlspecialchars(getGroupRole($pdo, $group['id'])); ?></small>
            <?php } else { ?>
                <button>Ansök om medlemskap</button>
            <?php } ?>
        </li>
    <?php } ?>
</ul>