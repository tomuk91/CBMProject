# Unsplash API Setup

The application uses Unsplash API to fetch car images for the vehicle information display.

## Getting Your Unsplash API Key

1. **Sign up for Unsplash Developer Account**
   - Visit: https://unsplash.com/developers
   - Click "Register as a developer"
   - Create an account or log in

2. **Create a New Application**
   - Go to: https://unsplash.com/oauth/applications
   - Click "New Application"
   - Accept the Terms and API Usage Guidelines
   - Fill in the application details:
     - Application name: "CBM Auto Car Service"
     - Description: "Car service booking system with vehicle management"

3. **Get Your Access Key**
   - Once created, you'll see your application dashboard
   - Copy the "Access Key" (not the Secret Key for this use case)

4. **Add to Your .env File**
   ```
   UNSPLASH_ACCESS_KEY=your_access_key_here
   ```

## Rate Limits

- **Demo/Development**: 50 requests per hour
- **Production**: After approval, 5000 requests per hour

The application caches car images for 30 days to minimize API calls.

## Features Using Unsplash API

1. **Dashboard Vehicle Display**: Shows a photo of the user's car make/model
2. **Profile Vehicle Section**: Displays car image with vehicle details

## Fallback Images

If the API is unavailable or no key is provided, the application will use:
- Default car images from Unsplash's public URLs (no API key needed)
- Manufacturer-specific placeholder images
- Generic car icon

## Testing Without API Key

You can test the application without an API key. The CarImageService will automatically use fallback placeholder images based on the vehicle make.

## Attribution

When using Unsplash images, proper attribution is automatically handled through the API response. For production use, ensure you comply with Unsplash's attribution requirements:
https://help.unsplash.com/en/articles/2511245-unsplash-api-guidelines
