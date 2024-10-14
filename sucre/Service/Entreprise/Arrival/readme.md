```markdown
# Arrival Service

## Overview

The Arrival Service manages arrivals in the system, providing functionality to create, update, retrieve, and delete arrival records. It interacts with the `ArrivalManagement` model for various operations related to arrivals.

## Features

- List all valid arrivals with pagination.
- Retrieve details of a specific arrival.
- Create new arrivals.
- Update existing arrivals.
- Mark arrivals as deleted (invalid).
- Validate arrival dates to ensure they are not in the past.

## Usage

### Listing Arrivals

To list all valid arrivals:

```php
$response = (new ArrivalService())->listArrivals();
```

### Showing an Arrival

To retrieve a specific arrival by ID:

```php
$response = (new ArrivalService())->showOneArrival($arrivalId);
```

### Storing a New Arrival

To create a new arrival:

```php
$request = new ArrivalStoreRequest($validatedData);
$response = (new ArrivalService())->storeNewArrival($request);
```

### Updating an Arrival

To update an existing arrival:

```php
$request = new ArrivalUpdateRequest($validatedData);
$response = (new ArrivalService())->updateArrival($arrivalId, $request);
```

### Deleting an Arrival

To mark an arrival as deleted:

```php
$response = (new ArrivalService())->deleteArrival($arrivalId);
```

## API Endpoints

### List Arrivals

- **GET** `/api/arrivals`

### Show Arrival

- **GET** `/api/arrivals/{id}`

### Store Arrival

- **POST** `/api/arrivals`

**Body:**

```json
{
  "label_name": "Sample Arrival",
  "arrival_date": "2024-09-28",
  "bag_price": 100,
  "type_rice_id": 1
}
```

### Update Arrival

- **PUT/PATCH** `/api/arrivals/{id}`

**Body:**

```json
{
  "label_name": "Updated Arrival",
  "bag_price": 150,
  "type_rice_id": 2
}
```

### Delete Arrival

- **DELETE** `/api/arrivals/{id}`

## Author

**RANDRIANARISOA**  
Email: maheninarandrianarisoa@gmail.com

## License

This project is licensed under the MIT License.
