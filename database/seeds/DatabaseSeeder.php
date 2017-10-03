

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ManajemenTableSeeder::class);
        $this->call(ArsipTableSeeder::class);
        $this->call(DraftingTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
