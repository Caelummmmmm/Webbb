<?php

namespace App\Controllers;

use App\Models\CustomerAccountModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Accounts extends BaseController
{
    private CustomerAccountModel $accounts;

    public function __construct()
    {
        $this->accounts = new CustomerAccountModel();
    }

    private function requireLogin()
    {
        if (session()->get('isLoggedIn') !== true) {
            return redirect()->to('/login')
                ->with('error', 'Please log in first.');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $search = trim((string) $this->request->getGet('search'));
        $status = trim((string) $this->request->getGet('status'));
        $type = trim((string) $this->request->getGet('type'));

        $builder = $this->accounts;

        if ($search !== '') {
            $builder = $builder->groupStart()
                ->like('account_number', $search)
                ->orLike('customer_name', $search)
                ->orLike('email', $search)
                ->orLike('phone', $search)
                ->groupEnd();
        }

        if ($status !== '') {
            $builder = $builder->where('status', $status);
        }

        if ($type !== '') {
            $builder = $builder->where('connection_type', $type);
        }

        return view('home/index', [
            'accounts' => $builder->orderBy('created_at', 'DESC')->paginate(10),
            'pager' => $this->accounts->pager,
            'current_page' => $this->accounts->pager->getCurrentPage(),

            'total_accounts' => $this->accounts->countAll(),
            'active_accounts' => $this->accounts->where('status', 'active')->countAllResults(),
            'inactive_accounts' => $this->accounts->where('status', 'inactive')->countAllResults(),
            'suspended_accounts' => $this->accounts->where('status', 'suspended')->countAllResults(),

            'search_keyword' => $search,
            'filter_status' => $status,
            'filter_type' => $type,
        ]);
    }

    public function show(int $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        return view('home/view_account', [
            'account' => $this->findAccount($id),
        ]);
    }

    public function new()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        return view('home/account_form', [
            'account' => null,
            'title' => 'Add Customer Account',
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        if (!$this->validateAccount()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->accounts->insert($this->accountData());

        return redirect()->to('/dashboard')
            ->with('success', 'Customer account added successfully.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        return view('home/account_form', [
            'account' => $this->findAccount($id),
            'title' => 'Edit Customer Account',
        ]);
    }

    public function update(int $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $this->findAccount($id);

        if (!$this->validateAccount($id)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->accounts->update($id, $this->accountData());

        return redirect()->to('/account/' . $id)
            ->with('success', 'Customer account updated successfully.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $this->findAccount($id);
        $this->accounts->delete($id);

        return redirect()->to('/dashboard')
            ->with('success', 'Customer account deleted.');
    }

    private function findAccount(int $id): array
    {
        return $this->accounts->find($id)
            ?? throw PageNotFoundException::forPageNotFound();
    }

    private function validateAccount(?int $id = null): bool
    {
        $unique = 'is_unique[customer_accounts.account_number'
            . ($id ? ',id,' . $id : '') . ']';

        return $this->validate([
            'account_number' => 'required|max_length[30]|' . $unique,
            'customer_name' => 'required|min_length[2]|max_length[150]',
            'address' => 'required|max_length[255]',
            'phone' => 'required|max_length[30]',
            'email' => 'required|valid_email|max_length[150]',
            'meter_number' => 'required|max_length[50]',
            'connection_type' => 'required|in_list[residential,commercial,industrial]',
            'status' => 'required|in_list[active,inactive,suspended]',
        ]);
    }

    private function accountData(): array
    {
        return $this->request->getPost([
            'account_number',
            'customer_name',
            'address',
            'phone',
            'email',
            'meter_number',
            'connection_type',
            'status',
        ]);
    }
}