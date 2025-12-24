# 🚀 Deployment Guide: InfinityFree

Follow these exact steps to launch your site on infinityfree.com.

## Step 1: Create Account & Account
1.  Go to [infinityfree.com](https://www.infinityfree.com/) and Sign Up.
2.  Click **"Create Account"**.
3.  Choose a **Subdomain** (e.g., `myjavaclass.free.nf` or `epizy.com`).
4.  Finish the creation process. It might take a minute or two for the account to be "Active".

## Step 2: Get Database Details (Do this FIRST)
1.  In the Client Area, click the **"Control Panel"** button (green button) or "Manage" -> "Control Panel".
    *   *Note: If asked to approve email alerts (VistaPanel), click "I Approve".*
2.  In the Panel, look for the **"DATABASES"** section and click **"MySQL Databases"**.
3.  **Create New Database:**
    *   Enter a name (e.g., `class`) and click **Create Database**.
4.  **SCROLL DOWN** to the "Current Databases" section. You will see your **MySQL details**.
    *   **MySQL Host Name:** (e.g., `sql300.infinityfree.com`) -> **IMPORTANT:** It is NOT localhost.
    *   **MySQL User Name:** (e.g., `if0_3456789`)
    *   **MySQL Password:** (This is usually your vPanel password, shown in the Client Area, NOT the DB password field if blank. Check your main account details for the "hosting password").
    *   **Database Name:** (e.g., `if0_3456789_class`)
5.  **Write these down carefully.**

## Step 3: Import SQL
1.  In the Control Panel, click **"phpMyAdmin"** (under Databases).
2.  Click "Connect Now" next to your new database.
3.  Click the **"Import"** tab at the top.
4.  Click **"Choose File"** -> Select `database_export.sql` from your computer.
5.  Click **"Go"**.

## Step 4: Update `db.php`
Before uploading, edit your local `db.php` file (or edit it after uploading):
```php
<?php
// ...
$host = "sql300.infinityfree.com"; // COPY FROM STEP 2
$username = "if0_3456789";         // COPY FROM STEP 2
$password = "your_vpanel_password"; // COPY FROM STEP 2
$dbname = "if0_3456789_class";     // COPY FROM STEP 2
$port = 3306;
// ...
```

## Step 5: Upload Files
1.  Go to the **"Online File Manager"** (from Client Area or Control Panel).
2.  Open the **`htdocs`** folder.
    *   *Note: Delete the default `index2.html` or similar welcome files if present.*
3.  **Upload** these files to `htdocs`:
    *   `index.html`
    *   `db.php` (The updated one!)
    *   `chat.php`
    *   `login.php`
    *   `register.php`
    *   `get_progress.php`
    *   `save_progress.php`
    *   `get_students_progress.php`
    *   `fpdf.php` (folder or file if you have it)
    *   `certificate.php` (if created)
4.  **Optional:** InfinityFree works fine with `.html`, but if you face issues, rename `index.html` to `index.php`.

## Step 6: Launch
1.  Open your browser and visit your subdomain (e.g., `http://myjavaclass.free.nf`).
2.  If you see a "Directory Listing" or 404, make sure your files are surely inside `htdocs` and NOT just in the root `/`.
