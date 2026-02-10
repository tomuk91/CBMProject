# Cloudflare R2 Setup Guide

## Step 1: Create R2 Bucket

1. Go to Cloudflare Dashboard → R2 Object Storage
2. Click "Create bucket"
3. Name: `cbm-auto-vehicles` (or your preferred name)
4. Location: Automatic
5. Click "Create bucket"

## Step 2: Create API Token

1. In R2 dashboard, go to "Manage R2 API Tokens"
2. Click "Create API token"
3. Token name: `cbm-auto-production`
4. Permissions: 
   - Object Read & Write
5. TTL: Forever (or set expiration)
6. Click "Create API Token"
7. **Copy the Access Key ID and Secret Access Key** (shown only once!)

## Step 3: Set Up Public Access (Optional)

If you want images publicly accessible via CDN:

1. Go to your bucket → Settings
2. Under "Public Access", click "Connect Domain"
3. Add a custom domain (e.g., `cdn.cbmauto.com`) or use R2.dev subdomain
4. This will be your `R2_PUBLIC_URL`

## Step 4: Configure Railway Environment Variables

Add these to your Railway service:

```bash
FILESYSTEM_DISK=r2
R2_ACCESS_KEY_ID=<your_access_key_id>
R2_SECRET_ACCESS_KEY=<your_secret_access_key>
R2_BUCKET=cbm-auto-vehicles
R2_ENDPOINT=https://71acdda182c59c568e4314f2ca260031.r2.cloudflarestorage.com
R2_PUBLIC_URL=https://your-bucket-url.r2.dev
```

**Important**: After setting up public access in Step 3, update `R2_PUBLIC_URL` with your actual public URL.

## Step 5: Deploy

Push your changes and redeploy on Railway:

```bash
git add -A
git commit -m "Add Cloudflare R2 storage for vehicle images"
git push
```

## Testing Locally

To test locally, add the same variables to your `.env` file and set:

```bash
FILESYSTEM_DISK=r2
```

## Accessing Images in Views

Images will automatically be accessible via the URL configured in `R2_PUBLIC_URL`:

```blade
<img src="{{ Storage::disk('r2')->url($vehicle->image) }}" alt="Vehicle">
```

Or if using the default disk:

```blade
<img src="{{ Storage::url($vehicle->image) }}" alt="Vehicle">
```

## Storage Costs

- **Storage**: Free up to 10GB, then $0.015/GB/month
- **Class A Operations** (write): $4.50 per million requests
- **Class B Operations** (read): $0.36 per million requests  
- **Egress**: **FREE** (unlimited!)

## Troubleshooting

**Images not uploading:**
- Check Railway logs for S3 errors
- Verify API credentials are correct
- Ensure bucket name matches exactly

**Images not displaying:**
- Verify `R2_PUBLIC_URL` is set correctly
- Check bucket has public access enabled
- Test URL directly in browser

**403 Forbidden errors:**
- API token needs Object Read & Write permissions
- Bucket name might be incorrect
