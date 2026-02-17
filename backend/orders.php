<?php
$pageTitle = 'Orders';
require_once 'includes/db.php';
include 'includes/header.php';

$success = '';
$error = '';
$csrfError = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    $error = 'Invalid session. Please refresh and try again.';
    $csrfError = true;
}

// Handle status update
if (isset($_POST['update_status']) && !$csrfError) {
    $orderId = (int)($_POST['order_id'] ?? 0);
    $status = $_POST['status'] ?? 'pending';
    if ($orderId && updateOrderStatusById($orderId, $status)) {
        $success = 'Order status updated';
    } else {
        $error = $error ?: 'Failed to update order status';
    }
}

// Handle bulk actions
if (isset($_POST['bulk_action']) && !$csrfError) {
    $selected = array_map('intval', $_POST['selected'] ?? []);
    $action = $_POST['bulk_action'] ?? '';
    if (empty($selected)) {
        $error = 'No orders selected for bulk action.';
    } else {
        if (strpos($action, 'status_') === 0) {
            $status = str_replace('status_', '', $action);
            if (updateOrdersStatusBulk($selected, $status)) {
                $success = 'Updated status for ' . count($selected) . ' order(s).';
            } else {
                $error = 'Failed to update selected orders.';
            }
        } elseif ($action === 'resend_receipt') {
            foreach ($selected as $oid) {
                appendOrderNote($oid, 'Receipt/email resend requested from admin panel.');
            }
            $success = 'Queued resend note for ' . count($selected) . ' order(s).';
        } elseif ($action === 'resend_webhook') {
            foreach ($selected as $oid) {
                appendOrderNote($oid, 'Webhook resend requested from admin panel.');
            }
            $success = 'Queued webhook resend note for ' . count($selected) . ' order(s).';
        }
    }
}

// Handle notes update
if (isset($_POST['save_note']) && !$csrfError) {
    $orderId = (int)($_POST['order_id'] ?? 0);
    $note = trim($_POST['notes'] ?? '');
    if ($orderId) {
        if (updateOrderNotes($orderId, $note)) {
            $success = 'Notes saved for order #' . $orderId;
        } else {
            $error = 'Failed to save notes.';
        }
    }
}

// Filters
$filters = [
    'status' => $_GET['status'] ?? '',
    'q' => $_GET['q'] ?? '',
    'date' => $_GET['date'] ?? '',
    'payment_method' => $_GET['payment_method'] ?? '',
    'amount_min' => $_GET['amount_min'] ?? '',
    'attention' => $_GET['attention'] ?? ''
];

// Get filtered orders
$orders = getOrdersFiltered($filters);
$statusCounts = getOrderStatusCounts();

// CSV export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="orders.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['Order #','Email','Status','Service','Package','Qty','Target','Amount','Payment','Txn ID','Created']);
    foreach ($orders as $o) {
        fputcsv($out, [
            $o['order_number'] ?? ('#'.$o['id']),
            $o['user_email'] ?? ($o['email'] ?? ''),
            $o['status'] ?? '',
            $o['service_name'] ?? '',
            $o['package_name'] ?? ($o['package_code'] ?? ''),
            $o['quantity'] ?? '',
            $o['target_url'] ?? '',
            $o['price'] ?? ($o['amount'] ?? ''),
            $o['payment_method'] ?? '',
            $o['transaction_id'] ?? '',
            $o['created_at'] ?? ''
        ]);
    }
    fclose($out);
    exit;
}
?>

