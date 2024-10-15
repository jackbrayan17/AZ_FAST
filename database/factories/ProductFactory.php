namespace Database\Factories;

use App\Models\Product;
use App\Models\User;  // Make sure to import the User model
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'category_id' => \App\Models\Category::factory(),  // assuming you have a Category model
            'price' => $this->faker->randomFloat(2, 1000, 50000),
            'description' => $this->faker->sentence,
            'stock' => $this->faker->numberBetween(10, 100),
            'user_id' => User::factory(),  // Add this line to generate a valid user ID
        ];
    }
}
