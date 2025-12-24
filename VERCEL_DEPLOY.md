# 🚀 Frontend Deployment: Vercel

Since you want to host the HTML on Vercel (for speed) and PHP on InfinityFree, follow these steps.

## Step 1: Prepare Files
1.  Make sure you have saved all changes in VS Code.
2.  (Optional) Create a GitHub repository and push your code. This is the easiest way to use Vercel.

## Step 2: Deploy to Vercel
1.  Go to [vercel.com](https://vercel.com) and Sign Up/Login.
2.  Click **"Add New..."** -> **"Project"**.
3.  **Import Git Repository:**
    *   Connect your GitHub and select the repo containing these files.
4.  **Configure Project:**
    *   Framework Preset: **Other** (since it's plain HTML).
    *   Root Directory: `./` (default).
5.  Click **Deploy**.

## Step 3: Important - Update InfinityFree!
Because you modified the PHP files to add `cors.php`, you **MUST UPLOAD THEM AGAIN** to InfinityFree.

1.  Go to InfinityFree File Manager (`htdocs`).
2.  **Delete** the old `.php` files (optional, but cleaner).
3.  **Upload the NEW versions** of:
    *   `cors.php` (New file!)
    *   `chat.php`
    *   `login.php`
    *   `register.php`
    *   `get_progress.php`
    *   `save_progress.php`
    *   `get_students_progress.php`
    *   `db.php`
    *   `index.html` (You can keep it there as a backup, but the Vercel one will be the main one).

## Step 4: Test
1.  Open your **Vercel URL** (e.g., `https://java-classroom.vercel.app`).
2.  Try to **Login**.
    *   If it works: Your CORS setup is perfect! 🎉
    *   If it fails (Network Error): Check the Console (F12). If you see "blocked by CORS policy", make sure `cors.php` is uploaded correctly to InfinityFree.
