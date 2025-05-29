<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\PurchaseItem;
use App\Models\SaleItem;
use DataTables;

class ItemStockController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $month = $request->month;
            $year = $request->year;
            $items = Item::all();
            $data = $items->map(function($item, $i) use ($month, $year) {
                // Opening stock
                $opening = $item->opening_stock;
                // Purchased in month
                $purchased = 0;
                $sold = 0;
                // Purchases
                $purchases = PurchaseItem::whereJsonContains('items', [['item_name' => $item->item_name]])
                    ->whereMonth('date', $month)->whereYear('date', $year)->get();
                foreach ($purchases as $purchase) {
                    foreach (json_decode($purchase->items, true) as $pItem) {
                        if ($pItem['item_name'] == $item->item_name) {
                            $purchased += $pItem['quantity'];
                        }
                    }
                }
                // Sales
                $sales = SaleItem::whereJsonContains('items', [['item_name' => $item->item_name]])
                    ->whereMonth('date', $month)->whereYear('date', $year)->get();
                foreach ($sales as $sale) {
                    foreach (json_decode($sale->items, true) as $sItem) {
                        if ($sItem['item_name'] == $item->item_name) {
                            $sold += $sItem['quantity'];
                        }
                    }
                }
                $current = $opening + $purchased - $sold;
                return [
                    'sr_no' => $i+1,
                    'item_name' => $item->item_name,
                    'opening_stock' => $opening,
                    'purchased' => $purchased,
                    'sold' => $sold,
                    'current_stock' => $current,
                ];
            });
            return DataTables::of($data)->make(true);
        }
        return view('item_stock.index');
    }
} 