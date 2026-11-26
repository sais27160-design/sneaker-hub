# SneakerHub

SneakerHub is a Laravel sneaker shop for browsing sneakers, managing stock by EU size, saving wishlists, and placing orders.

## How it works

```text
URL → Route → Controller → Model → SQLite database
                         → Blade page or Vue page
```

- **Routes** decide which controller handles a URL.
- **Controllers** run the shop actions and validate form data.
- **Models** connect Laravel to database tables.
- **Blade** displays the shop, cart, checkout, and admin pages.
- **Vue and Inertia** display login and account settings pages.

## Important folders and files

- `routes/web.php` — shop, cart, checkout, and admin URLs.
- `routes/settings.php` — account settings URLs.
- `app/Http/Controllers/` — shop and order logic.
- `app/Models/` — User, Brand, Sneaker, size, wishlist, and order models.
- `database/migrations/` — database table changes.
- `database/database.sqlite` — local database, ignored by Git.
- `resources/views/` — Blade pages.
- `resources/js/` — Vue pages and components.
- `resources/css/app.css` — Tailwind CSS entry point.

## Shopping flow

1. The catalog loads sneakers, brands, and size stock from SQLite.
2. The cart is saved in the visitor's session.
3. A signed-in user checks out. Laravel saves the order and its items, checks and reduces stock, then empties the cart.
4. Shipping costs €3.99. The project records orders but does not take online payments.

Admins need an account with the `admin` role to manage sneakers. Sneaker images are entered as URLs. Stock for each EU size is stored in `sneaker_sizes`.

## Database tables

- `users` — customer and admin accounts.
- `brands` — sneaker brands.
- `sneakers` — sneaker details and image URL.
- `sneaker_sizes` — stock for each size.
- `wishlists` — saved sneakers for each user.
- `orders` and `order_items` — purchases and the sneakers in them.

## Run locally on Windows

Start Laravel in one PowerShell window:

```powershell
php artisan serve
```

Start the frontend in a second window:

```powershell
npm.cmd run dev
```

Open the address shown by Laravel, usually `http://127.0.0.1:8000`.

Run `php artisan migrate` to apply new migrations. Keep existing migrations separate because they record changes already applied to the database. Do not use `php artisan migrate:fresh` if you need to keep your data.

