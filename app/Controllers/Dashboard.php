<?php

namespace App\Controllers;

use App\Models\CustomerAccountModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Dashboard extends BaseController
{
    public function index()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $search = trim((string) $this->request->getGet('search'));
        $status = strtolower(trim((string) $this->request->getGet('status')));
        $type = strtolower(trim((string) $this->request->getGet('type')));

        $allowedStatuses = ['active', 'inactive', 'suspended'];
        $allowedTypes = ['residential', 'commercial', 'industrial'];

        $status = in_array($status, $allowedStatuses, true) ? $status : '';
        $type = in_array($type, $allowedTypes, true) ? $type : '';

        $accounts = new CustomerAccountModel();

        if ($search !== '') {
            $accounts->groupStart()
                ->like('account_number', $search)
                ->orLike('customer_name', $search)
                ->orLike('email', $search)
                ->orLike('phone', $search)
                ->groupEnd();
        }

        if ($status !== '') {
            $accounts->where('status', $status);
        }

        if ($type !== '') {
            $accounts->where('connection_type', $type);
        }

        $accountRows = $accounts
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $pager = $accounts->pager;
        $pager->setPath('dashboard');
        $pager->only(['search', 'status', 'type']);

        $statistics = new CustomerAccountModel();

        return view('home/index', [
            'accounts'           => $accountRows,
            'pager'              => $pager,
            'current_page'       => $pager->getCurrentPage(),
            'search_keyword'     => $search,
            'filter_status'      => $status,
            'filter_type'        => $type,
            'total_accounts'     => $statistics->getTotalAccounts(),
            'active_accounts'    => $statistics->getCountByStatus('active'),
            'inactive_accounts'  => $statistics->getCountByStatus('inactive'),
            'suspended_accounts' => $statistics->getCountByStatus('suspended'),
        ]);
    }

    public function viewAccount(int $id)
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $account = (new CustomerAccountModel())->find($id);

        if ($account === null) {
            throw PageNotFoundException::forPageNotFound(
                'Customer account not found.'
            );
        }

        return view('home/view_account', ['account' => $account]);
    }
}