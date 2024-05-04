<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transcation;
use Auth, DB;
class WalletController extends Controller
{
    public function index(Request $request)
    {
        $opening = 0;
        $cloesing = 0;
        if ($request->paginate) {
            $paginate = $request->paginate;
        } else {
            $paginate = 20;
        }
        if ($request->sort_f) {
            $sort_f = $request->sort_f;
        } else {
            $sort_f = "id";
        }
        if ($request->sort_by) {
            $sort_by = $request->sort_by;
        } else {
            $sort_by = "ASC";
        }
        $search = $request->search;
        $wallet = User::sum("wallet");
       // $transactional_wallet = User::sum("transactional_wallet");
        $transcation = Transcation::select(
            "*",
            \DB::raw(
                '(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = transcations.user_id) AS created_by'
            )
        );
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        if ($startDate != null && $endDate != null) {
            $transcation = $transcation->whereBetween("created_at", [
                $startDate . " 00:00:00",
                $endDate . " 23:59:59",
            ]);
        }

        if ($request->user != null && $request->user != "") {
            $transcation = $transcation->where("user_id", $request->user);
            $data = $transcation->first();
            if ($data) {
                if ($data->debit_amount != 0) {
                    $opening = $data->debit_amount + $data->remaining_amount;
                } else {
                    $opening = $data->remaining_amount;
                }
                $cloesing = $transcation
                    ->orderBy("id", "desc")
                    ->value("remaining_amount");
            }
        }
        if (strpos(strtolower($search), "promotional") !== false) {
            $transcation = $transcation->where("transcation_type", 1);
        } elseif (strpos(strtolower($search), "transactional") !== false) {
            $transcation = $transcation->where("transcation_type", 2);
        } else {
            if ($search != null) {
                $transcation = $transcation->Where(
                    DB::raw(
                        '(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = transcations.user_id)'
                    ),
                    "LIKE",
                    "%" . $search . "%"
                );
            }
        }

        $transcation = $transcation
            ->orderBy($sort_f, $sort_by)
            ->paginate($paginate);

        if ($request->ajax()) {
            $view = view(
                "admin.wallet.scroll_data",
                compact("transcation")
            )->render();
            return response()->json(["html" => $view]);
        }
        $user = User::whereHas("roles", function ($q) {
            $q->whereIn("name", [
                "superdistributor",
                "distributor",
                "reseller",
                "user",
            ]);
        })->get();
        return view(
            "admin.wallet.index",
            compact(
               // "transactional_wallet",
                "wallet",
                "transcation",
                "paginate",
                "search",
                "sort_f",
                "sort_by",
                "user",
                "startDate",
                "endDate",
                "cloesing",
                "opening"
            )
        );
    }

    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }
}
