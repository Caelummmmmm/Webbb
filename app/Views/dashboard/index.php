<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts Dashboard | Puihaha Electric</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .pagination {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 25px;
}

.pagination li {
    list-style: none;
    margin: 0 !important;
}

.pagination a,
.pagination span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    margin: 0 !important;
    padding: 0 12px;
    border-radius: 8px;
    text-decoration: none;
}

.pagination a {
    background-color: #667eea;
    color: white;
}

.pagination a:hover {
    background-color: #4f46e5;
    color: white;
}

.pagination .active span,
.pagination span.active {
    background-color: #764ba2;
    color: white;
    font-weight: bold;
}
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark topbar shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url() ?>">
            <i class="bi bi-lightning-charge-fill text-warning"></i>
            Puihaha Electric
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#dashboardNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="dashboardNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('dashboard') ?>">
                        <i class="bi bi-grid me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>">
                        <i class="bi bi-house me-1"></i> Website
                    </a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-light btn-sm" href="<?= base_url('logout') ?>">
                        <i class="bi bi-box-arrow-right me-1"></i> Log Out
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4 py-md-5">
    <section class="page-header mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
                <p class="text-white-50 mb-1">Customer Account Management</p>
                <h1 class="h2 mb-0">Accounts Dashboard</h1>
            </div>
            <div class="mt-3 mt-md-0">
                <span class="badge text-bg-light text-primary px-3 py-2">
                    <i class="bi bi-person-check me-1"></i>
                    <?= esc(session()->get('username') ?? 'Administrator') ?>
                </span>
            </div>
        </div>
    </section>

    <section class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Accounts</div>
                        <div class="h3 mb-0"><?= esc($total_accounts) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Active</div>
                        <div class="h3 mb-0"><?= esc($active_accounts) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-danger-subtle text-danger">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Inactive</div>
                        <div class="h3 mb-0"><?= esc($inactive_accounts) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Suspended</div>
                        <div class="h3 mb-0"><?= esc($suspended_accounts) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="card accounts-card">
        <div class="card-body p-3 p-md-4">
            <form method="get" action="<?= base_url('dashboard') ?>" class="row g-3 mb-4">
                <div class="col-lg-5">
                    <label class="form-label">Search accounts</label>
                    <input type="search" name="search" class="form-control"
                        placeholder="Name, account number, email, or phone"
                        value="<?= esc($search_keyword ?? '') ?>">
                </div>

                <div class="col-md-4 col-lg-2">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="">All</option>
                        <option value="active" <?= ($filter_status ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= ($filter_status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        <option value="suspended" <?= ($filter_status ?? '') === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                    </select>
                </div>

                <div class="col-md-4 col-lg-2">
                    <label class="form-label">Type</label>
                    <select class="form-select" name="type">
                        <option value="">All</option>
                        <option value="residential" <?= ($filter_type ?? '') === 'residential' ? 'selected' : '' ?>>Residential</option>
                        <option value="commercial" <?= ($filter_type ?? '') === 'commercial' ? 'selected' : '' ?>>Commercial</option>
                        <option value="industrial" <?= ($filter_type ?? '') === 'industrial' ? 'selected' : '' ?>>Industrial</option>
                    </select>
                </div>

                <div class="col-md-4 col-lg-3 d-flex align-items-end gap-2">
                    <button class="btn btn-primary flex-grow-1" type="submit">
                        <i class="bi bi-search me-1"></i> Search
                    </button>

                    <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary">
                        Clear
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Account No.</th>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($accounts)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-search fs-2 d-block mb-2"></i>
                                    No customer accounts found.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($accounts as $account): ?>
                                <tr>
                                    <td class="account-number"><?= esc($account['account_number']) ?></td>
                                    <td>
                                        <div class="fw-semibold"><?= esc($account['customer_name']) ?></div>
                                        <small class="text-muted"><?= esc($account['address']) ?></small>
                                    </td>
                                    <td>
                                        <div><?= esc($account['email']) ?></div>
                                        <small class="text-muted"><?= esc($account['phone']) ?></small>
                                    </td>
                                    <td>
                                        <span class="badge text-bg-info">
                                            <?= ucfirst(esc($account['connection_type'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?= esc($account['status']) ?>">
                                            <?= ucfirst(esc($account['status'])) ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="<?= base_url('account/' . $account['id']) ?>"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($pager && $pager->getPageCount() > 1): ?>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-4 gap-3">
                    <small class="text-muted">
                        Page <?= esc($current_page) ?> of <?= esc($pager->getPageCount()) ?>
                    </small>
                    <?= $pager->links() ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>