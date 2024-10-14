# Bag Management Module

## Overview

The Bag Management module provides functionalities to manage bags within the application. This includes creating, updating, deleting, and retrieving bags associated with arrival management. The module is built using Laravel, leveraging its features for routing, database management, and testing.

## Features

- List all bags
- Retrieve a specific bag by ID
- Create a new bag
- Update an existing bag
- Delete a bag


## Usage

### Endpoints

#### 1. List Bags
- **GET** `/api/bags`
  
#### 2. Get Bag by ID
- **GET** `/api/bags/{id}`

#### 3. Create a New Bag
- **POST** `/api/bags`
- **Request Body:**
  ```json
  {
    "quantity": 10,
    "arrival_management_id": 1
  }
  ```

#### 4. Update an Existing Bag
- **PUT** `/api/bags/{id}`
- **Request Body:**
  ```json
  {
    "quantity": 15,
    "arrival_management_id": 2
  }
  ```

#### 5. Delete a Bag
- **DELETE** `/api/bags/{id}`

## Testing

This module includes tests to ensure the functionality works as expected. The tests are located in the `tests/Unit/Sucre/Service/Entreprise/Bag` directory.

### Running Tests

To run the tests, use the following command:

```bash
php artisan test
```

### Test Cases

1. **Test Listing Bags**: 
   - Confirms that three bags are listed correctly when created in the database.

2. **Test Get Bag by ID**: 
   - Verifies that a specific bag can be retrieved by its ID.

3. **Test Get Bag by ID Not Found**: 
   - Ensures that requesting a non-existent bag returns a 404 status.

4. **Test Store Bag**: 
   - Checks that a new bag can be created and is stored in the database.

5. **Test Update Bag**: 
   - Verifies that an existing bag can be updated successfully.

6. **Test Update Bag Not Found**: 
   - Confirms that updating a non-existent bag returns a 404 status.

7. **Test Delete Bag**: 
   - Tests that a bag can be deleted and checks that it no longer exists in the database.

8. **Test Delete Bag Not Found**: 
   - Ensures that attempting to delete a non-existent bag returns a 404 status.

## Contributing

Contributions are welcome! Please create an issue for any improvements or suggestions, and submit a pull request for code changes.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
