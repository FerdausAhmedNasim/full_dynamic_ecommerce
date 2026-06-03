<?php

namespace Database\Seeders\DemoData;

use App\Models\User;
use Faker\Generator;
use App\Library\Enum;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductStock;
use App\Models\ProductReview;
use App\Models\ProductDetails;
use App\Models\ProductService;
use App\Models\ProductLanguage;
use Illuminate\Database\Seeder;
use Illuminate\Container\Container;
use App\Models\ProductServiceLanguage;

class ProductSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Container::getInstance()->make(Generator::class);
    }

    public function run()
    {
        $products = Product::factory(40)->create();

        $products->each(function ($product) {
            $storeLanguage = new ProductLanguage();
            $storeLanguage->local = 'en';
            $storeLanguage->title = Str::of($product->slug)->replace('-', ' ')->title();
            $storeLanguage->product_id = $product->id;
            $storeLanguage->save();

            $product->has_discount = 1;
            $product->save();

            $productDetails = new ProductDetails;
            $productDetails->estimated_shipping_days = '3';
            $productDetails->discount_type = Enum::DISCOUNT_TYPE_FLAT;
            $productDetails->discount = 5;
            $productDetails->discount_start = now()->format('Y-m-d');
            $productDetails->discount_end = now()->addMonth()->format('Y-m-d');;
            $productDetails->product_id = $product->id;
            $productDetails->shipping_type = Enum::SHIPPING_TYPE_FLAT_RATE;
            $productDetails->save();

            $productService = new ProductService();
            $productService->product_id = $product->id;
            $productService->order = 1;
            $productService->active = 1;
            $productService->operator_id = 1;
            $productService->save();

            $productServiceLanguage = new ProductServiceLanguage();
            $productServiceLanguage->local = 'en';
            $productServiceLanguage->title = $this->faker->sentence($this->faker->numberBetween(3, 5));
            $productServiceLanguage->sub_title = $this->faker->sentence;
            $productServiceLanguage->product_service_id = $productService->id;
            $productServiceLanguage->save();

            $variant = new ProductStock();
            $variant->product_id = $product->id;
            $variant->current_stock = $product->current_stock;
            $variant->unit_price = $product->unit_price;
            $variant->sku = random_int(100, 999);
            $variant->save();

            // $iterate = 1;
            // while ($product->id % 2 && $iterate <= 5) {
            //     $variant = new ProductReview();
            //     $variant->customer_id = User::where('user_type', Enum::USER_TYPE_CUSTOMER)->get()->random(1)->first()->id;
            //     $variant->product_id = $product->id;
            //     $variant->active = 1;
            //     $variant->rating = random_int(1, 5);
            //     $variant->comment = $iterate % 2 ? $this->faker->paragraph : $this->faker->sentence ;
            //     $variant->save();

            //     $iterate += 1;
            // }
        });
    }
}
