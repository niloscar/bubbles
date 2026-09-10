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
    echo '<p>Det finns inga medlemsförfrågningar att hantera.</p>';
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
                        <button class="btn-success" name="action" value="approve_membership" title="Godkänn">
                            <i class="icon icon-check success-bg"></i>
                        </button>
                        <input type="hidden" name="request_id" value="<?= (int) $request['id'] ?>">
                    </form>

                    <form method="POST" value="reject_membership">
                        <button class="btn-error" name="action" value="reject_membership" title="Neka">
                            <i class="icon icon-x error-bg"></i>
                        </button>
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
                                    <button type="submit" title="Godkänn">
                                        <i class="icon icon-check success-bg"></i>
                                    </button>
                                </form>

                                <form method="post" action="/membership_requests/<?= $request['id'] ?>/reject">
                                    <button type="submit" title="Neka">
                                        <i class="icon icon-x error-bg"></i>
                                    </button>
                                </form>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
    </ul>

<?php } ?>