<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Category;
use App\Models\CustomerMetadata;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomersExport;

class AdminController extends Controller
{
    /**
     * Listado simple sin filtros.
     */
    public function index(): View
    {
        $customers = Customer::latest('customers.created_at')
            ->with(['categories', 'metadata'])
            ->paginate(15);

        return view('customers.index', compact('customers'));
    }

    /**
     * Mostrar detalle.
     */
    public function show(Customer $customer)
    {
        $customer->load(['categories', 'metadata']);

        if (!view()->exists('customers.show')) {
            return redirect()->route('customers.index')->with('error', 'Vista de detalle no implementada.');
        }

        return view('customers.show', compact('customer'));
    }

    /**
     * FILTRO DE CLIENTES + METADATOS
     * Adaptado para cifrado automático + search fields.
     */
    public function filter(Request $request): View
    {
        $filters = $request->all();
        $query = Customer::query()->select('customers.*');

        /*
        ───────────────────────────────────────────────
        🔍 CUSTOMER: USAR SEARCH_FIELDS (cifrado)
        ───────────────────────────────────────────────
        */
        if (!empty($filters['first_name'])) {
            $query->where('first_name_search', 'LIKE', '%' . strtolower($filters['first_name']) . '%');
        }

        if (!empty($filters['last_name'])) {
            $query->where('last_name_search', 'LIKE', '%' . strtolower($filters['last_name']) . '%');
        }

        if (!empty($filters['email'])) {
            $query->where('email_search', 'LIKE', '%' . strtolower($filters['email']) . '%');
        }

        if (!empty($filters['phone'])) {
            $normalized = preg_replace('/\D+/', '', $filters['phone']);
            $query->where('phone_search', 'LIKE', '%' . $normalized . '%');
        }

        /*
        ───────────────────────────────────────────────
        🔍 CAMPOS NO CIFRADOS (BUSCADOS NORMALMENTE)
        ───────────────────────────────────────────────
        */
        if (!empty($filters['country'])) {
            $query->where('country', 'LIKE', '%' . $filters['country'] . '%');
        }

        if (!empty($filters['city'])) {
            $query->where('city', 'LIKE', '%' . $filters['city'] . '%');
        }

        if (!empty($filters['company'])) {
            $query->where('company', 'LIKE', '%' . $filters['company'] . '%');
        }

        /*
        ───────────────────────────────────────────────
        🔍 FECHAS DEL CUSTOMER
        ───────────────────────────────────────────────
        */
        if (!empty($filters['customer_date_from'])) {
            $query->whereDate('customers.created_at', '>=', $filters['customer_date_from']);
        }

        if (!empty($filters['customer_date_to'])) {
            $query->whereDate('customers.created_at', '<=', $filters['customer_date_to']);
        }

        /*
        ───────────────────────────────────────────────
        🔍 FILTRO POR CATEGORÍAS
        ───────────────────────────────────────────────
        */
        if (!empty($filters['categories'])) {
            $catIds = is_array($filters['categories']) ? $filters['categories'] : [$filters['categories']];

            $query->whereHas('categories', function ($q) use ($catIds) {
                $q->whereIn('categories.id', $catIds);
            });
        }

        /*
        ───────────────────────────────────────────────
        🔍 METADATA JOIN (solo si se solicita)
        ───────────────────────────────────────────────
        */
        $needsMetadataJoin = false;

        foreach (['source', 'language', 'metadata_date_from', 'metadata_date_to', 'suspected_bot'] as $f) {
            if (!empty($filters[$f])) {
                $needsMetadataJoin = true;
                break;
            }
        }

        if ($needsMetadataJoin) {
            $query->join('customer_metadata', 'customers.id', '=', 'customer_metadata.customer_id');

            if (!empty($filters['source'])) {
                $query->where('customer_metadata.source', 'LIKE', '%' . $filters['source'] . '%');
            }

            if (!empty($filters['language'])) {
                $query->where('customer_metadata.browser_language', 'LIKE', '%' . $filters['language'] . '%');
            }

            if (isset($filters['suspected_bot']) && $filters['suspected_bot'] !== '') {
                $query->where('customer_metadata.suspected_bot', $filters['suspected_bot']);
            }

            if (!empty($filters['metadata_date_from'])) {
                $query->whereDate('customer_metadata.registration_date', '>=', $filters['metadata_date_from']);
            }

            if (!empty($filters['metadata_date_to'])) {
                $query->whereDate('customer_metadata.registration_date', '<=', $filters['metadata_date_to']);
            }
        }

        /*
        ───────────────────────────────────────────────
        🔍 EJECUCIÓN FINAL (distinct evita duplicados)
        ───────────────────────────────────────────────
        */
        $customers = $query
            ->distinct('customers.id')
            ->latest('customers.created_at')
            ->paginate(15);

        $customers->loadMissing(['categories', 'metadata']);

        $categories = Category::orderBy('name')->get();

        return view('customers.filter', compact('customers', 'categories', 'filters'));
    }

    /**
     * Exportación Excel.
     */
    public function exportExcel(Request $request)
    {
        $filters = $request->all();
        $fileName = 'clientes_filtrados_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new CustomersExport($filters), $fileName);
    }

    /**
     * Listado de metadatos.
     */
    public function showMetadata(): View
    {
        $metadataItems = CustomerMetadata::with('customer')
            ->latest('registration_date')
            ->paginate(15);

        return view('customers.metadata', compact('metadataItems'));
    }
}
