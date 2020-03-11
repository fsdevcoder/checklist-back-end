# Back-end test using Symfony, REST API, Parameters, Unit Testing

### Project setup and testing
- *composer install*
- *symfony server:start*
- edit minimum number of words in *config/services.yaml*
- edit parameters/settings in *config/servgices.yaml*:
    ```
    checklist.settings.keywords: banana, apple
    checklist.settings.min_number_of_words: 10
    ```
- POST api/checklist
    ```
    {
        "content": "fruits are really good for your health. You should eat at least 1 banana per day and 1 green apple."
    }
    ```    
- Expected Result
    ```
    200 OK
    {
        "content": "fruits are really good for your health. You should eat at least 1 banana per day and 1 green apple."
        "keywords used": 2,
        "average keywords density": 0.10
    }
    ```
- Unit Testing
    ```
    php bin/phpunit
    ```
