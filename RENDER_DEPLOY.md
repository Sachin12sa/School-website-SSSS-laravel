# Render Deployment

This app is prepared for Render using Docker, PHP 8.3, Nginx, PHP-FPM, and Render Postgres.

## What Render Will Create

- A free Docker web service named `school-website-demo`
- A free Postgres database named `school-website-demo-db`
- A generated Laravel `APP_KEY`
- Automatic migrations before every deploy
- Demo seed data after the first successful deploy

Render supports Docker-based services and recommends Docker for PHP apps because PHP is not one of its native runtimes. Render also provides free web services and free Postgres for demos/testing, but not production.

## Deploy Steps

1. Push this repository to GitHub.
2. Open Render Dashboard.
3. Go to **Blueprints**.
4. Click **New Blueprint Instance**.
5. Select this repo.
6. Render will read `render.yaml` and create the app plus database.
7. After deploy finishes, open:
   `https://school-website-demo.onrender.com`

If Render changes the public URL because the subdomain is already taken, update `APP_URL` in the service environment variables.

## Admin Login

The demo seed creates:

- Email: `admin@school.edu`
- Password: `admin`

Change this immediately after the demo site is live.

## Important Free Hosting Limitation

Render free services use an ephemeral filesystem. Database content will stay in Postgres, but images uploaded from the admin panel can disappear after redeploys/restarts unless you add persistent storage or move uploads to S3/Cloudinary.

For a short demo, this is usually okay. For a real public site, use paid persistent disk storage or cloud object storage.
