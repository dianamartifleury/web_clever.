<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CustomersExport implements FromView
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        $filters = $this->filters;

        $query = Customer::query()->select('customers.*');

        // ============================================================
        // FILTROS SOBRE CAMPOS CIFRADOS → USAR *_search
        // ============================================================
        if (!empty($filters['first_name'])) {
            $query->where('first_name_search', 'like', '%' . strtolower($filters['first_name']) . '%');
        }

        if (!empty($filters['last_name'])) {
            $query->where('last_name_search', 'like', '%' . strtolower($filters['last_name']) . '%');
        }

        if (!empty($filters['email'])) {
            $query->where('email_search', 'like', '%' . strtolower($filters['email']) . '%');
        }

        if (!empty($filters['company'])) {
            $query->where('company', 'like', '%' . $filters['company'] . '%');
        }

        if (!empty($filters['country'])) {
            $query->where('country', 'like', '%' . $filters['country'] . '%');
        }

        if (!empty($filters['city'])) {
            $query->where('city', 'like', '%' . $filters['city'] . '%');
        }

        // Fechas
        if (!empty($filters['customer_date_from'])) {
            $query->whereDate('customers.created_at', '>=', $filters['customer_date_from']);
        }

        if (!empty($filters['customer_date_to'])) {
            $query->whereDate('customers.created_at', '<=', $filters['customer_date_to']);
        }

        // Categorías
        if (!empty($filters['categories'])) {
            $query->whereHas('categories', function ($q) use ($filters) {
                $q->whereIn('categories.id', $filters['categories']);
            });
        }

        // ============================================================
        // FILTROS DE METADATOS (igual que AdminController)
        // ============================================================

        $needsJoin = false;

        if (!empty($filters['source']) ||
            !empty($filters['metadata_date_from']) ||
            !empty($filters['metadata_date_to'])
        ) {
            $needsJoin = true;
        }

        if ($needsJoin) {

            $query->join('customer_metadata', 'customers.id', '=', 'customer_metadata.customer_id');

            if (!empty($filters['source'])) {
                $query->where('customer_metadata.source', 'like', '%' . $filters['source'] . '%');
            }

            if (!empty($filters['metadata_date_from'])) {
                $query->whereDate('customer_metadata.registration_date', '>=', $filters['metadata_date_from']);
            }

            if (!empty($filters['metadata_date_to'])) {
                $query->whereDate('customer_metadata.registration_date', '<=', $filters['metadata_date_to']);
            }
        }

        // ============================================================
        // RESULTADOS + RELACIONES
        // ============================================================
        $customers = $query
            ->distinct('customers.id')
            ->with(['categories', 'metadata'])
            ->orderBy('customers.created_at', 'desc')
            ->get();

        return view('exports.customers', [
            'customers' => $customers,
        ]);
    }
}