# Attendance API — Backend Training (Day 1)

Welcome. This is the backend half of your 3-day training. By the end of today, you should have a working REST API that can list, create, update, and delete attendance records.

**Important:** This guide tells you *what* to do and gives you hints. It does **not** give you the code. You're expected to read the Laravel documentation, search when stuck, and ask questions when truly blocked. Struggling a bit is part of learning — don't shortcut it by asking AI to write the code for you. You'll learn far more by writing one line yourself than reading ten lines someone else wrote.

When you're stuck for more than ~20 minutes on the same problem, ask.

---

## Prerequisites

Before you start, confirm these work in your terminal:

- `php -v` → should show PHP 8.2 or higher
- `composer -V` → should show Composer 2.x
- `git --version` → any recent version
- A REST client installed: Postman, Insomnia, or the Thunder Client extension in VS Code

You do **not** need MySQL. We'll use SQLite (a database that lives in a single file).

---

## What you're building

A REST API with these endpoints:

| Method | URL | Purpose |
|---|---|---|
| GET | `/api/attendance` | List all records |
| POST | `/api/attendance` | Create a new record |
| GET | `/api/attendance/{id}` | Get one record |
| PUT | `/api/attendance/{id}` | Update a record |
| DELETE | `/api/attendance/{id}` | Delete a record |

Each attendance record has:

- `employee_name` — text
- `date` — a date
- `check_in_time` — a time
- `check_out_time` — a time, optional (the person might still be working)

The API will run at `http://127.0.0.1:8000` and your frontend (tomorrow) will call it from `http://localhost:5173`.

---

## Step 1 — Get into your empty repo

Your trainer has given you a GitHub URL for an empty `attendance-api` repository. Clone it to your projects folder, then `cd` into it.

When you're inside, run `ls -la` (or `dir` on Windows). You should see a `.git` folder and not much else.

**Checkpoint:** You are inside the empty cloned folder.

---

## Step 2 — Scaffold the Laravel project

You need to create a Laravel project **inside this existing folder** — not in a new sub-folder next to it. The Composer command for this uses a `.` (dot) to mean "current directory".

Hints:

- Look up `composer create-project laravel/laravel` in the Laravel docs
- If Composer refuses because the directory isn't empty, you can scaffold into a temporary folder and move the files in
- After scaffolding, copy `.env.example` to `.env` and run `php artisan key:generate`

**Checkpoint:** Running `php artisan serve` starts a server and the Laravel welcome page loads in your browser at `http://127.0.0.1:8000`. Stop the server with `Ctrl+C` before continuing.

**Commit your work:** `git add . && git commit -m "Scaffold Laravel project"`

---

## Step 3 — Configure SQLite

Open the `.env` file. Find the database section. You want Laravel to use SQLite instead of MySQL.

Hints:

- `DB_CONNECTION` should be `sqlite`
- The MySQL-specific lines (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) can be commented out or deleted
- Laravel expects the SQLite file at `database/database.sqlite`. You need to create that empty file yourself — search how to create an empty file on your OS