<?php if ($success): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="table-container">
    <div class="table-header" style="gap: 1rem; flex-wrap: wrap;">
        <h2>All Orders (<?php echo count($orders); ?>)</h2>
        <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
            <?php 
                $tabs = [
                    ['label' => 'All', 'status' => ''],
                    ['label' => 'Pending', 'status' => 'pending', 'count' => $statusCounts['pending'] ?? 0],
                    ['label' => 'Processing', 'status' => 'processing', 'count' => $statusCounts['processing'] ?? 0],
                    ['label' => 'Completed', 'status' => 'completed', 'count' => $statusCounts['completed'] ?? 0],
                    ['label' => 'Refunded', 'status' => 'refunded', 'count' => $statusCounts['refunded'] ?? 0],
                    ['label' => 'Cancelled', 'status' => 'cancelled', 'count' => $statusCounts['cancelled'] ?? 0],
                    ['label' => 'Needs Attention', 'status' => '', 'attention' => 1, 'count' => $statusCounts['attention'] ?? 0]
                ];
            ?>
            <?php foreach ($tabs as $tab): 
                $isActive = ($filters['status'] === ($tab['status'] ?? '') ) && (($filters['attention'] === '1') === (!empty($tab['attention'])));
                $qs = http_build_query(array_merge($_GET, ['status' => $tab['status'] ?? '', 'attention' => $tab['attention'] ?? '']));
            ?>
                <a href="?<?php echo htmlspecialchars($qs); ?>" class="btn-secondary" style="padding:0.45rem 0.75rem; <?php echo $isActive ? 'border-color:#0ea5e9;color:#0ea5e9;' : ''; ?>">
                    <?php echo $tab['label']; ?>
                    <?php if (!empty($tab['count'])): ?>
                        <span style="background:#e2e8f0; padding:2px 6px; border-radius:6px; margin-left:6px; font-size:0.8rem; color:#475569;">
                            <?php echo (int)$tab['count']; ?>
                        </span>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
        <form method="GET" action="" style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center;">
            <input type="text" name="q" value="<?php echo htmlspecialchars($filters['q']); ?>" placeholder="Search order #, email, target, txn" style="padding: 0.6rem 0.8rem; border: 2px solid #e2e8f0; border-radius: 10px; min-width: 240px;">
            <select name="status" style="padding: 0.6rem 0.8rem; border: 2px solid #e2e8f0; border-radius: 10px; min-width: 140px;">
                <option value="">All Statuses</option>
                <?php foreach (['pending','processing','completed','cancelled','refunded'] as $s): ?>
                    <option value="<?php echo $s; ?>" <?php echo $filters['status'] === $s ? 'selected' : ''; ?>><?php echo ucfirst($s); ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="payment_method" value="<?php echo htmlspecialchars($filters['payment_method']); ?>" placeholder="Payment method" style="padding: 0.6rem 0.8rem; border: 2px solid #e2e8f0; border-radius: 10px; min-width: 150px;">
            <input type="number" step="0.01" name="amount_min" value="<?php echo htmlspecialchars($filters['amount_min']); ?>" placeholder="Min amount" style="padding: 0.6rem 0.8rem; border: 2px solid #e2e8f0; border-radius: 10px; width: 140px;">
            <input type="date" name="date" value="<?php echo htmlspecialchars($filters['date']); ?>" style="padding: 0.6rem 0.8rem; border: 2px solid #e2e8f0; border-radius: 10px;">
            <label style="display: flex; align-items: center; gap: 0.35rem; font-size: 0.9rem; color: #475569;">
                <input type="checkbox" name="attention" value="1" <?php echo $filters['attention'] === '1' ? 'checked' : ''; ?> style="width: auto;">
                Needs attention (24h+)
            </label>
            <button class="btn-secondary" type="submit">Filter</button>
            <a href="orders.php" class="btn-secondary" style="text-decoration: none;">Reset</a>
            <a href="?<?php echo htmlspecialchars(http_build_query(array_merge($_GET, ['export' => 'csv']))); ?>" class="btn-secondary" style="text-decoration: none;">Export CSV</a>
        </form>
    </div>
    
    <?php if (count($orders) > 0): ?>
        <div style="display:flex; gap:0.5rem; align-items:center; margin-bottom:0.5rem; flex-wrap:wrap;">
            <select id="bulkActionSelect" style="padding:0.5rem 0.6rem; border:1px solid #e2e8f0; border-radius:8px; min-width:200px;">
                <option value="">Bulk action</option>
                <option value="status_pending">Mark Pending</option>
                <option value="status_processing">Mark Processing</option>
                <option value="status_completed">Mark Completed</option>
                <option value="status_cancelled">Mark Cancelled</option>
                <option value="status_refunded">Mark Refunded</option>
                <option value="resend_receipt">Add note: resend email</option>
                <option value="resend_webhook">Add note: resend webhook</option>
            </select>
            <button type="button" class="btn-secondary" onclick="submitBulk()">Apply</button>
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table" style="min-width: 1100px;">
                <thead>
                    <tr>
                        <th style="width:40px; text-align:center;"><input type="checkbox" id="selectAllOrders"></th>
                        <th>Order #</th>
                        <th>Client</th>
                        <th>Email</th>
                        <th>Service</th>
                        <th>Package</th>
                        <th>Qty</th>
                        <th>Target</th>
                        <th>Amount</th>
                        <th>Pay Method</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <?php 
                            $status = $order['status'] ?? 'pending';
                            $badgeClass = 'badge-info';
                            if ($status === 'completed') $badgeClass = 'badge-success';
                            if ($status === 'pending') $badgeClass = 'badge-warning';
                            if ($status === 'cancelled' || $status === 'refunded') $badgeClass = 'badge-danger';
                            $packageLabel = '';
                            if (!empty($order['package_name'])) {
                                $packageLabel = $order['package_name'];
                            } elseif (!empty($order['package_code'])) {
                                $packageLabel = $order['package_code'];
                            } elseif (!empty($order['notes']) && preg_match('/Package Code:\s*([^\s]+)/', $order['notes'], $m)) {
                                $packageLabel = $m[1];
                            }

                            $createdAt = $order['created_at'] ?? null;
                            $isStale = false;
                            if ($createdAt && in_array($status, ['pending','processing'], true)) {
                                $isStale = strtotime($createdAt) <= strtotime('-24 hours');
                            }
                        ?>
                        <tr style="<?php echo $isStale ? 'background: #fff7ed;' : ''; ?>">
                            <td style="text-align:center;"><input type="checkbox" name="selected[]" value="<?php echo $order['id']; ?>" class="row-check"></td>
                            <td><strong><?php echo htmlspecialchars($order['order_number'] ?? ('#' . $order['id'])); ?></strong></td>
                            <td><?php echo htmlspecialchars($order['user_name'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($order['user_email'] ?? $order['email'] ?? 'N/A'); ?></td>
                            <td>
                                <div style="font-weight: 600; color: #1e293b;">
                                    <?php echo htmlspecialchars($order['service_name'] ?? 'N/A'); ?>
                                </div>
                                <?php if (!empty($order['package_name'])): ?>
                                    <div style="font-size: 0.85rem; color: #64748b; margin-top: 0.15rem;">
                                        <?php echo htmlspecialchars($order['package_name']); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($packageLabel): ?>
                                    <div style="font-weight: 600; color: #1e293b;"><?php echo htmlspecialchars($packageLabel); ?></div>
                                <?php else: ?>
                                    <span style="color: #cbd5e1;">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #1e293b;">
                                    <?php echo isset($order['quantity']) ? number_format($order['quantity']) : '—'; ?>
                                </div>
                            </td>
                            <td style="max-width: 180px;">
                                <div style="font-size: 0.85rem; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?php echo htmlspecialchars($order['target_url'] ?? ''); ?>">
                                    <?php echo htmlspecialchars($order['target_url'] ?? ''); ?>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #10b981;">$<?php echo number_format($order['price'] ?? ($order['amount'] ?? 0), 2); ?></div>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($order['payment_method'] ?? 'online'); ?>
                                <?php if (!empty($order['transaction_id'])): ?>
                                    <div style="font-size: 0.8rem; color: #64748b; margin-top: 2px;" title="Txn ID">
                                        <?php echo htmlspecialchars($order['transaction_id']); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge <?php echo $badgeClass; ?>"><?php echo ucfirst($status); ?></span>
                                <?php if ($isStale): ?>
                                    <div style="color: #c2410c; font-size: 0.8rem; font-weight: 600; margin-top: 2px;">24h+</div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo $createdAt ? date('M d, Y H:i', strtotime($createdAt)) : '—'; ?>
                                <?php if ($createdAt): ?>
                                    <div style="font-size: 0.8rem; color: #64748b;">Age: <?php echo floor((time() - strtotime($createdAt)) / 3600); ?>h</div>
                                <?php endif; ?>
                            </td>
                            <td class="table-actions" style="justify-content: flex-end; gap: 0.25rem;">
                                <form method="POST" action="" style="display: flex; gap: 0.4rem; align-items: center;">
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrfToken()); ?>">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status" style="padding: 0.45rem 0.5rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem;">
                                        <?php foreach (['pending','processing','completed','cancelled','refunded'] as $s): ?>
                                            <option value="<?php echo $s; ?>" <?php echo $status === $s ? 'selected' : ''; ?>><?php echo ucfirst($s); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" name="update_status" class="btn-secondary" style="padding: 0.45rem 0.9rem;">Update</button>
                                    <button type="button" class="btn-secondary" style="padding: 0.45rem 0.9rem;" onclick="toggleDetails(<?php echo $order['id']; ?>)">Details</button>
                                </form>
                            </td>
                        </tr>
                        <tr id="details-<?php echo $order['id']; ?>" style="display:none; background:#f8fafc;">
                            <td></td>
                            <td colspan="12" style="padding: 0.75rem 1rem;">
                                <div style="display:flex; flex-wrap:wrap; gap:1.25rem; align-items:flex-start;">
                                    <div style="min-width:220px;">
                                        <div style="font-weight:700; color:#0f172a;">Target</div>
                                        <div style="word-break:break-all; color:#334155; font-size:0.95rem;"><?php echo htmlspecialchars($order['target_url'] ?? ''); ?></div>
                                    </div>
                                    <div>
                                        <div style="font-weight:700; color:#0f172a;">Amount / Payment</div>
                                        <div style="color:#334155;">$<?php echo number_format($order['price'] ?? ($order['amount'] ?? 0),2); ?> • <?php echo htmlspecialchars($order['payment_method'] ?? 'online'); ?></div>
                                        <?php if (!empty($order['transaction_id'])): ?>
                                        <div style="color:#64748b; font-size:0.9rem;">Txn: <?php echo htmlspecialchars($order['transaction_id']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div style="font-weight:700; color:#0f172a;">Timestamps</div>
                                        <div style="color:#334155; font-size:0.95rem;">Created: <?php echo $createdAt ? date('M d, Y H:i', strtotime($createdAt)) : '—'; ?></div>
                                        <?php if (!empty($order['updated_at'])): ?>
                                        <div style="color:#334155; font-size:0.95rem;">Updated: <?php echo date('M d, Y H:i', strtotime($order['updated_at'])); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div style="flex:1; min-width:260px;">
                                        <div style="font-weight:700; color:#0f172a; display:flex; justify-content:space-between; align-items:center;">Notes
                                            <form method="POST" action="" style="display:flex; gap:0.5rem; align-items:center;">
                                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrfToken()); ?>">
                                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                                <textarea name="notes" rows="3" style="width:100%; border:1px solid #cbd5e1; border-radius:8px; padding:0.5rem; font-size:0.95rem;" placeholder="Add internal notes..."><?php echo htmlspecialchars($order['notes'] ?? ''); ?></textarea>
                                                <button type="submit" name="save_note" class="btn-secondary" style="white-space:nowrap;">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <h3>No Orders Found</h3>
            <p>Adjust filters or wait for new orders.</p>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>

<form method="POST" action="" id="bulkHiddenForm" style="display:none;">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrfToken()); ?>">
    <input type="hidden" name="bulk_action" id="bulkActionHidden">
</form>

<script>
document.getElementById('selectAllOrders')?.addEventListener('change', function(e) {
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = e.target.checked);
});

function toggleDetails(id) {
    var row = document.getElementById('details-' + id);
    if (row) {
        row.style.display = row.style.display === 'none' ? '' : 'none';
    }
}

function submitBulk() {
    var action = document.getElementById('bulkActionSelect').value;
    var checked = Array.from(document.querySelectorAll('.row-check:checked'));
    if (!action) {
        alert('Choose a bulk action first.');
        return;
    }
    if (!checked.length) {
        alert('Select at least one order.');
        return;
    }
    var form = document.getElementById('bulkHiddenForm');
    document.getElementById('bulkActionHidden').value = action;
    // Remove previous selected inputs
    Array.from(form.querySelectorAll('input[name="selected[]"]')).forEach(el => el.remove());
    checked.forEach(cb => {
        var clone = document.createElement('input');
        clone.type = 'hidden';
        clone.name = 'selected[]';
        clone.value = cb.value;
        form.appendChild(clone);
    });
    form.submit();
}
</script>
