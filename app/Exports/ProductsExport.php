<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::select(
            'product_name',
            'category_id',
            'supplier_id',
            'product_code',
            'product_garage',
            'product_image',
            'product_store',
            'buying_date',
            'expire_date',
            'buying_price',
            'selling_price'
        )->get();
    }

    public function headings(): array
    {
        return [
            'product_name',
            'category_id',
            'supplier_id',
            'product_code',
            'product_garage',
            'product_image',
            'product_store',
            'buying_date',
            'expire_date',
            'buying_price',
            'selling_price'
        ];
    }
}
