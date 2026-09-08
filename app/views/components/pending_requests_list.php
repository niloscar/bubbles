<?php

/**
 * Display pending membership requests
 */

$pdo = db();

$groupId = $data['group_id'] ?? null;

$pendingRequests = getPendingMembershipRequests($pdo, $groupId);

if ($pendingRequests === false) {
    echo '<p>Det gick inte att hämta medlemsförfrågningar.</p>';
    return;
}

if (empty($pendingRequests)) {
    echo '<p>Det finns inga medlemsförfrågningar.</p>';
    return;
}
?>

<?php if ($groupId !== null) { ?>

    <ul class="pending-requests-list">
        <?php foreach ($pendingRequests as $request) { ?>
            <li>
                <span><?= htmlspecialchars($request['username']) ?></span>

                <span><?= formatTimeAgo($request['created_at']) ?></span>

                <div class="pending-request-actions">
                    <form method="POST">
                        <button name="action" value="approve_membership">Godkänn</button>
                        <input type="hidden" name="request_id" value="<?= (int) $request['id'] ?>">
                    </form>

                    <form method="POST" value="reject_membership">
                        <button name="action" value="reject_membership">Avvisa</button>
                        <input type="hidden" name="request_id" value="<?= (int) $request['id'] ?>">
                    </form>
                </div>
            </li>
        <?php } ?>
    </ul>

<?php } else {

    $pendingRequestsByGroup = [];

    foreach ($pendingRequests as $request) {
        $requestGroupId = (int) $request['group_id'];

        $pendingRequestsByGroup[$requestGroupId] ??= [
            'name' => $request['group_name'],
            'requests' => []
        ];

        $pendingRequestsByGroup[$requestGroupId]['requests'][] = $request;
    }
    ?>

    <ul class="pending-requests-list">
        <?php foreach ($pendingRequestsByGroup as $group) { ?>
            <li>
                <h3><?= htmlspecialchars($group['name']) ?></h3>

                <ul>
                    <?php foreach ($group['requests'] as $request) { ?>
                        <li>
                            <span><?= htmlspecialchars($request['username']) ?></span>

                            <span><?= formatTimeAgo($request['created_at']) ?></span>

                            <div class="pending-request-actions">
                                <form method="post" action="/membership_requests/<?= $request['id'] ?>/approve">
                                    <button type="submit">Godkänn</button>
                                </form>

                                <form method="post" action="/membership_requests/<?= $request['id'] ?>/reject">
                                    <button type="submit">Avvisa</button>
                                </form>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
    </ul>

<?php } ?>