**Checkpoint:** The file `database/database.sqlite` exists (even though it's 0 bytes).

---

## Step 4 — Enable API routes

In Laravel 11+, the `routes/api.php` file does **not** exist by default. You need to enable it with one Artisan command.

Hints:

- Look up "Laravel install api" — there's a single `php artisan` command for this
- It will also ask if you want to run migrations. Say yes.

**Checkpoint:** The file `routes/api.php` exists. Running `php artisan route:list` shows some default API routes.

---

## Step 5 — Create the model and migration

You need:

1. A **model** named `AttendanceRecord` — this represents one attendance record in PHP code
2. A **migration** that creates the database table for it

Both can be generated with a single Artisan command if you pass the right flag.

Hints:

- The Artisan command is `php artisan make:model` — look up its flags
- The migration file appears in `database/migrations/`
- You need to define the columns in the migration's `up()` method, inside the `Schema::create(...)` callback
- Match the data types to what each field needs (string, date, time, nullable time)
- Run `php artisan migrate` to apply the migration

**Checkpoint:** Running `php artisan migrate:status` shows your `create_attendance_records_table` migration as "Ran". You can verify the table exists by opening `database/database.sqlite` in a SQLite viewer (DB Browser for SQLite, or the SQLite extension in VS Code).

**Commit:** `git add . && git commit -m "Create attendance_records table"`

---

## Step 6 — Configure the model

Open `app/Models/AttendanceRecord.php`. Right now it's nearly empty.

For Laravel to let you save data using `Model::create([...])` from a request, it needs to know which fields are safe to mass-assign. This is a security feature called **mass assignment protection**.

Hints:

- Look up "Laravel mass assignment" in the docs
- You'll add a `protected $fillable = [...]` array
- List every column that should be settable from API input (i.e., everything except `id`, `created_at`, `updated_at`)

**Checkpoint:** The model has a `$fillable` array containing your four data columns.

---

## Step 7 — Create the controller

Generate an API controller for the attendance record. Artisan has a flag specifically for API controllers (it skips the `create` and `edit` form methods that you don't need for an API).

Hints:

- The command is `php artisan make:controller` with a specific flag
- Name it `AttendanceRecordController`
- The generated file will have empty `index`, `store`, `show`, `update`, `destroy` methods

Now you need to implement each method. For each one, think:

- **`index`** — return all records. What does `Model::all()` give you? How do you return JSON in Laravel? (Hint: returning an Eloquent collection automatically becomes JSON.)
- **`store`** — read the data from the request, **validate it**, then create a record. Look up `$request->validate([...])` — what does it return on success? What happens on failure?
- **`show`** — return one record by ID. Look up "Laravel route model binding" — you can have Laravel auto-fetch the model for you.
- **`update`** — same as store, but update an existing record instead of creating one.
- **`destroy`** — delete a record. What HTTP status should you return when something is deleted successfully?

Things to look up:

- Eloquent: `all()`, `create()`, `update()`, `delete()`
- `Illuminate\Http\Request` and `$request->validate()`
- Route model binding (it's a one-line trick that makes `show`/`update`/`destroy` much shorter)
- HTTP status codes 200, 201, 204, 404, 422

**Checkpoint:** Your controller has five methods, each doing the right thing.

---

## Step 8 — Register the routes

Open `routes/api.php`. You need to register all five routes for your controller. Laravel has a shortcut for this — one line that registers all five RESTful routes at once.

Hints:

- Look up `Route::apiResource(...)` in the Laravel routing docs
- Make sure to import your controller class at the top of the file

After registering, verify with:

```bash
php artisan route:list --path=api
```

You should see five routes for `attendance`.

**Checkpoint:** All five routes appear in the route list.

**Commit:** `git add . && git commit -m "Add attendance controller and routes"`

---

## Step 9 — Configure CORS (very important)

CORS = Cross-Origin Resource Sharing. Browsers block JavaScript from one origin (`http://localhost:5173` — your future Vue app) from calling APIs on a different origin (`http://127.0.0.1:8000` — this API) unless the API explicitly says it's allowed.

If you skip this step, your frontend tomorrow will fail with cryptic errors.

Hints:

- In Laravel 11, run `php artisan config:publish cors` to publish the config file
- Open `config/cors.php`
- The `paths` array should include `'api/*'`
- The `allowed_origins` array should include both `http://localhost:5173` and `http://127.0.0.1:5173` (browsers treat these as different origins)
- `allowed_methods` should be `['*']` (allow all HTTP methods)
- After saving, restart `php artisan serve` for the change to apply

**Checkpoint:** The file `config/cors.php` exists with the two frontend origins listed.

---

## Step 10 — Test everything with Postman

Start the server (`php artisan serve`) and use Postman to test each endpoint.

For each request, set the header `Accept: application/json` — this tells Laravel to return JSON errors instead of HTML error pages.

**Test 1 — Create a record:**

- Method: POST
- URL: `http://127.0.0.1:8000/api/attendance`
- Body type: JSON (raw)
- Body: a JSON object with all four fields filled in
- Expected: 201 status code, response body contains the created record with an `id`

**Test 2 — Create a record with bad data:**

- Same URL, but send an empty body or missing fields
- Expected: 422 status code, response shows which fields failed validation

**Test 3 — List records:**

- Method: GET
- URL: `http://127.0.0.1:8000/api/attendance`
- Expected: 200 status, JSON array of records

**Test 4 — Get one record:**

- Method: GET
- URL: `http://127.0.0.1:8000/api/attendance/1`
- Expected: 200 status, the single record as JSON
- Then try `/api/attendance/9999` — expected: 404

**Test 5 — Update:**

- Method: PUT
- URL: `http://127.0.0.1:8000/api/attendance/1`
- Body: JSON with updated fields
- Expected: 200, response shows updated record. Run the list endpoint again to confirm.

**Test 6 — Delete:**

- Method: DELETE
- URL: `http://127.0.0.1:8000/api/attendance/1`
- Expected: 204 (no content). Run the list endpoint — the record is gone.

If all six tests pass, your API is done.

**Commit:** `git add . && git commit -m "Complete attendance CRUD API" && git push`

---

## End of Day 1

You should have:

- A Laravel project running on `http://127.0.0.1:8000`
- A SQLite database with an `attendance_records` table
- One model with `$fillable` configured
- One controller with five working methods
- Routes registered with `apiResource`
- CORS configured for the frontend
- All endpoints tested in Postman

**Before you stop for the day:**

- Create 3-4 sample records in Postman so tomorrow you have data to display
- Commit and push all your work
- **Leave the Laravel server running** if you continue straight to Day 2 — you'll need it

---

## Common Problems

**"SQLSTATE[HY000]: General error: 1 no such table"**
You forgot to run `php artisan migrate` after creating the migration.

**"Add [field_name] to fillable property to allow mass assignment"**
You forgot to list that field in `$fillable` on the model.

**"404 Not Found" when hitting `/api/attendance`**
Either you forgot to run `php artisan install:api`, or you forgot to register the route in `routes/api.php`, or you registered it in `routes/web.php` by mistake.

**Postman returns HTML instead of JSON**
You forgot the `Accept: application/json` header.

**Validation errors come back as HTML page instead of JSON**
Same as above — add the `Accept: application/json` header.

**Everything works in Postman but the frontend will fail tomorrow**
Most likely a missing CORS config. Verify `config/cors.php` exists and `allowed_origins` includes the Vue dev server URLs.

---

## What to read while learning

- Laravel docs: <https://laravel.com/docs/11.x>
- Specifically: Routing, Controllers, Eloquent (Getting Started), Validation, HTTP Responses
- Don't try to read everything. Search for specifically what you need.

Good luck. Ask when stuck.
