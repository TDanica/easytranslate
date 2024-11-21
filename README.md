# Currency Conversion Application

This is a simple Laravel application that demonstrates currency conversion functionality. It includes tests for the `ConversionController`, `ApiService`, and `ConversionService`.

## Setup

This application uses Docker and Laravel Sail for development. Ensure you have Docker installed on your machine before proceeding.

1. Clone the repository:
   ```
   git clone https://github.com/TDanica/easytranslate.git
   ```

2. Set up Laravel Sail:
   ```
   cd easytranslate

   cp .env.example .env

   docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest composer install

   ./vendor/bin/sail up -d

   ./vendor/bin/sail artisan key:generate
   ```

3. Run the migration:
   ```
   ./vendor/bin/sail artisan migrate
   ```

4. Run tests:
   ```
   ./vendor/bin/sail test
   ```

## Testing

This application include test for the conversion endpoint:

- **ConversionControllerTest:** Tests the `/convert` endpoint to ensure proper currency conversion functionality.

## Usage

1. Access the application in your browser:
   ```
   http://localhost:80
   ```

2. Use the `/convert` endpoint to perform currency conversion.
3. Use the `/currencies` endpoint to get currencies.

## Contributors

- Danica Tundjova(https://github.com/TDanica)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.