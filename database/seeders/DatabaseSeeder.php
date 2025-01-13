<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Address;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(3)->create();
        // Address::factory(6)->create();
        
        Category::create(['id'=>1,'name' => 'Electronics', 'icon'=>'bi bi-lightning']);
        Category::create(['id'=>2,'name' => 'Περιποίηση', 'icon'=>'bi bi-heart']);
        Category::create(['id'=>3,'name' => 'Διατροφή', 'icon'=>'bi bi-cup-straw']);
        Category::create(['id'=>4,'name' => 'Hobby', 'icon'=>'bi bi-palette']);
        Category::create(['id'=>5,'name' => 'Αυτοάμυνα', 'icon'=>'bi bi-shield']);

        Product::create([
            'name' => 'Σπρέι πιπεριού 200ml',
            'description'=> 'Σπρέι πιπεριού για αυτοάμυνα',
            'price' => 47.99,
            'stock'=>121,
            'image'=>'pexels-eprism-studio-108171-335257.jpg',
            'category_id' => 5,
        ]);

        Product::create([
            'name' => 'Ρολόι χειρός',
            'description'=> 'Δείχνει μόνο την ώρα, τα λεπτά και τα δευτερόλεπτα',
            'price' => 236.99,
            'stock'=>0,
            'image'=>'pexels-javon-swaby-197616-2783873.jpg',
            'category_id' => 2,
        ]);

        Product::create([
            'name' => 'Κρυπτονίτης 20gr',
            'description'=> 'anti-Superman μίας χρήσης',	
            'price' => 12.99,
            'stock'=>130,
            'image'=>'pexels-karolina-grabowska-4040600.jpg',
            'category_id' => 5,
        ]);

        Product::create([
            'name' => 'Σαπούνι 100gr',
            'description'=> 'Για χέρια, για πόδια, για πιάτα και για ρούχα',	
            'price' => 6.99,
            'stock'=>4,
            'image'=>'pexels-karolina-grabowska-4210374.jpg',
            'category_id' => 2,
        ]);

        Product::create([
            'name' => 'Φοινικέλαιο 750ml',
            'description'=> 'Εξαιρετικό για το μαγείρεμα και τα τριγλυκερίδια',	
            'price' => 6.99,
            'stock'=>9,
            'image'=>'pexels-karolina-grabowska-4465828.jpg',
            'category_id' => 3,
        ]);

        Product::create([
            'name' => 'Φωτογραφική μηχανή',
            'description'=> 'Με φακό 50mm και αισθητήρα 24MP',	
            'price' => 319.99,
            'stock'=>0,
            'image'=>'pexels-madebymath-90946.jpg',
            'category_id' => 4,
        ]);

        Product::create([
            'name' => 'Smartwatch με κλαδί ελιάς',
            'description'=> 'Με ενσωματωμένο GPS και αισθητήρα καρδιακών παλμών',	
            'price' => 89.99,
            'stock'=>42,
            'image'=>'pexels-olenkabohovyk-3646165.jpg',
            'category_id' => 1,
        ]);

        Product::create([
            'name' => 'Δοχεία για γάλα',
            'description'=> 'Σετ 3 τεμαχίων',	
            'price' => 19.99,
            'stock'=>195,
            'image'=>'pexels-pixabay-248412.jpg',
            'category_id' => 3,
        ]);

        Product::create([
            'name' => 'Φακός Φωτογραφικής Μηχανής',
            'description'=> 'Με μεγέθυνση 50mm',	
            'price' => 99.99,
            'stock'=>7,
            'image'=>'pexels-pixabay-279906.jpg',
            'category_id' => 4,
        ]);

        Product::create([
            'name' => 'Πένα για έγχορδα',
            'description'=> 'Ιδανική για τσέλο και κοντραμπάσο',	
            'price' => 4.99,
            'stock'=>121,
            'image'=>'pexels-rombo-1510555-3801990.jpg',
            'category_id' => 4,
        ]);


        
        OrderStatus::create(['name' => 'Processing']);
        OrderStatus::create(['name' => 'Shipped']);
        OrderStatus::create(['name' => 'Canceled']);
    }
}
