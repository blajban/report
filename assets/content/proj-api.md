### API documentation

#### Get All Rooms

Get a list of all rooms. ([TRY IT](../api/room)).

- **URL:** `/proj/api/room`
- **Method:** `GET`

#### Add Room

Add a new room. 

- **URL:** `/proj/api/room/add`
- **Method:** `POST`

**Request Body:**
- `json_data` (form-data, required): JSON data containing room information.
- `img` (form-data, optional): An image file representing the room.

**Request Body Example:**
```
{
    "name": "test",
    "description": "Desc."
}
```

**CURL example command**:
```
curl --location --request POST 'localhost:8888/proj/api/room/add' \
--form 'json_data="{
    \"name\": \"test\",
    \"description\": \"Desc.\"
}"' \
--form 'img=@"/home/blajban/Desktop/2_enigmatic_study.png"'
```

#### Delete Room

Delete a room.

- **URL:** `/proj/api/room/delete`
- **Method:** `POST`

**Request Body:**
- `id` (form-data, required): The ID of the room to be deleted.

**CURL example command**:
```
curl --location --request POST 'localhost:8888/proj/api/room/delete' \
--form 'id="17"'
```

#### Update Room

Update a room.

- **URL:** `/proj/api/room/update`
- **Method:** `POST`

**Request Body:**
- `id` (form-data, required): The ID of the room to be updated.
- `json_data` (form-data, required): JSON data containing updated room information.
- `img` (form-data, optional): An updated image file representing the room.

**Request Body Example:**
```
{
    "name": "Updated",
    "description": "dsadasdsa."
}
```

**CURL example command**:
```
curl --location --request POST 'localhost:8888/proj/api/room/update' \
--form 'id="8"' \
--form 'img=@"/home/blajban/Desktop/3_time_chamber.png"'
```

#### Get All Items

Get a list of all items. ([TRY IT](../api/item)).

- **URL:** `/proj/api/item`
- **Method:** `GET`

#### Add Item

Add a new item.

- **URL:** `/proj/api/item/add`
- **Method:** `POST`

**Request Body:**
- `text` (raw text, required): JSON data containing item information.

**Request Body Example:**
```
{
    "name": "Ett item",
    "description": "En beskrivning"
}
```

**CURL example command**:
```
curl --location --request POST 'localhost:8888/proj/api/item/add' \
--header 'Content-Type: text/plain' \
--data-raw '{
    "name": "Enchanted Hourglass",
    "description": "A mystical hourglass that seems to defy the laws of time."
}'
```

#### Delete Item

Delete an item.

- **URL:** `/proj/api/item/delete`
- **Method:** `POST`

**Request Body:**
- `id` (form-data, required): The ID of the item to be deleted.

**CURL example command**:
```
curl --location --request POST 'localhost:8888/proj/api/item/delete' \
--form 'id="3"'
```
