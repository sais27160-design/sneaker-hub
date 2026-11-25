<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Order;
use App\Models\Sneaker;
use App\Models\SneakerSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSneakerController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
    }

    public function index(Request $request)
    {
        $this->ensureAdmin();

        $brands = Brand::orderBy('name')->get();
        $sneakers = Sneaker::with(['brand', 'sizes'])->orderByDesc('id')->get();
        $editingSneaker = null;

        if ($request->filled('edit')) {
            $editingSneaker = Sneaker::with(['brand', 'sizes'])->findOrFail($request->query('edit'));
        }

        $totalSneakers = Sneaker::count();
        $totalStock = SneakerSize::sum('stock_quantity');
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount');

        return view('admin.dashboard', compact(
            'brands',
            'sneakers',
            'editingSneaker',
            'totalSneakers',
            'totalStock',
            'totalOrders',
            'totalRevenue'
        ));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $data = $this->validatedSneakerData($request);

        DB::transaction(function () use ($data) {
            $data['model'] = $data['name'];
            $sneaker = Sneaker::create($data);
            $this->createSizeRows($sneaker, (int) $data['stock_quantity']);
        });

        return redirect()->route('admin.dashboard')->with('success', 'Sneaker added successfully.');
    }

    public function update(Request $request, Sneaker $sneaker)
    {
        $this->ensureAdmin();

        $data = $this->validatedSneakerData($request);
        $newTotalStock = (int) $data['stock_quantity'];

        DB::transaction(function () use ($sneaker, $data, $newTotalStock) {
            $data['model'] = $data['name'];
            $sneaker->update($data);
            $this->adjustSizeStock($sneaker, $newTotalStock);
        });

        return redirect()->route('admin.dashboard')->with('success', 'Sneaker updated successfully.');
    }

    public function destroy(Sneaker $sneaker)
    {
        $this->ensureAdmin();

        // Keep historical order records intact.
        if ($sneaker->orderItems()->exists()) {
            return redirect()->route('admin.dashboard')->with('error', 'This sneaker cannot be deleted because it is included in an order.');
        }

        DB::transaction(function () use ($sneaker) {
            $sneaker->wishlists()->delete();
            $sneaker->sizes()->delete();
            $sneaker->delete();
        });

        return redirect()->route('admin.dashboard')->with('success', 'Sneaker deleted successfully.');
    }

    private function validatedSneakerData(Request $request): array
{
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'brand_id' => ['required', 'integer', 'exists:brands,id'],
        'price' => ['required', 'numeric', 'min:0'],
        'stock_quantity' => ['required', 'integer', 'min:0'],
        'image' => ['nullable', 'string', 'max:2048'],
        'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
    ]);

    // Upload image to Laravel public storage
    if ($request->hasFile('image_file')) {
        $data['image'] = $request->file('image_file')
            ->store('sneakers', 'public');
    } else {
        $data['image'] = trim($data['image'] ?? '') !== ''
            ? trim($data['image'])
            : null;
    }

    unset($data['image_file']);

    return $data;

    }

    /** Create the seven EU sizes and split the entered total stock between them. */
    private function createSizeRows(Sneaker $sneaker, int $totalStock): void
    {
        $sizes = [38, 39, 40, 41, 42, 43, 44];
        $baseStock = intdiv($totalStock, count($sizes));
        $remainder = $totalStock % count($sizes);

        foreach ($sizes as $index => $size) {
            $sneaker->sizes()->create([
                'size' => $size,
                'stock_quantity' => $baseStock + ($index < $remainder ? 1 : 0),
            ]);
        }

        $sneaker->update(['stock_quantity' => $totalStock]);
    }

    /** Adjust total stock while preserving existing size allocations as much as possible. */
    private function adjustSizeStock(Sneaker $sneaker, int $newTotal): void
    {
        $sizes = $sneaker->sizes()->orderBy('size')->get();

        if ($sizes->isEmpty()) {
            $this->createSizeRows($sneaker, $newTotal);
            return;
        }

        $currentTotal = (int) $sizes->sum('stock_quantity');

        if ($currentTotal === 0 && $newTotal > 0) {
            $baseStock = intdiv($newTotal, $sizes->count());
            $remainder = $newTotal % $sizes->count();

            foreach ($sizes->values() as $index => $sizeRow) {
                $sizeRow->update([
                    'stock_quantity' => $baseStock + ($index < $remainder ? 1 : 0),
                ]);
            }
        } elseif ($newTotal > $currentTotal) {
            $increase = $newTotal - $currentTotal;
            $targetSize = $sizes->firstWhere('size', 42) ?? $sizes->last();
            $targetSize->increment('stock_quantity', $increase);
        } elseif ($newTotal < $currentTotal) {
            $remainingToRemove = $currentTotal - $newTotal;

            foreach ($sizes->sortByDesc('stock_quantity') as $sizeRow) {
                if ($remainingToRemove <= 0) {
                    break;
                }

                $removeFromThisSize = min((int) $sizeRow->stock_quantity, $remainingToRemove);
                $sizeRow->decrement('stock_quantity', $removeFromThisSize);
                $remainingToRemove -= $removeFromThisSize;
            }
        }

        $sneaker->update(['stock_quantity' => $newTotal]);
    }
}
