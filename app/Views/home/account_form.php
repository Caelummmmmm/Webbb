<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> - Puihaha Electric</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            padding: 35px 0;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .form-card {
            border: 0;
            border-radius: 16px;
        }

        .form-title {
            color: #667eea;
            font-weight: 700;
        }

        .back-button {
            padding: 7px 13px;
            font-size: 0.85rem;
            white-space: nowrap;
            height: fit-content;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
        }

        .form-control,
        .form-select {
            min-height: 45px;
            border-radius: 8px;
        }

        textarea.form-control {
            min-height: 90px;
            resize: vertical;
        }

        .save-button {
            padding: 10px 25px;
            font-weight: 600;
        }

        @media (max-width: 576px) {
            .form-header {
                flex-direction: column;
                gap: 15px;
            }

            .back-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <main class="container" style="max-width: 900px;">
        <div class="card shadow form-card">
            <div class="card-body p-4 p-md-5">

                <div class="d-flex justify-content-between align-items-start form-header mb-4">
                    <div>
                        <h2 class="form-title mb-1">⚡ <?= esc($title) ?></h2>
                        <p class="text-muted mb-0">Puihaha Electric Company</p>
                    </div>

                    <a class="btn btn-outline-secondary back-button" href="<?= base_url('dashboard') ?>">
                        ← Back to Dashboard
                    </a>
                </div>

                <?php $errors = session()->getFlashdata('errors'); ?>

                <?php if ($errors): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= $account ? base_url('account/' . $account['id']) : base_url('account') ?>">
                    <?= csrf_field() ?>

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label">Account Number</label>
                            <input class="form-control" name="account_number" required
                                value="<?= esc(old('account_number', $account['account_number'] ?? '')) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Customer Name</label>
                            <input class="form-control" name="customer_name" required
                                value="<?= esc(old('customer_name', $account['customer_name'] ?? '')) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input class="form-control" type="email" name="email" required
                                value="<?= esc(old('email', $account['email'] ?? '')) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input class="form-control" name="phone" required
                                value="<?= esc(old('phone', $account['phone'] ?? '')) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Meter Number</label>
                            <input class="form-control" name="meter_number" required
                                value="<?= esc(old('meter_number', $account['meter_number'] ?? '')) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Connection Type</label>

                            <?php $connectionType = old('connection_type', $account['connection_type'] ?? 'residential'); ?>

                            <select class="form-select" name="connection_type" required>
                                <option value="residential" <?= $connectionType === 'residential' ? 'selected' : '' ?>>
                                    Residential
                                </option>
                                <option value="commercial" <?= $connectionType === 'commercial' ? 'selected' : '' ?>>
                                    Commercial
                                </option>
                                <option value="industrial" <?= $connectionType === 'industrial' ? 'selected' : '' ?>>
                                    Industrial
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Account Status</label>

                            <?php $status = old('status', $account['status'] ?? 'active'); ?>

                            <select class="form-select" name="status" required>
                                <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                <option value="suspended" <?= $status === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" required><?= esc(old('address', $account['address'] ?? '')) ?></textarea>
                        </div>

                    </div>

                    <div class="mt-4 pt-2">
                        <button class="btn btn-primary save-button" type="submit">
                            <?= $account ? 'Save Changes' : 'Add Account' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>