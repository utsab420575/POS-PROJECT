<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class ProductsImport implements ToCollection, WithHeadingRow, SkipsOnFailure, SkipsOnError, WithValidation
{
    use SkipsFailures, SkipsErrors;

    public function collection(Collection $rows)
    {
        DB::beginTransaction();

        try {
            foreach ($rows as $row) {
                $productCode = $row['product_code'];

                // Check duplicate in DB
                if (Product::where('product_code', $productCode)->exists()) {
                    throw new \Exception("Duplicate product_code found: $productCode");
                }

                // Create product
                Product::create([
                    'product_name'     => $row['product_name'],
                    'category_id'      => $row['category_id'],
                    'supplier_id'      => $row['supplier_id'],
                    'product_code'     => $productCode,
                    'product_garage'   => $row['product_garage'],
                    'product_image'    => $row['product_image'],
                    'product_store'    => $row['product_store'],
                    'buying_date'      => $row['buying_date'],
                    'expire_date'      => $row['expire_date'],
                    'buying_price'     => $row['buying_price'],
                    'selling_price'    => $row['selling_price'],
                ]);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // Let the controller catch and show message
        }
    }

    //t validates each row of the Excel file before inserting it into the database.need must
    public function rules(): array
    {
        return [
            '*.product_code' => ['required'],
            '*.product_name' => ['required'],
        ];
    }
}
