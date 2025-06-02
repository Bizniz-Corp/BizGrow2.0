<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use App\Models\SalesTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class SalesControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Nonaktifkan middleware autentikasi
        $this->withoutMiddleware();

        // Mock Auth::id() untuk mengembalikan user ID
        Auth::shouldReceive('id')->andReturn(6);
    }

    private function mockSalesTransactionWithData(array $data)
    {
        $mock = Mockery::mock('overload:' . SalesTransaction::class);
        $mock->shouldReceive('join')->andReturnSelf();
        $mock->shouldReceive('where')->andReturnSelf();
        $mock->shouldReceive('whereBetween')->andReturnSelf();
        $mock->shouldReceive('select')->andReturnSelf();
        $mock->shouldReceive('orderBy')->andReturnSelf();
        $mock->shouldReceive('paginate')->andReturn(
            new LengthAwarePaginator($data, count($data), 10, 1)
        );
    }

    private function mockSalesTransaction()
    {
        $mock = Mockery::mock('overload:' . SalesTransaction::class);
        $mock->shouldReceive('join')->andReturnSelf();
        $mock->shouldReceive('where')->andReturnSelf();
        $mock->shouldReceive('whereBetween')->andReturnSelf();
        $mock->shouldReceive('select')->andReturnSelf();
        $mock->shouldReceive('orderBy')->andReturnSelf();
        $mock->shouldReceive('paginate')->andReturn(
            new LengthAwarePaginator([], 0, 10, 1)
        );
    }

    public function test_path_1_with_filters()
    {
        $productName = 'Bakso';
        $startDate = '2024-03-10';
        $endDate = '2024-12-10';

        // Mock SalesTransaction
        $mock = Mockery::mock('overload:' . SalesTransaction::class);
        $mock->shouldReceive('join')->andReturnSelf();
        $mock->shouldReceive('where')
            ->with('umkms.user_id', 6)
            ->once()
            ->andReturnSelf();
        $mock->shouldReceive('where')
            ->with('products.product_name', 'like', '%' . $productName . '%')
            ->once()
            ->andReturnSelf();
        $mock->shouldReceive('whereBetween')
            ->with('sales_transactions.sales_date', [$startDate, $endDate])
            ->once()
            ->andReturnSelf();
        $mock->shouldReceive('select')->andReturnSelf();
        $mock->shouldReceive('orderBy')->andReturnSelf();
        $mock->shouldReceive('paginate')->andReturn(
            new LengthAwarePaginator([], 0, 10, 1)
        );

        // Kirim request ke endpoint
        $response = $this->getJson('/api/sales-history?product_name=' . $productName . '&start_date=' . $startDate . '&end_date=' . $endDate);

        // Verifikasi response
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [],
                'pagination' => [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => 10,
                    'total' => 0,
                ],
            ]);
    }

    public function test_path_2_without_end_date()
    {
        $productName = 'Bakso';
        $startDate = '2024-03-10';

        $mock = Mockery::mock('overload:' . SalesTransaction::class);
        $mock->shouldReceive('join')->andReturnSelf();
        $mock->shouldReceive('where')
            ->with('umkms.user_id', 6)
            ->once()
            ->andReturnSelf();
        $mock->shouldReceive('where')
            ->with('products.product_name', 'like', '%' . $productName . '%')
            ->once()
            ->andReturnSelf();
        $mock->shouldReceive('whereBetween')->never(); // Tidak boleh dipanggil
        $mock->shouldReceive('select')->andReturnSelf();
        $mock->shouldReceive('orderBy')->andReturnSelf();
        $mock->shouldReceive('paginate')->andReturn(
            new LengthAwarePaginator([], 0, 10, 1)
        );

        $response = $this->getJson('/api/sales-history?product_name=' . $productName . '&start_date=' . $startDate);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [],
                'pagination' => [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => 10,
                    'total' => 0,
                ],
            ]);
    }

    public function test_path_3_without_start_date()
    {
        $productName = 'Bakso';

        $mock = Mockery::mock('overload:' . SalesTransaction::class);
        $mock->shouldReceive('join')->andReturnSelf();
        $mock->shouldReceive('where')
            ->with('umkms.user_id', 6)
            ->once()
            ->andReturnSelf();
        $mock->shouldReceive('where')
            ->with('products.product_name', 'like', '%' . $productName . '%')
            ->once()
            ->andReturnSelf();
        $mock->shouldReceive('whereBetween')->never(); // Tidak boleh dipanggil
        $mock->shouldReceive('select')->andReturnSelf();
        $mock->shouldReceive('orderBy')->andReturnSelf();
        $mock->shouldReceive('paginate')->andReturn(
            new LengthAwarePaginator([], 0, 10, 1)
        );

        $response = $this->getJson('/api/sales-history?product_name=' . $productName);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [],
                'pagination' => [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => 10,
                    'total' => 0,
                ],
            ]);
    }

    public function test_path_4_with_date_range_only()
    {
        $startDate = '2024-03-10';
        $endDate = '2024-12-10';

        $mock = Mockery::mock('overload:' . SalesTransaction::class);
        $mock->shouldReceive('join')->andReturnSelf();
        $mock->shouldReceive('where')
            ->with('umkms.user_id', 6)
            ->once()
            ->andReturnSelf();
        $mock->shouldReceive('where')->never();
        $mock->shouldReceive('whereBetween')
            ->with('sales_transactions.sales_date', [$startDate, $endDate])
            ->once()
            ->andReturnSelf();
        $mock->shouldReceive('select')->andReturnSelf();
        $mock->shouldReceive('orderBy')->andReturnSelf();
        $mock->shouldReceive('paginate')->andReturn(
            new LengthAwarePaginator([], 0, 10, 1)
        );

        $response = $this->getJson('/api/sales-history?start_date=' . $startDate . '&end_date=' . $endDate);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [],
                'pagination' => [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => 10,
                    'total' => 0,
                ],
            ]);
    }
    public function test_path_5_with_start_date_only()
    {
        $startDate = '2023-01-01';

        // Mock SalesTransaction
        $mock = Mockery::mock('overload:' . SalesTransaction::class);
        $mock->shouldReceive('join')->andReturnSelf();
        $mock->shouldReceive('where')
            ->with('umkms.user_id', 6)
            ->once()
            ->andReturnSelf();
        $mock->shouldReceive('where')->never(); // Tidak boleh dipanggil untuk product_name
        $mock->shouldReceive('whereBetween')->never(); // Tidak boleh dipanggil karena tidak ada end_date
        $mock->shouldReceive('select')->andReturnSelf();
        $mock->shouldReceive('orderBy')->andReturnSelf();
        $mock->shouldReceive('paginate')->andReturn(
            new LengthAwarePaginator([], 0, 10, 1)
        );

        // Kirim request ke endpoint
        $response = $this->getJson('/api/sales-history?start_date=' . $startDate);

        // Verifikasi response
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [],
                'pagination' => [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => 10,
                    'total' => 0,
                ],
            ]);
    }

    public function test_path_6_without_any_date_filters()
    {
        // Mock SalesTransaction
        $mock = Mockery::mock('overload:' . SalesTransaction::class);
        $mock->shouldReceive('join')->andReturnSelf();
        $mock->shouldReceive('where')
            ->with('umkms.user_id', 6)
            ->once()
            ->andReturnSelf();
        $mock->shouldReceive('where')->never(); // Tidak boleh dipanggil untuk product_name
        $mock->shouldReceive('whereBetween')->never(); // Tidak boleh dipanggil karena tidak ada start_date dan end_date
        $mock->shouldReceive('select')->andReturnSelf();
        $mock->shouldReceive('orderBy')->andReturnSelf();
        $mock->shouldReceive('paginate')->andReturn(
            new LengthAwarePaginator([], 0, 10, 1)
        );

        // Kirim request ke endpoint
        $response = $this->getJson('/api/sales-history');

        // Verifikasi response
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [],
                'pagination' => [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => 10,
                    'total' => 0,
                ],
            ]);
    }

}